<?php
namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Closure;
use Log;
use stdClass;
class Error
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // エラーレスポンスの場合はレスポンスを整形する
        // if ($response->getStatusCode() > 399) {
        //     // バリデーションエラーの場合は更にメッセージを加工する
        //     if ($response->getStatusCode() === 422) {
        
        //         $message = 'バリデーションエラー：';
        //         $tmp = json_decode($response->getContent());
        //         if (isset($tmp->message)) {
        //             $message = $tmp->message;
        //         } else {
        //             $errors = [];
        //             foreach ($tmp as $key => $value) {
        //                 foreach ($value as $msg) {
        //                     $errors[] = $msg;
        //                 }
        //             }
        //             $error = implode('', $errors);
        //             $message = $message . $error;
        //         }
        //     } else if ($response->getStatusCode() === 404) {
        //         $message = '指定されたデータは存在しません。';
        //     } else if ($response->getStatusCode() === 401) {
        //         $tmp = json_decode($response->getContent());
        //         if (isset($tmp->message)) {
        //             $message = $tmp->message;
        //         } else {
        //             $message = '認証エラー';
        //         }
        //     } else if ($response->getStatusCode() === 400) {
        //         $tmp = json_decode($response->getContent());
        //         Log::info($tmp);
        //         if (isset($tmp->errors)) {
        //             $message = $tmp->errors;
        //         } else {
        //             $message = '予期せぬエラー';
        //         }
        //     } else {
        //         $message = '予期せぬエラー';
        //     }
        //     $response = new JsonResponse([
        //         'message' => $message
        //     ], $response->getStatusCode());
        // } else {
        //     // 正常終了ならそのまま返す
        // }
        return $response;
    }
}
