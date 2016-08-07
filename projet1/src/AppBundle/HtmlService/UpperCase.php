<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/07/16
 * Time: 10:05
 */

namespace AppBundle\HtmlService;


class UpperCase
{
    public function __construct()
    {

    }

    public function render($string)
    {
        return strtoupper($string);
    }
}