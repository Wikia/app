<?php
class ObjectCallTrace {

	const ACTION = 'action';
	const ARGUMENTS = 'arguments';
	const CHILDREN = 'children';

	protected $nextId = 1;
	protected $traces = array();
	protected $stack = array();
	protected $errors = array();


	public function __construct() {
		$this->stack[0] = array(
			'id' => 0,
			'children' => &$this->traces,
		);
	}

	public function begin( $action, $arguments ) {
		$id = $this->nextId++;
		$trace = array(
			'id' => $id,
			'action' => $action,
			'arguments' => $arguments,
			'children' => array(),
		);
		$depth = count($this->stack);
		$this->stack[$depth-1]['children'][] = &$trace;
		$this->stack[$depth] = &$trace;
		return $id;
	}

	public function end( $id ) {
		$count = count($this->stack);
		for ($i=$count-1;$i>0;$i--) {
			if ($this->stack[$i]['id'] == $id) {
				if ($i < $count - 1) {
					// ending in wrong order
					$this->errors[] = 'wrong order during closing of: '.$id;
				}
				array_splice($this->stack, $i);
				return true;
			}
		}
		// ending non-existing thing
		$this->errors[] = 'transaction not found with id: '.$id;
		return false;
	}

	public function log( $action, $arguments ) {
		$args = func_get_args();
		$id = call_user_func_array(array($this,'begin'), $args);
		$this->end($id);
		return $id;
	}

	public function get() {
		return $this->traces;
	}
}