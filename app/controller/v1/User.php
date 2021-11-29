<?php


namespace app\controller\v1;


use app\BaseController;
use app\middleware\CheckUserExsit;
use app\Model\Users;
use thans\jwt\facade\JWTAuth;
use think\exception\ValidateException;
use think\facade\Request;


class User extends BaseController
{

    //判断用户是否已存在中间件，only在register()里有效
    protected $middleware = [
        CheckUserExsit::class => ['only' => ['register']],
    ];

    public function register()
    {

        $post = Request::param('param');

//        dd($post);

        try {

            validate(\app\validate\Users::class)
                ->scene('register')
                ->check($post);

        } catch (ValidateException $v) {

            $err  = $v->getError();
            //验证失败
            throw new $err;

        }

        $user = Users::create([
            'username' => $post['username'],
            'password' => $post['password']
        ]);

        if(!$user->id){

            return JsonCode(2,'注册失败');

        }

        return JsonCode(1,'注册成功');

    }


    public function login()
    {

        $token = JWTAuth::builder(['uid' => 1, 'name' => 'mila']);

        return $token;
    }

    public function getUserInfo()
    {
        return json(['id' => 2, 'name' => 'cq']);
    }

    public function getToken()
    {


//        $payload = JWTAuth::auth();
//
//        $uid = $payload['uid']->getValue();
//
//        return json($payload);

        return JWTAuth::token();


    }

    /**
     * 刷新token，将token加入黑名单
     */
    public function tokenRefresh()
    {

        $res = JWTAuth::refresh();

        return json($res);

    }

    /**
     * 验证token是否在黑名单中
     */
    public function tokenVilidate()
    {

        $res = JWTAuth::validate();

        return json($res);

    }

}
