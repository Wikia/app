<?php

class FCKeditorParserOptions extends ParserOptions {
	function getNumberHeadings() { return false; }
	function getEditSection() { return false; }

	function getSkin( $title = null ) {
		if ( !isset( $this->mSkin ) ) {
			$this->mSkin = new FCKeditorSkin( $this->mUser->getSkin( $title ) );
		}
		return $this->mSkin;
	}
}
