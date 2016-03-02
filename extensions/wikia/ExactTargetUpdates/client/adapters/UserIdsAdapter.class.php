<?php

namespace Wikia\ExactTarget;

class UserIdsAdapter extends BaseAdapter {

	private $ids = [ ];

	public function getUsersIds() {
		return $this->ids;
	}

	protected function extractSingle( $property ) {
		if ( isset( $property->Value ) ) {
			$this->ids[ ] = $property->Value;
		}
	}
}
