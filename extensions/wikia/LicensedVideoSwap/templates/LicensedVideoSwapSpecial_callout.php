<section class="lvs-callout">
	<button class="close wikia-chiclet-button">
		<img src="<?= $wgStylePath ?>/oasis/images/icon_close.png">
	</button>
	<p><?= wfMessage( 'lvs-callout-header' )->plain() ?></p>


	<ul>
		<li>
			<?= wfMessage( 'lvs-callout-title-licensed' )->parse() ?>
			<?= wfMessage( 'lvs-callout-reason-licensed' )->parse() ?>
		</li>
		<li>
			<?= wfMessage( 'lvs-callout-title-quality' )->parse() ?>
			<?= wfMessage( 'lvs-callout-reason-quality' )->parse() ?>
		</li>
		<li>
			<?= wfMessage( 'lvs-callout-title-collaborative' )->parse() ?>
			<?= wfMessage( 'lvs-callout-reason-collaborative' )->parse() ?>
		</li>
	</ul>

	<p><?= wfMessage( 'lvs-callout-reason-more' )->plain() ?></p>
</section>
