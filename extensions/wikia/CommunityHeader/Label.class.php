<?php
namespace CommunityHeader;

class Label {
	public function __construct( $value, $type = 'text' ) {
		$this->type = $type;
		if ( $this->type === 'translatable-text' ) {
			$this->key = $value;
		} else {
			$this->value = $value;
		}
	}
}
