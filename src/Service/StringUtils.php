<?php
/**
 * Created by PhpStorm.
 * User: pascal
 * Date: 12/09/2018
 * Time: 12:20
 */

namespace App\Service;


class StringUtils
{
    public function capitalize($string) {
        return ucfirst(mb_strtolower($string));
    }
}