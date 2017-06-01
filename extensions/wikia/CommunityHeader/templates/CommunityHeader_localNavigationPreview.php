<header class="wds-community-header local-navigation-preview">
	<?= $app->renderView(
		'CommunityHeaderController',
		'localNavigation',
		[ 'wikiText' => $wikiText, 'isPreview' => true ]
	); ?>
</header>
