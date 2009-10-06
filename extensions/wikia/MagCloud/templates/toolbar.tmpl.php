<div id="MagCloudToolbar">
	<div id="MagCloudToolbarLogo">&nbsp;</div>
<?php
	if (isset($steps)) {
		// show process steps on Special:Collection
		foreach($steps as $stepId => $stepName) {
			$className = 'MagCloudToolbarStep' . ($stepId + 1 == $currentStep ? ' MagCloudToolbarActiveStep' : '');
?>
			<span class="MagCloudItem <?= $className ?>"><?= wfMsg('magcloud-toolbar-step', $stepId + 1, htmlspecialchars($stepName)) ?></span>
<?php
			if ($stepId < count($steps) - 1) {
?>
			<span class="MagCloudToolbarArrow MagCloudItem">&nbsp;</span>
<?php
			}
		}
	}
	else {
		if (isset($title)) {
			if ($isInCollection) {
				// this article is in your collection
?>
	<span id="MagCloudToolbarArticle" class="MagCloudItem"><?= wfMsgExt('magcloud-toolbar-article-in-collection', array('parseinline'), htmlspecialchars($title)) ?></span>
<?php
			}
			else {
				// show "add article" button
?>
	<span id="MagCloudToolbarArticle" class="MagCloudItem"><?= wfMsgExt('magcloud-toolbar-article-add', array('parseinline'), htmlspecialchars($title)) ?></span>
	<a id="MagCloudToolbarAdd" class="wikia_button" onclick="MagCloud.addArticle()">
		<span><?= wfMsg('magcloud-toolbar-add') ?></span>
	</a>
<?php
			}
		}
		elseif (isset($message)) {
			// show message on non-content pages
?>
	<span id="MagCloudToolbarMessage" class="MagCloudItem"><?= htmlspecialchars($message) ?></span>
<?php
		}
?>
	<div id="MagCloudToolbarArticlesCount">
		<span class="MagCloudItem">
			<?= wfMsgExt('magcloud-toolbar-articles-count', array('parsemag'), $count) ?>
		</span>
		<a id="MagCloudToolbarGoToMagazine" class="wikia_button" href="<?=$magazineUrl;?>" onclick="MagCloud.track('/goToMagazine')">
			<span><?= wfMsg('magcloud-toolbar-go-to-magazine') ?></span>
		</a>
	</div>
<?php
	}
?>
	<div id="MagCloudToolbarClose"><a onclick="MagCloud.hideToolbar()">X</a></div>
</div>
