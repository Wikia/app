<?php

namespace Xhgui\Profiler\Profilers;

use Xhgui\Profiler\ProfilingFlags;

class UProfiler extends AbstractProfiler
{
    const EXTENSION_NAME = 'uprofiler';

    public function isSupported()
    {
        return extension_loaded(self::EXTENSION_NAME);
    }

    public function enable($flags = array(), $options = array())
    {
        uprofiler_enable($this->combineFlags($flags, $this->getProfileFlagMap()), $options);
    }

    public function disable()
    {
        return uprofiler_disable();
    }

    private function getProfileFlagMap()
    {
        return array(
            ProfilingFlags::CPU => UPROFILER_FLAGS_CPU,
            ProfilingFlags::MEMORY => UPROFILER_FLAGS_MEMORY,
            ProfilingFlags::NO_BUILTINS => UPROFILER_FLAGS_NO_BUILTINS,
            ProfilingFlags::NO_SPANS => 0,
        );
    }
}
