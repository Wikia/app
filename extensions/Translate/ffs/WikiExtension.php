<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * Multiple language wiki file format handler.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

class WikiExtensionFormatReader extends WikiFormatReader {
	public function parseSections( $var ) {
		if ( $this->filename === false ) {
			return array( '', array() );
		}

		$data = file_get_contents( $this->filename ) . "\n";

		$headerP = "
		.*? # Ungreedily eat header
		\\$$var \s* = \s* array \s* \( \s* \) \s*;";
		/*
		* x to have nice syntax
		* u for utf-8
		* s for dot matches newline
		*/
		$fileStructure = "~^($headerP)(.*)~xsu";

		$matches = array();
		if ( !preg_match( $fileStructure, $data, $matches ) ) {
			throw new MWException( "Unable to parse file structure" );
		}

		list( , $header, $data ) = $matches;

		$sectionP = '(?: /\*\* .*? \*/ )? (?: .*?  \n\);\n\n )';
		$codeP = "\\$$var\[' (.*?) '\]";

		$sectionMatches = array();
		if ( !preg_match_all( "~$sectionP~xsu", $data, $sectionMatches, PREG_SET_ORDER ) ) {
			throw new MWException( "Unable to parse sections" );
		}

		$sections = array();
		$unknown = array();
		foreach ( $sectionMatches as $index => $data ) {
			$code = array();
			if ( !preg_match( "~$codeP~xsu", $data[0], $code ) ) {
				echo "Malformed section:\n$data[0]";
				$unknown[] = $data[0];
			} else {
				$sections[$code[1]] = $data[0];
			}
		}

		if ( $unknown )
			$sections[] = implode( "\n", $unknown );

		return array( $header, $sections );
	}

	public function parseMessages( StringMangler $mangler ) {
		if ( $this->filename === false ) {
			return array();
		}
		$ { $this->variableName } = array();
		require( $this->filename );
		$messages = $ { $this->variableName } ;
		foreach ( $messages as $code => $value ) {
			$messages[$code] = $mangler->mangle( $value );
		}
		return $messages;
	}
}

class WikiExtensionFormatWriter extends WikiFormatWriter {

	// Inherit
	protected $authors;

	// Own data
	protected $header = '';
	protected $sections;

	// Set by creater
	public $variableName = 'messages';

	public function fileExport( array $languages, $targetDirectory ) {

		$filename = $this->group->getMessageFile( '' );
		$target = $targetDirectory . '/' . $filename;

		wfMkdirParents( dirname( $target ) );
		$handle = fopen( $target, 'wt' );
		if ( $handle === false ) {
			throw new MWException( "Unable to open target for writing" );
		}

		$this->doExport( $handle, $languages );

		fclose( $handle );
	}

	public function webExport( MessageCollection $collection ) {
		$code = $collection->code; // shorthand

		// Open temporary stream
		$filename = $this->group->getMessageFile( $code );
		$handle = fopen( 'php://temp', 'wt' );

		$this->addAuthors( $collection->getAuthors(), $code );
		$this->doExport( $handle, array( $collection->code ) );

		// Fetch data
		rewind( $handle );
		$data = stream_get_contents( $handle );
		fclose( $handle );
		return $data;
	}

	protected function doExport( $handle, $languages ) {
		$this->_load();
		$this->_makeHeader( $handle );

		$this->exportSection( $handle, 'en', $languages );
		$this->exportSection( $handle, 'qqq', $languages );

		$__languages = Language::getLanguageNames( false );
		foreach ( array_keys( $__languages ) as $code ) {
			if ( $code === 'en' || $code === 'qqq' ) continue;
			$this->exportSection( $handle, $code, $languages );
		}
	}

	protected function exportSection( $handle, $code, array $languages ) {
		// Never export en, just copy it verbatim
		if ( in_array( $code, $languages ) && $code !== 'en' ) {

			// Parse authors only if we regenerate section
			if ( isset( $this->sections[$code] ) ) {
				$authors = $this->parseAuthorsFromString( $this->sections[$code] );
				$this->addAuthors( $authors, $code );
			}
			$this->writeSection( $handle, $code );
			unset( $this->sections[$code] );
		} elseif ( isset( $this->sections[$code] ) ) {
			fwrite( $handle, $this->sections[$code] );
			unset( $this->sections[$code] );
		}
	}

	protected function writeSection( $handle, $code ) {
		$messages = $this->getMessagesForExport( $this->group, $code );
		$messages = $this->makeExportArray( $messages );
		if ( count( $messages ) ) {
			list( $name, $native ) = $this->getLanguageNames( $code );
			$authors = $this->formatAuthors( ' * @author ', $code );
			if ( !empty( $authors ) )
				$authors = "\n$authors";

			fwrite( $handle, "/** $name ($native)$authors */\n" );
			fwrite( $handle, "\${$this->variableName}['$code'] = array(\n" );
			$this->writeMessagesBlock( $handle, $messages, "\t" );
			fwrite( $handle, ");\n\n" );
		}
	}

	public function parseAuthorsFromString( $string ) {
		$count = preg_match_all( '/@author (.*)/', $string, $m );
		return $m[1];
	}

	public function _load() {
		$reader = $this->group->getReader( 'mul' );
		if ( $reader instanceof WikiExtensionFormatReader ) {
			list( $this->header, $this->sections ) = $reader->parseSections( $this->group->getVariableName() );
		}
	}

	public function _makeHeader( $handle ) {
		if ( $this->header ) {
			fwrite( $handle, $this->header );
		}
	}

	// Inherit
	# protected function writeMessagesBlock( $handle, $messages );
}
