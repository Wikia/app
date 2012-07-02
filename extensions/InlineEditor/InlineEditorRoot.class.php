<?php
/**
 * This is a special marking that spans all wikitext.
 */
class InlineEditorRoot extends InlineEditorMarking {
	function __construct( &$wiki ) {
		parent::__construct( 0, strlen( $wiki ), 'rootElement inlineEditorBasic', true, true, 0, false );
		$this->id = 'inline-editor-root';
	}
}
