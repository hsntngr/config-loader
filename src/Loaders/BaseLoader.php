<?php


namespace Hsntngr\Config\Loaders;


use Hsntngr\Config\Exceptions\DirectoryNotDefined;

abstract class BaseLoader
{
    public $directory;

    /**
     * BaseLoader constructor.
     * @param string $directory
     */
    public function __construct($directory = null)
    {
        $this->directory = $directory;
    }

    /**
     * Scans all files under the given directory
     * @param string $directory
     * @return array
     */
    public function scan(string $directory)
    {
        return array_diff(scandir($directory), [".", ".."]);
    }


    /**
     * @param $path
     * @return array
     */
    abstract protected function getContent($path): array;


    /**
     * @param $path
     * @return array
     */
    public function load($path)
    {
        return $this->getContent($path);
    }

    /**
     * @param string $directory
     * @return array
     * @throws DirectoryNotDefined
     */
    public function loadDir(string $directory = null): array
    {
        if (is_null($directory)) {
            $directory = $this->directory;
        }

        if (is_null($directory)) {
            throw new DirectoryNotDefined();
        }

        $configs = [];
        foreach ($this->scan($directory) as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $configs[$filename] = $this->load(
                $directory . '/' . $file
            );
        }

        return $configs;
    }
}