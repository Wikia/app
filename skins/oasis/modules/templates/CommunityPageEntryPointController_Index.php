<section class="community-page-entry-point-module module">
	<div class="community-page-entry-point-logo"></div>
	<div class="community-page-entry-point-container">
		<div class="community-page-entry-point-new">
			<?= wfMessage( 'communitypage-new' )->escaped() ?>
		</div>
		<div class="community-page-entry-point-description">
			<?php
				/* compage-entry-point-nowrap element starts within message and ends after as we want
 				 * to break line before site name but not after (JPN-538)
				 */
			?>
			<?= wfMessage( 'communitypage-help-us-grow', $noWrapOpenWithSiteName, $noWrapClose )->parse() ?>
		</div>
		<div>
			<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="community-page-entry-point-button"><?= wfMessage( 'communitypage-entry-button' )->escaped() ?></a>
		</div>
	</div>
</section>
