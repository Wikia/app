<?php
/**
 * Java properties file format handler.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/**
 * Reader for java property files. Not completely general, as it excepts two
 * comment sections at the top, separated by a blank line.
 *
 * Authors in the first section are detected, if prefixed with '# Author: '.
 * Second section (if any) is returned verbatim.
 */
class JavaFormatReader extends SimpleFormatReader {

	/**
 	 * Inherited from SimpleFormatReader, which parses whole header in one pass.
	 * Basically the same, with different author prefix and separator between
	 * headers and messages.
	 *
	 * FIXME: possible to refactor to reduce duplication?
	 */
	protected function parseHeader() {
		$authors = array();
		$staticHeader = '';

		if ( $this->filename !== false ) {
			$handle = fopen( $this->filename, "rt" );
			$state = 0;

			while ( !feof( $handle ) ) {
				$line = fgets( $handle );

				if ( $state === 0 ) {
					if ( $line === "\n" ) {
						$state = 1;
						continue;
					}

					$formatPrefix = '# Author: ';

					$prefixLength = strlen( $formatPrefix );
					$prefix = substr( $line, 0, $prefixLength );
					if ( strcasecmp( $prefix, $formatPrefix ) === 0 ) {
						// fgets includes the trailing newline, trim to get rid of it
						$authors[] = trim( substr( $line, $prefixLength ) );
					}
				} elseif ( $state === 1 ) {
					if ( $line === "\n" || $line[0] !== '#' ) {
						break; // End of static header, if any
					}
					$staticHeader .= $line;
				}
			}

			fclose( $handle );
		}

		$this->authors = $authors;
		$this->staticHeader = $staticHeader;
	}

	/**
	 * Parses messages from lines key=value. Whitespace is trimmer around key and
	 * values. New lines inside values have to be escaped as '\n'. Lines which do
	 * not have = are ignored. Comments are designated by # at the start of the
	 * line only. Values can have = characters, only the first one is considered
	 * separator.
	 */
	public function parseMessages( StringMangler $mangler ) {
		if ( !file_exists( $this->filename ) ) {
			return null;
		}

		# This format works nicely with line based parsing
		$lines = array_map( 'trim', file( $this->filename ) );
		if ( !$lines ) { return null; }

		$messages = array();

		foreach ( $lines as $line ) {
			if ( $line === '' || !strpos( $line, '=' ) || $line[0] === '#' ) { continue; }
			list( $key, $value ) = explode( '=', $line, 2 );
			$messages[$mangler->mangle( trim( $key ) )] = trim( $value );
		}
		return $messages;
	}
}

/**
 * Very simple writer for exporting messages to Java property files from wiki.
 */
class JavaFormatWriter extends SimpleFormatWriter {

	/**
	 * Inherited. Very simplistic header with timestamp.
	 */
	public function makeHeader( $handle, $code ) {
		global $wgSitename;
		list( $name, $native ) = $this->getLanguageNames( $code );
		$authors = $this->formatAuthors( '# Author: ', $code );
		$when = wfTimestamp( TS_ISO_8601 );

		fwrite( $handle, <<<HEADER
# Messages for $name ($native)
# Exported from $wgSitename
$authors

HEADER
		);
	}

	/**
	 * Inherited. Exports messages as lines of format key=value.
	 */
	protected function exportMessages( $handle, MessageCollection $collection ) {
		$mangler = $this->group->getMangler();
		foreach ( $collection->keys() as $item ) {
			$key = $mangler->unmangle( $item );
			$value = str_replace( TRANSLATE_FUZZY, '', $collection[$item]->translation );

			# Make sure we don't slip newlines trough... it would be fatal
			$value = str_replace( "\n", '\\n', $value );
			# No pretty alignment here, sorry
			fwrite( $handle, "$key=$value\n" );
		}
	}

}