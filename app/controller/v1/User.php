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

    //register()里判断用户是否已存在中间件
    protected $middleware = [
        CheckUserExsit::class => ['only' => ['register']],
    ];

    public function register()
    {

        $post = Request::param();

        try {

            validate(\app\validate\Users::class)
                ->scene('register')
                ->check($post);

        } catch (ValidateException $v) {

            //验证失败

            print_r($v->getError());

        }

        $user = Users::create([
            'username' => $post['username'],
            'password' => $post['password']
        ]);

        if(!$user->id){

            return json('添加失败');

        }

        return json('添加成功');





//        return json('新增成功');
        //获取用户填写信息
        //验证用户填写的信息
        //校验通过后信息存入数据库
        //注册成功传递成功码，前端直接跳转到后台首页，否则提示注册错误信息
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
