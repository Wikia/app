<div id="MyToolsConfiguration" class="MyToolsConfiguration">

	<h1><?= wfMsg('oasis-toolbar-edit-title') ?></h1>

	<form class="toolbar-customize">
		<div class="column">
			<label><?= wfMsg('oasis-toolbar-edit-toolbar-list') ?></label>
			<span class="reset-defaults">
				<a class="wikia-chiclet-button" href="#">
					<img height="0" width="0" src="<?= wfBlankImgUrl() ?>">
				</a>
				<a href="#">
					<?= wfMsg('oasis-toolbar-edit-reset-defaults') ?>
				</a>
			</span>
			<ul class="options-list">
			</ul>
		</div>
		<div class="column">
			<label><?= wfMsg('oasis-toolbar-edit-find-a-tool') ?></label>
			<span class="advanced-tools"><?php echo wfMsgExt('oasis-toolbar-edit-advanced-tools', array('parseinline')); ?></span>
			<div class="search-box">
				<input type="text" class="search" autocomplete="off" placeholder="<?= wfMsg('oasis-toolbar-edit-search-for-tool') ?>">
			</div>
			<div class="popular-tools-group">
				<ul class="popular-list">
				</ul>
				<div class="popular-toggle toggle-1"><span class="icon-show"></span><?= wfMsg('oasis-toolbar-edit-popular-tools') ?></div>
				<div class="popular-toggle toggle-0"><span class="icon-hide"></span><?= wfMsg('oasis-toolbar-edit-hide-tools') ?></div>
			</div>
		</div>
		<div class="buttons">
			<input type="submit" class="save-button" value="<?= wfMsg('oasis-toolbar-edit-save') ?>">
			<input type="button" class="cancel-button secondary" value="<?= wfMsg('oasis-toolbar-edit-cancel') ?>">
		</div>
		
	</form>

</div>