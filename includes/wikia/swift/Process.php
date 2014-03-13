<?php

namespace Wikia\Swift\Process;

class Runner {
	protected $queue = array();
	protected $active = array();

	protected $threads;
	protected $delay;

	public function __construct( $processes, $threads, $delay = 0 ) {
		$this->queue = $processes;
		$this->threads = $threads;
		$this->delay = $delay;
	}

	public function run() {
		$lastSpawned = 0;
		while ( !empty($this->queue) || !empty($this->active) ) {
			while ( !empty($this->queue) && count($this->active) < $this->threads ) {
				if ( $this->delay != 0 ) {
					if ( $lastSpawned + $this->delay > time() ) {
						break;
					}
				}
				/** @var Process $process */
				$process = array_shift($this->queue);
				$process->start();
				$this->active[] = $process;
				$lastSpawned = time();
			}
			foreach ($this->active as $k => $process) {
				if ( !$process->isRunning() ) {
					unset($this->active[$k]);
				}
			}
			usleep(100);
		}
	}

}

class Process {
	protected $cmd;

	protected $started = false;
	protected $stopped = false;
	protected $proc;

	protected $info;

	public function __construct( $cmd ) {
		$this->cmd = $cmd;
	}

	public function start() {
		if ( $this->started ) return;
		$pipes = null;
		$this->proc = proc_open($this->cmd,array(
		),$pipes);
		$this->started = true;
		$this->onStart();
	}

	public function isRunning() {
		$this->check();
		return $this->started && !$this->stopped;
	}

	public function check() {
		if ( $this->started && !$this->stopped ) {
			$this->info = proc_get_status($this->proc);
			if ( !$this->info['running'] ) {
				proc_close($this->proc);
				$this->proc = null;
				$this->stopped = true;
				$this->onTerminate();
			}
		}
	}

	protected function onStart() {
		echo "Started : {$this->cmd}\n";
	}
	protected function onTerminate() {
		echo "Finished: {$this->cmd}\n";
		if ( $this->info['exitcode'] !== 0 ) {
			echo "  * exit code: {$this->info['exitcode']}\n";
		}
	}

}