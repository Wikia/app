<? global $wgStylePath ?>

<? if ( !empty( $videoList ) ): ?>
	<?= $app->renderPartial( 'LicensedVideoSwapSpecialController', 'callout' ) ?>
<? endif; ?>

<div class="lvs-instructions">
	<h2><?= wfMessage( 'lvs-instructions-header' )->parse() ?></h2>
	<p><?= wfMessage( 'lvs-instructions' )->plain() ?></p>
</div>

<? if ( !empty( $videoList ) ): ?>

	<div class="WikiaGrid LVSGrid" id="LVSGrid">

		<?= $app->renderPartial( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList, 'thumbWidth' => $thumbWidth, 'thumbHeight' => $thumbHeight ) ) ?>
		<?= $pagination ?>

	</div>

<? else: ?>
	<p class="lvs-zero-state"><?= wfMessage( 'lvs-zero-state' )->plain() ?></p>
<? endif; ?>
