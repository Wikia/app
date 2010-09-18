<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
function deletechecked() {
    var answer = confirm("Delete tag?")
	return answer;
}

$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
	$('#wftagsearchinput').autocomplete({
		serviceUrl: wgServer+wgScript+'?action=ajax&rs=WikiFactoryTags::axQuery',
		minChars:3,
		deferRequestBy: 0
	});
});

/*]]>*/
</script>
<form action="<?php echo $title->getFullUrl() ?>" method="post">
<fieldset>
	<legend>Search for wikis</legend>
	<table>
	<tr>
		<td class="mw-label" style="width: 150px;">
			Tag name
		</td>
		<td class="mw-input">
			&nbsp;
			<input type="text" name="wpSearchTag" id="wftagsearchinput" value="<?php echo $searchTag; ?>" />
			<input type="submit" id="wpSearchTagSubmit" value="Search" />
		</td>
	</tr>
	</table>
</fieldset>
</form>
<?php
# if( !empty($_POST) ) { print "POST="; print_r($_POST); print "<br/>\n"; }

if( !empty($info) ) { print_r($info); }
?>
<form action="<?php echo $title->getFullUrl() ?>" method="post"><?
?><input type="hidden" name="remove_tag" value="<?php echo $searchTag; ?>" /><?
?><input type="hidden" name="wpSearchTag" value="<?php echo $searchTag; ?>" />
<?php if( count( $searchTagWikiIds ) > 0 ): ?>
<fieldset>
	<legend>Tagged wikis (<?php echo count( $searchTagWikiIds ); ?>)</legend>
		<tr>
			<td class="mw-input">
				<?php foreach( $searchTagWikiIds as $wikiId ): ?>
					<input type='checkbox' name="remove_tag_id[]" value="<?php echo $wikiId; ?>"> <?
					echo '<a href="' . $wikiFactoryUrl . "/" . $wikiId . '">' .
					"<strong>" . $wikiId . "</strong> - " . WikiFactory::getVarValueByName('wgServer', $wikiId);
					?></a><br />
				<?php endforeach; ?><br/>
			</td>
		</tr>
		<tr>
			<td class="mw-input"><input type="submit" value="remove tag from checked wikis" /></td>
		</tr>
	</table>
</fieldset>
<?php endif; ?>
</form>
