<?php
/**
 *
 */
class Hash
{

    public static function Create($algo, $data, $salt)
    {

        $generate = hash_init($algo, HASH_HMAC, $salt);
        hash_update($generate, $data);
        return hash_final($generate);

    }

    public static function CreateV2($algo1, $algo2, $data)
    {
        $salt            = $algo1(time() . rand(1, 1000));
        $password        = $algo2($salt . $data);
        return $generate = [$salt, $password];

    }
}


