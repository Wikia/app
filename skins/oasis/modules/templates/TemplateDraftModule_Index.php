<section class="templatedraft-module module">
	<h2><?= wfMessage( 'templatedraft-module-title' )->escaped() ?></h2>
	<p class="templatedraft-module-subtitle"><?= wfMessage( 'templatedraft-module-subtitle' )->parse() ?></p>
	<p><?= wfMessage( 'templatedraft-module-content' )->escaped() ?></p>
	<a href="<?= $draftUrl ?>" class="templatedraft-module-button" type="button">
		<?= wfMessage( 'templatedraft-module-button' )->escaped() ?>
	</a>
	<p class="templatedraft-module-closelink">
		<a href="#"><?= wfMessage( 'templatedraft-module-closelink' )->escaped() ?></a>
	</p>
</section>
