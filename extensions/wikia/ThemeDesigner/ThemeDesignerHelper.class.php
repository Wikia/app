<?php

class ThemeDesignerHelper {

	public static function checkAccess() {
		global $wgUser;
		// @FIXME when we're out of beta editinterface needs to be removed and themedesgner set to true for sysops
		return $wgUser->isAllowed( 'themedesigner' );
	}

	public static function parseText($text = "") {
		global $wgTitle;
		return ParserPool::parse( $text, $wgTitle, new ParserOptions())->getText();
	}

	public static function isValidColor( $sColor ) {

		// First try

		$isHexColor = preg_match( '/^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/', $sColor );

		if ( !empty( $isHexColor ) ){
			return true;
		}

		// Last chance: array is not proper hash so maybe it is predefined color name

		$aColorArray = array(
			'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure',
			'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown',
			'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue',
			'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod',
			'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen',
			'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen',
			'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet',
			'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick',
			'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite',
			'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew',
			'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush',
			'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan',
			'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightpink',
			'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray',
			'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta',
			'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple',
			'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise',
			'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin',
			'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered',
			'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred',
			'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue',
			'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon',
			'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue',
			'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan',
			'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white',
			'whitesmoke', 'yellow', 'yellowgreen'
		);

		$isColorName = in_array ( strtolower( $sColor ), $aColorArray );

		Wikia::log(__METHOD__, "JKU", "[{$sColor}] is not a valid color name");

		return $isColorName;
	}

	public static function getColorVars(){
		return array (
			'color-body'	=> '#BACDD8',
			'color-page'	=> '#FFF',
			'color-buttons' => '#006CB0',
			'color-links'	=> '#006CB0',
			'color-header'	=> '#3A5766'
		);
	}
}
