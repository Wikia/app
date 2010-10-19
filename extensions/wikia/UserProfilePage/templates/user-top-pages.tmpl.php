<div id="profile-top-pages-body">
	<?php foreach( $topData as $page ): ?>
		<?php if($isOwner): ?>
			<a class="HideButton" title="<?= $page['title']; ?>">[x]</a>
		<?php endif; ?>
		<a href="<?= $page['url']; ?>">
			<img src="<?= $page['imgUrl']; ?>" /><br />
			<strong><?= $page['title']; ?></strong> (<?= wfMsg( 'userprofilepage-top-page-edits', array( $page['editCount'] ) ); ?>)
		</a><br />
	<?php endforeach; ?>
	<?php if($isOwner): ?>
		<!-- hidden top pages -->
		<div id="profile-top-pages-hidden">
			<strong><?= wfMsg( 'userprofilepage-hidden-top-pages-section-title' ); ?></strong><br />
			<?php foreach( $topDataHidden as $page ): ?>
				<a class="UnhideButton" title="<?= $page['title']; ?>">[x]</a>&nbsp;
				<a href="<?= $page['url']; ?>"><?= $page['title']; ?></a><br />
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>