<section class="CommunityCornerModule module">
	<h2 class="dark_text_2"><?= wfMessage( 'myhome-community-corner-header' )->escaped(); ?></h2>
	<div id="myhome-community-corner-content"><?= wfMessage( 'community-corner' )->parse(); ?></div>
	
<?php if ( $isAdmin ): ?>
	<div id="myhome-community-corner-edit">
		<a class="more" href="<?= Skin::makeNSUrl( 'community-corner', 'edit', NS_MEDIAWIKI ); ?>" rel="nofollow">
			<?= wfMessage( 'oasis-myhome-community-corner-edit' )->escaped(); ?>
		</a>
	</div>
<?php endif; ?>
</section>
