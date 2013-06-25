<? global $wgStylePath ?>

<? if ( !empty( $videoList ) ): ?>
	<section class="lvs-callout">
		<button class="close wikia-chiclet-button">
			<img src="<?= $wgStylePath ?>/oasis/images/icon_close.png">
		</button>
		<h1><?= wfMessage( 'lvs-callout-header' )->plain() ?></h1>
		<ul>
			<li>- <?= wfMessage( 'lvs-callout-reason-licensed' )->parse() ?></li>
			<li>- <?= wfMessage( 'lvs-callout-reason-quality' )->parse() ?></li>
			<li>- <?= wfMessage( 'lvs-callout-reason-collaborative' )->parse() ?></li>
			<li>- <?= wfMessage( 'lvs-callout-reason-more' )->plain() ?></li>
		</ul>
	</section>
<? endif; ?>

<p><?= wfMessage( 'lvs-instructions-header' )->parse() ?></p>
<p><?= wfMessage( 'lvs-instructions' )->plain() ?></p>

<? if ( !empty( $videoList ) ): ?>

	<?= $app->renderView( 'LicensedVideoSwapSpecialController', 'contentHeaderSort', $contentHeaderSortOptions ) ?>

	<div class="WikiaGrid LVSGrid" id="LVSGrid">

		<?= $app->renderPartial( 'LicensedVideoSwapSpecial', 'row', array( 'videoList' => $videoList, 'thumbWidth' => $thumbWidth, 'thumbHeight' => $thumbHeight ) ) ?>
		<?= $pagination ?>

	</div>

<? else: ?>
	<p class="lvs-zero-state"><?= wfMessage( 'lvs-zero-state' )->plain() ?></p>
<? endif; ?>
