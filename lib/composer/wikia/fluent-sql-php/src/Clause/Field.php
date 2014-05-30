<?php

/**
 * Field
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;
use FluentSql\Functions\SqlFunction;

class Field implements ClauseInterface {
	use AsAble;

	protected $column;

	/** @var SQL */
	protected $fieldSql;

	/** @var SqlFunction */
	protected $function;

	/** @var array of Values */
	protected $values;

	/** @var Condition */
	protected $condition; //Condition can also be in field

	/** @var Cases */
	protected $case;

	public function __construct( /*...*/ ) {
		$argc = func_num_args();
		$argv = func_get_args();

		$this->values = [];
		if ($argc > 1) {
			foreach ($argv as $val) {
				if (!($val instanceof Values)) {
					$val = new Values($val);
				}

				$this->values []= $val;
			}
		} elseif ($argc == 1) {
			$arg = $argv[0];
			if ($arg instanceof Values) {
				$this->values []= $arg;
			} elseif ($arg instanceof SqlFunction) {
				$this->function = $arg;
			} elseif ($arg instanceof Condition) {
				$this->condition = $arg;
			} elseif ($arg instanceof SQL) {
				$this->fieldSql = $arg;
			} elseif ($arg instanceof Cases) {
				$this->case = $arg;
			} else { // is_string
				$this->column = $arg;
			}
		}
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->function != null) {
			$this->function->build($bk, $tabs);
		}

		if ($this->column !== null) {
			$bk->append(" ".$this->column);
		}

		if (count($this->values) > 1) {
			$bk->append(" (");
		}

		$doCommaValues = false;
		foreach ($this->values as $val) {
			/** @var Values $val */
			if ($doCommaValues) {
				$bk->append(",");
			} else {
				$doCommaValues = true;
			}
			$val->build($bk, $tabs);
		}

		if (count($this->values) > 1) {
			$bk->append(" )");
		}

		if ($this->fieldSql != null) {
			if ($this->fieldSql->hasType()) {//Don't put parenthesis when it is not a complex query like SELECT,INSERT.
				$bk->append(" (");//Non complex queries are just VALUES.. FUNCTIONS
			}

			$this->fieldSql->build($bk, $tabs);

			if ($this->fieldSql->hasType()) {
				$bk->append(" )");
			}
		}

		if ($this->condition != null) {
			$this->condition->build($bk, $tabs);
		}

		if ($this->case != null) {
			$this->case->build($bk, $tabs);
		}

		$bk->appendAs($this->as_());
	}

	public function numValues() {
		return count($this->values);
	}
}
