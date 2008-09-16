<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/
#wpTextbox1 {
	display: none;
}
/*]]>*/
</style>
<div style="display:block;" id="wpTableMultiEdit" name="wpTableMultiEdit">
<?php
foreach ($boxes as $id => $box) {
?>
<?	
	$display = (empty($box['display'])) ? 'none' : 'block';
	$id = trim($id);
	$html = "name=\"wpTextboxes".$id."\" id=\"wpTextboxes".$id."\" style=\"display:".$display."\"";
	$value = "";
	switch ($box['type']) {
		case "text":  {
			$value = "<input type=\"text\" size=\"50\" {$html} value=\"".$box['value']."\">";
			break;
		}
		case "hidden" : {
			$value = "<input type=\"hidden\" {$html} value=\"".$box['value']."\">";
			break;
		}
                case "textarea": {
                        $linenum = count( explode( "\n", $box['value'] ) ) + 1;
                        $linenum = ($linenum > 8) ? 8 : $linenum;
                        $value = "<textarea type=\"text\" rows=\"5\" cols=\"{$cols}\" {$html}>".$box['value']."</textarea>";
			if ($box ['toolbar'] != '') {
				$value = $box ['toolbar'] . $value ;
				$value .= "<a href=\"#\" id=\"wpTextIncrease" . $id . "\" class=\"createpage-controller\">+</a><br/>" ;
                        	$value .= "<a href=\"#\" id=\"wpTextDecrease" . $id . "\" class=\"createpage-controller\">-</a>" ;
			}
                        break;
                }
		default: {
			$value = $box['value'];
		}
	}
?>
<div class="display:<?=$display?>"><?=$value?></div>
<?
}
?>
</div>
<!-- e:<?= __FILE__ ?> -->
