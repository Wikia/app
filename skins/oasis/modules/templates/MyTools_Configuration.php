<div id="MyToolsConfiguration" class="MyToolsConfiguration">

	<script src="<?= $wgScriptPath ?>/skins/common/jquery/jquery-ui-1.7.2.custom.js"></script>

	<h1><?= wfMsg('oasis-edit-my-tools-title') ?></h1>


	<form class="my-tools-form">
		<fieldset>
			<label><?= wfMsg('oasis-edit-my-tools-addtool') ?></label>
			<input type="text" class="search" autocomplete="off">

			<label><?= wfMsg('oasis-edit-my-tools-list') ?></label>
			<ul class="list">
<?php foreach($userCustomTools as $tool) { ?>
				<li class="<?= $tool['name'] ?>"><img src="<?= $wgBlankImgUrl ?>" class="sprite drag"><?= $tool['desc'] ?><img src="<?= $wgBlankImgUrl ?>" class="sprite trash"></li>
<?php } ?>
			</ul>
		</fieldset>

		<input type="submit" value="<?= wfMsg('oasis-edit-my-tools-save') ?>">
	</form>

	<div class="help-text">
		<h1><?= wfMsg('oasis-edit-my-tools-about') ?></h1>
		<?= wfMsgExt('oasis-edit-my-tools-desc', array('parse')) ?>
	</div>

</div>