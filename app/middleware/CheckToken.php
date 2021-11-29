<?php
declare (strict_types = 1);

namespace app\middleware;

use thans\jwt\exception\JWTException;
use thans\jwt\facade\JWTAuth;

class CheckToken
{
    /**
     * 判断token
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if($request->isOptions()){

            return response();

        }

        try {

            JWTAuth::auth();

        }catch (JWTException $e){

            return json($e->getMessage());

        }

        //处理请求之前执行中间件的操作
        return $next($request);


    }
}
