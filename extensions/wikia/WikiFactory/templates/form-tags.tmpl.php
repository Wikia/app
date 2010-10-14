<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
function deletechecked() {
    var answer = confirm("Delete tag?")
	return answer;
}

$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
	$('#wftaginput').autocomplete({
		serviceUrl: wgServer+wgScript+'?action=ajax&rs=WikiFactoryTags::axQuery',
		minChars:3,
		deferRequestBy: 0
	});
});

/*]]>*/
</script>
<div>
<?php
	if( !empty( $info ) ):
		echo $info;
	endif;
?>
<form action="<?php echo $title->getFullUrl() ?>" method="post">
<fieldset>
	<legend><strong><big>Tags management</big></strong></legend>
	<table>
	<tr>
	<td class="mw-label" style="width: 150px;">
		Tags defined for this wiki
	</td>
	<td class="mw-input">
		&nbsp;
<?php
	if( is_array( $tags ) ):
		global $wgBlankImgUrl;
		$icon_class = Wikia::isOasis() ? 'remove' /*oasis*/ : 'delete' /*monaco*/;
		$remove_icon = '<img src="'.$wgBlankImgUrl.'" class="sprite '.$icon_class.'" alt="remove" />';
		foreach( $tags as $id => $tag ):
			echo ' ' . Xml::tags('a',
				array(
					'href' => $wikiFactoryUrl . '/' .
								$wiki->city_id .  '/' .
								'findtags' . '/' .
								$tag,
					),
				"<strong>{$tag}</strong>"
				);

			echo '&nbsp;' . Xml::tags('a',
				array(
					'href' => $title->getFullUrl( array( "wpTagId" => $id, "wpTagName" => $tag ) ),
					'class' => 'wfTagRemove',
					'onclick' => 'return deletechecked()',
					'title' => 'remove ['.$tag.'] from this wiki',
					),
				$remove_icon
				);
		endforeach;
	endif;
?>
	</td>
	</tr>
	<tr>
		<td class="mw-label">
			Add new tag
		</td>
		<td class="mw-input">
			&nbsp;
			<input type="text" name="wpTag" id="wftaginput" />
			<input type="submit" name="wpAddTagSubmit" value="Add" />
		</td>
	</tr>
	</table>
</fieldset>
</form>
</div>
<!-- e:<?= __FILE__ ?> -->
