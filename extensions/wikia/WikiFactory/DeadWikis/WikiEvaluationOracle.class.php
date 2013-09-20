<?php
/**
 * NOTE: PLEASE TAKE CARE WHILE EDITING THIS FILE.
 *       BAD CHANGE AND WE CAN CLOSE MANY WIKIS BY ACCIDENT.
 */


class WikiEvaluationOracle {
	
	protected $conditionSets;
	
	public function __construct( $conditionSets ) {
		$this->conditionSets = $conditionSets;
	}
	
	protected function checkCondition( $condition ) {
		$type = $condition['type'];
		$value = $condition['value'];
//		$name = $condition['name'];

		if ($value === false) {
//			$this->messages[] = "{$name} could not be fetched";
			return false;
		}

		$conds = array( 'min', 'max' );
		$condsCount = 0;
		foreach ($conds as $cond) {
			if (!array_key_exists($cond,$condition)) {
				continue;
			}

			$condsCount++;
			$refValue = $condition[$cond];
			//$rawRefValue = $refValue;
			if ($type == 'datetime' && is_string($refValue)) {
				$refValue = strtotime($refValue);
			}

			switch ($cond) {
				case 'min':
					if ($value < $refValue) {
//						$this->messages[] = "{$name} (\"{$value}\") is lesser than \"{$rawRefValue}\"";
						return false;
					}
					break;
				case 'max':
					if ($value > $refValue) {
//						$this->messages[] = "{$name} (\"{$value}\") is greater than \"{$rawRefValue}\"";
						return false;
					}
					break;
			}
		}

		if ($condsCount == 0) {
			return false;
		}
		
		return true;
	}
	
	protected function checkSet( $data, $conditions ) {
		foreach ($conditions as $condition) {
			if ( !array_key_exists($condition['key'],$data)) {
				return false;
			}
			$condition['value'] = $data[$condition['key']];
			if ( !$this->checkCondition($condition) ) {
				return false;
			}
		}
		return true;
	}
	
	public function check( $data ) {
		foreach ($this->conditionSets as $name => $conditions) {
			if ($this->checkSet($data,$conditions)) {
				return $name;
			}
		}
		return false;
	}
	
}
