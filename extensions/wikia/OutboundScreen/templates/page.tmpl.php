<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}
			#pageTop {
				background-image: url('<?=$imagesPath?>/wikia_logo_tiny.png');
				background-repeat: no-repeat;
				background-position: 5px 50%;
				padding: 5px;
				text-align: center;
			}

			#exitLink {
				color: white;
				text-decoration: none;
				font-size: 12px;
				font-family: Verdana, Arial, sans-serif;
			}

			#exitPageAd {
				text-align: center;
				padding: 5px;
			}
		</style>
		<?= $css ?>

		<script type="text/javascript">/*<![CDATA[*/
			function doRedirect() {
				window.location = <?= Xml::encodeJSvar($url) ?>;
			}
		/*]]>*/</script>
	</head>
	<body class="color2"<?php if($redirectDelay > 0): ?> onLoad="setTimeout(doRedirect, <?=($redirectDelay * 1000);?>)"<?php endif?>>
		<div>
			<div id="pageTop" class="color1"><a href="<?= htmlspecialchars($url); ?>" id="exitLink" rel="nofollow"><?=($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a></div>
			<div id="exitPageAd">
				<script type="text/javascript">/*<![CDATA[*/
					google_ad_client = "pub-4086838842346968";
					/* Exit page ad */
					google_ad_slot = "0549965769";
					google_ad_width = 336;
					google_ad_height = 280;
					google_page_url = "http://gamergear.wikia.com/wiki/GamerGear_Wiki";
				/*]]>*/</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
		</div>
	</body>
</html>
