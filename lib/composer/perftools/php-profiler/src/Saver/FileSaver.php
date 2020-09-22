<?php

namespace Xhgui\Profiler\Saver;

class FileSaver implements SaverInterface
{
    /** @var string */
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function isSupported()
    {
        return is_writable(dirname($this->file));
    }

    public function save(array $data)
    {
        $json = json_encode($data);

        return file_put_contents($this->file, $json . PHP_EOL, FILE_APPEND);
    }
}
