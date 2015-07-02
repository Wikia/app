<section class="templatedraft-module module">
	<h2><?= wfMessage( 'templatedraft-module-title-create' )->escaped() ?></h2>
	<p class="templatedraft-module-subtitle"><?= wfMessage( 'templatedraft-module-subtitle-create' )->parse() ?></p>
	<p><?= wfMessage( 'templatedraft-module-content-create' )->escaped() ?></p>
	<a href="<?= $draftUrl ?>" title="<?= wfMessage( 'templatedraft-module-button-title-create' )->escaped() ?>" target="_blank">
		<button class="templatedraft-module-button" type="button">
			<?= wfMessage( 'templatedraft-module-button-create' )->escaped() ?>
		</button>
	</a>
	<p class="templatedraft-module-closelink">
		<a class="templatedraft-module-closelink-link">
			<?= wfMessage( 'templatedraft-module-closelink-create' )->escaped() ?>
		</a>
	</p>
</section>
