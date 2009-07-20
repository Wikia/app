<?php
/*
 * @author Bartek Łapiński
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'Template Image Placeholder',
        'author' => 'Bartek Łapiński',
        'version' => '0.11',
);

$wgHooks['Parser::FetchTemplateAndTitle'][] = 'TIPFetchTemplateAndTitle';

function TIPFetchTemplateAndTitle( $text, $finalTitle ) {
	$img_tag = "{{{Image}}}";

	// TODO this is a temporary test
	if( strpos( $text, $img_tag ) ) {
		$text = str_replace( $img_tag, "{{TIP_PLACEMENT}}", $text );
	}

        return true;
}


