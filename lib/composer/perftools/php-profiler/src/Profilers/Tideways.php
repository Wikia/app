<?php

namespace Xhgui\Profiler\Profilers;

use Xhgui\Profiler\ProfilingFlags;

/**
 * v4 (tideways)
 *
 * @see https://github.com/tideways/php-profiler-extension
 */
class Tideways extends AbstractProfiler
{
    const EXTENSION_NAME = 'tideways';

    public function isSupported()
    {
        return extension_loaded(self::EXTENSION_NAME);
    }

    public function enable($flags = array(), $options = array())
    {
        tideways_enable($this->combineFlags($flags, $this->getProfileFlagMap()), $options);
    }

    public function disable()
    {
        return tideways_disable();
    }

    private function getProfileFlagMap()
    {
        return array(
            ProfilingFlags::CPU => TIDEWAYS_FLAGS_CPU,
            ProfilingFlags::MEMORY => TIDEWAYS_FLAGS_MEMORY,
            ProfilingFlags::NO_BUILTINS => TIDEWAYS_FLAGS_NO_BUILTINS,
            ProfilingFlags::NO_SPANS => TIDEWAYS_FLAGS_NO_SPANS,
        );
    }
}
