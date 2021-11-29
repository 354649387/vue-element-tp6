<?php


namespace app\controller\v2;


use app\BaseController;
use thans\jwt\facade\JWTAuth;

class User extends BaseController
{

    public function login(){

//        return "asd";

//        $tokenStr = JWTAuth::token()->get();
////
//        return $tokenStr;

//        $payload = JWTAuth::auth('asd'); //可验证token, 并获取token中的payload部分
//        $uid = $payload['uid']->getValue(); //可以继而获取payload里自定义的字段，比如uid


        return '$uid';


    }

}
