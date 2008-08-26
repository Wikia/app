<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "UnicodeConverter extension\n";
	exit( 1 );
}

wfLoadExtensionMessages( 'UnicodeConverter' );

class UnicodeConverter extends SpecialPage
{
	function UnicodeConverter() {
		SpecialPage::SpecialPage("UnicodeConverter");
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle;

		$this->setHeaders();

		$q = $wgRequest->getText( 'q' );
		$encQ = htmlspecialchars( $q );
		$action = $wgTitle->escapeLocalUrl();
		$ok = htmlspecialchars( wfMsg( 'unicodeconverter-ok' ) );

		$wgOut->addHTML( <<<END
<form name="ucf" method="post" action="$action">
<textarea rows="15" cols="80" name="q">$encQ</textarea><br />
<input type="submit" name="submit" value="$ok" /><br /><br />
</form>
END
);

		if ( !is_null( $q ) ) {
			$html = wfUtf8ToHTML( htmlspecialchars( $q ) );
			$wgOut->addHTML( "<br /><b>". wfMsg('unicodeconverter-oldtext'). "</b><br /><br />" . nl2br( $html ) . "<br /><br /><hr /><br /><b>" . wfMsg('unicodeconverter-newtext'). "</b><br /><br />".
			  nl2br( htmlspecialchars( $html ) ) . "<br /><br />" );
		}
	}
}

# Converts a single UTF-8 character into the corresponding HTML character entity
function wfUtf8Entity( $matches ) {
	$char = $matches[0];
	# Find the length
	$z = ord( $char{0} );
	if ( $z & 0x80 ) {
		$length = 0;
		while ( $z & 0x80 ) {
			$length++;
			$z <<= 1;
		}
	} else {
		$length = 1;
	}

	if ( $length != strlen( $char ) ) {
		return '';
	}
	if ( $length == 1 ) {
		return $char;
	}

	# Mask off the length-determining bits and shift back to the original location
	$z &= 0xff;
	$z >>= $length;

	# Add in the free bits from subsequent bytes
	for ( $i=1; $i<$length; $i++ ) {
		$z <<= 6;
		$z |= ord( $char{$i} ) & 0x3f;
	}

	# Make entity
	return "&#$z;";
}

# Converts all multi-byte characters in a UTF-8 string into the appropriate character entity
function wfUtf8ToHTML($string) {
	return preg_replace_callback( '/[\\xc0-\\xfd][\\x80-\\xbf]*/', 'wfUtf8Entity', $string );
}
