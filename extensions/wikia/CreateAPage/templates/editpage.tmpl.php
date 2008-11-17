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
<input type="hidden" id="wpOptionals" name="wpOptionals" value="">
<?php

$sections = 0;
$optionalSections = array();

foreach ($boxes as $id => $box) {
?>
<?	
	$display = (empty($box['display'])) ? 'none' : 'block';
	$id = trim($id);
	$html = "name=\"wpTextboxes".$id."\" id=\"wpTextboxes".$id."\" style=\"display:".$display."\"";
	$value = "";
	$clear = " class=\"createpage-clear\""  ;

	switch ($box['type']) {
		case 'section_display': {
			$i = $id;
			$title_found = false;
			$visible = '';
			while( $i < count( $boxes ) - 1 ) {
				$i++;
				if ( ($boxes[$i]['type'] == 'title') || ($boxes[$i]['type'] == 'optional_textarea') ) {
					$title_found = true;
					if ($boxes[$i]['type'] == 'optional_textarea') {
						$optionalSections[] = array( $sections, $box['value'] );
					}		
					break;
				}
				if ($boxes[$i]['type'] == 'section_display') {
					break;
				}	
			}			
			if ($title_found) {
				$clear = "";
			}
			$value = $box['value'];
			if ($sections > 0) {
			?>
				</div>
			<?
			}
			?>
				<div id="createpage_section_<?= $sections ?>">	
			<?
			$sections++;
			break;
		}
		case "text":  {
			$value = "<input type=\"text\" size=\"50\" {$html} value=\"".$box['value']."\">";
			break;
		}
		case "hidden" : {
			$value = "<input type=\"hidden\" {$html} value=\"".$box['value']."\">";
			break;
		}
		case "optional_textarea":
                case "textarea": {
                        $linenum = count( explode( "\n", $box['value'] ) ) + 1;
                        $linenum = ($linenum > 8) ? 8 : $linenum;
                        $value = "<textarea type=\"text\" rows=\"5\" cols=\"{$cols}\" {$html} class=\"createpage-textarea\">".$box['value']."</textarea>";
			if ($box ['toolbar'] != '') {
				$value = $box ['toolbar'] . $value ;
                        	$value .= "<a href=\"#\" id=\"wpTextDecrease" . $id . "\" class=\"createpage-controller createpage-upper\"><img src=\"" . $imgpath . "up.png\" alt=\"-\"></a>" ;
				$value .= "<a href=\"#\" id=\"wpTextIncrease" . $id . "\" class=\"createpage-controller createpage-lower\"><img src=\"" . $imgpath . "down.png\" alt=\"+\"></a>" ;
			}
                        break;
                }
		default: {
			$value = $box['value'];
		}
	}
?>
<div style="display:<?=$display?>"<?=$clear?>><?=$value?></div>
<?
}
?>
</div>
<?
if( !empty ($optionalSections) ) {
?>
	<div id="createpage_optionals"><span id="createpage_optionals_text"><?= $optional_text ?></span><br/>
	<span id="createpage_optionals_content">
<?
	$check = '';
	foreach( $optionalSections as $opt ) {
		in_array( $opt[0], $optional_sections ) ? $check = 'checked="checked"' : $check = '';
?>
	<span id="wpOptional<?= $opt[0] ?>"><input type="checkbox" id="wpOptionalInput<?= $opt[0] ?>" name="wpOptionalInput<?= $opt[0] ?>" <?= $check ?>/><span id="wpOptionalDesc<?= $opt[0] ?>"><?= $opt[1] ?></span></span>
<?
	}
?>
	</span>
	</div>
<?
}


?>




</div>
<!-- e:<?= __FILE__ ?> -->
