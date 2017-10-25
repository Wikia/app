<section class="community-page-rail-module">
	<div class="avatars">
		<div class="wds-avatar-stack">
			<? foreach( $avatars as $index => $avatar ): ?>
				<a href="<?= $avatar['userProfileUrl'] ?>" class="wds-avatar-stack__avatar"
				   title="<?= Sanitizer::encodeAttribute( $avatar['username'] ) ?>">
					<img class="wds-avatar" src="<?= $avatar['avatarUrl'] ?>"/>
				</a>
			<? endforeach; ?>
		</div>
	</div>
	<div class="content">
		<div class="description"><?= wfMessage( 'communitypage-help-us-grow' )->parse() ?></div>
		<a href="<?= SpecialPage::getTitleFor( 'Community' )->getLocalURL(); ?>" class="entry-button wds-is-secondary wds-button wds-is-squished">
			<?= wfMessage( 'communitypage-entry-button' )->escaped() ?>
		</a>
	</div>
</section>
