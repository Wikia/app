<?php
/**
 * Enhanced feed generation classes.
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
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
 */

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * General extension information.
 */
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'WlFeed',
	'version'        => '1.2.0',
	'author'         => 'Juliano F. Ravasi',
	'descriptionmsg' => 'wlfeed-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Wikilog',
);

/**
 * Module autoload information.
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['WlFeed'] = $dir . 'WlFeed.i18n.php';

$wgAutoloadClasses += array(
	'WlSyndicationBase'		=> $dir . 'WlFeed.body.php',
	'WlSyndicationFeed'		=> $dir . 'WlFeed.body.php',
	'WlSyndicationEntry'	=> $dir . 'WlFeed.body.php',
	'WlTextConstruct'		=> $dir . 'WlFeed.body.php',
	'WlAtomFeed'			=> $dir . 'WlFeed.body.php',
	'WlRSSFeed'				=> $dir . 'WlFeed.body.php',
	'WlFeedItemCompat'		=> $dir . 'WlFeed.body.php',
	'WlAtomFeedCompat'		=> $dir . 'WlFeed.body.php',
	'WlRSSFeedCompat'		=> $dir . 'WlFeed.body.php'
);

/**
 * Extension setup.
 */

$wgExtensionFunctions[] = array( 'WlFeed', 'ExtensionInit' );

/**
 * Main WlFeed class.
 */
class WlFeed
{

	/**
	 * Configuration: Override default MediaWiki syndication classes. If set
	 * to true, default feed classes defined in $wgFeedClasses global will
	 * be overriden with compatibility classes of WlFeed. This causes all
	 * MediaWiki feeds (Special:Recentchanges, page history, etc) to be
	 * served through this extension.
	 *
	 * Use with caution. WlFeed classes have some differences from system
	 * feed classes, for example, regarding to ctype= and quirks= parameters
	 * and caching.
	 */
	static public $cfgOverride = false;

	/**
	 * System class equivalence.
	 */
	static private $classEquiv = array(
		'AtomFeed' => 'WlAtomFeedCompat',
		'RSSFeed' => 'WlRSSFeedCompat'
	);

	/**
	 * Extension setup function.
	 */
	static function ExtensionInit() {
		# Override system feeds.
		if ( self::$cfgOverride ) {
			global $wgFeedClasses;
			foreach ( $wgFeedClasses as $t => $c ) {
				if ( isset( self::$classEquiv[$c] ) ) {
					$wgFeedClasses[$t] = self::$classEquiv[$c];
				}
			}
		}
	}
}
