<!doctype html>
<html lang="en" dir="<?= $dir ?>">
<head>
	<meta http-equiv="Content-Type" content="<?= $mimetype ?>; charset=<?= $charset ?>">
	<meta name="viewport" content="width=1200">

	<title><?= wfMsg('themedesigner-title') ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<link rel="stylesheet" href="<?= wfGetSassUrl('/extensions/wikia/ThemeDesigner/css/ThemeDesigner.scss') ?>">

	<?= $globalVariablesScript ?>

	<script>
		var returnTo = <?= Xml::encodeJSVar($returnTo) ?>;
		var themeHistory = <?= Wikia::json_encode($themeHistory) ?>;
		var themeSettings = <?= Wikia::json_encode($themeSettings) ?>;
		var themes = <?= Wikia::json_encode($wgOasisThemes) ?>;
	</script>

	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.4.2.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.wikia.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.wikia.tracker.js"></script>
	<script src="<?= $wgStylePath ?>/common/jquery/jquery.json-1.3.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/js/aim.js"></script>

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
		<?= wfRenderModule('ThemeDesigner', 'ThemeTab') ?>
		<?= wfRenderModule('ThemeDesigner', 'CustomizeTab') ?>
		<?= wfRenderModule('ThemeDesigner', 'WordmarkTab') ?>
		<div id="Toolbar" class="Toolbar">
			<div class="inner">
				<span class="mode"><?= wfMsg('themedesigner-preview-mode') ?></span>
<?php
	if(count($themeHistory) > 0) {
?>
				<span class="history">
					<span class="revisions"><?= count($themeHistory) ?></span>
					<?= wfMsg('themedesigner-previous-versions') ?>
					<img class="chevron" src="<?= $wgBlankImgUrl ?>">
					<ul>
					<?php
					foreach($themeHistory as $themeHistoryItem) {
					?>
						<li>
							<?= View::specialPageLink('#', null, 'wikia-chiclet-button', 'blank.gif', 'recycle'); ?>
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

	<?= wfRenderModule('ThemeDesigner', 'Picker') ?>

	<iframe frameborder=0 id="PreviewFrame" class="PreviewFrame" src="<?= $wgServer ?>/wiki/Special:ThemeDesignerPreview"></iframe>

<?= $analytics ?>

</body>
</html>
