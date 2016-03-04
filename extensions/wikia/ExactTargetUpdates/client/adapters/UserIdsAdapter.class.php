<?php

namespace Wikia\ExactTarget;

class UserIdsAdapter extends BaseAdapter {

	private $ids = [ ];

	public function getUsersIds() {
		return $this->ids;
	}

	protected function extractResult( $property ) {
		if ( isset( $property->Value ) ) {
			$this->ids[ ] = $property->Value;
		}
	}
}
