<?php

namespace Xhgui\Profiler\Profilers;

interface ProfilerInterface
{
    /**
     * @return bool
     */
    public function isSupported();

    /**
     * Enable profiling.
     *
     * @param array $flags
     * @param array $options
     */
    public function enable($flags = array(), $options = array());

    /**
     * Disable (stop) the profiler. Return the collected data.
     *
     * @return array
     */
    public function disable();
}
