<?php

namespace Xhgui\Profiler\Saver;

use Xhgui_Saver_Pdo;

/**
 * @property Xhgui_Saver_Pdo $saver
 */
class PdoSaver extends AbstractSaver
{
    public function isSupported()
    {
        if (!$this->saver instanceof Xhgui_Saver_Pdo) {
            return false;
        }

        return class_exists('PDO');
    }
}
