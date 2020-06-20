<?php


namespace Hsntngr\Config\Loaders;


class ArrayLoader extends BaseLoader
{
    /**
     * @param $path
     * @return array
     */
    protected function getContent($path): array
    {
        return require_once $path;
    }
}