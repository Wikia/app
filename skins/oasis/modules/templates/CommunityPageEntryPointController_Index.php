<section class="community-page-entry-point-module module">
	<div class="community-page-entry-point-logo"></div>
	<div class="community-page-entry-point-description"><?= wfMessage( 'communitypage-help-us-grow' )->parse() ?></div>
	<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="community-page-entry-point-button"><?= wfMessage( 'communitypage-entry-button' )->escaped() ?></a>
</section>
