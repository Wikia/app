<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * An useless extension for making pie charts of user options usage.
 * Requirements: PHPlot and FCFontFinder (for i18n fonts, optional).
 * FCFontFinder can be found with extension Translate at utils/Font.php.
 * Also need to install fonts for all languages!
 *
 * PHPlot needs to be in $wgAutoloadClasses:
 * $wgAutoloadClasses['PHPlot'] = '/path/to/phplot/phplot.php'
 *
 * Request params:
 * - pietitle 'Title of the chart'
 * - width 'Width of the image' 200..1000
 * - height 'Height of the image' 200..1000
 * - shading 'Shading of the pie' 0..1000
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'User Option Statistics',
	'version'        => '1.0',
	'author'         => 'Niklas Laxström',
	'description'    => '[[Special:UserOptionStats|Special page]] for reporting on Mediawiki user option usage',
	'descriptionmsg' => 'useroptionstats-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:UserOptionStats',
);

$dir = dirname( __FILE__ );
$wgAutoloadClasses['SpecialUserOptionStats'] = "$dir/SpecialUserOptionStats.php";
$wgExtensionMessagesFiles['UserOptionStats'] = "$dir/UserOptionStats.i18n.php";
$wgExtensionAliasesFiles['UserOptionStats'] = "$dir/UserOptionStats.alias.php";
$wgSpecialPages['UserOptionStats'] = 'SpecialUserOptionStats';
$wgSpecialPageGroups['UserOptionStats'] = 'wiki';
