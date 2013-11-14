<?php
/**
 * Functions
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Functions implements ClauseBuild {
	use AsAble;

	const MAX = "MAX";
	const MIN = "MIN";
	const COUNT = "COUNT";
	const SUM = "SUM";
	const AVG = "AVG";
	const LOWER = "LOWER";
	const UPPER = "UPPER";

	protected $function;
	protected $functionFields;

	public function __construct(/* function, ...fields... */ ) {
		$args = func_get_args();
		$this->function = array_shift($args);
		$this->functionFields = $args;
	}

	public function build(Breakdown $bk, $tabs) {
		$fieldFunctionOpenedParenthesis = false;

		if ($this->function != null) {
			$bk->append(" ". $this->function);
			$bk->append("(");
			$fieldFunctionOpenedParenthesis = true;
		}

		$doCommaField = false;
		foreach ($this->functionFields as $field) {
			if ($field === null) {
				continue;
			}

			if ($doCommaField) {
				$bk->append(",");
			} else {
				$doCommaField = true;
			}
			$field->build($bk, $tabs);
		}

		if ($fieldFunctionOpenedParenthesis) {
			$bk->append(" )");
			$fieldFunctionOpenedParenthesis = false;
		}

		$bk->appendAs($this->as_());
	}
}