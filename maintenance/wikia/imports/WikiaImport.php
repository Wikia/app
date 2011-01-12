<?php

class WikiaImport {
	var $i = 0;
	var $verbose = true;

	function execute() {
		while( $this->getSource() ) {
			if ( $this->getContent() ) {
				if ( $this->translate() ) {
					$this->save();
				}
			}

			$this->i++;
		}
	}

	function getSource() {
		$this->mSource = false;

		$url = $this->remoteUrl . $this->remotePath . $this->i;

		$this->msg( "Fetching source document from $url... " );

		$this->mSource = Http::get( $url );

		$this->msgStatus( $this->mSource );

		return (bool) $this->mSource;
	}

	function getContent() { return false; }

	function translate() { return false; }

	function save() {
		$this->msg( "Saving article... " );

		$title = Title::newFromText( $this->mTitle );

		$wgTitle = $title;
		$wgUser = User::newFromName( 'Wikia' );

		$article = new Article( $title );

		$status = $article->doEdit( $this->mWikitext, "Importing content" );

		$this->msgStatus( $status );
	}

	function msg( $text, $newline = false ) {
		if ( $this->verbose ) {
			$text = $newline ? $text . "\n" : $text;
			echo $text;
		}
	}

	function msgStatus( $status ) {
		if ( $status ) {
			$text = "[done]";
		} else {
			$text = "[failed]";
		}

		$this->msg( $text, true );
	}
}
