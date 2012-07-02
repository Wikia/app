<?php
/**
 * StarterWiki
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['other'][] = array (
	'name' => 'StarterWiki',
	'url' => 'http://wiki-tools.com/wiki/StarterWiki',
	'version' => '1.2a',
	'author' => "[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]",
	'description' => "Provides a set of maintenance scripts and functions to allow for creation of wiki databases based off a starter wiki."
);

## A list of pages to convert titles and override when cloning the database.
## Key is the ns:title on starter, value is the ns:title to use on the other wiki.
$wgStarterWikiPageAliases = array(
	'0:Main_Page/Starter' => '0:Main_Page'
);

## Array of namespaces to exclude from cloning.
$wgStarterWikiOmitNamespaces = array(
	NS_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_USER, # Don't clone userpages, users may not be the same.
	NS_USER_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_PROJECT_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_IMAGE, # Don't clone image pages, files are not cloned.
	NS_IMAGE_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_MEDIAWIKI, # Don't clone messages, a shared system should be used
	NS_MEDIAWIKI_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_TEMPLATE_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_HELP_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
	NS_CATEGORY_TALK, # Don't clone talkpages, discussions shouldn't be cloned.
);
