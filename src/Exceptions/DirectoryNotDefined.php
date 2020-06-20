<?php


namespace Hsntngr\Config\Exceptions;


class DirectoryNotDefined extends \Exception
{
    public function __construct()
    {
        $message = "Directory not specified to load configurations";

        parent::__construct($message);
    }
}