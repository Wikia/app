<?php
/*
 * @author Bartek Łapiński 
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'ShareFeature',
        'author' => 'Bartek Łapiński',
        'version' => '0.10',
);

$wgHooks['MonacoAfterArticleLinks'][] = 'SFMonacoAfterArticleLinks';

// display the links for the feature in the page controls bar
function SFMonacoAfterArticleLinks() {




	// todo version for anons

	// todo version for logged in

}


