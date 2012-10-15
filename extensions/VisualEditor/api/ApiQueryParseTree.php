<?php

/**
 * API module to parse wikitext articles using the new parser, which as of early 2012 is node.js-based.
 *
 * @file ApiQueryParseTree.php
 *
 * @license GNU GPL v2 or later
 * @author Neil Kandalgaonkar <neilk@wikimedia.org>
 */


class ApiQueryParseTree extends ApiQueryBase {

	const paramPrefix = 'pa';

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, self::paramPrefix );
	}
	
	/**
	 * Obtain the parse of a wiki article
	 */
	public function execute() {
		$titles = $this->getPageSet()->getGoodTitles();
		if ( count( $titles ) == 0 ) {
			return;
		}

		$params = $this->extractRequestParams();

		foreach( $titles as $title ) {
			$pageId = $title->getArticleID();
			if ( ! $title->hasSourceText() ) {
				$results = array( 'errors' => 'Title does not exist' );
			} else if ( ! $title->userCan( 'read' ) ) {
				$results = array( 'errors' => 'Cannot read this title' );
			} else {
				# Get the article text
				$rev = Revision::newFromTitle( $title );
				if ( !is_object( $rev ) ){
					$results = array( 'errors' => 'Could not get revision' );
				} else {
					$text = $rev->getText();
					$results['contents'] = $this->getParseTree( $text );
				}
			}
			foreach ( $results as $elementName => $item ) {
				$fit = $this->addPageSubItem( $pageId, $item, $elementName );
				if ( ! $fit ) {
					/* ?? this should never happen */ 
				}
			}
		}
	}
	
	/** 
	 * Execute a shell command to obtain the parse tree of a string of wikitext
	 *
	 * @param String wikitext
	 * @return Array ret Array of two keys, 'contents' with script output, 'errors' with errors if any.
	 */ 
	public function getParseTree( $text ) {
		global $wgVisualEditorParserCmd, $wgServer, $wgScriptPath;

		// TODO This is probably not very portable to non-Unix OS. There's a lot of code in wfShellExec to make
		// that portable and secure on Windows etc. In any case the existing PHP-based parser calls out to an external script to do 
		// HTML-tidy anyway, in a similar manner, without any shell escapes...
		$cmd = join( " ", array( 
			$wgVisualEditorParserCmd, 
			'--wgScriptPath', wfEscapeShellArg( $wgServer . $wgScriptPath ),
		) );

		$parserIn = 0;
		$parserOut = 1;
		$parserErr = 2;

		$descriptorSpec = array(
			$parserIn => array( 'pipe', 'r' ), // child reads from stdin, we write
			$parserOut => array( 'pipe', 'w' ), // child writes to stdout, we read
			$parserErr => array( 'pipe', 'w' )  // child writes to stderr, we read
		);

		$pipes = array();

		$process = proc_open( $cmd, $descriptorSpec, $pipes );

		$ret = array( 'contents' => null );

		if ( is_resource( $process ) ) {
			// Theoretically, this style of communication could cause a deadlock
			// here. If the stdout buffer fills up, then writes to stdin could
			// block. 
			//
			// TODO This might be an opportune time to give the parser all the subtemplates it's going to need,
			// such that we can. The DB does have a mapping of title to templates used.
			// Would need a convention for indicating multiple files in the text we write to the parser, like mime multipart
			fwrite( $pipes[$parserIn], $text );
			fclose( $pipes[$parserIn] );
		
			$ret['contents'] = FormatJson::decode( self::readFilehandle( $pipes[$parserOut] ) );

			$errors = self::readFilehandle( $pipes[$parserErr] );
			if ( $errors != '' and $errors != null ) {
				$ret['errors'] = $errors;
			}

			$retval = proc_close( $process );
			if ( $retval != 0 ) {
				wfWarn( "Parser process returned $retval" );
				if ( !$ret['errors'] ) {
					$ret['errors'] = 'External parser process returned error code, check server logs';
				}
			}
		} else {
			wfWarn( "Unable to start external parser process" );
			$ret['errors'] = "Unable to start external parser process, check server logs";
		}

		return $ret;
	}

	/**
	 * Read filehandle until done. XXX May block!
	 * @param Filehandle $fh 
	 * @return String contents of filehandle until EOF
	 */
	public static function readFilehandle( $fh ) {
		$contents = '';
		// appends are probably slow, replace with array & join?
		while ( !feof( $fh ) ) {
			$contents .= fgets( $fh, 1024 );
		}
		fclose( $fh );
		return $contents;
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function getAllowedParams() {
		return array(
			'structure' => array(
				ApiBase::PARAM_TYPE => array( 'wikidom' ),
				ApiBase::PARAM_DFLT => 'wikidom',
				ApiBase::PARAM_ISMULTI => false,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'structure' => 'How to structure the parse tree.'
		);
	}

	public function getDescription() {
		return 'Returns parse tree of the given page(s)';
	}

	public function getExamples() {
		return array(
			'Get a parse tree of the [[Main Page]]:',
			'  api.php?action=query&prop=parsetree&titles=Main%20Page',
			'',
			'Get a parse tree with a specific structure:',
			'  api.php?action=query&prop=parsetree&' . self::paramPrefix .'structure=wikidom&titles=Main%20Page',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}	

	// TODO errors!

}


