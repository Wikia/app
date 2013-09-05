<section class="lvs-callout">
	<button class="close wikia-chiclet-button">
		<img src="<?= $wg->StylePath ?>/oasis/images/icon_close.png">
	</button>
	<p class="description"><?= wfMessage( 'lvs-callout-header' )->plain() ?></p>


	<ul>
		<li>
			<span class="heading licensed"><?= wfMessage( 'lvs-callout-title-licensed' )->parse() ?></span>
			<?= wfMessage( 'lvs-callout-reason-licensed' )->parse() ?>
		</li>
		<li>
			<span class="heading quality"><?= wfMessage( 'lvs-callout-title-quality' )->parse() ?></span>
			<?= wfMessage( 'lvs-callout-reason-quality' )->parse() ?>
		</li>
		<li>
			<span class="heading collaborative"><?= wfMessage( 'lvs-callout-title-collaborative' )->parse() ?></span>
			<?= wfMessage( 'lvs-callout-reason-collaborative' )->parse() ?>
		</li>
	</ul>

	<p><?= wfMessage( 'lvs-callout-reason-more' )->plain() ?></p>
</section>
