<!-- s:<?= __FILE__ ?> -->
<fieldset id="cp-infobox-fieldset">
<legend><?=$infobox_legend?></legend>
<div id="cp-infobox" style="display: block;">
<input type="hidden" id="wpInfoboxValue" name="wpInfoboxValue" value="<?= htmlspecialchars ($infoboxes[0][0]) ?>" />
<?
$inf_par_num = 0 ;
$inf_image_num = 0 ;
#---
foreach ($inf_pars as $inf_par) 
{
	$inf_par_pair = preg_split ("/=/", $inf_par, -1) ;
	if (is_array ($inf_par_pair)) 
	{
		if (preg_match(MULTIEDIT_IMAGEUPLOAD_TAG_SPECIFIC, $inf_par_pair[1], $match)) 
		{
			continue;
		} 
		elseif (preg_match(htmlspecialchars(MULTIEDIT_IMAGEUPLOAD_TAG_SPECIFIC), $inf_par_pair[1], $match))
		{
			continue;
		}
		else 
		{
?>			
<label for="wpInfoboxPar<?=$inf_par_num?>" class="normal-label"><?=$inf_par_pair[0]?></label><input type="text" id="wpInfoboxPar<?=$inf_par_num?>" name="wpInfoboxPar<?=$inf_par_num?>" value="<?= htmlspecialchars (trim($inf_par_pair[1])) ?>" class="normal-input" /><br/>
<?
		}
		$inf_par_num++ ;
	}
}
?>
</div>
</fieldset>
<!-- e:<?= __FILE__ ?> -->

