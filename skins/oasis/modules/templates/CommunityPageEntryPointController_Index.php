<section class="community-page-rail-module">
	<div class="avatars">
		<div class="wds-avatar-stack">
			<? foreach( $avatars as $index => $avatar ): ?>
				<div class="wds-avatar">
					<a href="<?= $avatar['userProfileUrl'] ?>"
					   title="<?= Sanitizer::encodeAttribute( $avatar['username'] ) ?>">
						<img class="wds-avatar__image" src="<?= $avatar['avatarUrl'] ?>"/>
					</a>
				</div>
			<? endforeach; ?>
		</div>
	</div>
	<div class="content">
		<div class="description"><?= wfMessage( 'communitypage-help-us-grow' )->parse() ?></div>
		<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="entry-button wds-is-secondary wds-button">
			<?= wfMessage( 'communitypage-entry-button' )->escaped() ?>
		</a>
	</div>
</section>
