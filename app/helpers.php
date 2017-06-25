<?php

function sql_filter($sql)
{
    return str_replace(
        ["'", '"', '&', '|', '@', '%', '*', '(', ')', '-', '\\'],
        ['', '', '', '', '', '', '', '', '', '', ''],
        $sql);
}

function build_api_return($data = null, $code = 200, $msg = 'OK')
{
    return [
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ];
}
