<div id="jwplayer-test"></div>
<?php
global $wgExtensionsPath;
?>
<script src="<?= $wgExtensionsPath; ?>/wikia/jwplayer/jwplayer-7.12.4/jwplayer.js"></script>
<script>jwplayer.key="NWuTYrWkPDZefl67ijlzIXP9h3hnI4G+DalcxnMSvB81+dNKBc8OL82WQdo=";</script>
<script>
	var jwConfig = {
		"aspectratio": "16:9",
		"autostart": true,
		"controls": true,
		"displaydescription": false,
		"displaytitle": true,
		"flashplayer": "//ssl.p.jwpcdn.com/player/v/7.12.4/jwplayer.flash.swf",
		"height": 270,
		"key": "LnGt0Cic9n2ep7kMTjxOvAVQiPHdbJmxuNXwKnzrSisl/RfFohg0Rx6EvHs=",
		"mute": true,
		"ph": 3,
		"pid": "TAUVjJL5",
		"playlist": [
			{
				"description": "",
				"duration": 253,
				"image": "//content.jwplatform.com/thumbs/FYykS9se-720.jpg",
				"link": "//content.jwplatform.com/previews/FYykS9se",
				"mediaid": "FYykS9se",
				"pubdate": "Thu, 20 Jul 2017 10:50:43 -0000",
				"recommendations": "//content.jwplatform.com/feed.json?related_media_id=FYykS9se&feed_id=Y2RWCKuS",
				"sources": [
					{
						"file": "//content.jwplatform.com/manifests/FYykS9se.m3u8",
						"type": "hls"
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-TI0yeHZW.mp4",
						"height": 180,
						"label": "180p",
						"type": "video/mp4",
						"width": 320
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-DnzUC89Y.mp4",
						"height": 270,
						"label": "270p",
						"type": "video/mp4",
						"width": 480
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-xhZUqUI6.mp4",
						"height": 406,
						"label": "406p",
						"type": "video/mp4",
						"width": 720
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-1lt3rSsE.mp4",
						"height": 720,
						"label": "720p",
						"type": "video/mp4",
						"width": 1280
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-LiJWxqIn.m4a",
						"height": -1,
						"label": "AAC Audio",
						"type": "audio/mp4",
						"width": -1
					},
					{
						"duration": 253,
						"file": "//content.jwplatform.com/videos/FYykS9se-cSpmBcaY.mp4",
						"height": 1080,
						"label": "1080p",
						"type": "video/mp4",
						"width": 1920
					}
				],
				"tags": "",
				"title": "121316_RogueOne_Crash Course_FINAL",
				"tracks": [
					{
						"file": "//content.jwplatform.com/strips/FYykS9se-120.vtt",
						"kind": "thumbnails"
					}
				]
			}
		],
		"plugins": {
			"http://assets-jpcust.jwpsrv.com/player/6/6124956/ping.js": {
				"pixel": "http://content.jwplatform.com/ping.gif"
			}
		},
		"preload": "auto",
		"primary": "html5",
		"related": {
			"autoplaytimer": 10,
			"file": "http://content.jwplatform.com/feed.json?feed_id=Y2RWCKuS&related_media_id=FYykS9se",
			"onclick": "play",
			"oncomplete": "autoplay"
		},
		"repeat": false,
		"sharing": {
			"link": "http://content.jwplatform.com/previews/MEDIAID-TAUVjJL5",
			"sites": [
				"facebook",
				"twitter",
				"email"
			]
		},
		"stagevideo": false,
		"stretching": "uniform",
		"width": "100%"
	};

	jwplayer('jwplayer-test').setup(jwConfig);
</script>
