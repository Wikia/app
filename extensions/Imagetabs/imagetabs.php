<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright © 2007 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that shows interwiki tabs above Image: pages
 * Original code by Joe Beaudoin Jr. from www.battlestarwiki.org (joe(AT)frakmedia(DOT)net)
 * Modified for more generic usage by Roan Kattouw (AKA Catrope) (roan(DOT)kattouw(AT)home(DOT)nl)
 * For information how to install and use this extension, see the README file.
 *
 */

$wgExtensionFunctions[] = 'createImageTabs_setup';
$wgExtensionCredits['other'][] = array(
	'name' => 'Imagetabs',
	'author' => array('Joe Beaudoin Jr.', 'Roan Kattouw'),
	'description' => 'Adds tabs with interwiki links above Image: pages',
	'version' => '1.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Imagetabs'
);

function createImageTabs_setup() {
	global $wgHooks;
	$wgHooks['SkinTemplateContentActions'][] = 'createImageTabs_hook';
}

function createImageTabs_hook(&$content_actions) {
	global $wgEnableInterwikiImageTabs, $wgInterwikiImageTabs, $wgTitle, $wgLocalInterwiki;
	if($wgEnableInterwikiImageTabs && $wgTitle->getNamespace() == NS_IMAGE) {
		$i = 0;
		foreach($wgInterwikiImageTabs as $prefix => $caption) {
			// Go to prefix:Image:title. Image: is automatically translated if necessary.
			$titleObj = Title::newFromText($prefix . ":Image:" . $wgTitle->getText());
			// Check that we don't link to ourselves
			if($titleObj->getInterwiki() != $wgLocalInterwiki && $titleObj->getFullURL() != $wgTitle->getFullURL())
				$content_actions['interwikitab-'.$i++] = array(
					'class' => false,
					'text' => $caption,
					'href' => $titleObj->getFullURL()
				);
		}
	}
	return true;
}