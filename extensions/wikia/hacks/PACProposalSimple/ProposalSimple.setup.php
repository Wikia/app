<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

/**
 * classes
 */
$wgAutoloadClasses['ProposalUsersController'] =  $dir . 'ProposalUsersController.class.php';
$wgAutoloadClasses['ProposalUsers'] =  $dir . 'ProposalUsers.class.php';

/**
 * special pages
 */
$wgSpecialPages['ProposalSimple'] = 'ProposalUsersController';