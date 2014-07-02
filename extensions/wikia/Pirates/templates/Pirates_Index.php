<!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>

	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<?php if ( BodyController::isResponsiveLayoutEnabled() ) : ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<?php else : ?>
		<meta name="viewport" content="width=1200">
	<?php endif ?>
	<?= $headLinks ?>

	<title><?= $pagetitle ?></title>

	<!-- CSS injected by skin and extensions -->
	<?= $cssLinks ?>

	<?
	/*
	Add the wiki and user-specific overrides last.  This is a special case in Oasis because the modules run
	later than normal extensions and therefore add themselves later than the wiki/user specific CSS is
	normally added. See Skin::setupUserCss()
	*/
	?>
	<? if ( !empty( $wg->OasisLastCssScripts ) ): ?>
		<? foreach( $wg->OasisLastCssScripts as $src ): ?>
			<link rel="stylesheet" href="<?= $src ?>">
		<? endforeach ?>
	<? endif ?>

	<? /* RT #68514: load global user CSS (and other page specific CSS added via "SkinTemplateSetupPageCss" hook) */ ?>
	<? if ( $pagecss ): ?>
		<style type="text/css"><?= $pagecss ?></style>
	<? endif ?>

	<?= $topScripts ?>
	<?= $globalBlockingScripts; /*needed for jsLoader and for the async loading of CSS files.*/ ?>
	<?= $headItems ?>
</head>
<body class="<?= implode(' ', $bodyClasses) ?>">
<div class="WikiaSiteWrapper">
	<div id="ad-skin" class="wikia-ad noprint"></div>
	<?= $globalHeader ?>
	<?= $notifications ?>
	<?= $topAds ?>
	<section id="WikiaPage" class="WikiaPage<?= empty( $wg->OasisNavV2 ) ? '' : ' V2' ?><?= !empty($isGridLayoutEnabled) ? ' WikiaGrid' : '' ?>">
		<div id="WikiaPageBackground" class="WikiaPageBackground"></div>
		<div class="WikiaPageContentWrapper">
			<?= $wikiHeader ?>
			<article class="pirates-article">
				<header>
					<h1><?= $title ?></h1>
				</header>
				<div class="home-top-right-ads">
					<?php
					echo $app->renderView('Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD']);
					echo $app->renderView('Ad', 'Index', ['slotName' => 'MIDDLE_RIGHT_BOXAD']);
					echo $app->renderView('Ad', 'Index', ['slotName' => 'LEFT_SKYSCRAPER_2']);
					?>
				</div>
				<?= $bodytext ?>
			</article>
			<?= $footer ?>
		</div>
	</section><!--WikiaPage-->
</div>
<? if( $jsAtBottom ): ?>
	<!-- Combined JS files and head scripts -->
	<?= $jsFiles ?>
<? endif ?>

<script type="text/javascript">/*<![CDATA[*/ Wikia.LazyQueue.makeQueue(wgAfterContentAndJS, function(fn) {fn();}); wgAfterContentAndJS.start(); /*]]>*/</script>

<?= $bottomScripts ?>
<?= $cssPrintLinks ?>
</body>
</html>
