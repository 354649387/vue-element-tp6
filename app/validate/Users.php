<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Users extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username' => "require",
        'password' => 'require|min:6'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',
        'password.min' => '密码不能少于6位'
    ];

    protected $scene = [
        'register' => ['username','password']
    ];
}
