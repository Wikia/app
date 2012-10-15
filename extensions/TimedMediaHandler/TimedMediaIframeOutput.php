<?php 
/**
 * Adds iframe output ( bug 25862 ) 
 * 
 * This enables iframe based embeds of the wikimeia player with the following syntax:
 *  
 * <iframe src="http://commons.wikimedia.org/wiki/File:Folgers.ogv?embedplayer=yes"
 * 		width="240" height="180" frameborder="0" ></iframe>
 * 
 */

class TimedMediaIframeOutput {	
	/**
	 * The iframe hook check file pages embedplayer=yes
	 */
	static function iframeHook( &$title, &$article, $doOutput = true ) {
		global $wgTitle, $wgRequest, $wgOut, $wgEnableIframeEmbed;
		if( !$wgEnableIframeEmbed )
			return true; //continue normal output iframes are "off" (maybe throw a warning in the future)

		// Make sure we are in the right namespace and iframe=true was called:
		if(	is_object( $wgTitle ) && $wgTitle->getNamespace() == NS_FILE  &&
			$wgRequest->getVal('embedplayer') == 'yes' &&
			$wgEnableIframeEmbed &&
			$doOutput ){
				self::outputIframe( $title );
				// Turn off output of anything other than the iframe 
				$wgOut->disable();
		}
		
		return true;
	}
	/**
	 * Output an iframe
	 */
	static function outputIframe( $title ) {
		global $wgEnableIframeEmbed, $wgOut, $wgUser,
			$wgEnableScriptLoader;
	
		if(!$wgEnableIframeEmbed){
			throw new MWException( __METHOD__ .' is not enabled' );
		}
		
		$skin = $wgUser->getSkin();
		
		// Setup the render parm
		$file = wfFindFile( $title );	
		$params = array(
			'width' => 400
		);
		$videoTransform= $file->transform( $params );
		
		$wgOut->addModules( array( 'embedPlayerIframeStyle') );
		$wgOut->sendCacheControl();
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title->getText() ?></title>
	<?php 
		echo Html::element( 'meta', array( 'name' => 'ResourceLoaderDynamicStyles', 'content' => '' ) );
	?>
	<?php
		echo $wgOut->getHeadLinks($skin);
		echo $wgOut->getHeadItems();
	?>
	<style type="text/css">
		html, body {
		  height: 100%;
		  margin: 0;
		  padding: 0;
		  overflow:hidden;
		}
		img#bgimage {
		  position:fixed;
		  top:0;
		  left:0;
		  width:100%;
		  height:100%;
		}
	</style>
	<?php echo $wgOut->getHeadScripts( $skin ); ?>	
	<?php 
	echo Html::inlineScript(
	ResourceLoader::makeLoaderConditionalScript(
			Xml::encodeJsCall( 'mw.loader.go', array() )
		)
	);
	?>
	</head>
<body>
	<img src="<?php echo $videoTransform->getUrl() ?>" id="bgimage" ></img>
	<div id="videoContainer" style="visibility:hidden">
		<?php echo $videoTransform->toHtml(); ?>
	</div>
	<script>		
		// Set the fullscreen property inline to avoid poluting the player cache  
		mw.setConfig('EmbedPlayer.EnableFullscreen', false );
		$('#bgimage').remove(); 			
		
		mw.ready(function(){		
			var fitPlayer = function(){
				$( '#<?php echo TimedMediaTransformOutput::PLAYER_ID_PREFIX . '0' ?>' )
				.get(0).resizePlayer({
					'width' : $(window).width(),
					'height' : $(window).height()
				});
			}
			// Bind window resize to reize the player:
			$( window ).resize( fitPlayer );	  
			$('#videoContainer').css({
				'visibility':'visible'
			});
			fitPlayer(); 
		});
	</script>
</body>
</html>
	<?php
	}
	
}