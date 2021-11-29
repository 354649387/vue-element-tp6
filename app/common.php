<?php
// 应用公共文件

/**
 * 通用api信息返回
 * @param int $code api状态码
 * @param string $msg 提示信息
 * @param array $data api数据
 * @return false|string json字符串
 */
function JsonCode(int $code=1, string $msg='', array $data=[]){
    $res = [
        'code' => $code,
        'msg'  => $msg,
        'data' => $data
    ];
    return json_encode($res);

}
