<section class="HuluVideoPanelModule" style="position: relative;" >

<div id="huluPanel" panelpartner="<?= $partnerId ?>" panelLayout="vertical" panelItems="2" panelShow="<?= $wgHuluVideoPanelShow ?>" panelAllowMature="false" 
     panelAutoPlay="true" panelsortdefault="recentlyAdded" panelSearchEnabled="false" panelSortEnabled="true" panelScaleX="1.1" panelScaleY="1.1"
<?php
if (is_array($wgHuluVideoPanelAttributes)) {
	$implodedAttribs = array_map(create_function('$key, $value', 'return $key."=\"".$value."\" ";'), array_keys($wgHuluVideoPanelAttributes), array_values($wgHuluVideoPanelAttributes));
	echo implode($implodedAttribs);
}
?>
></div>
<!--	
<div id="huluPanel" panelpartner="Wikia" panelLayout="vertical" panelItems="2" panelShow="pretty-little-liars" panelAllowMature="false" 
	panelAutoPlay="true" panelsortdefault="recentlyAdded" panelBackgroundColor="#F1F5F7" panelBorderColor="#8FB3CD" panelElementBackgroundColor="#C8DBE1" 
	panelElementBackgroundHoverColor="#3B5B7A" panelElementBorderColor="#A0BFD7" panelElementColor="#3B5B7A" panelElementHoverColor="#93C7EC" 
	panelRolloverBackgroundColor="#F7FAFB" panelTextColor="#25435F" panelSearchEnabled="false" panelSortEnabled="true" panelScaleX="1.1" panelScaleY="1.1"></div>
-->	
<div id="huluPlayer" PlayerMode="fixed" PlayerScale="1.10" style="position: absolute; top: 0; left: -620px" ></div>

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