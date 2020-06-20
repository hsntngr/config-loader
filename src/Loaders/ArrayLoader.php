<?php


namespace Hsntngr\Config\Loaders;


use Hsntngr\Config\Exceptions\FileNotFound;

class ArrayLoader extends BaseLoader
{
    /**
     * @param $path
     * @return array|void
     * @throws FileNotFound
     */
    protected function getContent($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension != 'php') {
            return;
        }

        if (file_exists($path) && !is_dir($path)) {
            return require_once $path;
        }

        throw new FileNotFound($path);
    }
}