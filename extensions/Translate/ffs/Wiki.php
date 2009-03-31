<?php
/**
 * Wike file format handler.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

class WikiFormatReader extends SimpleFormatReader {
	// Set by creater
	public $variableName = 'messages';

	/**
	 * Reads all \@author tags from the file and returns array of authors.
	 *
	 * @param $filename From which file to get the authors.
	 * @return Array of authors.
	 */
	public function parseAuthors() {
		if ( $this->filename === false ) {
			return array();
		}
		$contents = file_get_contents( $this->filename );
		$m = array();
		$count = preg_match_all( '/@author (.*)/', $contents, $m );
		return $m[1];
	}

	public function parseStaticHeader() {
		if ( $this->filename === false ) {
			return '';
		}
		$contents = file_get_contents( $this->filename );

		/** FIXME: handle the case where the first comment is missing */
		$dollarstart = strpos( $contents, '$' );

		$start = strpos( $contents, '*/' );
		$end = strpos( $contents, '$messages' );
		if ( $start === false ) return '';
		if ( $start === $end ) return '';
		$start += 2; // Get over the comment ending
		if ( $end === false ) return trim( substr( $contents, $start ) );
		return trim( substr( $contents, $start, $end - $start ) );
	}

	public function parseMessages( StringMangler $mangler ) {
		if ( $this->filename === false ) {
			return array();
		}
		$ { $this->variableName } = array();
		require( $this->filename );
		return $mangler->mangle( $ { $this->variableName } );
	}

}

class WikiFormatWriter extends SimpleFormatWriter {
	public $commaToArray = false;

	public function makeHeader( $handle, $code ) {
		list( $name, $native ) = $this->getLanguageNames( $code );
		$authors = $this->formatAuthors( ' * @author ', $code );

		fwrite( $handle, <<<HEADER
<?php
/** $name ($native)
 *
 * @ingroup Language
 * @file
 *
$authors */

HEADER
		);
	}

	protected function exportStaticHeader( $target ) {
		if ( $this->staticHeader ) {
			fwrite( $target, "\n" . $this->staticHeader . "\n" );
		}
	}

	protected function exportMessages( $handle, MessageCollection $collection ) {
		fwrite( $handle, "\n\$messages = array(\n" );

		$messages = $this->makeExportArray( $collection );

		$dir = $this->group->getMetaDataPrefix();
		if ( !$dir ) {
			$this->writeMessagesBlock( $handle, $messages );
			fwrite( $handle, ");\n" );
			return;
		}

		require( $dir . '/messages.inc' );

		# Sort messages to blocks
		$sortedMessages['unknown'] = $messages;
		foreach ( $wgMessageStructure as $blockName => $block ) {
			foreach ( $block as $key ) {
				if ( array_key_exists( $key, $sortedMessages['unknown'] ) ) {
					$sortedMessages[$blockName][$key] = $sortedMessages['unknown'][$key];
					unset( $sortedMessages['unknown'][$key] );
				}
			}
		}

		foreach ( $sortedMessages as $block => $messages ) {
			# Skip if it's the block of unknown messages - handle that in the end of file
			if ( $block == 'unknown' ) continue;
			$this->writeMessagesBlockComment( $handle, $wgBlockComments[$block] );
			$this->writeMessagesBlock( $handle, $messages );
			fwrite( $handle, "\n" );
		}

		# Write the unknown messages, alphabetically sorted.
		if ( count( $sortedMessages['unknown'] ) ) {
			ksort( $sortedMessages['unknown'] );
			$this->writeMessagesBlockComment( $handle, 'Unknown messages' );
			$this->writeMessagesBlock( $handle, $sortedMessages['unknown'] );
		}

		fwrite( $handle, ");\n" );
	}

	/**
	 * Preprocesses MessageArray to suitable format and filters things that should
	 * not be exported.
	 *
	 * @param $array Reference of MessageArray.
	 */
	public function makeExportArray( MessageCollection $messages ) {
		// We copy only relevant translations to this new array
		$new = array();
		$mangler = $this->group->getMangler();
		foreach ( $messages as $key => $m ) {
			$key = $mangler->unMangle( $key );
			# Remove fuzzy markings before export
			$translation = str_replace( TRANSLATE_FUZZY, '', $m->translation );
			$new[$key] = $translation;
		}

		return $new;
	}

	protected function writeMessagesBlockComment( $handle, $blockComment ) {
		# Format the block comment (if exists); check for multiple lines comments
		if ( !empty( $blockComment ) ) {
			if ( strpos( $blockComment, "\n" ) === false ) {
				fwrite( $handle, "# $blockComment\n" );
			} else {
				fwrite( $handle, "/*\n$blockComment\n*/\n" );
			}
		}
	}

	protected function writeMessagesBlock( $handle, $messages, $prefix = '' ) {
		# Skip the block if it includes no messages
		if ( empty( $messages ) ) {
			return;
		}

		foreach ( $messages as $key => $value ) {
			fwrite( $handle, $prefix );
			$this->exportItemPad( $handle, $key, $value );
		}
	}

	protected function exportItemPad( $handle, $key, $value, $pad = 0 ) {
		# Add the key name
		fwrite( $handle, "'$key'" );
		# Add the appropriate block whitespace
		if ( $pad ) fwrite( $handle, str_repeat( ' ', $pad - strlen( $key ) ) );
		fwrite( $handle, ' => ' );

		if ( $this->commaToArray ) {
			fwrite( $handle, 'array( ' );
			$values = array_map( 'trim', explode( ',', $value ) );
			$values = array_map( array( __CLASS__, 'quote' ), $values );
			fwrite( $handle, implode( ', ', $values ) );
			fwrite( $handle, " ),\n" );
		} else {
			fwrite( $handle, self::quote( $value ) );
			fwrite( $handle, ",\n" );
		}
	}

	public static function quote( $value ) {
		# Check for the appropriate apostrophe and add the value
		# Quote \ here, because it needs always escaping
		$value = addcslashes( $value, '\\' );

		# For readability
		$single = "'";
		$double = '"';
		$quote = $single;

		# It is safe to use '-quoting, unless there is '-quote in the text
		if ( strpos( $value, $single ) !== false ) {

			# In case there is no variables that need to be escaped, just use "-quote
			if ( strpos( $value, $double ) === false && !preg_match( '/\$[^0-9]/', $value ) ) {
				$quote = $double;

			# Something needs quoting, pick the quote which causes less quoting
			} else {
				$doubleEsc = substr_count( $value, $double ) + substr_count( $value, '$' );
				$singleEsc = substr_count( $value, $single );

				if ( $doubleEsc < $singleEsc ) {
					$quote = $double;
					$extra = '$';
				} else {
					$extra = '';
				}

				$value = addcslashes( $value, $quote . $extra );
			}
		}

		return $quote . $value . $quote;
	}
}
