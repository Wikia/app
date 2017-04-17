<?php

class InfoboxReplaceHelper {

	public function processLayoutAttribute( $content ) {
		return preg_replace_callback( '/<infobox([^>]*)>/i', [ $this, 'replace' ], $content );
	}

	private function replace( $matches ) {
		if ( $this->hasLayout( $matches[0] ) ) {
			return $matches[0];
		}
		print( "... replaced!\n" );
		return preg_replace( '/<infobox/i', '<infobox layout="stacked"', $matches[0] );
	}

	private function hasLayout( $subject ) {
		return strpos( $subject, 'layout' ) !== false;
	}
}
