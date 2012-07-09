<!DOCTYPE html>
<html lang=<?= $languageCode ;?> dir=<?= $languageDirection ;?>>
<head>
	<title><?= htmlspecialchars( $pageTitle ) ;?></title>
	<meta name=robots content='noindex, nofollow'>
	<meta http-equiv=Content-Type content="<?= $mimeType ;?>; charset=<?= $charSet ;?>">
	<meta name=HandheldFriendly content=true>
	<meta name=MobileOptimized content=width>
	<meta name=viewport content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta name=apple-mobile-web-app-capable content=yes>
	<?= $cssLinks ;?>
</head>
<body>
	<a href=http://wikia.com id=wkLnk></a>
	<a href='<?= $link ?>' id=wk404 style="background-image: url('<?= $img ?>')"></a>
	<span><?= $wf->Msg('wikiamobile-page-not-found', $title) ?></span>
</body>
</html>