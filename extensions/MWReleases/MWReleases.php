<?php
/**
 * MWReleases - lets us maintain a list of releases that we support
 * on Mediawiki.org, to be queried by the API. Goal is to have the
 * installer and updater check MW.org for latest versions :)
 *
 * EXAMPLE MWRELEASES-LIST:
 * <code>
 * current:1.15.1
 * supported:1.14.1
 * supported:1.6.12
 * </code>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @author Chad Horohoe
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

define( 'MWRELEASES_VERSION', '1.1' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MWReleases',
	'url' => 'http://www.mediawiki.org/wiki/Extension:MWReleases',
	'author' => 'Chad Horohoe',
	'descriptionmsg' => 'mwreleases-desc',
	'version' => MWRELEASES_VERSION,
);

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiMWReleases'] = $dir . 'ApiMWReleases.php';
$wgExtensionMessagesFiles['MWReleases'] = $dir . 'MWReleases.i18n.php';
$wgAPIModules['mwreleases'] = 'ApiMWReleases';
