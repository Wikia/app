<?php

abstract class WikiaImport {
	var $i = 0;
	var $end = 0;
	var $verbose = true;
	var $overwrite = true;
	var $notify = "TOR";
	var $remoteUrl = "";
	var $remotePath = "";
	var $parameters = array(
		'overwrite' => 'Shall I overwite existing pages?',
	);

	function execute() {
		$this->msg( "\nWelcome! What shall we import today?\n", true );

		$this->getParams();

		$this->msg( "\n\nOK. Starting import!", true );

		while( $this->proceed() && $this->getSource() ) {
			if ( $this->getContent() ) {
				if ( $this->translate() ) {
					wfWaitForSlaves( 5 );
					$this->save();
				}
			}

			$this->i++;
		}
	}

	function proceed() {
		if ( empty( $this->end ) ) {
			return true;
		}

		return ( $this->i <= $this->end );
	}

	function getParams() {
		foreach ( $this->parameters as $param => $prompt ) {
			$input = trim( readline( $prompt . " (default: {$this->$param}) " ) );
			if ( !empty( $input ) ) {
				if ( in_array( $input, array( "no", "n", "N", "No" ) ) ) {
					$input = false;
				} elseif ( in_array( $input, array( "yes", "y", "Y", "Yes" ) ) ) {
					$input = true;
				}
				$this->$param = $input;
			}
		}
	}

	function getSource() {
		$this->mSource = false;

		$url = $this->getUrl();

		$this->msg( "Fetching source document from $url... " );

		$this->mSource = Http::get( $url );

		$this->msgStatus( $this->mSource );

		return (bool) $this->mSource;
	}

	abstract function getUrl();

	abstract function getContent();

	abstract function translate();

	function save() {
		global $wgUser, $wgTitle;

		// set username to something generic
		$wgUser = User::newFromName( 'Wikia' );

		$this->msg( "Saving article... " );

		$title = Title::newFromText( $this->mTitle );

		if ( $title->exists() && !$this->overwrite ) {
			$this->msg( "Article {$this->mTitle} already exists! Giving up (because you told me to)!", true, true );
			exit( 0 );
		}

		$wgTitle = $title;

		$article = new Article( $title );

		$status = $article->doEdit( $this->mWikitext, "Importing content" );

		$this->msgStatus( $status );
	}

	function msg( $text, $newline = false, $sendMail = false ) {
		if ( $this->verbose ) {
			$text = $newline ? $text . "\n" : $text;
			echo $text;
		}

		if ( $sendMail ) {
			$user = User::newFromName( $this->notify );
			$subject = "Import " . $this->remoteUrl . " failed at " . $this->i;
			$user->sendMail( $subject, $text );
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
