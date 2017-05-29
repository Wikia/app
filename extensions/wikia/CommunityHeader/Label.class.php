<?php

namespace CommunityHeader;

class Label {
	const TYPE_TEXT = 'text';
	const TYPE_TRANSLATABLE_TEXT = 'translatable-text';

	public function __construct( $value, $type = self::TYPE_TEXT ) {
		$this->type = $type;
		if ( $this->type === self::TYPE_TRANSLATABLE_TEXT ) {
			$this->key = $value;
		} else {
			$this->value = $value;
		}
	}

	public function render( bool $inContentLang = false ) {
		return \DesignSystemHelper::renderText( (array) $this, $inContentLang );
	}
}
