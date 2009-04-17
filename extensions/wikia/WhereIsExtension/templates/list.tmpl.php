<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#PaneList #headerWikis {
	margin-top: 20px;
}
#busyDiv {
	position: fixed;
	top: 9em;
	right: 1em;
	z-index: 9000;
}
select {
	vertical-align: inherit;
}
</style>

<div id="busyDiv" style="display: none;">
	<img src="http://images.wikia.com/common/progress_bar.gif" width="100" height="9" alt="Wait..." border="0" />'
</div>

<div id="PaneList">
	<form method="get" action="<?= $formData['actionURL'] ?>">
		<div style="float: left; margin-right: 6px">
			<select size="10" style="width: 22em;" id="variableSelect" name="var">
			<?php
			$gVar = empty($formData['selectedVar']) ? '' : $formData['selectedVar'];
			$gVal = empty($formData['selectedVal']) ? '' : $formData['selectedVal'];
			foreach($formData['vars'] as $varId => $varName) {
				$selected = $gVar == $varId ? ' selected="selected"' : '';
				echo "\t\t<option value=\"$varId\"$selected>$varName</option>\n";
			}
			?>
			</select>
		</div>
		<?= wfMsg('whereisextension-isset') ?>
		<select name="val">
			<option value="true"<?= $gVal == 'true' ? ' selected="selected"' : '' ?>>true</option>
			<option value="false"<?= $gVal == 'false' ? ' selected="selected"' : '' ?>>false</option>
		</select>
		<input type="submit" value="<?= wfMsg('whereisextension-submit') ?>"/>
	</form>

	<br/>
	<?= wfMsg('whereisextension-filter') ?>
	<br/>
	<select id="groupSelect" name="group">
		<option value="0" selected="selected">
			<?= wfMsg('whereisextension-all-groups') ?>
		</option>
		<? foreach ($formData['groups'] as $key => $value) {
			$selected = $key == $formData['selectedGroup'] ? ' selected="selected"' : '';
		?>
		<option value="<?= $key ?>"<?= $selected ?>><?= $value ?></option>
		<? } ?>
	</select>
	<br/>
	<label for="withString"><?= wfMsg('whereisextension-name-contains') ?></label>
	<br/>
	<input type="text" name="withString" id="withString" size="18" />

	<?php
	if (!empty($formData['wikis']) && count($formData['wikis'])) {
		?>
		<h3 id="headerWikis"><?= wfMsg('whereisextension-list') ?> (<?= count($formData['wikis']) ?>)</h3>
		<ul>
		<?php
		foreach($formData['wikis'] as $wikiName => $wikiUrl) {
			?>
			<li><a href="<?= htmlspecialchars($wikiUrl) ?>"><?= $wikiName ?></a></li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	?>
</div>

<script type="text/javascript">
	var ajaxpath = "<?= $GLOBALS['wgScriptPath'].'/index.php'; ?>";
	var DOM = YAHOO.util.Dom;

	busy = function(state) {
		if (state == 0) {
			DOM.setStyle('busyDiv', 'display', 'none');
		} else {
			DOM.setStyle('busyDiv', 'display', 'block');
		}
	};

	filterCallback = {
		success: function( oResponse ) {
			var aData = YAHOO.Tools.JSONParse(oResponse.responseText);
			DOM.get('variableSelect').innerHTML = aData['selector'];
			DOM.get('variableSelect').disabled = false;
			busy(0);

		},
		failure: function( oResponse ) {
			busy(0);
			DOM.get('variableSelect').disabled = false;
		},
		timeout: 50000
	};

	filter = function (e) {
		busy(1);

		// disable variable selector
		DOM.get("variableSelect").disabled = true;

		// read data from form
		var values = '';
		values += '&group=' + DOM.get('groupSelect').value;
		values += '&string=' + DOM.get('withString').value;
		YAHOO.util.Connect.asyncRequest('POST', ajaxpath+'?action=ajax&rs=axWFactoryFilterVariables' + values, filterCallback);
	};

	YAHOO.util.Event.addListener('withString', 'keypress', filter);
	YAHOO.util.Event.addListener('groupSelect', 'change', filter);
</script>
<!-- e:<?= __FILE__ ?> -->
