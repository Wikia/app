<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

/**
 * classes
 */
$app->registerClass('ProposalUsersController', $dir . 'ProposalUsersController.class.php');
$app->registerClass('ProposalUsers', $dir . 'ProposalUsers.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('ProposalSimple', 'ProposalUsersController');