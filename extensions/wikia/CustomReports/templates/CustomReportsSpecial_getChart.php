<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?=$width?>" height="<?=$height?>" id="chart<?=$num_chart?>" >
	<param name="movie" value="<?=$swf?>" />
	<param name="FlashVars" value="&dataXML=<?=$data_xml?>">
	<param name="quality" value="high" />
	<param name="wmode" value="transparent" />
	<embed src="<?=$swf?>" flashVars="&dataXML=<?=$data_xml?>" quality="high" width="<?=$width?>" height="<?=$height?>" wmode="transparent" name="chart<?=$num_chart?>" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
