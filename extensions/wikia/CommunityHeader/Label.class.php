<?php

namespace Wikia\CommunityHeader;

class Label {
	const TYPE_TEXT = 'text';
	const TYPE_TRANSLATABLE_TEXT = 'translatable-text';

	public $key;
	public $type;
	public $value;
	public $iconKey;

	public function __construct( string $value, string $type = self::TYPE_TEXT, $iconKey = null ) {
		$this->type = $type;
		if ( $this->type === self::TYPE_TRANSLATABLE_TEXT ) {
			$this->key = $value;
		} else {
			$this->value = $value;
		}
		$this->iconKey = $iconKey;
	}

	public function render(): string {
		return \DesignSystemHelper::renderText( (array)$this );
	}

	public function renderInContentLang(): string {
		return \DesignSystemHelper::renderText( (array)$this, true );
	}
}
