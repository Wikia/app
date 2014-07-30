<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
<?php if (BodyController::isResponsiveLayoutEnabled()) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<?php else : ?>
	<meta name="viewport" content="width=1200">
<?php endif ?>
	<?= $headLinks ?>
	<title><?= $pagetitle ?></title>
	<?= $cssLinks ?>
<?
/*
Add the wiki and user-specific overrides last.  This is a special case in Oasis because the modules run
later than normal extensions and therefore add themselves later than the wiki/user specific CSS is
normally added. See Skin::setupUserCss()
*/
?>
<? if (!empty($wg->OasisLastCssScripts)): ?>
	<? foreach ($wg->OasisLastCssScripts as $src): ?>
		<link rel="stylesheet" href="<?= $src ?>">
	<? endforeach ?>
<? endif ?>

<? /* RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook) */ ?>
<? if ($pagecss): ?>
	<style type="text/css"><?= $pagecss ?></style>
<? endif ?>

	<?= $topScripts ?>
	<?= $globalBlockingScripts; /*needed for jsLoader and for the async loading of CSS files.*/ ?>
	<?= $headItems ?>
</head>

<body class="<?= $bodyClasses ?>">
<div id="ad-skin" class="wikia-ad noprint"></div>
<?#TODO: Re-Enable when it's ready = $globalHeader ?>
<?#TODO: Re-Enable when it's ready = $notifications ?>
<?#TODO: Re-Enable when it's ready = $topAds ?>
<section class="wikia-page">
	<?#TODO: Re-Enable when it's ready = $wikiHeader ?>
	<article class="article">
		<header>
			<h1><?= $title ?></h1>
		</header>
		<?= $bodytext ?>
	</article>
	<?#TODO: Re-Enable when it's ready = $footer ?>
	<?#TODO: Re-Enable when it's ready = $corporateFooter ?>
</section>
	<!--WikiaPage-->
<? if ($jsAtBottom): ?>
	<!-- Combined JS files and head scripts -->
	<?= $jsFiles ?>
<? endif ?>
<?= $bottomScripts ?>
<?= $cssPrintLinks ?>
</body>
</html>
