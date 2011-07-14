<header id="WikiaPageHeader" class="WikiaPageHeader<?= (empty($revisions) && empty($categories)) ? ' separator' : '' ?>">

	<ul class="comments"><li class="article-comments-li even">
	<div class="comment-avatar">
		<a href="<?= htmlspecialchars(AvatarService::getUrl($authorName)) ?>">
			<?= AvatarService::renderAvatar($authorName, 50) ?>
		</a>
	</div>
	<blockquote>
		<div class="article-comm-text">
			<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
		</div>
		<details>
			<?= wfMsg('oasis-comments-added-by', $firstRevTimestamp, AvatarService::renderLink($authorName)) ?>
		</details>
	</blockquote>
	</li></ul>

<?php
	// render search box
	if ($showSearchBox) {
		echo wfRenderModule('Search');
	}
?>
</header>
