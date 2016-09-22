<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogListingHeader">
<?php if ( !empty( $actionButton ) ): // render edit button / dropdown menu ?>
	<?= $app->renderView( 'MenuButton', 'Index', [
		'action' => $actionButton,
		'image' => MenuButtonController::BLOG_ICON,
		'name' => 'createblogpost',
	] );
	?>
<?php endif; ?>
	<h1><?= htmlspecialchars( $title ); ?></h1>
	<h2><?= $subtitle ?></h2>
</div>
