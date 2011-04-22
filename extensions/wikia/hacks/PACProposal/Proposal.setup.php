<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

/**
 * classes (controllers)
 */
$app->registerClass('ProposalController', $dir . 'ProposalController.class.php');
$app->registerClass('ProposalPagesController', $dir . 'ProposalPagesController.class.php');
$app->registerClass('TestSpecialPage', $dir . 'TestSpecialPage.class.php');

/**
 * classes (model)
 */
$app->registerClass('ProposalPages', $dir . 'ProposalPages.class.php');

/**
 * message files
 */
$app->registerExtensionMessageFile('Proposal', $dir . 'Proposal.i18n.php' );

/**
 * special pages
 */
$app->registerSpecialPage('Proposal', 'ProposalController');
$app->registerSpecialPage('Test', 'TestSpecialPage');
