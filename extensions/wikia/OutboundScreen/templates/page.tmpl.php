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

			#exitPageAd1 {
				text-align: center;
				padding: 5px;
			}

			#exitPageAd2 {
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
		<?= $athenaInitStuff; ?>
		<div>
			<div id="pageTop" class="color1"><a href="<?= htmlspecialchars($url); ?>" id="exitLink" rel="nofollow"><?=($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a></div>
			<?=$adSlots['INVISIBLE'];?>
			<div id="exitPageAd1">
				<?=$adSlots['BOXAD_1'];?>
			</div>
			<div id="exitPageAd2">
				<?=$adSlots['BOXAD_2'];?>
			</div>
		</div>
	</body>
</html>
