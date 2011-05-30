<?php
/**
 * Support %MediaWiki: http://www.mediawiki.org/.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @todo Remove once %MediaWiki core group uses yaml configuration.
 */

/// @cond
$dir = dirname( __FILE__ );
$wgAutoloadClasses['MediaWikiMessageChecker'] = dirname( __FILE__ ) . '/Checker.php';
/// @endcond