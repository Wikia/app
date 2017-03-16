<div class="pph-wiki-header" style="background-image: url('<?= $backgroundImageUrl ?>');">
	<?php // fixme it will not work with wikis without wordmark image  ?>
	<?= $app->renderView( 'WikiHeader', 'Wordmark' ) ?>
	<div class="pph-wordmark-text">
		<a href="<?= Sanitizer::encodeAttribute( $mainPageURL ); ?>"><?= $wordmarkText; ?></a>
	</div>

	<div class="pph-tally-area">
		<div class="pph-tally"><?= $tallyMsg ?></div>

		<a href="<?= $addNewPageHref; ?>"
		   class="pph-add-new-page createpage">
			<svg width="14" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M2.667 10H6v1.333H2.667V10zm0-3.333h8V8h-8V6.667zm0-3.334h8v1.334h-8V3.333zM.667 16H8v-4.667c0-.368.299-.666.667-.666h4.666v-10A.667.667 0 0 0 12.667 0h-12A.667.667 0 0 0 0 .667v14.666c0 .368.299.667.667.667z"/>
				<path d="M12.943 12h-3.61v3.61z"/>
			</svg>
			<?= wfMessage( 'oasis-button-add-new-page' )->escaped(); ?>
		</a>
	</div>
	<div class="pph-local-nav">
		<?= $app->renderView( 'PremiumPageHeader', 'navigation' ) ?>
	</div>
</div>
