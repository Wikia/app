<section id="HuluVideoPanel" class="HuluVideoPanel">

<div class="containerHPlayer">
	<div id="huluPlayer" class="huluPlayer" PlayerMode="fixed-open" PlayerScale="1.20"></div>
</div>
<div class="containerHPanel">
	<div id="huluPanel" class="huluPanel" panelpartner="<?= $partnerId ?>" panelLayout="horizontal" panelItems="4" panelShow="<?= $panelShow ?>" panelAllowMature="false" 
	     panelAutoPlay="true" panelsortdefault="recentlyAdded" panelSearchEnabled="true" panelSortEnabled="true" panelScaleX="1.0" panelScaleY="1.0"
<?php
if (is_array($panelAttributes)) {
	$implodedAttribs = array_map(create_function('$key, $value', 'return $key."=\"".$value."\" ";'), array_keys($panelAttributes), array_values($panelAttributes));
	echo implode($implodedAttribs);
}
?>
	></div>
</div>

<script type="text/javascript">
	wgAfterContentAndJS.push(function() {
		var fileref=document.createElement('script');
		fileref.type = "text/javascript";
		fileref.id = "HULU_VP_JS";
		fileref.src = "http://player.hulu.com/videopanel/js/huluVideoPanel.js?partner=<?= $partnerId ?>";
		document.getElementsByTagName("head")[0].appendChild(fileref);	
	});
</script>

</section>