<?php
# Copyright (C) 2010 Ryan Lane <http://www.mediawiki.org/wiki/User:Ryan_lane>
#
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

# This extension is loosely based on the SidebarEx extension by Jean-Lou Dupont;
# See: http://www.mediawiki.org/wiki/Extension:SidebarEx

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Not a valid entry point";
	exit( 1 );
}

// Set defaults

// Allow users to create their own custom sidebars under User:<username>/Sidebar
$wgDynamicSidebarUseUserpages = true;

// Allow group sidebars under MediaWiki:Sidebar/Group:<group>
$wgDynamicSidebarUseGroups = true;

// Allow category based sidebars under MediaWiki:Sidebar/Group:<category>
$wgDynamicSidebarUseCategories = true;

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DynamicSidebar',
	'version' => '1.0a',
	'author' => 'Ryan Lane',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DynamicSidebar',
	'descriptionmsg' => 'dynamicsidebar-desc',
);

$wgExtensionFunctions[] = array( 'DynamicSidebar', 'setup' );
$wgHooks['SkinBuildSidebar'][] = 'DynamicSidebar::modifySidebar';

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['DynamicSidebar'] = $dir . 'DynamicSidebar.body.php';
$wgExtensionMessagesFiles['DynamicSidebar'] = $dir . 'DynamicSidebar.i18n.php';

