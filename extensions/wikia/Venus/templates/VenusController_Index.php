<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimeType ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<?= $headLinks ?>
	<title><?= $pageTitle ?></title>
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
<? if ($pageCss): ?>
	<style type="text/css"><?= $pageCss ?></style>
<? endif ?>

	<?= $topScripts ?>
	<?= $jsHeadFiles ?>
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
		<?= $contents ?>
	</article>
	<?#TODO: Re-Enable when it's ready = $footer ?>
	<?#TODO: Re-Enable when it's ready = $corporateFooter ?>
</section>
	<!--WikiaPage-->
<?= $jsBodyFiles ?>
<?#TODO: = $printCssLinks ?>
</body>
</html>
