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
 * @file
 * @ingroup Extensions
 * @author Evan Prodromou <evan@vinismo.com>
 */

if( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SpecialForm'] = $dir . 'SpecialForm.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['Form'] = $dir . 'SpecialForm.i18n.php'; #Load internationalization file
$wgExtensionAliasesFiles['Form'] = $dir . 'SpecialForm.alias.php';
$wgSpecialPages['Form'] = 'SpecialForm'; # Let MediaWiki know about your new special page.

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Form',
	'version' => '0.4.1',
	'author' => 'Evan Prodromou',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Form',
	'description' => 'A form interface to start new articles',
	'descriptionmsg' => 'form-desc',
);

# Use recaptcha; default to false
$wgSpecialFormRecaptcha = false;