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
	<form method="get" action="<?= Sanitizer::encodeAttribute( $formData['actionURL'] ) ?>">
		<div style="float: left; margin-right: 6px">


			<select size="10" style="width: 22em;" id="variableSelect" name="var">
			<?php
				$gVar = empty( $formData['selectedVar'] ) ? '' : $formData['selectedVar'];
				$gVal = empty( $formData['selectedVal'] ) ? '' : $formData['selectedVal'];
				foreach( $formData['vars'] as $varId => $varName ) :
					$selected = $gVar == $varId ? ' selected' : '';
			?>
				<option value="<?= Sanitizer::encodeAttribute( $varId ) ?>" <?= $selected ?>>
					<?= htmlspecialchars( $varName ) ?>
				</option>
			<?php
				endforeach;
			?>
			</select>
		</div>
		<p>
			<?= wfMessage( 'whereisextension-search-type' )->escaped() ?>
		</p>
		<select style="width: 22em;" id="searchType" name="searchType" >
			<option value="bool" <?= $formData['searchType'] != 'full' ? 'selected' : '' ?>  ><?= wfMessage( 'whereisextension-search-type-bool' )->escaped() ?></option>
			<option value="full" <?= $formData['searchType'] == 'full' ? 'selected' : '' ?> ><?= wfMessage( 'whereisextension-search-type-full' )->escaped() ?></option>
		</select>
		<p class="boolValue"   >
			<?= wfMessage( 'whereisextension-isset' )->escaped() ?>
		</p>
		<select class="boolValue" name="val">
			<?php
				foreach( $formData['vals'] as $valId => $valName ) :
					$selected = $gVal == $valId ? ' selected' : '';
			?>
				<option value="<?= Sanitizer::encodeAttribute( $valId ) ?>" <?= $selected ?>>
					<?= htmlspecialchars( $valName[0] ) ?>
				</option>
			<?php
				endforeach;
			?>
		</select>
		<p class="likeValue"  style="display:none">
			<?= wfMessage( 'whereisextension-search-like-value' )->escaped() ?>
		</p>

		<input value="<?= Sanitizer::encodeAttribute( $formData['likeValue'] ) ?>" type="text" name="likeValue" class="likeValue"  style="display:none">&nbsp;
		<input type="submit" value="<?= wfMessage( 'whereisextension-submit' )->escaped() ?>">
	</form>

	<br/>
	<?= wfMessage( 'whereisextension-filter' )->escaped() ?>
	<br/>
	<select id="groupSelect" name="group">
		<option value="0" selected="selected">
			<?= wfMessage( 'whereisextension-all-groups' )->escaped() ?>
		</option>
		<? foreach ( $formData['groups'] as $key => $value ) {
			$selected = $key == $formData['selectedGroup'] ? ' selected' : '';
		?>
		<option value="<?= Sanitizer::encodeAttribute( $key ) ?>"<?= $selected ?>>
			<?= htmlspecialchars( $value ) ?>
		</option>
		<? } ?>
	</select>
	<br/>
	<label for="withString"><?= wfMessage( 'whereisextension-name-contains' )->escaped() ?></label>
	<br/>
	<input type="text" name="withString" id="withString" size="18" />

	<?php
	if ( !empty( $formData['wikis'] ) && count( $formData['wikis'] ) ) {
		?>
		<h3 id="headerWikis"><?= wfMessage( 'whereisextension-list', $formData['count'] )->escaped() ?></h3>
		<form method="post" action="<?= Sanitizer::encodeAttribute( $formData['actionURL'] ) ?>" name="wikiSelectForm">
			<ul>
				<?
					foreach( $formData['wikis'] as $wikiID => $wikiInfo ) :
						$style = !$wikiInfo['p'] ? 'style="color: red"' : '';
						$editURL = SpecialPage::getTitleFor( 'WikiFactory', "{$wikiID}/variables/{$formData['vars'][ $formData['selectedVar'] ]}" )->getFullURL();
				?>
					<li class="wikiList">
						<input type="checkbox" name="wikiSelected[]" id="wikiSelected_<?= Sanitizer::encodeAttribute( $wikiID ) ?>" value="<?= Sanitizer::encodeAttribute( $wikiID ) ?>">
						<a href="<?= Sanitizer::encodeAttribute( $editURL ) ?>" <?= $style ?>><?= wfMessage( 'whereisextension-edit' )->escaped() ?></a>
						<a href="<?= Sanitizer::encodeAttribute( $wikiInfo['u'] ) ?>" <?= $style ?>>
							<?= htmlspecialchars( $wikiInfo['t'] ) ?>
						</a> (<?= htmlspecialchars( $wikiInfo['u'] ) ?>)
					</li>
				<? endforeach; ?>
			</ul>
                        <?= $sPager ?>
			<a href="#" id="wikiSelectAll" class="selectorLink"><?= wfMessage( 'whereisextension-select-all' )->escaped() ?></a>&nbsp;
			<a href="#" id="wikiDeselectAll" class="selectorLink"><?= wfMessage( 'whereisextension-deselect-all' )->escaped() ?></a><br />
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

	$.loadJQueryAutocomplete(function() {
		$('#wikiSelectTagName').autocomplete({
			serviceUrl: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScript' ) + '?action=ajax&rs=WikiFactoryTags::axQuery',
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
	var ajaxpath = mw.config.get('wgScriptPath') + '/index.php';

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
		values += '&group=' + encodeURIComponent($('#groupSelect').val());
		values += '&string=' + encodeURIComponent($('#withString').val());

		$.ajax({
			type:"POST",
			dataType: "json",
			url: ajaxpath + '?action=ajax&rs=axWFactoryFilterVariables' + values,
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
