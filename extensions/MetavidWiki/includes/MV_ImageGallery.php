<?php
/*
 * MV_ImageGallery.php Created on Oct 22, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 class MV_ImageGallery extends ImageGallery{
 	private $mAttribs = array();
 	private $contextTitle = false;

	private $mPerRow = 4; // How many images wide should the gallery be?
	private $mWidths = 160, $mHeights = 120; // How wide/tall each thumbnail should be
	
 	function toHTML() {
 		global $wgLang, $mvDefaultAspectRatio;

		$sk = $this->getSkin();

		$attribs = Sanitizer::mergeAttributes(
			array(
				'class' => 'gallery',
				'cellspacing' => '0',
				'cellpadding' => '0' ),
			$this->mAttribs );
		$s = Xml::openElement( 'table', $attribs );
		if( $this->mCaption )
			$s .= "\n\t<caption>{$this->mCaption}</caption>";

		$params = array( 'width' => $this->mWidths, 'height' => $this->mHeights );
		$i = 0;
		$this->already_named_resource=array();
		foreach ( $this->mImages as $pair ) {			
			$nt = $pair[0];
			$text = $pair[1];
			
			# Give extensions a chance to select the file revision for us
			$time = false;
			wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time ) );

			$img = wfFindFile( $nt, $time );
			
			
			if($nt->getNamespace() == MV_NS_MVD || 
				$nt->getNamespace() == MV_NS_STREAM || 
				$nt->getNamespace() == MV_NS_SEQUENCE ){ //@@todo fix sequence embed
				//$vpad = floor( ( 1.25*$this->mHeights - $thumb->height ) /2 ) - 2;				
				$mvTitle = new MV_Title($nt);							
				
				//remap MVD namespace links into the Stream view (so contextual metadata is present)
				if($nt->getNamespace() == MV_NS_MVD ){
					$nt = Title::MakeTitle(MV_NS_STREAM,ucfirst($mvTitle->getStreamName()).'/'.$mvTitle->getTimeRequest() );
				}					
				$vidH = round($this->mWidths*$mvDefaultAspectRatio);
				$vidRes = $this->mWidths.'x'.$vidH;
				//make sure we have the mv_embed header:
				mvfAddHTMLHeader('embed');
				//print "img url: " . 	$mvTitle->getStreamImageURL();
				$thumbhtml = "\n\t\t\t".
					'<div class="thumb" style="padding: 4px 0; width: ' .($this->mWidths+5).'px;">'
					# Auto-margin centering for block-level elements. Needed now that we have video
					# handlers since they may emit block-level elements as opposed to simple <img> tags.
					# ref http://css-discuss.incutio.com/?page=CenteringBlockElement				
					. '<div style="margin-left: auto; margin-right: auto; width: ' .$this->mWidths.'px;">' 
					. $mvTitle->getEmbedVideoHtml('', $vidRes)
					//. '<img width="'.$this->mWidths.'" src="'.$mvTitle->getStreamImageURL() . '">'
					. '</div>' .
						'<span style="clear:both"></div>'.
						//@@todo clean up link
						'<span class="gallerytext" style="float:left">'.
						$sk->makeKnownLinkObj( $nt, $mvTitle->getStreamNameText().' '. $mvTitle->getTimeDesc() ) .
						'</span>'.						
					'</div>';
					 
					$nb = '';
					$textlink='';				
						
			}else{
				
				if( $nt->getNamespace() != NS_IMAGE || !$img ) {
					# We're dealing with a non-image, spit out the name and be done with it.
					$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
						. htmlspecialchars( $nt->getText() ) . '</div>';
				} elseif( $this->mHideBadImages && wfIsBadImage( $nt->getDBkey(), $this->getContextTitle() ) ) {
					# The image is blacklisted, just show it as a text link.
					$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
						. $sk->makeKnownLinkObj( $nt, htmlspecialchars( $nt->getText() ) ) . '</div>';
				} elseif( !( $thumb = $img->transform( $params ) ) ) {
					# Error generating thumbnail.
					$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
						. htmlspecialchars( $img->getLastError() ) . '</div>';
				} else {
					$vpad = floor( ( 1.25*$this->mHeights - $thumb->height ) /2 ) - 2;
						
					$thumbhtml = "\n\t\t\t".
						'<div class="thumb" style="padding: ' . $vpad . 'px 0; width: ' .($this->mWidths+30).'px;">'
						# Auto-margin centering for block-level elements. Needed now that we have video
						# handlers since they may emit block-level elements as opposed to simple <img> tags.
						# ref http://css-discuss.incutio.com/?page=CenteringBlockElement
						. '<div style="margin-left: auto; margin-right: auto; width: ' .$this->mWidths.'px;">'
						. $thumb->toHtml( array( 'desc-link' => true ) ) . '</div></div>';
	
					// Call parser transform hook
					if ( $this->mParser && $img->getHandler() ) {
						$img->getHandler()->parserTransformHook( $this->mParser, $img );
					}
				}
	
				//TODO
				//$ul = $sk->makeLink( $wgContLang->getNsText( Namespace::getUser() ) . ":{$ut}", $ut );
	
				if( $this->mShowBytes ) {
					if( $img ) {
						$nb = wfMsgExt( 'nbytes', array( 'parsemag', 'escape'),
							$wgLang->formatNum( $img->getSize() ) );
					} else {
						$nb = wfMsgHtml( 'filemissing' );
					}
					$nb = "$nb<br />\n";
				} else {
					$nb = '';
				}
	
				$textlink = $this->mShowFilename ?
					$sk->makeKnownLinkObj( $nt, htmlspecialchars( $wgLang->truncate( $nt->getText(), 20, '...' ) ) ) . "<br />\n" :
					'' ;
			}
			# ATTENTION: The newline after <div class="gallerytext"> is needed to accommodate htmltidy which
			# in version 4.8.6 generated crackpot html in its absence, see:
			# http://bugzilla.wikimedia.org/show_bug.cgi?id=1765 -Ævar

			if ( $i % $this->mPerRow == 0 ) {
				$s .= "\n\t<tr>";
			}
			$s .=
				"\n\t\t" . '<td><div class="gallerybox" style="width: '.($this->mWidths+10).'px;">'
					. $thumbhtml
					. "\n\t\t\t" . '<div class="gallerytext">' . "\n"
						. $textlink . $text . $nb
					. "\n\t\t\t</div>"
				. "\n\t\t</div></td>";
			if ( $i % $this->mPerRow == $this->mPerRow - 1 ) {
				$s .= "\n\t</tr>";
			}
			++$i;
		}
		if( $i % $this->mPerRow != 0 ) {
			$s .= "\n\t</tr>";
		}
		$s .= "\n</table>";

		return $s;
	}
 }
?>
