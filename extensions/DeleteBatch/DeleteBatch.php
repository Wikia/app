<?php
/**
 * DeleteBatch - a special page to delete a batch of pages
 *
 * @author Bartek Łapiński
 * @version 1.0
 */
if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'deletebatch';
$wgGroupPermissions['staff']['deletebatch'] = true;

$wgExtensionCredits['specialpage'][] = array(
   'name'           => 'Delete Batch',
   'version'        => '1.0',
   'author'         => 'Bartek Łapiński',
   'url'            => 'http://www.mediawiki.org/wiki/Extension:DeleteBatch',
   'description'    => 'Deletes a batch of pages',
   'descriptionmsg' => 'deletebatch-msg',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DeleteBatch'] = $dir . 'DeleteBatch.i18n.php';
$wgExtensionAliasesFiles['DeleteBatch'] = $dir . 'DeleteBatch.alias.php';
$wgAutoloadClasses['DeleteBatch'] = $dir. 'DeleteBatch.body.php';
$wgSpecialPages['DeleteBatch'] = 'DeleteBatch';
