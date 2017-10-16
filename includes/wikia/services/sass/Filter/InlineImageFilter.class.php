<?php

namespace Wikia\Sass\Filter;

/**
 * Inline image filter handles encoding and embedding files in CSS stylesheet
 * for URLs marked to be processed that way.
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 * @author Bartosz V. Bentkowski <v@wikia-inc.com>
 */
class InlineImageFilter extends Filter {

	protected $rootDir;

	public function __construct( $rootDir ) {
		$this->rootDir = $rootDir;
	}

	public function process( $contents ) {
		wfProfileIn( __METHOD__ );

		$contents = preg_replace_callback( "/([, ]url[^\n]*?\))([^\n]*?)(\s*\/\*\s*inline\s*\*\/)/is", [$this, 'processMatches'], $contents );

		wfProfileOut( __METHOD__ );

		return $contents;
	}

	protected function processMatches( $matches ) {
		$fileName = $this->rootDir . trim( substr( $matches[1], 4, -1 ), '\'"() ' );

		$inlined = $this->inlineFile( $fileName );
		if ( $inlined !== false ) {
			return " url({$inlined}){$matches[2]}";
		} else {
			throw new \Wikia\Sass\Exception( "/* Putting image inline failed: {$fileName} not found or not supported! */" );
		}
	}

	protected function inlineFile( $fileName ) {
		wfProfileIn( __METHOD__ );

		if ( !$this->checkFileExists( $fileName ) ) {
			wfProfileOut( __METHOD__ );

			return false;
		}

		$parts = explode( '.', $fileName );
		$ext = end( $parts );

		$enableBase64 = true;

		switch ( $ext ) {
			case 'gif':
			case 'png':
				$type = $ext;
				break;
			case 'jpg':
				$type = 'jpeg';
				break;
			case 'svg':
				$type = 'svg+xml;charset=utf-8,'; // include charset
				$enableBase64 = false;
				break;
			// not supported image type provided
			default:
				wfProfileOut( __METHOD__ );

				return false;
		}

		$content = $this->getFileContent( $fileName );

		$out = "\"data:image/{$type}";
		if ($enableBase64) {
			$out .= ';base64,';
			$content = base64_encode( $content );
		} else {
			$content = rawurlencode( $content );
		}
		$out .= $content;
		$out .= '"';

		wfProfileOut( __METHOD__ );

		return $out;
	}

	protected function checkFileExists( $fileName ) {
		return file_exists( $fileName );
	}

	protected function getFileContent( $fileName ) {
		return file_get_contents( $fileName );
	}

}
