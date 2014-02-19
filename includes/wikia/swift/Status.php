<?php

namespace Wikia\Swift\Status;

use Wikia\Swift\Operation\Operation;
use Wikia\Swift\Transaction\OperationList;

interface IStatusProvider {
	public function getText();
	public function getPercent();
}

abstract class Status implements IStatusProvider {
	protected $total;
	protected $completed;
	protected $failed;
	protected $done;
	public function setTotal( $total ) {
		$this->total = $total;
		$this->completed = $this->failed = $this->done = 0;
	}
	public function completed( $n ) { $this->completed += $n; $this->done += $n; }
	public function failed( $n ) { $this->failed += $n; $this->done += $n; }
	public function resetFailed() {
		$this->done -= $this->failed;
		$this->failed = 0;
	}
	public function getPercent() {
		if ( $this->total === null ) { return null; }
		else if ( $this->total == 0 ) { return 1; }
		else { return $this->done / $this->total; }
	}
}
class SizeStatus extends Status {
	public function getText() {
		if ( $this->total === null ) { return '---'; }
		return sprintf("%s/%s",$this->formatSize($this->done),$this->formatSize($this->total));
	}
	protected function formatSize( $size ) {
		return sprintf("%.1fMB",$size / 1024 / 1024 );
	}
}
class CountStatus extends Status {
	public function getText() {
		if ( $this->total === null ) { return '---'; }
		return sprintf("%d/%d",$this->done,$this->total);
	}
}
class AggregateStatus implements IStatusProvider {
	protected $list;
	public function __construct( $list ) {
		$this->list = $list;
	}
	public function getText() {
		$texts = array();
		/** @var IStatusProvider $status */
		foreach ($this->list as $status) {
			$texts[] = $status->getText();
		}
		return implode(' ',$texts);
	}
	public function getPercent() {
		$minPercent = null;
		/** @var IStatusProvider $status */
		foreach ($this->list as $status) {
			$percent = $status->getPercent();
			if ( $percent !== null ) {
				if ( $minPercent === null ) {
					$minPercent = $percent;
				} else {
					$minPercent = min( $minPercent, $percent );
				}
			}
		}
		return $minPercent;
	}
}

class NamedAggregateStatus implements IStatusProvider {
	protected $name;
	/** @var IStatusProvider $status */
	protected $status;
	public function __construct( $name, IStatusProvider $status ) {
		$this->name = $name;
		$this->status = $status;
	}
	public function getText() {
		return $this->name . ' ' . $this->status->getText();
	}
	public function getPercent() {
		return $this->status->getPercent();
	}
}


class StatusPrinter {
	/** @var IStatusProvider $status */
	protected $status;
	protected $start;

	public function __construct( IStatusProvider $status ) {
		$this->status = $status;
		$this->start = microtime(true);
	}

	public function getText() {
		$now = microtime(true);
		$elapsed = $now - $this->start;

		$etaText = '--:--:--';
		$percentText = '--.-%';
		$percent = $this->status->getPercent();
		if ( $elapsed >= 1 && $percent !== null && $percent >= 0.001 ) {
			$etaText = $this->formatTime( $elapsed / $percent - $elapsed );
			$percentText = sprintf("%4.1f%%",$percent*100);
		}

		return sprintf("[%s ETA:%s %s] %s",$this->formatTime($elapsed),$etaText,$percentText,$this->status->getText());
	}

	public function printStatus() {
		$text = $this->getText();
		echo "\r{$text}\r";
	}

	public function finish() {
		$this->printStatus();
		echo "\n";
	}

	protected function formatTime( $time ) {
		$time = intval($time);
		return sprintf("%02d:%02d:%02d",
			intval($time / 3600),
			intval($time / 60) % 60,
			$time % 60
		);
	}

}

