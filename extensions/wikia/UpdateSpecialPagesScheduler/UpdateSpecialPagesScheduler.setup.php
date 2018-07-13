<?php
/**
 * Expose a button on Special:Statistics allowing Wikia Staff members to schedule
 * updateSpecialPages.php maintenance script run.
 *
 * @author macbre
 * @see SUS-5473
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "UpdateSpecialPagesScheduler::onCustomSpecialStatistics";

$wgAutoloadClasses[ 'UpdateSpecialPagesScheduler' ] = __DIR__ . '/UpdateSpecialPagesScheduler.class.php';
$wgExtensionMessagesFiles[ "UpdateSpecialPagesScheduler" ] =  __DIR__ . '/UpdateSpecialPagesScheduler.i18n.php';
