<?php


namespace Hsntngr\Config\Loaders;



use Symfony\Component\Yaml\Yaml;

class YamlLoader extends BaseLoader
{
    /**
     * @param $path
     * @return array
     */
    protected function getContent($path): array
    {
        return Yaml::parseFile($path);
    }
}