<?php
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * This is an extension that lets you protect part of an article.  You have to be a member
 * of a group with the 'protectsection' user right in order to add section protection.
 *
 * To protect a section of text, enclose it in a <protect> </protect> block.
 *
 * @file
 * @ingroup Extensions
 *
 * @author ThomasV <thomasv1@gmx.de>
 * @author Jim Hu (remove Section Edit links in protected text, bug fixes)
 * @author Siebrand Mazeland (i18n and SVN merge)
 * @author Nephele (fix bugs, add new options)
 * @copyright Copyright © 2006, ThomasV
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# Unfixed issues as of version 1.1:
# If nowiki'd protect tags are used on a page with real protect tags, there may be display problems
#  (although actual protection should still be preserved), specifically section-edit-links might not be
#  removed properly, and the nowiki'd protect tags may not appear on rendered page
# Edit-link-removal can handle a single unpaired nowiki tag on a page, but not multiple unpaired nowiki tags (i.e.,
#  some edit links may be removed even though they shouldn't be)

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ProtectSection',
	'author' => 'ThomasV',
	'version' => '1.1',
	'descriptionmsg' => 'protectsection_desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ProtectSection'
);

// If set to true, text cannot be inserted before a protect tag at the start of an article
// False by default for backwards compatibility
$egProtectSectionNoAddAbove = false;

// Two new permissions
$wgGroupPermissions['sysop']['protectsection']         = true;
$wgGroupPermissions['bureaucrat']['protectsection']    = true;
$wgAvailableRights[] = 'protectsection';
 
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ProtectSectionClass'] = $dir . 'ProtectSection_body.php';
$wgExtensionMessagesFiles['ProtectSection'] = $dir . 'ProtectSection.i18n.php';

// Register hooks
$wgHooks['ParserAfterTidy'][] = 'ProtectSectionClass::stripTags' ;
$wgHooks['ParserBeforeStrip'][] = 'ProtectSectionClass::countTags' ;
$wgHooks['EditFilterMerged'][] = 'ProtectSectionClass::checkProtectSection' ;
$wgHooks['PageRenderingHash'][] = 'ProtectSectionClass::pageRenderingHash';
