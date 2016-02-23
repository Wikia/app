<?php

namespace Wikia\ExactTarget;

class UserIdsAdapter {


	private $ids;

	public function __construct( $result ) {
		$ids = [ ];
		if ( !is_array( $result ) ) {
			$result = [ $result ];
		}
		foreach ( $result as $object ) {
			if ( isset( $object->Properties->Property->Value ) ) {
				$ids[] = $object->Properties->Property->Value;
			}
		}
		$this->ids = $ids;
	}

	public function getUsersIds() {
		return $this->ids;
	}
}
