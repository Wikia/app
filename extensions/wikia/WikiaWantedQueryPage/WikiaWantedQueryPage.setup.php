<?php
/**
 * @author Jacek Jursza <jacek at wikia-inc.com>
 * @date 2012-05-29
 * @copyright Copyright (C) 2012 Jacek Jursza, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @description Extension to overwrite MediaWiki special pages that are based on QueryPage
 */

/**
* @var WikiaApp
*/

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'WantedPagesPageWikia',
	'author' => 'Jacek Jursza <jacek at wikia-inc.com>',
	'descriptionmsg' => 'wantedquerypage-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WantedPagesPageWikia',
);

$dir = dirname( __FILE__ );
$wgAutoloadClasses[ 'WantedPagesPageWikia'] = 		$dir . '/WantedPagesPageWikia.class.php' ;
$wgAutoloadClasses[ 'WantedFilesPageWikia'] = 		$dir . '/WantedFilesPageWikia.class.php' ;

/**
 * Overwrite MediaWiki Special:WantedPages with Wikia version
 */
$wgSpecialPages['Wantedpages'] = 'WantedPagesPageWikia';
$wgSpecialPages['Wantedfiles'] = 'WantedFilesPageWikia';