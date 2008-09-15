<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 */
$wgExtensionFunctions[] = 'wfVideoGallery';

function wfVideoGallery() {
	global $wgParser;
	$wgParser->setHook('videogallery', 'wfRenderVideoGallery');
}

function wfRenderVideoGallery($input, $argv, &$parser){
	global $wgTitle;
	$vg = new VideoGallery();
	$vg->setContextTitle( $wgTitle->mTitle );
	$vg->setShowFilename( true );
	$vg->setParsing();

	if( isset( $argv['perrow'] ) ) {
		$vg->setPerRow( $argv['perrow'] );
	}
	if( isset( $params['widths'] ) ) {
		$vg->setWidths( $argv['widths'] );
	}
	if( isset( $params['heights'] ) ) {
		$vg->setHeights( $argv['heights'] );
	}
	$lines = explode( "\n", $input );
	foreach ( $lines as $line ) {
		# match lines like these:
		# Image:someimage.jpg|This is some image
		 
		
		$matches = array();
		preg_match( "/^([^|]+)(\\|(.*))?$/", $line, $matches );
		# Skip empty lines
		if ( count( $matches ) == 0 ) {
			continue;
		}
		 
		$tp = Title::newFromText( $matches[1] );
		$nt =& $tp;
		if( is_null( $nt ) ) {
			# Bogus title. Ignore these so we don't bomb out later.
			continue;
		}
		if ( isset( $matches[3] ) ) {
			$label = $matches[3];
		} else {
			$label = '';
		}

		/*
		$pout = $this->parse( $label,
			$this->mTitle,
			$this->mOptions,
			false, // Strip whitespace...?
			false  // Don't clear state!
		);
		$html = $pout->getText();
		*/
		 
		$vg->add( new Video( $nt ), $html );

	}
	return $vg->toHTML();
}
/**
 * Image gallery
 *
 * Add images to the gallery using add(), then render that list to HTML using toHTML().
 *
 */
class VideoGallery
{
	var $mVideos, $mShowFilename;
	var $mSkin = false;

	/**
	 * Is the gallery on a wiki page (i.e. not a special page)
	 */
	var $mParsing;


	private $mPerRow = 3; // How many images wide should the gallery be?
	private $mWidths = 200, $mHeights = 200; // How wide/tall each thumbnail should be

	/**
	 * Create a new image gallery object.
	 */
	function __construct( ) {
		$this->mVideos = array();
		$this->mShowFilename = true;
		$this->mParsing = false;
	}

	/**
	 * Set the "parse" bit so we know to hide "bad" images
	 */
	function setParsing( $val = true ) {
		$this->mParsing = $val;
	}

	/**
	 * Set the caption (as plain text)
	 *
	 * @param $caption Caption
	 */
	function setCaption( $caption ) {
		$this->mCaption = htmlspecialchars( $caption );
	}

	/**
	 * Set the caption (as HTML)
	 *
	 * @param $caption Caption
	 */
	public function setCaptionHtml( $caption ) {
		$this->mCaption = $caption;
	}

	/**
	 * Set how many images will be displayed per row.
	 *
	 * @param int $num > 0; invalid numbers will be rejected
	 */
	public function setPerRow( $num ) {
		if ($num > 0) {
			$this->mPerRow = (int)$num;
		}
	}

	/**
	 * Set how wide each image will be, in pixels.
	 *
	 * @param int $num > 0; invalid numbers will be ignored
	 */
	public function setWidths( $num ) {
		if ($num > 0) {
			$this->mWidths = (int)$num;
		}
	}

	/**
	 * Set how high each image will be, in pixels.
	 *
	 * @param int $num > 0; invalid numbers will be ignored
	 */
	public function setHeights( $num ) {
		if ($num > 0) {
			$this->mHeights = (int)$num;
		}
	}

	/**
	 * Instruct the class to use a specific skin for rendering
	 *
	 * @param $skin Skin object
	 */
	function useSkin( $skin ) {
		$this->mSkin = $skin;
	}

	/**
	 * Return the skin that should be used
	 *
	 * @return Skin object
	 */
	function getSkin() {
		if( !$this->mSkin ) {
			global $wgUser;
			$skin = $wgUser->getSkin();
		} else {
			$skin = $this->mSkin;
		}
		return $skin;
	}

