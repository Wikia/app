<!DOCTYPE html>
<html lang=<?= $languageCode ;?> dir=<?= $languageDirection ;?><? if ( !empty( $appCacheManifestPath ) ) :?> manifest=<?= $appCacheManifestPath ;?><? endif ;?>>
	<head>
		<title><?= htmlspecialchars( $pageTitle ) ;?></title>
		<? if( !$showAllowRobotsMetaTag ): ?>
			<meta name=robots content='noindex, nofollow'>
		<?endif; ?>
		<meta http-equiv=Content-Type content="<?= $mimeType ;?>; charset=<?= $charSet ;?>">
		<meta name=HandheldFriendly content=true>
		<meta name=MobileOptimized content=width>
		<meta name=viewport content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<meta name=apple-mobile-web-app-capable content=yes>
		<?= $headLinks ;?>
		<?= $cssLinks ;?>
		<?= $topScripts ?>
		<?= $globalVariablesScript ;?>
		<?= $jsHeadFiles ;?>
		<?= $headItems ;?>
	</head>
	<body class="<?= implode(' ', $bodyClasses) ?>">
		<?= $advert ;?>
		<?= $wikiaNavigation ;?>
		<?= $pageContent ;?>
		<?= $wikiaFooter ;?>
		<?= $jsBodyFiles ;?>
		<?= $quantcastTracking ;?>
		<?= $comscoreTracking ;?>
		<?= $gaTracking ;?>
		<?= $gaOneWikiTracking ;?>
		<div class=curtain></div>
	</body>
</html>