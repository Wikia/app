<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'ContributionAppreciationController' ] = $dir . 'ContributionAppreciationController.class.php';

// i18n mapping
$wgExtensionMessagesFiles[ 'ContributionAppreciation' ] = $dir . 'ContributionAppreciation.i18n.php';

$wgHooks['DiffViewHeader'][] = 'ContributionAppreciationController::onDiffHeader';
$wgHooks['PageHistoryLineEnding'][] = 'ContributionAppreciationController::onPageHistoryLineEnding';
$wgHooks['PageHistoryBeforeList'][] = 'ContributionAppreciationController::onPageHistoryBeforeList';
$wgHooks['SendGridPostbackLogEvents'][] = 'ContributionAppreciationController::onSendGridPostbackLogEvents';
