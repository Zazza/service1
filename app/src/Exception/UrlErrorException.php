<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 15:25
 */
namespace App\Exception;

class UrlErrorException extends \Exception
{
    protected $message = 'URL error';
    protected $code = 1;
}
