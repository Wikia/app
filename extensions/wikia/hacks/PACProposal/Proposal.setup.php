<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes (controllers)
 */
$wgAutoloadClasses['ProposalController'] =  $dir . 'ProposalController.class.php';
$wgAutoloadClasses['ProposalPagesController'] =  $dir . 'ProposalPagesController.class.php';

/**
 * classes (model)
 */
$wgAutoloadClasses['ProposalPages'] =  $dir . 'ProposalPages.class.php';

/**
 * message files
 */
$app->registerExtensionMessageFile('Proposal', $dir . 'Proposal.i18n.php' );

/**
 * hookds
 */
$app->registerHook('SpecialPage_initList', 'ProposalController', 'onSpecialPage_initList');


/**
 * special pages
 */
$wgSpecialPages['Proposal'] = 'ProposalController';
