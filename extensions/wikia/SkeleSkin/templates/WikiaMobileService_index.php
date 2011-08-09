<!DOCTYPE html>
<html lang="<?= $languageCode ;?>" dir="<?= $languageDirection ;?>"<? if ( !empty( $appCacheManifestPath ) ) :?> manifest="<?= $appCacheManifestPath ;?>"<? endif ;?>>
	<head>
		<title><?= htmlspecialchars( $pageTitle ) ;?></title>
		<? if( !$showAllowRobotsMetaTag ): ?>
			<meta name="robots" content="noindex, nofollow"/>
		<?endif; ?>
		<meta http-equiv="Content-Type" content="<?= $mimeType ;?>; charset=<?= $charSet ;?>"/>
		<meta name="HandheldFriendly" content="true" />
		<meta name="MobileOptimized" content="width" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />	
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="alternate" media="handeld" href="" />
		<?= $headLinks ;?>
		<?= $cssLinks ;?>
	</head>
	<body>
		<?= $wikiaNavigation ;?>
		<?= $wikiHeaderContent ;?>
		<?= $pageContent ;?>
		<?= $jsFiles ;?>
	</body>
</html>