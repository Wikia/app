<?php

class PBWikiImporter extends ReverseImporter {

	function adjustPreParse() {
		// convert strongs to bs
		$this->mText = str_replace( 'strong>', 'b>', $this->mText );

		// replace nbsp by spaces
		$this->mText = str_replace( '&nbsp;', ' ', $this->mText );

		// remove invalid imgs
		$this->mText = preg_replace( '|<img.*src="file:///.*">|', '', $this->mText );

		// replace valid imgs by placeholder
		$this->mText = str_replace( '<img', 'this_is_an_img', $this->mText );

		return true;
	}

	function adjustPostParse() {
		// unreplace valid imgs
		$this->mWikiText = str_replace( 'this_is_an_img', '[[Image:', $this->mWikiText );
		$this->mWikiText = preg_replace( '|\[\[Image:.*/(.*)">|', '[[Image:\1|thumb|]]', $this->mWikiText );

		// remove empty headers
		// FIXME: this should really be more inteligent
		$this->mWikiText = preg_replace( '/======/', '', $this->mWikiText );

		// remove unneeded newlines
		$this->mWikiText = preg_replace( '/\n\n\n/m', "\n\n", $this->mWikiText );
		$this->mWikiText = preg_replace( '/\n\n\n/m', "\n\n", $this->mWikiText );
		$this->mWikiText = preg_replace( '/\n\n\n/m', "\n\n", $this->mWikiText );

		return true;
	}

	function getUser() {
		$user = null;

		preg_match( '/<!-- name=(.*) -->/', $this->mText, $matches );

		if ( !empty( $matches[1] ) ) {
			$user = User::newFromName( $matches[1] );
			if ( is_object( $user ) ) {
				// do not assign edits to a user ID, just use the name
				$user->setId( 0 );
				$user->mFrom = 'name';
			}
		}

		return $user;
	}
}
