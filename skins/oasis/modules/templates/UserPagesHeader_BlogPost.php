<header id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogPostHeader">
	<?= F::app()->renderView('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
	<?php
		if (!empty($actionMenu['action'])) {
			echo F::app()->renderView('MenuButton', 'Index', array(
				'action' => $actionMenu['action'],
				'dropdown' => $actionMenu['dropdown'],
				'image' => MenuButtonController::EDIT_ICON,
			));
		}
	?>
	<h1><?= htmlspecialchars($title) ?></h1>

	<div class="author-details">
		<?= $avatar ?>
		<span class="post-author"><a href="<?= htmlspecialchars($userPage) ?>"><?= htmlspecialchars($userName) ?></a></span>
		<span><?= $editTimestamp ?></span>
		<? if ( $wg->EnableBlogArticles ): ?>
		<span><a href="<?= htmlspecialchars($userBlogPage) ?>"><?= $userBlogPageMessage ?></a></span>
		<? endif; ?>
		<? if ( !empty( $wg->EnableGoogleAuthorInfo ) && !empty( $googleAuthorLink ) ): ?>
		<a class="google-author-link" href="<?= htmlspecialchars( $googleAuthorLink ) ?>">Google</a>
		<? endif; ?>

	</div>
	<? if (isset($navLinks)) : ?>
		<?= $navLinks ?>
	<? endif; ?>
</header>
