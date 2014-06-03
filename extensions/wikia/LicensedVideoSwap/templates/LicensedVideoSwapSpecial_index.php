<?
/**
 * @var $wgUser
 * @var $pagination
 * @var $app
 * @var $videoList
 * @var $totalVideos
 * @var $thumbWidth
 * @var $thumbHeight
 */

?>

<h2><?= wfMessage( 'lvs-maintenance-header' )->plain() ?></h2>
<p><?= wfMessage( 'lvs-maintenance-body' )->plain() ?></p>


<?
	// Temporary rollout of new LVS thumbnails per VID-1743
	$isStaff = in_array( 'staff', $app->wg->User->getEffectiveGroups() );
?>

<? if ( $isStaff ): ?>
	<? if ( !empty( $videoList ) ): ?>
		<?= $app->renderPartial( 'LicensedVideoSwapSpecialController', 'callout' ) ?>
	<? endif; ?>

	<div class="lvs-instructions">
		<h2><?= wfMessage( 'lvs-instructions-header' )->parse() ?></h2>
		<p><?= wfMessage( 'lvs-instructions' )->parse() ?></p>
	</div>

	<section class="lvs-match-stats">
		<div class="count"><?= $totalVideos ?></div>
		<div class="description"><?= wfMessage( 'lvs-match-stats-description' )->plain() ?></div>
	</section>

	<? if ( !empty( $videoList ) ): ?>

		<div class="WikiaGrid LVSGrid" id="LVSGrid">

			<?= $app->renderPartial( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList, 'thumbWidth' => $thumbWidth, 'thumbHeight' => $thumbHeight ) ) ?>
			<?= $pagination ?>

		</div>

	<? else: ?>
		<p class="lvs-zero-state"><?= wfMessage( 'lvs-zero-state' )->plain() ?></p>
	<? endif; ?>
<? endif; ?>
