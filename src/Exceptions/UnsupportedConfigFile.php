<?php


namespace Hsntngr\Config\Exceptions;


class UnsupportedConfigFile extends \Exception
{
    public function __construct($file)
    {
        $message = $file . " is not supported";

        parent::__construct($message);
    }
}