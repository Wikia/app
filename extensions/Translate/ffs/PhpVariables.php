<?php
/**
 * PHP variables file format handler.
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/**
 * Reader for PHP variables files. Not completely general, as it excepts two
 * comment sections at the top, separated by a blank line.
 *
 * Authors in the first section are detected, if prefixed with '# Author: '.
 * Second section (if any) is returned verbatim.
 */
class PhpVariablesFormatReader extends SimpleFormatReader {

	/**
	 * Reads all \@author tags from the file and returns array of authors.
	 *
	 * @param $filename From which file to get the authors.
	 * @return Array of authors.
	 *
	 * FIXME: possible to refactor to reduce duplication? (copy from Wiki.php)
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

		$data = file_get_contents( $this->filename );

		$matches = array();
		$regex = '/^\$(.*?)\s*=\s*[\'"](.*?)[\'"];.*?$/mus';
		preg_match_all( $regex, $data, $matches, PREG_SET_ORDER );
		$messages = array();
		foreach ( $matches as $_ ) {
			$legal = Title::legalChars();
			$key = preg_replace( "/([^$legal]|\\\\)/ue", '\'\x\'.' . "dechex(ord('\\0'))", $_[1] );
			$value = str_replace( array( "\'", "\\\\" ), array( "'", "\\" ), $_[2] );
			$messages[$key] = $value;
		}
		return $messages;
	}
}

/**
 * Very simple writer for exporting messages to PhpVariables property files from wiki.
 */
class PhpVariablesFormatWriter extends SimpleFormatWriter {

	// Ugly. Should be in Mantis.php or something
	public function makeHeader( $handle, $code ) {
		list( $name, $native ) = $this->getLanguageNames( $code );
		$authors = $this->formatAuthors( ' * @author ', $code );

		fwrite( $handle, <<<HEADER
<?php
/** MantisBT - a php based bugtracking system
 *
 * Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * Copyright (C) 2002 - 2009  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 *
 * MantisBT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * MantisBT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.
 */

/** $name ($native)
 *
 * @ingroup Language
 * @file
 *
$authors */


HEADER
		);
	}

	/**
	 * Inherited. Exports messages as lines of format $key = 'value'.
	 */
	protected function exportMessages( $handle, MessageCollection $collection ) {
		$mangler = $this->group->getMangler();
		foreach ( $collection->keys() as $item ) {

			$key = $mangler->unmangle( $item );
			$key = stripcslashes( $key );

			$value = $collection[$item]->translation;
			$value = str_replace( TRANSLATE_FUZZY, '', $value );
			$value = addcslashes( $value, "'" );

			# No pretty alignment here, sorry
			fwrite( $handle, "$$key = '$value';\n" );
		}
	}
}
