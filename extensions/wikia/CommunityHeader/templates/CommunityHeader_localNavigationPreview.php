<header class="wds-community-header local-navigation-preview">
	<?= $app->renderView(
		'CommunityHeaderService',
		'localNavigation',
		[ 'wikiText' => $wikiText, 'isPreview' => true ]
	); ?>
</header>
