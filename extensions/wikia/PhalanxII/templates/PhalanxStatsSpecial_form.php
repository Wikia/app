<fieldset class="lu_fieldset">
	<legend>Recent triggers of a block</legend>
	<form method="GET" action="<?=$phalanxTitle->getFullUrl()?>">
	ID: <input id="blockId" name="blockId" size="5" /><button class="submit">Load</button>
	</form>
	<br />
	Example:
	<ul>
		<li>http://community.wikia.com/wiki/Special:PhalanxStats/123456</li>
		<li>http://community.wikia.com/wiki/Special:PhalanxStats?blockId=123456</li>
	</ul>
</fieldset>

<fieldset class="lu_fieldset">
	<legend>Recent blocks on a wiki</legend>
	<form method="GET" action="<?=$phalanxTitle->getFullUrl()?>">
	ID: <input id="wikiId" name="wikiId" size="5" value="wiki/" /><button class="submit">Load</button>
	</form>
	<br />
	Example:
	<ul>
		<li>http://community.wikia.com/wiki/Special:PhalanxStats/wiki/123456</li>
	</ul>
</fieldset>