	/**
	 * Add an video to the gallery.
	 *
	 * @param $video Video object that is added to the gallery
	 * @param $html  String: additional HTML text to be shown. The name and size of the image are always shown.
	 */
	function add( $video, $html='' ) {
		$this->mVideos[] = array( &$video, $html );
		wfDebug( "VideoGallery::add " . $video->getName() . "\n" );
	}

	/**
 	* Add an image at the beginning of the gallery.
 	*
 	* @param $image Image object that is added to the gallery
 	* @param $html  String:  Additional HTML text to be shown. The name and size of the image are always shown.
 	*/
	function insert( $video, $html='' ) {
		array_unshift( $this->mVideos, array( &$video, $html ) );
	}


	/**
	 * isEmpty() returns true if the gallery contains no images
	 */
	function isEmpty() {
		return empty( $this->mVideos );
	}

	/**
	 * Enable/Disable showing of the filename of an image in the gallery.
	 * Enabled by default.
	 *
	 * @param $f Boolean: set to false to disable.
	 */
	function setShowFilename( $f ) {
		$this->mShowFilename = ( $f == true);
	}

	/**
	 * Return a HTML representation of the image gallery
	 *
	 * For each image in the gallery, display
	 * - a thumbnail
	 * - the image name
	 * - the additional text provided when adding the image
	 * - the size of the image
	 *
	 */
	function toHTML() {
		global $wgLang;

		$sk = $this->getSkin();
	 
		$s = '<table class="gallery" cellspacing="0" cellpadding="0">';
		if( $this->mCaption )
			$s .= "\n\t<caption>{$this->mCaption}</caption>";

		$i = 0;
		foreach ( $this->mVideos as $pair ) {
			$video =& $pair[0];
			$text = $pair[1];

			$nt = $video->getTitle();

			if( $nt->getNamespace() != NS_VIDEO ) {
				# We're dealing with a non-image, spit out the name and be done with it.
				$thumbhtml = "\n\t\t\t".'<div style="height: '.($this->mHeights*1.25+2).'px;">'
					. htmlspecialchars( $nt->getText() ) . '</div>';
 			} else {
				$video->setWidth($this->mWidths);
				$video->setHeight($this->mHeights);
				$vpad = floor( ( 1.25*$this->mHeights - $this->mWidths ) /2 ) - 2;
				$thumbhtml = "\n\t\t\t".'<div class="thumb" style="padding: ' . $vpad . 'px 0; width: '.($this->mWidths+30).'px;">'
					. $video->getEmbedCode() . '</div>';
			}

			//TODO
			//$ul = $sk->makeLink( $wgContLang->getNsText( Namespace::getUser() ) . ":{$ut}", $ut );

			$nb = '';
		
			$textlink = $this->mShowFilename ?
				$sk->makeKnownLinkObj( $nt, htmlspecialchars( $wgLang->truncate( $nt->getText(), 30, '...' ) ) ) . "<br />\n" :
				'' ;

			# ATTENTION: The newline after <div class="gallerytext"> is needed to accommodate htmltidy which
			# in version 4.8.6 generated crackpot html in its absence, see:
			# http://bugzilla.wikimedia.org/show_bug.cgi?id=1765 -Ævar

			if ( $i % $this->mPerRow == 0 ) {
				$s .= "\n\t<tr>";
			}
			$s .=
				"\n\t\t" . '<td><div class="gallerybox" style="width: '.($this->mWidths*1.25).'px;">'
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

	/**
	 * @return int Number of images in the gallery
	 */
	public function count() {
		return count( $this->mVideos );
	}
	
	/**
	 * Set the contextual title
	 *
	 * @param Title $title Contextual title
	 */
	public function setContextTitle( $title ) {
		$this->contextTitle = $title;
	}
	
	/**
	 * Get the contextual title, if applicable
	 *
	 * @return mixed Title or false
	 */
	public function getContextTitle() {
		return is_object( $this->contextTitle ) && $this->contextTitle instanceof Title
				? $this->contextTitle
				: false;
	}

} //class
?>
