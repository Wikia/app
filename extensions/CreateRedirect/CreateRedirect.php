<?php
/**
 * CreateRedirect - MediaWiki extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Marco Zafra ("Digi")
 *
 * Adds a special page that eases creation of redirects via a simple form.
 * Also adds a menu item to the sidebar as a shortcut.
 *
 * This program, CreateRedirect, is Copyright (C) 2007 Marco Zafra.
 * CreateRedirect is released under the GNU Lesser General Public License version 3.
 *
 * This file is part of CreateRedirect.
 *
 * CreateRedirect is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CreateRedirect is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with CreateRedirect.  If not, see <http://www.gnu.org/licenses/>.
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Add this extension to Special:Credits.
$wgExtensionCredits['specialpage'][] = array(
	'path'  => __FILE__,
	'name' => 'CreateRedirect',
	'author' => 'Marco Zafra',
	'version' => '1.0.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CreateRedirect',
	'descriptionmsg' => 'createredirect-desc',
);

// Set up the actual extension functionality.
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SpecialCreateRedirect'] = $dir . 'CreateRedirect.body.php';
$wgSpecialPages['CreateRedirect'] = 'SpecialCreateRedirect';
$wgSpecialPageGroups['CreateRedirect'] = 'pagetools';
$wgExtensionMessagesFiles['CreateRedirect'] = $dir . 'CreateRedirect.i18n.php';
$wgExtensionMessagesFiles['CreateRedirectAlias'] = $dir . 'CreateRedirect.alias.php';

// Add a shortcut link to the toolbox.
$wgHooks['SkinTemplateToolboxEnd'][] = 'createRedirect_addToolboxLink';

/**
 * Adds a shortcut link pointing to Special:CreateRedirect to the "toolbox" menu.
 * If applicable, also adds a reference to the current title as a GET param.
 *
 * @return Boolean: true
 */
function createRedirect_AddToolboxLink( &$tpl ) {
	global $wgRequest;

	// 1. Determine whether to actually add the link at all.
	// There are certain cases, e.g. in the edit dialog, in a special page,
	// where it's inappropriate for the link to appear.
	// 2. Check the title. Is it a "Special:" page? Don't display the link.
	$action = $wgRequest->getText( 'action', 'view' );
	if ( method_exists( $tpl, 'getSkin' ) ) {
		$title = $tpl->getSkin()->getTitle();
	} else {
		global $wgTitle;
		$title = $wgTitle;
	}

	if( $action != 'view' && $action != 'purge' && !$title->isSpecialPage() ) {
		return true;
	}

	// 3. Add the link!
	$href = SpecialPage::getTitleFor( 'CreateRedirect', $title->getPrefixedText() )->getLocalURL();
	echo Html::rawElement( 'li', null, Html::element( 'a', array( 'href' => $href ), wfMsg( 'createredirect' ) ) );

	return true;
}
