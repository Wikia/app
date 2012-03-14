<!DOCTYPE html>
<html lang=<?= $languageCode ;?> dir=<?= $languageDirection ;?><? if ( !empty( $appCacheManifestPath ) ) :?> manifest=<?= $appCacheManifestPath ;?><? endif ;?>>
	<head>
		<title><?= htmlspecialchars( $pageTitle ) ;?></title>
		<? if( !$showAllowRobotsMetaTag ): ?>
			<meta name=robots content=noindex, nofollow>
		<?endif; ?>
		<meta http-equiv=Content-Type content="<?= $mimeType ;?>; charset=<?= $charSet ;?>">
		<meta name=HandheldFriendly content=true>
		<meta name=MobileOptimized content=width>
		<meta name=viewport content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<meta name=apple-mobile-web-app-capable content=yes>
		<link rel=alternate media=handheld href="">
		<script>var JSSnippetsStack = [];</script>
		<?= $headLinks ;?>
		<?= $cssLinks ;?>
		<?= $globalVariablesScript ;?>
		<?= $jsHeadFiles ;?>
	</head>
	<body class=wkMobile>
		<?= $advert ;?>
		<?= $wikiaNavigation ;?>
		<?= $pageContent ;?>
		<?= $wikiaFooter ;?>
		<?= $jsBodyFiles ;?>
		<?= $quantcastTracking ;?>
		<?= $comscoreTracking ;?>
		<?= $gaTracking ;?>
		<?= $gaOneWikiTracking ;?>
	</body>
</html>