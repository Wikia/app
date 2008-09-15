<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/
#wpTextbox1 {
	display: none;
}
/*]]>*/
</style>

<div id="createpage_cloud_div" style="display: none;">
<div style="font-weight: bold;"><?= wfMsg ('createpage_categories') ?></div>
<div id="createpage_cloud_section">
<?
$xnum = 0;
foreach ( $cloud->tags as $xname => $xtag ) 
{
?>
	<span id="tag<?=$xnum?>" style="font-size:<?=$xtag['size']?>pt">
	<a href="#" id="cloud<?=$xnum?>" onclick="cloudAdd(escape ('<?=$xname?>'), <?=$xnum?>); return false;"><?=$xname?></a>
	</span>
<?
$xnum++;
}
?>
</div>
<textarea accesskey="," name="wpCategoryTextarea" id="wpCategoryTextarea" rows='3' cols='<?=$cols?>'<?$ew?>><?=$text_category?></textarea>
<input type="button" name="wpCategoryButton" id="wpCategoryButton" class="button color1" value="Add Category" onclick="cloudInputAdd(); return false ;" />
<input type="text" name="wpCategoryInput" id="wpCategoryInput" value="" />
</div>
<script type="text/javascript">
/*<![CDATA[*/
var div = document.getElementById('createpage_cloud_div');
document.getElementById('createpage_cloud_div').style.display = 'block';
/*]]>*/
</script>
<noscript>
<div id="createpage_cloud_section_njs">
<?
$xnum = 0;

foreach ( $cloud->tags as $xname => $xtag ) 
{
	$checked = (array_key_exists($xname, $array_category) && ($array_category[$xname])) ? "checked" : "";
	$array_category[$xname] = 0;
	#--$xtag['size']
?>
	<span id="tag_njs_<?=$xnum?>" style="font-size:9pt">
		<input <?=$checked?> type="checkbox" name="category_<?=$xnum?>" id="category_<?=$xnum?>" value="<?=$xname?>">&nbsp;<?=$xname?>
	</span>
<?
$xnum++;
}
$display_category = array();
foreach ($array_category as $xname => $visible)
{
	if ($visible == 1)
	{
		$display_category[] = $xname;
	}
}
$text_category = implode(",", $display_category);
?>
</div>
<textarea tabindex='<?=$num?>' accesskey="," name="wpCategoryTextarea" id="wpCategoryTextarea" rows='3' cols='<?=$cols?>'<?$ew?>><?=$text_category?></textarea>
</noscript>
<!-- e:<?= __FILE__ ?> -->
