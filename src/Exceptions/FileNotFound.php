<?php


namespace Hsntngr\Config\Exceptions;


class FileNotFound extends \Exception
{
    public function __construct(string $file = null)
    {
        if ($file === null) {
            $message = 'File could not be found.';
        } else {
            $message = sprintf('File "%s" could not be found.', $file);
        }

        parent::__construct($message);
    }
}