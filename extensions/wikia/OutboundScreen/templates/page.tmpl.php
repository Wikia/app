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
				background-image: url('<?php print $imagesPath?>/wikia_logo_tiny.png');
				background-repeat: no-repeat;
				background-position: 5px 50%;
				padding: 5px;
				text-align: center;
			}

			#exitLink {
				text-decoration: none;
				font-size: 12px;
				font-family: Verdana, Arial, sans-serif;
			}
		</style>
		<?php print $css ?>

		<script type="text/javascript">/*<![CDATA[*/
			function doRedirect() {
				window.location = <?php print Xml::encodeJSvar( htmlspecialchars_decode( $url ) ); ?>;
			}
		/*]]>*/</script>
	</head>
	<body class="color2"<?php if($redirectDelay > 0): ?> onLoad="setTimeout(doRedirect, <?php print ($redirectDelay * 1000);?>)"<?php endif?>>
		<?php print $athenaInitStuff; ?>
		<div>
			<div id="pageTop" class="color1"><a href="<?php print $url ?>" id="exitLink" rel="nofollow"><?php print ($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a>&nbsp;<?php print wfMsgForContent('outbound-screen-login-text', array( $userloginTitle->getFullUrl('type=signup'), $userloginTitle->getFullUrl() ) );?></div>
			<?php print $adLayout;?>
		</div>
	</body>
</html>
