<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'NumberFormat',
	'version' => '0.6.0', // 2012-10-25
	'descriptionmsg' => 'numberformat_desc',
	'author' => array(
		'[[mw:User:Patrick Nagel|Patrick Nagel]]',
		'[[mw:User:Pastakhov|Pavel Astakhov]]'
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:NumberFormat',
);

$dir = __DIR__;
$wgExtensionMessagesFiles['NumberFormat'] = $dir . '/NumberFormat.i18n.php';
$wgExtensionMessagesFiles['NumberFormatMagic'] = $dir . '/NumberFormat.i18n.magic.php';
$wgHooks['ParserFirstCallInit'][] = 'number_format_Setup';

function number_format_Setup( Parser $parser )	 {
	$parser->setFunctionHook( 'number_format', 'NumberFormart::number_format_Render' );
	return true;
}

class NumberFormart {

	public static function number_format_Render( &$parser ) {
		wfProfileIn(__METHOD__);
		// {{#number_format:number|decimals|dec_point|thousands_sep}}

		// Get the parameters that were passed to this function
		$params = func_get_args();
		array_shift( $params );
		$paramcount = count( $params );

		if ( isset( $params[0] ) && $params[0] == '' ) {
			wfProfileOut(__METHOD__);
			return '';
		}

		switch ( $paramcount ) {
			case 5:
				// Since 'space' cannot be passed through parser functions, users are advised to use
				// the underscore instead. Converting back to space here.
				if ( $params[4] == '_' ) {
					$params[4] = ' ';
				}
				$params[0] = str_replace( $params[4], '.', $params[0] );
			case 4:
				if ( $params[3] == '_' ) {
					$params[3] = ' ';
				} //Converting back to space
			case 3:
				if ( $params[2] == '_' ) {
					$params[2] = ' ';
				} //Converting back to space
			case 2:
				if ( $params[1] == '_' ) {
					$params[1] = strrpos( $params[0], '.' ) ? strlen( $params[0] ) - strrpos( $params[0], '.' ) - 1 : 0;
				} //Number of decimal points same as input
			case 1:
				break;
			case 0:
				wfProfileOut(__METHOD__);
				return ""; //Empty output for empty input
				break;
			default:
				wfProfileOut(__METHOD__);
				return '<span class="error">' . wfMessage( 'numberformat_wrongnargs' )->escaped() . '</span>';
		}

		$params[0] = preg_replace( "/[^\.0-9e]*/", "", $params[0] ); //Set to plain number
		if ( !is_numeric( $params[0] ) ) {
			wfProfileOut(__METHOD__);
			return '<span class="error">' . wfMessage( 'numberformat_firstargument' )->escaped() . '</span>';
		}
		$output = number_format(
			$params[0],
			isset( $params[1] ) ? $params[1] : null,
			isset( $params[2] ) ? $params[2] : null,
			isset( $params[3] ) ? $params[3] : null
		);

		if( isset( $params[3] ) ) {
			switch ( $params[3] ) {
				case 't':
					$output = str_replace( 't', '&thinsp;', $output );
					break;
				case 'n':
					$output = str_replace( 'n', '&nbsp;', $output );
					break;
			}
		}

		wfProfileOut(__METHOD__);

		return $output;
	}

}
