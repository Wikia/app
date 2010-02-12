<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
<?php // TODO: DO WE NEDED THIS STYLE HERE ANYMORE?  MOST OF IT (not the body{} code) CAN BE MERGED WITH Interstitials.css IF IT IS NEEDED AT ALL, BUT THIS STYLE MIGHT COMPLETELY GO AWAY. ?>
			body {
				margin: 0;
				padding: 0;
			}
			#pageTop {
<?php /*		background-image: url('<?php print $imagesPath?>/wikia_logo_tiny.png'); */ ?>
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
<?php
	// TODO: MERGE THIS STUFF WHEN WE COMBINE TO A SINGLE TEMPLATE
	/*
		<?php print $athenaInitStuff; ?>
		<div>
			<div id="pageTop" class="color1"><a href="<?php print $url ?>" id="exitLink" rel="nofollow"><?php print ($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a>&nbsp;<?php print wfMsgForContent('outbound-screen-login-text', array( $userloginTitle->getFullUrl('type=signup'), $userloginTitle->getFullUrl() ) );?></div>
			<?php print $adLayout;?>
		</div>
	*/
?>
		<div id="wikia_header" class="color2">
			<div class="monaco_shinkwrap">
				<div id="wikiaBranding">
					<div id="wikia_logo">Wikia</div>
				</div>
			</div>
		</div>
		<div id='background_strip'>
			&nbsp;
		</div>
		<div id="wikia_page">
			<div class='interstitial_fg_top color1' id="page_bar">
				<a href = "<?php print $url; ?>" class='wikia_button'><span><?php
					print $skip
				?></span></a>
			</div>
			<div class='interstitial_fg_body'>
				<?php print $code ?>
			</div>
		</div>
	</body>
</html>
