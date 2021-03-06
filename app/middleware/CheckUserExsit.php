<?php
declare (strict_types = 1);

namespace app\middleware;

use app\Model\Users;
use think\facade\Log;
use think\response\Jsonp;

class CheckUserExsit
{
    /**
     * 判断新注册的用户是否已存在
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {


        $username = $request->param('username');

        $user = Users::where('username',$username)->find();

        if($user !== null){

            Log::error('CheckUserExist中间件--用户已存在');

            return json('用户已存在');

        }

        return $next($request);

    }
}
