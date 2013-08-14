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

$dir = dirname( __FILE__ );
$wgAutoloadClasses[ 'WantedPagesPageWikia'] = 		$dir . '/WantedPagesPageWikia.class.php' ;
$wgAutoloadClasses[ 'WantedFilesPageWikia'] = 		$dir . '/WantedFilesPageWikia.class.php' ;

$wgExtensionMessagesFiles['WantedFilesPageWikia'] = $dir . '/WikiaWantedQueryPage.i18n.php';
/**
 * Overwrite MediaWiki Special:WantedPages with Wikia version
 */
$wgSpecialPages['Wantedpages'] = 'WantedPagesPageWikia';
$wgSpecialPages['Wantedfiles'] = 'WantedFilesPageWikia';