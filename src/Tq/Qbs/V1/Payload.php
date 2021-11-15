<?php

namespace Tq\Qbs\V1;

class Payload
{
    public static function encrypt($data, $key)
    {
        $iv = substr(md5($key), 0, 8);
        return bin2hex(openssl_encrypt(json_encode($data), 'DES-EDE3-CBC', $key, OPENSSL_RAW_DATA, $iv));
    }

    public static function decrypt($data, $key)
    {
        $iv = substr(md5($key), 0, 8);
        return openssl_decrypt(hex2bin($data), 'DES-EDE3-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}
