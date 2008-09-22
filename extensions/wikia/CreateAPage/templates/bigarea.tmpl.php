<!-- s:<?= __FILE__ ?> -->
<div style="display:block;" id="wpTableMultiEdit" name="wpTableMultiEdit">
<?
	$display = 'none' ;
	$id = '1' ;
	$html = "name=\"wpTextboxes".$id."\" id=\"wpTextboxes".$id."\" style=\"display:".$display."\"" ;
	$value = "<input type=\"hidden\" {$html} value=\"". "<!---blanktemplate--->" . "\">" ;
?>
<div class="display:<?=$display?>"><?=$value?></div>
<?	
	$display = 'block' ;
	$id = '0' ;
	$html = "name=\"wpTextboxes".$id."\" id=\"wpTextboxes".$id."\" style=\"display:".$display."\" class=\"bigarea\"" ;
	$value = "<textarea type=\"text\" rows=\"25\" cols=\"80\" {$html}>".$box."</textarea>" ;
	if ($toolbar != '') {
		$value = $toolbar . $value ;
	}
?>
<div class="display:<?=$display?>"><?=$value?></div>
</div>
<!-- e:<?= __FILE__ ?> -->
