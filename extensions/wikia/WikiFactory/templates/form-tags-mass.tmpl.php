<!-- s:<?= __FILE__ ?> -->
<script>
$.loadJQueryAutocomplete(function() {
	$('#wftaginput').autocomplete({
		serviceUrl: mw.util.wikiScript() +'?action=ajax&rs=WikiFactoryTags::axQuery',
		minChars:3,
		deferRequestBy: 0
	});
});
</script>
<?php
	if( !empty( $info ) ):
		echo $info;
	endif;
?>
<form action="<?php echo $title->getFullUrl() ?>" method="post">
<fieldset>
	<legend><strong><big>Mass Tagger</big></strong></legend>
	<table>
		<tr>
			<td class="mw-label" style="width: 100px;">Tag name</td>
			<td class="mw-input"><input type="text" name="wpMassTag" id="wftaginput" value="" /></td>
		</tr>
		<tr>
			<td class="mw-label" style="width: 100px;">DART rows</td>
			<td class="mw-input"><textarea rows="10" cols="40" name="wfMassTagWikis" id="wfMassTagWikis" /></textarea></td>
		</tr>
		<tr>
			<td class="mw-label" style="width: 100px;"></td>
			<td class="mw-input">
				<input type="submit" id="wpMassTagSubmit" value="Add the above tag to all these wikis?" />
			</td>
		</tr>
	</table>
</fieldset>
</form>
