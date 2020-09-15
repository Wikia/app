<?php

namespace Xhgui\Profiler\Saver;

use Xhgui_Saver_Mongo;

/**
 * @property Xhgui_Saver_Mongo $saver
 */
class MongoSaver extends AbstractSaver
{
    public function isSupported()
    {
        if (!$this->saver instanceof Xhgui_Saver_Mongo) {
            return false;
        }

        return class_exists('MongoClient');
    }
}
