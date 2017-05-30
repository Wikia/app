<?php

namespace CommunityHeader;

class Label {
	const TYPE_TEXT = 'text';
	const TYPE_TRANSLATABLE_TEXT = 'translatable-text';

	public function __construct( string $value, string $type = self::TYPE_TEXT ) {
		$this->type = $type;
		if ( $this->type === self::TYPE_TRANSLATABLE_TEXT ) {
			$this->key = $value;
		} else {
			$this->value = $value;
		}
	}

	public function render( bool $inContentLang = false ): string {
		return \DesignSystemHelper::renderText( (array)$this, $inContentLang );
	}
}
