<?php

class FCKeditorParserOptions extends ParserOptions
{
	function getNumberHeadings() {return false;}
	function getEditSection() {return false;}

	function getSkin() {
		if ( !isset( $this->mSkin ) ) {
			$this->mSkin = new FCKeditorSkin( $this->mUser->getSkin() );
		}
		return $this->mSkin;
	}
}
