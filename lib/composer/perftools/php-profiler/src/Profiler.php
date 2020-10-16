<?php

namespace Xhgui\Profiler;

use Exception;
use RuntimeException;
use Xhgui\Profiler\Profilers\ProfilerInterface;
use Xhgui\Profiler\Saver\SaverInterface;

class Profiler
{
    const SAVER_UPLOAD = 'upload';
    const SAVER_FILE = 'file';
    const SAVER_MONGODB = 'mongodb';
    const SAVER_PDO = 'pdo';

    const PROFILER_TIDEWAYS = 'tideways';
    const PROFILER_TIDEWAYS_XHPROF = 'tideways_xhprof';
    const PROFILER_UPROFILER = 'uprofiler';
    const PROFILER_XHPROF = 'xhprof';

    /**
     * Profiler configuration.
     *
     * @var array
     */
    private $config;

    /**
     * @var SaverInterface
     */
    private $saveHandler;

    /**
     * @var ProfilerInterface
     */
    private $profiler;

    /**
     * Simple state variable to hold the value of 'Is the profiler running or not?'
     *
     * @var bool
     */
    private $running;

    /**
     * If true, session is closed, buffers are flushed and fcgi request is finished on shutdown handler
     * Disable this if this conflicts with your framework.
     *
     * @var bool
     */
    private $flush;

    /**
     * Profiler constructor.
     *
     * @param array $config
     * @throws RuntimeException if unable to create profiler
     */
    public function __construct(array $config)
    {
        $this->config = array_replace($this->getDefaultConfig(), $config);
    }

    /**
     * Evaluate profiler.enable condition, and start profiling if that returned true.
     */
    public function start($flush = true)
    {
        if (!$this->shouldRun()) {
            return;
        }

        $this->enable();

        $this->flush = $flush;
        // shutdown handler collects and stores the data.
        $this->registerShutdownHandler();
    }

    /**
     * Stop profiling. Get currently collected data and save it
     */
    public function stop()
    {
        $data = $this->disable();
        $this->save($data);

        return $data;
    }

    /**
     * Enables profiling for the current request / CLI execution
     */
    public function enable($flags = null, $options = null)
    {
        $this->running = false;

        // 'REQUEST_TIME_FLOAT' isn't available before 5.4.0
        // https://www.php.net/manual/en/reserved.variables.server.php
        if (!isset($_SERVER['REQUEST_TIME_FLOAT'])) {
            $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
        }

        $profiler = $this->getProfiler();
        if (!$profiler) {
            throw new RuntimeException('Unable to create profiler: No suitable profiler found');
        }

        $saver = $this->getSaver();
        if (!$saver) {
            throw new RuntimeException('Unable to create saver');
        }

        if ($flags === null) {
            $flags = $this->config['profiler.flags'];
        }
        if ($options === null) {
            $options = $this->config['profiler.options'];
        }

        $profiler->enable($flags, $options);
        $this->running = true;
    }

    /**
     * Stop profiling. Return currently collected data
     *
     * @return array
     */
    public function disable()
    {
        if (!$this->running) {
            return array();
        }

        $profiler = $this->getProfiler();
        if (!$profiler) {
            // error for unable to create profiler already thrown in enable() method
            // but this can also happen if methods are called out of sync
            throw new RuntimeException('Unable to create profiler: No suitable profiler found');
        }

        $profile = new ProfilingData($this->config);
        $this->running = false;

        return $profile->getProfilingData($profiler->disable());
    }

    /**
     * Saves collected profiling data
     *
     * @param array $data
     */
    public function save(array $data = array())
    {
        if (!$data) {
            return;
        }

        $saver = $this->getSaver();
        if (!$saver) {
            // error for unable to create saver already thrown in enable() method
            // but this can also happen if methods are called out of sync
            throw new RuntimeException('Unable to create profiler: Unable to create saver');
        }

        $saver->save($data);
    }

    /**
     * Tells, if profiler is running or not
     *
     * @return bool
     */
    public function isRunning()
    {
        return $this->running;
    }


    /**
     * Returns value of `profiler.enable` function evaluation
     *
     * @return bool
     */
    private function shouldRun()
    {
        $closure = $this->config['profiler.enable'];

        return is_callable($closure) ? $closure() : false;
    }

    /**
     * Calls register_shutdown_function .
     * Registers this class' shutDown method as the shutdown handler
     *
     * @see Profiler::shutDown
     */
    private function registerShutdownHandler()
    {
        // do not register shutdown function if the profiler isn't running
        if (!$this->running) {
            return;
        }

        register_shutdown_function(array($this, 'shutDown'));
    }

    /**
     * @internal
     */
    public function shutDown()
    {
        if ($this->flush) {
            $this->flush();
        }

        try {
            $this->stop();
        } catch (Exception $e) {
            return;
        }
    }

    private function flush()
    {
        // ignore_user_abort(true) allows your PHP script to continue executing, even if the user has terminated their request.
        // Further Reading: http://blog.preinheimer.com/index.php?/archives/248-When-does-a-user-abort.html
        // flush() asks PHP to send any data remaining in the output buffers. This is normally done when the script completes, but
        // since we're delaying that a bit by dealing with the xhprof stuff, we'll do it now to avoid making the user wait.
        ignore_user_abort(true);

        if (function_exists('session_write_close')) {
            session_write_close();
        }

        flush();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    /**
     * @return ProfilerInterface|null
     */
    private function getProfiler()
    {
        if ($this->profiler === null) {
            $this->profiler = ProfilerFactory::create($this->config) ?: false;
        }

        return $this->profiler ?: null;
    }

    /**
     * @return SaverInterface|null
     */
    private function getSaver()
    {
        if ($this->saveHandler === null) {
            $this->saveHandler = SaverFactory::create($this->config['save.handler'], $this->config) ?: false;
        }

        return $this->saveHandler ?: null;
    }

    /**
     * @return array
     */
    private function getDefaultConfig()
    {
        return array(
            'save.handler' => Profiler::SAVER_FILE,
            'profiler.enable' => function () {
                return true;
            },
            'profiler.flags' => array(),
            'profiler.options' => array(),
            'profiler.exclude-env' => array(),
            'profiler.simple_url' => function ($url) {
                return preg_replace('/=\d+/', '', $url);
            },
            'profiler.replace_url' => null,
        );
    }
}
