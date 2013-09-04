<?
/**
 * @var $languageCode String
 * @var $languageDirection String
 * @var $pageTitle String
 * @var $allowRobots String
 * @var $mimeType String
 * @var $charSet String
 * @var $headLinks String
 * @var $cssLinks String
 * @var $globalVariablesScript String
 * @var $jsClassScript String
 * @var $headItems String
 * @var $bodyClasses String[]
 * @var $trackingCode String
 * @var $wikiaNavigation String
 * @var $pageContent String
 * @var $wikiaFooter String
 * @var $jsBodyFiles String
 * @var $jsExtensionPackages String
 * @var $topLeaderBoardAd String
 * @var $inContentAd String
 * @var $modalInterstitial String
 * @var $floatingAd String
 */
?>
<!DOCTYPE html>
<html lang=<?= $languageCode ;?> dir=<?= $languageDirection ;?>>
<head>
	<meta http-equiv=Content-Type content="<?= "{$mimeType};charset={$charSet}" ;?>">
	<?= $cssLinks ;?>
	<title><?= htmlspecialchars( $pageTitle ) ;?></title>
	<?= $headLinks ;?>
	<?= $headItems ;?>
	<?= $globalVariablesScript ;?>
	<?= $jsClassScript ;?>
	<? if( !$allowRobots ): ?>
		<meta name=robots content='noindex, nofollow'>
	<? endif; ?>
	<meta name=HandheldFriendly content=true>
	<meta name=MobileOptimized content=width>
	<meta name=viewport content="initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta name=apple-mobile-web-app-capable content=yes>
	<? if ( !empty( $smartBannerConfig ) ) : ?>
		<? foreach( $smartBannerConfig['meta'] as $name => $content ) : ?>
			<meta name="<?= $name ?>" content="<?= $content ?>">
		<? endforeach; ?>
	<? endif; ?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>">
<?= $wikiaNavigation ;?>
<?= $topLeaderBoardAd ;?>
<?= $pageContent ;?>
<?= $wikiaFooter ;?>
<div id=wkCurtain>&nbsp;</div>
<?= $jsBodyFiles ;?>
<?= $jsExtensionPackages ?>
<?= $inContentAd ;?>
<?= $modalInterstitial ;?>
<?= $floatingAd ;?>
<?= $trackingCode ;?>
</body>
</html>