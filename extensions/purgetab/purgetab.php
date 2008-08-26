<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Joe Beaudoin Jr. <joe@frakmedia.net>
 * @copyright Copyright (C) 2008 Joe Beaudoin Jr.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that shows the purge tabs above article and talk pages
 * Original code by Jonathan Tse from www.jontse.com
 * Modified by Joe Beaudoin Jr. (joe(AT)frakmedia(DOT)net)
 * For information how to install and use this extension, see: http://www.mediawiki.org/wiki/Extension:Purgetab
 *
 */

$wgExtensionCredits['other'][] = array(
       'name' => 'Purge Tab 1.0',
       'author' =>'Jonathan Tse and Joe Beaudoin Jr.',
       'url' => 'http://www.mediawiki.org/wiki/Extension:Purgetab',
       'description' => 'An extension to add the purge tab to all pages without the use of JavaScript.'
       );

$wgHooks['SkinTemplateContentActions'][] = 'purgetab_ReplaceTabs';

function purgetab_ReplaceTabs ($content_actions) {
	global $wgTitle;

	if ($wgTitle->getNamespace() != NS_SPECIAL)
	{
		$purge_action['purge'] = array(
			'class' => false, 
			'text' => 'Purge',
			'href' => $wgTitle->getFullURL('action=purge')
		);
		$content_actions = array_merge($content_actions,$purge_action);
	}
	return true;  
}
