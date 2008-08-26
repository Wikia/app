<?php

/**
 * Trivial extension to provide form value preloading from GET/POST/cookie.
 * Works on forms emitted by $wgRawHtml or parser extensions. 
 * Operates post-parser-cache, co-operates with squid cache.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}
if ( $wgUseFileCache ) {
	echo "FormPreloadPostCache does not work with \$wgUseFileCache\n";
	exit( 1 );
}

$wgHooks['OutputPageBeforeHTML'][] = 'FormPreloadPostCache::htmlHook';

class FormPreloadPostCache {
	static function htmlHook( &$outputPage, &$text ) {
		global $wgRequest;

		$dom = new DOMDocument;
		wfSuppressWarnings();
		$result = $dom->loadHTML( <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>$text</body>
</html>
EOT
);
		wfRestoreWarnings();
		if ( !$result ) {
			return true;
		}

		$preloads = $wgRequest->getArray( 'fppc' );
		if ( !$preloads ) {
			return true;
		}

		$xpath = new DOMXPath( $dom );

		// <input/>
		$inputs = $xpath->query( '//input' );
		foreach ( $inputs as $input ) {
			$name = $input->getAttribute( 'name' );
			if ( !isset( $preloads[$name] ) ) {
				continue;
			}
			$type = strtolower( $input->getAttribute( 'type' ) );
			if ( $type == 'text' ) {
				$input->setAttribute( 'value', $preloads[$name] );
			} elseif ( $type == 'checkbox' ) {
				if ( $preloads[$name] ) {
					$input->setAttribute( 'checked', '1' );
				} else {
					$input->removeAttribute( 'checked' );
				}
			}
		}

		// <select>
		$selects = $xpath->query( '//select' );
		foreach ( $selects as $select ) {
			$name = $select->getAttribute( 'name' );
			if ( !isset( $preloads[$name] ) ) {
				continue;
			}
			$preload = $preloads[$name];
			$options = $xpath->query( 'option', $select );
			$found = false;
			foreach ( $options as $option ) {
				if ( !$found && $option->getAttribute( 'value' ) == $preload ) {
					$found = true;
					$option->setAttribute( 'selected', '1' );
				} else {
					$option->removeAttribute( 'selected' );
				}
			}
		}

		// <textarea>
		$textareas = $xpath->query( '//textarea' );
		foreach ( $textareas as $textarea ) {
			$name = $textarea->getAttribute( 'name' );
			if ( isset( $preloads[$name] ) ) {
				while ( $textarea->childNodes->length ) {
					$textarea->removeChild( $textarea->childNodes->item( 0 ) );
				}
				$textarea->appendChild( $dom->createTextNode( $preloads[$name] ) );
			}
		}

		$dom->encoding = 'utf-8';
		$result = $dom->saveHTML();
		if ( preg_match( '!<body>(.*)</body>!s', $result, $m ) ) {
			$text = $m[1];
		} else {
			var_dump( $result );
		}
		return true;
	}
}
