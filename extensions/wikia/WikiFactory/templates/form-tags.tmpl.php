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
<h2>Tags</h2>
<div>
<?php
	if( !empty( $info ) ):
		echo $info;
	endif;
?>
<form action="<?php echo $title->getFullUrl() ?>" method="post">
<fieldset>
	<legend>Tags management  </legend>
	<table>
	<tr>
	<td class="mw-label">
		Tags defined for this wiki
	</td>
	<td class="mw-input">
		&nbsp;
<?php
	if( is_array( $tags ) ):
		foreach( $tags as $id => $tag ):
			echo " <strong>{$tag}</strong><sup><a href=\"";
			echo $title->getFullUrl( array( "wpTagId" => $id, "wpTagName" => $tag ) );
			echo "\" class=\"wfTagRemove\" onclick=\"return deletechecked()\" >remove</a></sup> ";
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
			<input type="submit" value="Add" />
		</td>
	</tr>
	</table>
</fieldset>
</form
</div>
<!-- e:<?= __FILE__ ?> -->
