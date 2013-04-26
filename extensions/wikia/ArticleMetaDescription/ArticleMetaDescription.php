<?php
/**
 * ArticleMetaDescription - adding meta-description tag containing snippet of the Article
 *
 * Puts the snippet from the ArticleService into <meta description="..." /> tag inside
 * page header section. It's possible to set predefined description for main
 * page (configured in MediaWiki:Mainpage) by putting desired text
 * into the MediaWiki:Description message.
 *
 * @author Adrian 'ADi' Wieczorek <adi@wikia.com>
 * @author Sean Colombo <sean@wikia.com>
 *
 */

if(!defined('MEDIAWIKI')) {
    echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
    die();
}

$wgExtensionCredits['other'][] = array(
    'name' => 'ArticleMetaDescription',
    'version' => '1.1',
    'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek], [http://seancolombo.com Sean Colombo]',
    'description' => 'adding meta-description tag containing snippet of the Article, provided by the ArticleService'
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass('ArticleMetaDescriptionHelpers', $dir.'ArticleMetaDescriptionHelpers.class.php');
$app->registerClass('ArticleMetaDescriptionHooks', $dir.'ArticleMetaDescriptionHooks.class.php');

//$wgHooks['OutputPageBeforeHTML'][] = 'ArticleMetaDescription::onOutputPageBeforeHTML';
$app->registerHook('OutputPageBeforeHTML', 'ArticleMetaDescriptionHooks', 'onOutputPageBeforeHTML');
