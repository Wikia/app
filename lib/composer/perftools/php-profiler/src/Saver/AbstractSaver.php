<?php

namespace Xhgui\Profiler\Saver;

use Xhgui_Saver_Interface;

abstract class AbstractSaver implements SaverInterface
{
    protected $saver;

    public function __construct(Xhgui_Saver_Interface $saver)
    {
        $this->saver = $saver;
    }

    public function save(array $data)
    {
        return $this->saver->save($data);
    }
}
