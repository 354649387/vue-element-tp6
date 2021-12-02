<?php


namespace app\controller\v1;


use app\BaseController;
use app\middleware\CheckUserExsit;
use app\Model\Users;
use Cassandra\Uuid;
use thans\jwt\facade\JWTAuth;
use think\exception\ValidateException;
use think\facade\Request;
use think\response\Json;


class User extends BaseController
{

    //判断用户是否已存在中间件，only在register()里有效
    protected $middleware = [
        CheckUserExsit::class => ['only' => ['register']],
    ];

    /**
     * 注册
     */
    public function register()
    {

        $post = Request::param();

        $check = [
            'username' => $post['username'],
            'password' => $post['password']
        ];

        try {

            validate(\app\validate\Users::class)
                ->scene('register')
                ->check($check);

        } catch (ValidateException $v) {

            $err = $v->getError();

            //验证失败
            throw new $err;

        }

        $user = Users::create([
            'username' => $post['username'],
            'password' => md5($post['username'] . $post['password']),//密码加密，用户名和密码相结合得到一个新密码
        ]);

        if (!$user->id) {

            return JsonCode(2, '注册失败');

        }

        return JsonCode(1, '注册成功');

    }


    /**
     * 登录
     */
    public function login()
    {
        $uuid4 = \Ramsey\Uuid\Uuid::uuid4()->toString();

        $post = Request::param();

        $username = $post['username'];
        $password = $post['password'];

        $user = Users::where('username', $username)->find();


        //用户名和密码都校验通过
        $token = JWTAuth::builder(['uid' => $uuid4, 'name' => $username]);

        if ($user === null) {

            return JsonCode(2, '用户名不存在，请重新输入正确用户名或者注册新用户');

        }

        if ($user->password !== md5($username . $password)) {

            return JsonCode(2, '密码不正确');

        } else {

            return JsonCode(1, '登录成功', ['token' => $token]);

        }

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

    public function pushToken(){

//        return "tokkkkken";
        return JWTAuth::token()->get();

    }

}
