<?php
/**
 * ArticleEmblems extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'ArticleEmblems',
	'author' => array( 'Trevor Parscal' ),
	'version' => '0.1.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ArticleEmblems',
	'descriptionmsg' => 'articleEmblems-desc',
);
$wgAutoloadClasses['ArticleEmblemsHooks'] = dirname( __FILE__ ) . '/ArticleEmblems.hooks.php';
$wgExtensionMessagesFiles['ArticleEmblems'] = dirname( __FILE__ ) . '/ArticleEmblems.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'ArticleEmblemsHooks::parserFirstCallInit';
$wgHooks['OutputPageParserOutput'][] = 'ArticleEmblemsHooks::outputPageParserOutput';

$wgResourceModules['ext.articleEmblems'] = array(
	'styles' => 'ext.articleEmblems.css',
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'ArticleEmblems/modules',
);
