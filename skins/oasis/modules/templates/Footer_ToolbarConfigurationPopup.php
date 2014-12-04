<div id="MyToolsConfiguration" class="MyToolsConfiguration">
	<div class="toolbar-customize WikiaForm">
		<div class="column">
			<label><?= wfMessage('oasis-toolbar-edit-find-a-tool')->plain() ?></label>
			<span class="advanced-tools"><?= wfMessage('oasis-toolbar-edit-advanced-tools')->parse() ?></span>
			<div class="search-box input-group">
				<input type="text" class="search" autocomplete="off" placeholder="<?= wfMessage('oasis-toolbar-edit-search-for-tool')->plain() ?>">
			</div>
			<div class="popular-tools-group">
				<ul class="popular-list">
				</ul>
				<div class="popular-toggle toggle-1"><span class="icon-show"></span><?= wfMessage('oasis-toolbar-edit-popular-tools')->plain() ?></div>
				<div class="popular-toggle toggle-0"><span class="icon-hide"></span><?= wfMessage('oasis-toolbar-edit-hide-tools')->plain() ?></div>
			</div>
		</div>
		<div class="column">
			<label><?= wfMessage('oasis-toolbar-edit-toolbar-list')->plain() ?></label>
			<span class="reset-defaults">
				<a class="wikia-chiclet-button" href="#">
					<img height="0" width="0" src="<?= wfBlankImgUrl() ?>">
				</a>
				<a href="#">
					<?= wfMessage('oasis-toolbar-edit-reset-defaults')->plain() ?>
				</a>
			</span>
			<ul class="options-list">
			</ul>
		</div>
	</div>
</div>
