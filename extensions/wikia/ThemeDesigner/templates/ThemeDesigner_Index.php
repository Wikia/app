<!doctype html>
<html lang="en" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">

	<title><?= $pageTitle ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ThemeDesigner/css/ThemeDesigner.scss') ?>">
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/skins/oasis/css/core/WikiaSlider.scss') ?>">
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/resources/wikia/libraries/bootstrap/tooltip.scss') ?>">

	<?= $globalVariablesScript ?>

	<script>
		var returnTo = <?= Xml::encodeJSVar($returnTo) ?>;
		var themeHistory = <?= json_encode($themeHistory) ?>;
		var themeSettings = <?= json_encode($themeSettings) ?>;
		var themes = <?= json_encode($wg->OasisThemes) ?>;
		var applicationThemeSettings = <?= json_encode($applicationThemeSettings) ?>;
	</script>

<?php
	$srcs = AssetsManager::getInstance()->getGroupCommonURL('theme_designer_js');

	foreach($srcs as $src) {
		echo "\n\t" . Html::linkedScript($src);
	}
?>

</head>
<body>

	<div id="Designer" class="Designer">
		<nav id="Navigation" class="Navigation">
			<ul>
				<li>
					<a href="#" rel="ThemeTab"><?= wfMsg('themedesigner-tab-theme') ?></a>
				</li>
				<li>
					<a href="#" rel="CustomizeTab"><?= wfMsg('themedesigner-tab-customize') ?></a>
				</li>
				<li>
					<a href="#" rel="WordmarkTab"><?= wfMsg('themedesigner-tab-wordmark') ?></a>
				</li>
			</ul>
		</nav>
		<?= F::app()->renderView('ThemeDesigner', 'ThemeTab') ?>
		<?= F::app()->renderView('ThemeDesigner', 'CustomizeTab') ?>
		<?= F::app()->renderView('ThemeDesigner', 'WordmarkTab') ?>
		<div id="Toolbar" class="Toolbar">
			<div class="inner">
				<span class="mode"><?= wfMsg('themedesigner-preview-mode') ?></span>
<?php
	if(count($themeHistory) > 0) {
?>
				<span class="history">
					<span class="revisions"><?= count($themeHistory) ?></span>
					<?= wfMsg('themedesigner-previous-versions') ?>
					<img class="chevron" src="<?= $wg->BlankImgUrl ?>">
					<ul>
					<?php
					foreach($themeHistory as $themeHistoryItem) {
					?>
						<li>
							<?= Wikia::specialPageLink('#', null, 'wikia-chiclet-button', 'blank.gif', 'recycle'); ?>
							<?= wfMsg( 'themedesigner-history-item', $themeHistoryItem['timeago'], $themeHistoryItem['author'] ) ?>
						</li>
					<?php
					}
					?>
					</ul>
				</span>
<?php
	} //end if
?>
				<button class="save"><?= wfMsg('themedesigner-button-save-im-done') ?></button>
				<button class="cancel secondary"><?= wfMsg('themedesigner-button-cancel') ?></button>
			</div>
		</div>
	</div>

	<?= F::app()->renderView('ThemeDesigner', 'Picker') ?>

	<iframe frameborder=0 id="PreviewFrame" class="PreviewFrame" src="<?= str_replace('$1', 'Special:ThemeDesignerPreview', $wg->ArticlePath) ?>?noexternals=1"></iframe>
</body>
</html>
