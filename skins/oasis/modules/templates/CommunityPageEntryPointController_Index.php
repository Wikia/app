<section class="community-page-entry-point-module module">
	<div class="community-page-entry-point-logo"></div>
	<div class="community-page-entry-point-new">
		<?= wfMessage( 'communitypage-new' )->escaped() ?>
	</div>
	<div class="community-page-entry-point-container">
		<div class="community-page-entry-point-description"><?= wfMessage( 'communitypage-help-us-grow' )->parse() ?></div>
		<div>
			<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="community-page-entry-point-button"><?= wfMessage( 'communitypage-entry-button' )->escaped() ?></a>
		</div>
	</div>
</section>
