<section class="HuluVideoPanelModule">

<div id="huluPanel" panelpartner="<?= $partnerId ?>" panelLayout="vertical" panelItems="2" panelShow="<?= $wg->HuluVideoPanelShow ?>" panelAllowMature="false" 
     panelAutoPlay="true" panelsortdefault="recentlyAdded" panelSearchEnabled="false" panelSortEnabled="true" panelScaleX="1.1" panelScaleY="1.1"
<?php
if (is_array($wg->HuluVideoPanelAttributes)) {
	$implodedAttribs = array_map(create_function('$key, $value', 'return $key."=\"".$value."\" ";'), array_keys($wg->HuluVideoPanelAttributes), array_values($wg->HuluVideoPanelAttributes));
	echo implode($implodedAttribs);
}
?>
></div>
<div id="huluPlayer" class="huluPlayer" PlayerMode="fixed" PlayerScale="1.10" style="position: absolute;"><!-- inline style is necessary. hulu js tries to overwrite it if not included --></div>

<script type="text/javascript" id="HULU_VP_JS" src="http://player.hulu.com/videopanel/js/huluVideoPanel.js?partner=<?= $partnerId ?>"></script>

</section>