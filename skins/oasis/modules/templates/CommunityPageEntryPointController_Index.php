<section class="community-page-entry-point-module module">
	<div class="entry-point-logo"></div>
	<div class="entry-point-new">
		<?= wfMessage( 'communitypage-new' )->escaped() ?>
	</div>
	<div class="entry-point-container">
		<div class="entry-point-description-top">
			<?= wfMessage( 'communitypage-help-us-grow-prefix' )->parse() ?>
		</div>
		<div class="entry-point-description-bottom">
			<?= wfMessage( 'communitypage-help-us-grow' )->parse() ?>
		</div>
		<div>
			<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="entry-point-button"><?= wfMessage( 'communitypage-entry-button' )->escaped() ?></a>
		</div>
	</div>
</section>
