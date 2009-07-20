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

	// TODO fill it out

        return true;
}


