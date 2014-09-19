<?php

/**
 * IntervalAble
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

trait IntervalAble {
	private $intervalType = '-';
	private $interval = 0;
	private $intervalPeriod = 'day';

	public function intervalType($interval, $type='-', $period='day') {
		$this->interval = $interval;
		$this->intervalType = $type;
		$this->intervalPeriod = $period;

		return $this;
	}

	public function build(Breakdown $breakDown, $tabs) {
		parent::build($breakDown, $tabs);

		$breakDown->append(" {$this->intervalType} INTERVAL ? {$this->intervalPeriod}");
		$breakDown->addParameter($this->interval);
	}
}
