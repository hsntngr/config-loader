<?php


namespace Hsntngr\Config\Loaders;


use Hsntngr\Config\Exceptions\FileNotFound;
use Symfony\Component\Yaml\Yaml;

class YamlLoader extends BaseLoader
{
    /**
     * @param $path
     * @return array | void
     * @throws FileNotFound
     */
    protected function getContent($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (!in_array($extension, ['yml', 'yaml'])) {
            return;
        }

        if (file_exists($path) && !is_dir($path)) {
            return Yaml::parseFile($path);
        }

        throw new FileNotFound($path);
    }
}