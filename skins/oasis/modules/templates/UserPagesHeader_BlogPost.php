<header id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogPostHeader">
	<?= $app->renderView( 'CommentsLikes', 'Index', [ 'comments' => $comments ] ); ?>
	<?php if ( !empty( $actionMenu['action'] ) ): ?>
		<?= $app->renderView( 'MenuButton', 'Index', [
			'action' => $actionMenu['action'],
			'dropdown' => $actionMenu['dropdown'],
			'image' => MenuButtonController::EDIT_ICON,
		] ); ?>
	<?php endif; ?>
	<h1><?= htmlspecialchars( $title ) ?></h1>

	<div class="author-details">
		<?= $avatar ?>
		<span class="post-author"><a href="<?= Sanitizer::encodeAttribute( $userPage ); ?>"><?= htmlspecialchars( $userName ); ?></a></span>
		<span><?= $editTimestamp ?></span>
		<? if ( $wg->EnableBlogArticles ): ?>
		<span><a href="<?= Sanitizer::encodeAttribute( $userBlogPage ); ?>"><?= $userBlogPageMessage ?></a></span>
		<? endif; ?>
		<? if ( !empty( $wg->EnableGoogleAuthorInfo ) && !empty( $googleAuthorLink ) ): ?>
		<a class="google-author-link" href="<?= htmlspecialchars( $googleAuthorLink ) ?>">Google</a>
		<? endif; ?>

	</div>
	<? if ( isset( $showNavLinks ) ) : ?>
	<a href="<?= Sanitizer::encodeAttribute( $wg->Title->getLocalURL() ); ?>"><?= wfMessage( 'oasis-page-header-back-to-article' )->escaped(); ?></a>
	<? endif; ?>
</header>
