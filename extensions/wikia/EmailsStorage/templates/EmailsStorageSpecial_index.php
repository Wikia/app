<h1><?= wfMsg('emailsstorage-button-export'); ?></h1>

<form action="<?= $buttonAction; ?>" method="post" class="emailsstorage-form" id="emailsstorage-form">
	<select name="type">
		<? foreach($typeList as $key => $label): ?>
			<option value="<?= $key; ?>"><?= wfMsg("emailsstorage-source-$label") ?></option>
		<? endforeach; ?>
	</select>
	<div class="buttons">
		<input type="submit" name="export" value="<?= wfMsg('emailsstorage-button-export'); ?>">
	</div>
</form>
