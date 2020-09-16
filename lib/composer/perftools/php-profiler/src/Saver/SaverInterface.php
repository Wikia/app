<?php

namespace Xhgui\Profiler\Saver;

interface SaverInterface
{
    /**
     * @return bool
     */
    public function isSupported();

    public function save(array $data);
}
