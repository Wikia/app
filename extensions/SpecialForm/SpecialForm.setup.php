<?php
/**
 * SpecialForm.php -- Use a form-based interface to start new articles
 * Copyright 2007 Vinismo, Inc. (http://vinismo.com/)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@vinismo.com>
 * @ingroup Extensions
 */

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

define('SPECIALFORM_VERSION', '0.2');

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialForm'] = $dir . '/SpecialForm.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['SpecialForm'] = $dir . 'SpecialForm.i18n.php'; #Load internationalization file
$wgSpecialPages['Form'] = 'SpecialForm'; # Let MediaWiki know about your new special page.
$wgHooks['LoadAllMessages'][] = 'SpecialForm::loadMessages'; # Load the internationalization messages for your special page.
$wgHooks['LanguageGetSpecialPageAliases'][] = 'formLocalizedPageName'; # Add any aliases for the special page.
# Typo in versions of MW earlier than 1.11.x (?)
$wgHooks['LangugeGetSpecialPageAliases'][] = 'formLocalizedPageName'; # Add any aliases for the special page.

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Form',
	'version' => SPECIALFORM_VERSION,
	'author' => 'Evan Prodromou',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Form',
	'description' => 'A form interface to start new articles',
	'descriptionmsg' => 'form-desc',
);

function formLocalizedPageName(&$specialPageArray, $code) {
	# The localized title of the special page is among the messages of the extension:
	SpecialForm::loadMessages();
	$text = wfMsgForContent('form');

	# Convert from title in text form to DBKey and put it into the alias array:
	$title = Title::newFromText($text);
	$specialPageArray['Form'][] = $title->getDBkey();

	return true;
}