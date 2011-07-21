var spongecell = spongecell || {};
spongecell.adTag = {
	objectHTML: function() {
		var html = this.flashHTML
		html = html.replace(/%flashvars%/g, this.flashvars());
		html = html.replace(/%widget_resource_host%/g, this.resourceHostDefault);
		return html;
	},
	flashData: function() {
		var encodes = [];
		for (var key in (this.params().flashData || {})) {
			encodes.push({
				key: key,
				value: this.params().flashData[key]
			});
		}
		return encodes;
	},
	writeImpressionPixel: function(){ 
		return "Impression pixel"
	}
	,writeTrackingPixel: function(){ 
		return "tracking pixel"
	}
	,flashvars: function() {
	}
};
spongecell.adTag.flashHTML = [
"<div style=\"text-align:center; width: 300px; height: 250px; display:inline;\">",
"  <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" height=\"250\" id=\"spongecellWidget265723\" width=\"300\">",
"    <param name=\"movie\" value=\"http://%widget_resource_host%/bloom/coupon/v4e/bin/RectangleGrid.swf\" />",
"    <param name=\"flashvars\" value=\"%flashvars%\" />",
"    <param name=\"allowScriptAccess\" value=\"always\" />",
"    <param name=\"allowNetworking\" value=\"all\" />",
"    <param name=\"allowFullScreen\" value=\"true\" />",
"    <param name=\"wmode\" value=\"opaque\" />",
"    <param name=\"quality\" value=\"high\" />",
"    <param name=\"salign\" value=\"tl\" />",
"    <param name=\"base\" value=\".\" />",
"    <!--[if !IE]>-->",
"    <object allowFullScreen=\"true\" allowNetworking=\"all\" allowScriptAccess=\"always\" base=\".\" data=\"http://%widget_resource_host%/bloom/coupon/v4e/bin/RectangleGrid.swf?%flashvars%\" height=\"250\" quality=\"high\" salign=\"tl\" type=\"application/x-shockwave-flash\" width=\"300\" wmode=\"opaque\">    </object>",
"    <!--<![endif]-->",
"  </object>",
"  <script type=\"text/javascript\">",
"  //<![CDATA[",
"  spongecell.adTag.writeImpressionPixel();",
"  //]]>",
"  </script>",
"  <script type=\"text/javascript\">",
"  //<![CDATA[",
"  spongecell.adTag.writeTrackingPixel();",
"  //]]>",
"  </script>",
"</div>",
].join("\n")
spongecell.adTag.resourceHostDefault = "cdn.statics.live.spongecell.com";
spongecell.adTag.reportBaseUrl = "http://analytics.spongecell.com/placements";
document.write(spongecell.adTag.objectHTML());

