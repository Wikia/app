<?php

namespace Xhgui\Profiler\Profilers;

abstract class AbstractProfiler implements ProfilerInterface
{
    /**
     * Combines flags using "bitwise-OR".
     *
     * Map generic Profiler\ProfilingFlags to {SPECIFIC_PROFILER_NAME_HERE} implementation
     *
     * @param array $flags
     * @param array $flagMap an array with the structure [generic_flag => specific_profiler_flag], e.g. [ProfilingFlags::CPU => XHPROF_FLAGS_CPU]
     * @return int
     */
    protected function combineFlags(array $flags, array $flagMap)
    {
        $combinedFlag = 0;

        foreach ($flags as $flag) {
            $mappedFlag = array_key_exists($flag, $flagMap) ? $flagMap[$flag] : $flag;
            $combinedFlag |= $mappedFlag;
        }

        return $combinedFlag;
    }
}
