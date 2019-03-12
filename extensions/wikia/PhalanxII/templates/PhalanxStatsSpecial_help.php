<fieldset>
	<legend>Recent triggers of a block</legend>
	<form method="get" action="<?= $action ?>">
		<label>
			ID:
			<input name="blockId" size="5" />
		</label>
		<input type="submit" value="Load">
	</form>
	Example:
	<ul>
		<li><?= $action ?>/123456</li>
		<li><?= $action ?>?blockId=123456</li>
	</ul>
</fieldset>
