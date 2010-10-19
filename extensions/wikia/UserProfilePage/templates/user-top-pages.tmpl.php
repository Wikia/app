<div id="profile-top-pages-body">
	<?php foreach( $topPages as $page ): ?>
		<?php if($isOwner): ?>
			<a href="#" class="HideButton" title="<?= $page['title']; ?>">[x]</a>
		<?php endif; ?>
		<a href="<?= $page['url']; ?>">
			<img src="<?= $page['imgUrl']; ?>" /><br />
			<strong><?= $page['title']; ?></strong> (<?= wfMsg( 'userprofilepage-top-page-edits', array( $page['editCount'] ) ); ?>)
		</a><br />
	<?php endforeach; ?>
</div>