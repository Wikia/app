<?php

/**
 * File holding the rendering function for the Storyboard tag.
 *
 * @file Storyboard_body.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class TagStoryboard {
	
	public static function render( $input, $args, $parser, $frame ) {
		global $wgOut, $wgJsMimeType, $egStoryboardScriptPath;
		
		$wgOut->addStyle($egStoryboardScriptPath . '/tags/Storyboard/Storyboard.css');		
		$wgOut->includeJQuery();
		$wgOut->addScriptFile($egStoryboardScriptPath . '/tags/Storyboard/Storyboard.js');

		$output = <<<END
<script type="$wgJsMimeType">var storyboardPath = '$egStoryboardScriptPath';</script>
<div id="storyboard"></div>
<script type="$wgJsMimeType"> /*<![CDATA[*/
	var storyboard = new Storyboard();
	storyboard.loadAjax();
/*]]>*/ </script>
END;

	return array($output, 'noparse' => 'true', 'isHTML' => 'true');
	}
	
}



