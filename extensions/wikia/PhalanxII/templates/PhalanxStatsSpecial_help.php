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
<!--
<fieldset class="lu_fieldset">
	<legend>Recent blocks on a wiki</legend>
	<form method="get" action="<?= $action ?>">
	ID: <input id="wikiId" name="wikiId" size="5" value="wiki/" /><button class="submit">Load</button>
	</form>
	<br />
	Example:
	<ul>
		<li>http://community.wikia.com/wiki/Special:PhalanxStats/wiki/123456</li>
	</ul>
</fieldset>
-->
