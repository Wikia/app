<?php

/**
 * Condition
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\Functions\SqlFunction;

class Condition implements ClauseInterface {
	const LESS_THAN = "<";
	const LESS_THAN_OR_EQUAL = "<=";
	const EQUAL = "=";
	const GREATER_THAN = ">";
	const GREATER_THAN_OR_EQUAL = ">=";
	const NOT_EQUAL = "!=";
	const IN = "IN";
	const NOT_IN = "NOT IN";
	const EXISTS = "EXISTS";
	const NOT_EXISTS = "NOT EXISTS";
	const BETWEEN = 'BETWEEN';

	const LIKE = "LIKE";
	const NULL = "NULL";
	const IS_NULL = "IS NULL";
	const IS_NOT_NULL = "IS NOT NULL";

	const AND_ = "AND";
	const OR_ = "OR";

	protected $connector;
	protected $left;
	protected $right;
	protected $equality;

	public function __construct($left=null, $operator=null, $right=null) {
		if ($operator !== null) {
			$this->equality = $operator;
		}

		if ($left instanceof Field || $left instanceof SqlFunction) {
			$this->left = $left;
		} elseif ($left !== null) {
			$this->left = new Field($left);
		}

		if ($right instanceof Field || $right instanceof SqlFunction) {
			$this->right = $right;
		} elseif ($right !== null) {
			$this->right = new Field(new Values($right));
		}
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->left != null) {
			$this->left->build($bk, $tabs);
		}

		if ($this->equality == Condition::IN && $this->right instanceof Field && $this->right->numValues() == 1) {
			$this->equality(Condition::EQUAL);
		} elseif ($this->equality == Condition::NOT_IN && $this->right instanceof Field && $this->right->numValues() == 1) {
			$this->equality(Condition::NOT_EQUAL);
		}

		$bk->append(" ".$this->equality);

		if ($this->right != null) {
			$this->right->build($bk, $tabs);
		}
	}

	public function connector($type=null) {
		if ($type !== null) {
			$this->connector = $type;
		}

		return $this->connector;
	}

	public function left($left=null) {
		if ($left !== null) {
			$this->left = $left;
		}

		return $this->left;
	}

	public function equality($equality=null) {
		if ($equality !== null) {
			$this->equality = $equality;
		}

		return $this->equality;
	}

	public function right($right=null) {
		if ($right !== null) {
			$this->right = $right;
		}

		return $this->right;
	}
}
