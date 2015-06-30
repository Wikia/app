<section class="templatedraft-module module">
	<h2><?= wfMessage( 'templatedraft-module-title' )->escaped() ?></h2>
	<p class="templatedraft-module-subtitle"><?= wfMessage( 'templatedraft-module-subtitle' )->parse() ?></p>
	<p><?= wfMessage( 'templatedraft-module-content' )->escaped() ?></p>
	<a href="<?= $draftUrl ?>" title="<?= wfMessage( 'templatedraft-module-button-title' )->escaped() ?>" target="_blank">
		<button class="templatedraft-module-button" type="button">
			<?= wfMessage( 'templatedraft-module-button' )->escaped() ?>
		</button>
	</a>
	<p class="templatedraft-module-closelink">
		<a class="templatedraft-module-closelink-link">
			<?= wfMessage( 'templatedraft-module-closelink' )->escaped() ?>
		</a>
	</p>
</section>
