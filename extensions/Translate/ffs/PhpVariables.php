<?php
/**
 * PHP variables file format handler.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements file format support for PHP files which consist of multiple
 * variable assignments.
 */
class FlatPhpFFS extends SimpleFFS {
	//
	// READ
	//
	public function readFromVariable( $data ) {
		# Authors first
		$matches = array();
		preg_match_all( '/^ \* @author\s+(.+)$/m', $data, $matches );
		$authors = $matches[1];

		# Then messages
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

		$messages = $this->group->getMangler()->mangle( $messages );

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages,
		);
	}

	//
	// WRITE
	//
	protected function writeReal( MessageCollection $collection ) {
		if ( isset( $this->extra['header'] ) ) {
			$output = $this->extra['header'];
		} else {
			$output = "<?php\n";
		}

		$output  .= $this->doHeader( $collection );

		$mangler = $this->group->getMangler();

		foreach ( $collection as $item ) {
			$key = $mangler->unmangle( $item->key() );
			$key = stripcslashes( $key );

			$value = $item->translation();
			if ( $value === null ) {
				continue;
			}

			$value = str_replace( TRANSLATE_FUZZY, '', $value );
			$value = addcslashes( $value, "'" );

			$output .= "\$$key = '$value';\n";
		}

		return $output;
	}

	protected function doHeader( MessageCollection $collection ) {
		global $wgSitename, $wgTranslateDocumentationLanguageCode;

		$code = $collection->code;
		$name = TranslateUtils::getLanguageName( $code );
		$native = TranslateUtils::getLanguageName( $code, true );

		if ( $wgTranslateDocumentationLanguageCode ) {
			$docu = "\n * See the $wgTranslateDocumentationLanguageCode 'language' for message documentation incl. usage of parameters";
		} else {
			$docu = '';
		}

		$authors = $this->doAuthors( $collection );

		$output = <<<PHP
/** $name ($native)
 * $docu
 * To improve a translation please visit http://$wgSitename
 *
 * @ingroup Language
 * @file
 *
$authors */


PHP;
		return $output;
	}

	protected function doAuthors( MessageCollection $collection ) {
		$output = '';
		$authors = $collection->getAuthors();
		$authors = $this->filterAuthors( $authors, $collection->code );

		foreach ( $authors as $author ) {
			$output .= " * @author $author\n";
		}

		return $output;
	}
}
