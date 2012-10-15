<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}
?>
<!-- s:<?php echo __FILE__ ?> -->
<div style="display:block;" id="wpTableMultiEdit" name="wpTableMultiEdit">
<?php
	$display = 'none';
	$id = '1';
	$html = 'name="wpTextboxes' . $id . '" id="wpTextboxes' . $id . '" style="display:' . $display . '"';
	$value = "<input type=\"hidden\" {$html} value=\"" . "<!---blanktemplate--->" . '">';
?>
<div class="display:<?php echo $display ?>"><?php echo $value ?></div>
<?php
	$display = 'block';
	$id = '0';
	$html = 'name="wpTextboxes' . $id . '" id="wpTextboxes' . $id . '" style="display:' . $display . '" class="bigarea"';
	$value = "<textarea type=\"text\" rows=\"25\" cols=\"80\" {$html}>" . $box . '</textarea>';
	if ( $toolbar != '' ) {
		$value = $toolbar . $value;
	}
?>
<div class="display:<?php echo $display ?>"><?php echo $value ?></div>
</div>
<!-- e:<?php echo __FILE__ ?> -->
