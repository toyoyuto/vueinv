<?php

namespace App\Console\Commands\Make;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait BuildReplacementsTrate
{
    protected function getModuleName()
    {
        $name = class_basename($this->getNameInput());
        $name = preg_replace('/(Controller|Request|Resource|ResourceCollection|Service|ValueObject)$/', '', $name);
        $name = preg_replace('/^Rest_/i', '', $name);

        return preg_replace('/^[a_z]_/i', '', $name);
    }

    protected function getModuleRelativePath()
    {
        if ($this->hasOption('module_relative_path')) {
            return $this->option('module_relative_path');
        }
        $dir = $this->getNameInput();

        return mb_substr($dir, 0, strlen($dir) - strlen(class_basename($dir)));
    }

    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Console\GeneratorCommand::buildClass()
     */
    protected function buildClass($name)
    {

        $stub = parent::buildClass($name);

        // モデル指定のない場合はそのまま返す
        if (!$this->option('model')) {
            return $stub;
        }
        $replaces = $this->buildCommonsReplacements([], $name);
        $replaces = $this->buildDummiesReplacements($replaces, $name);

        $replaces = array_filter($replaces, function ($v, $k) {
            return strncmp($k, 'Dummy', 5) === 0;
        }, \ARRAY_FILTER_USE_BOTH);

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $stub
        );
    }

    protected function buildCommonsReplacements(array $replaces, $name)
    {
        // DummyRelativeNamespace -> Admin\
        $dir               = $this->getModuleRelativePath();
        $relativeNamespace = str_replace('/', '\\', $dir);

        // DummySwaggerDefinitionsHead -> Admin_
        $swaggerDefinitionsHead = str_replace('/', '_', $dir);

        // DummyResourceCamelSingular -> Hoge
        $resourceCamelSingular = Str::singular($this->getModuleName());
        // DummyResourceCamelPlural -> Hoges
        $resourceCamelPlural = Str::plural($resourceCamelSingular);

        // DummyResourceSnakeSingular -> hoge
        $resourceSnakeSingular = Str::snake($resourceCamelSingular);
        // DummyResourceSnakePlural -> hoges
        $resourceSnakePlural = Str::snake($resourceCamelPlural);

        // DummyUrl -> admin/hoges
        $dirSnake = Str::snake($dir);
        $url      = $dirSnake . $resourceSnakePlural;

        // DummyTag -> Hoges
        $tag = $resourceCamelPlural;

        // ModelClassName
        $modelCalssName = $this->parseModel($this->option('model'));

        // ModelClass
        $modelClass = (new $modelCalssName());

        // Table
        $table = $modelClass->getTable();

        // AllColumns
        $allColumns     = DB::select("desc {$table}");
        $comments       = DB::select('SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME=?', [$table]);
        $columnComments = [];

        foreach ($comments as $comment) {
            $columnComments[$comment->COLUMN_NAME] = $comment->COLUMN_COMMENT;
        }

        // foreach ($allColumns as $column) {
        //     // 情報追加
        //     $column->ColumnType = Schema::getColumnType($table, $column->Field);
        //     \Log::info($column);
        //     $column->ColumnSize = preg_match('/\(([0-9]+)\)/', $column->Type, $matches) ? $matches[1] : '';
        //     $column->Commnet    = $columnComments[$column->Field] ?? '';
        // }

        // Columns
        $columns = [];

        foreach ($allColumns as $column) {
            if (in_array($column->Field, [
                'created_at',
                'updated_at',
                'deleted_at',
            ], true)) {
                continue;
            }
            $columns[] = $column;
        }

        return array_merge($replaces, [
            'DummyRelativeNamespace'      => $relativeNamespace,
            'DummySwaggerDefinitionsHead' => $swaggerDefinitionsHead,
            'DummyResourceCamelSingular'  => $resourceCamelSingular,
            'DummyResourceCamelPlural'    => $resourceCamelPlural,
            'DummyResourceSnakeSingular'  => $resourceSnakeSingular,
            'DummyResourceSnakePlural'    => $resourceSnakePlural,
            'DummyUrl'                    => $url,
            'DummyTag'                    => $tag,
            'DummyFullModelClass'         => $modelCalssName,
            'DummyModelClass'             => class_basename($modelCalssName),
            'DummyModelVariables'         => Str::singular(lcfirst(class_basename($modelClass))),
            'DummyModelVariable'          => Str::singular(lcfirst(class_basename($modelClass))),
            // 変換対象外
            'ModelClassName' => $modelCalssName,
            'ModelClass'     => $modelClass,
            'Table'          => $table,
            'Columns'        => $columns,
            'AllColumns'     => $allColumns,
        ]);
    }

    protected function buildDummiesReplacements(array $replaces, $name)
    {
        return $replaces;
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param string $model
     *
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new \InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (!Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace . 'ORM\\' . $model;
        }

        return $model;
    }
}
