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
