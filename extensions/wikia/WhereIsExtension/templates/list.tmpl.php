<!-- s:<?php print __FILE__ ?> -->
<style type="text/css">
#PaneList #headerWikis {
	margin-top: 20px;
	clear: both;
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

#wikiSelectTag {
	width: 120px;
}

.selectorLink {
	font-size: x-small;
}

</style>

<div id="busyDiv" style="display: none;">
	<img src="http://images.wikia.com/common/progress_bar.gif" width="100" height="9" alt="Wait..." border="0" />'
</div>
<?php if( !empty( $tagResultInfo ) ): ?>
	<div class="successbox" "style="margin: 0;margin-bottom: 1em;">
		<?php echo $tagResultInfo; ?>
	</div>
	<br style="clear: both;" />
<?php endif; ?>
<div id="PaneList">
	<form method="get" action="<?php print $formData['actionURL'] ?>">
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
		<?php print wfMsg('whereisextension-isset') ?>
		<select name="val">
			<?php
			foreach($formData['vals'] as $valId => $valName) {
				$selected = $gVal == $valId ? ' selected="selected"' : '';
				echo "\t\t<option value=\"$valId\"$selected>{$valName[0]}</option>\n";
			}
			?>
		</select>
		<input type="submit" value="<?php print wfMsg('whereisextension-submit') ?>"/>
	</form>

	<br/>
	<?php print wfMsg('whereisextension-filter') ?>
	<br/>
	<select id="groupSelect" name="group">
		<option value="0" selected="selected">
			<?php print wfMsg('whereisextension-all-groups') ?>
		</option>
		<? foreach ($formData['groups'] as $key => $value) {
			$selected = $key == $formData['selectedGroup'] ? ' selected="selected"' : '';
		?>
		<option value="<?php print $key ?>"<?php print $selected ?>><?php print $value ?></option>
		<? } ?>
	</select>
	<br/>
	<label for="withString"><?php print wfMsg('whereisextension-name-contains') ?></label>
	<br/>
	<input type="text" name="withString" id="withString" size="18" />

	<?php
	if (!empty($formData['wikis']) && count($formData['wikis'])) {
		?>
		<h3 id="headerWikis"><?php print wfMsg('whereisextension-list') ?> (<?php print count($formData['wikis']) ?>)</h3>
		<form method="post" action="<?php print $formData['actionURL'] ?>" name="wikiSelectForm">
			<ul>
			<?php
			$front = '&nbsp;<a href="' . Title::makeTitle( NS_SPECIAL, 'WikiFactory' )->getFullUrl() . '/';
			$back = '/variables/' . $formData['vars'][ $formData['selectedVar'] ] . '">[edit]</a>';
			foreach($formData['wikis'] as $wikiID => $wikiInfo) {
				$editURL = $front . $wikiID . $back;
				?>
				<li class="wikiList">
					<input type="checkbox" name="wikiSelected[]" id="wikiSelected_<?php print $wikiID; ?>" value="<?php print $wikiID; ?>" />&nbsp;
					<a href="<?php print htmlspecialchars($wikiInfo['u']) ?>" <?php echo ( !$wikiInfo['p'] ? "style=\"color: red;\"" : "" ); ?>><?php print $wikiInfo['t'] ?></a><?php print $editURL ?>
				</li>
				<?php
			}
			?>
			</ul>
			<a href="#" id="wikiSelectAll" class="selectorLink">select all</a>&nbsp;
			<a href="#" id="wikiDeselectAll" class="selectorLink">deselect all</a><br />
			Tag name:&nbsp;
			<input type="text" name="wikiSelectTagName" id="wikiSelectTagName" value="" />&nbsp;
			<input type="submit" name="wikiSelectSubmit" value="Tag selected" />
		</form>
<script type="text/javascript">
/*<![CDATA[*/
	$('#wikiSelectAll').bind('click', function(e) {
		$(".wikiList").find('input').each( function(i, element) {
				element.checked = true;
			});
			return false;
		});

	$('#wikiDeselectAll').bind('click', function(e) {
		$(".wikiList").find('input').each( function(i, element) {
				element.checked = false;
			});
			return false;
		});

	$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
		$('#wikiSelectTagName').autocomplete({
			serviceUrl: wgServer+wgScript+'?action=ajax&rs=WikiFactoryTags::axQuery',
			minChars:3,
			deferRequestBy: 0
		});
	});
/*]]>*/
</script>
		<?php
	}
	?>
</div>

<script type="text/javascript">
	var ajaxpath = "<?php print $GLOBALS['wgScriptPath'].'/index.php'; ?>";
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
<!-- e:<?php print __FILE__ ?> -->
