<?php

/**
 * Backlinks
 *
 * Writes backlink text to a dynamic fields in Solr upon rendering wikitext
 *
 * @author Robert Elwell <robert@wikia-inc.com>
 * @date 2012-09-01
 * @copyright Copyright (C) 2012 Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

// Extension credits
$wgExtensionCredits['other'][] = array(
	'name' => 'Backlinks',
	'version' => '1.0',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Backlinks',
	'author' => array('Robert Elwell'),
	'descriptionmsg' => 'backlinks-desc',
);

global $wgWikiaSearchIsDefault;

/**
 * This extension depends on the WikiaSearch extension for atomic updates
 */
if ( $wgWikiaSearchIsDefault ) {

	$dir = dirname(__FILE__);
	$app = F::app();
	
	$app->registerClass("Backlinks", "$dir/Backlinks.class.php");
	$app->registerClass("UpdateBacklinksJob", "$dir/job/UpdateBacklinksJob.class.php");
	
	//@todo make a special page controller that lets you view all pointing to a given page
	/**
	 * * register class BacklinksController $dir/BacklinksController.class.php
	 * * register special page Backlinks BacklinksController
	 */
	
	// i18n
	$wgExtensionMessagesFiles['Backlinks'] = $dir.'/Backlinks.i18n.php';
	
	// hooks
	$wgHooks['LinkEnd'][] = 'Backlinks::onLinkEnd';
	$wgHooks['OutputPageParserOutput'][] = 'Backlinks::onOutputpageParserOutput';
	
}