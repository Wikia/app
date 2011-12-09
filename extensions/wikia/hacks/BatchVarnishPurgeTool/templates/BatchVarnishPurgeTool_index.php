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

.selectorLink {
	font-size: x-small;
}

</style>

<div id="busyDiv" style="display: none;">
	<img src="http://images.wikia.com/common/progress_bar.gif" width="100" height="9" alt="Wait..." border="0" />'
</div>
<div id="PaneList">
	<form method="get" action="<?= $formData['actionURL'] ?>">
		<div>
			<?php if (!empty($formErrors['url'])) { ?>
			<div class="error"><?= $formErrors['url']?></div>
			<?php } ?>
			<label for="url"><?= wfMsg('batchvarnishpurgetool-url') ?></label>
			<input type="text" name="url" id="url" size="40" />
		</div>
		<div style="float: left; margin-right: 6px">
			<?php if (!empty($formErrors['var'])) { ?>
			<div class="error"><?= $formErrors['var']?></div>
			<?php } ?>
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
		<p>
			<?= wfMsg('batchvarnishpurgetool-search-type') ?>
		</p>
		<select style="width: 22em;" id="searchType" name="searchType" >
			<option value="bool" <?php echo $formData['searchType'] != 'full' ? 'selected="selected" ':'' ?>  ><?= wfMsg('batchvarnishpurgetool-search-type-bool') ?></option>
			<option value="full" <?php echo $formData['searchType'] == 'full' ? 'selected="selected" ':'' ?> ><?= wfMsg('batchvarnishpurgetool-search-type-full') ?></option>
		</select>
		<p class="boolValue"   >
			<?php print wfMsg('batchvarnishpurgetool-isset') ?>
		</p>
		<select class="boolValue" name="val">
			<?php
			foreach($formData['vals'] as $valId => $valName) {
				$selected = $gVal == $valId ? ' selected="selected"' : '';
				echo "\t\t<option value=\"$valId\"$selected>{$valName[0]}</option>\n";
			}
			?>
		</select>
		<p class="likeValue"  style="display:none">
			<?php print wfMsg('batchvarnishpurgetool-search-like-value') ?>
		</p>
		
		<input value="<?php echo $formData['likeValue']; ?>" type="text" name="likeValue" class="likeValue"  style="display:none" />&nbsp;
		<input type="submit" value="<?php print wfMsg('batchvarnishpurgetool-submit') ?>"/>
	</form>

	<br/>
	<?php print wfMsg('batchvarnishpurgetool-filter') ?>
	<br/>
	<select id="groupSelect" name="group">
		<option value="0" selected="selected">
			<?php print wfMsg('batchvarnishpurgetool-all-groups') ?>
		</option>
		<? foreach ($formData['groups'] as $key => $value) {
			$selected = $key == $formData['selectedGroup'] ? ' selected="selected"' : '';
		?>
		<option value="<?php print $key ?>"<?php print $selected ?>><?php print $value ?></option>
		<? } ?>
	</select>
	<br/>
	<label for="withString"><?php print wfMsg('batchvarnishpurgetool-name-contains') ?></label>
	<br/>
	<input type="text" name="withString" id="withString" size="18" />
</div>
<? if (!empty($purgedUrls)) { ?>
<div id='purgedUrls'>
<h3><?= wfMsg('batchvarnishpurgetool-success')?></h3>
	<ul>
	<? foreach ($purgedUrls as $url) { ?>
		<li><?= $url?></li>
	<? } ?>
	</ul>
</div>
<? } ?>

<script type="text/javascript">
	var ajaxpath = "<?php print $GLOBALS['wgScriptPath'].'/index.php'; ?>";

	function showHideLikeBool(e) {
		if(e.val() == "bool") {
			$('.likeValue').hide();
			$('.boolValue').show();
		}

		if(e.val() == "full") {
			$('.likeValue').show();
			$('.boolValue').hide();
		}
	} 

	$( function() {
		var el = $('#searchType');
		showHideLikeBool(el); 
	});
	
	$('#searchType').change(
		function(e) {
			var el = $(e.target);
			showHideLikeBool(el);
		}
	);

	busy = function(state) {
		if (state == 0) {
			$('#busyDiv').val('display', 'none');
			$('#variableSelect').attr("disabled", false);
		} else {
			$('#busyDiv').val('busyDiv', 'display', 'block');
			$("#variableSelect").attr("disabled" ,true);
		}
	};

	filter = function (e) {
		busy(1);
		// read data from form
		var values = '';
		values += '&group=' + $('#groupSelect').val();
		values += '&string=' + $('#withString').val();

		$.ajax({
			type:"POST",
			dataType: "json",
			url: ajaxpath+'?action=ajax&rs=axWFactoryFilterVariables' + values,
			success: function( aData ) {
				$('#variableSelect').html(aData['selector']);
				busy(0);
			},
			error: function( aData ) {
				busy(0);
			},
			timeout: 50000
		});
	};

	$('#withString').keyup(filter);
	$('#groupSelect').change(filter);
</script>
<!-- e:<?php print __FILE__ ?> -->

