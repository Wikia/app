<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes (controllers)
 */
$app->registerClass('ProposalController', $dir . 'ProposalController.class.php');
$app->registerClass('ProposalPagesController', $dir . 'ProposalPagesController.class.php');

/**
 * classes (model)
 */
$app->registerClass('ProposalPages', $dir . 'ProposalPages.class.php');

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
$app->registerSpecialPage('Proposal', 'ProposalController');
