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
#
#
# This extension displays an article and its 
# translation on two columns of the same page.
# The translation comes from another wiki 
# that can be accessed through interlanguage links


$wgExtensionMessagesFiles['DoubleWiki'] = dirname(__FILE__)  . '/DoubleWiki.i18n.php';
$wgAutoloadClasses['DoubleWiki'] = dirname( __FILE__ ) . "/DoubleWiki_body.php";
$wgHooks['OutputPageBeforeHTML'][] = 'DoubleWiki::OutputPageBeforeHTML';
// How long cached page output is stored in memcached
$wgDoubleWikiCacheTime = 3600 * 12;

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DoubleWiki',
	'author' => 'ThomasV',
	'url' => 'http://wikisource.org/wiki/Wikisource:DoubleWiki_Extension',
	'descriptionmsg' => 'doublewiki-desc',
);
