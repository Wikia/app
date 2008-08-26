<?php

/**
 * User image gallery generator
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

class UserImagesGallery {

	/**
	 * Parent parser
	 */
	private $parser = NULL;

	/**
	 * User object representing the queried user
	 */
	private $user = NULL;

	/**
	 * Custom caption for output
	 */
	private $caption = '';

	/**
	 * Maximum number of images to show
	 */
	private $limit = 10;

	/**
	 * Constructor
	 *
	 * @param $args Tag arguments
	 * @param $parser Parent parser
	 */
	public function __construct( $args, &$parser ) {
		$this->parser =& $parser;
		$this->loadOptions( $args );
		$this->setUser( $args );
	}

	/**
	 * Load options from the tag arguments
	 *
	 * @param $options Tag arguments
	 */
	private function loadOptions( $options ) {
		if( isset( $options['caption'] ) )
			$this->title = $options['caption'];
		if( isset( $options['limit'] ) )
			$this->limit = min( $options['limit'], 50 );
	}

	/**
	 * Initialise the user object, if possible
	 *
	 * @param $options Tag arguments
	 */
	private function setUser( $options ) {
		if( isset( $options['user'] ) ) {
			$this->user = User::newFromName( $options['user'] );
		}
	}

	/**
	 * Obtain an HTML image gallery to output, or else an error message
	 *
	 * @return string
	 */
	public function render() {
		wfLoadExtensionMessages( 'UserImages' );
		if( is_object( $this->user ) ) {
			$this->user->load();
			if( $this->user->getId() > 0 ) {
				$images = $this->getImages();
				if( count( $images ) > 0 ) {
					$gallery = new ImageGallery();
					#$gallery->setParsing( true ); # Fixme (?) undefined method ImageGallery::setParsing
					$gallery->setCaption( $this->getCaption() );
					$gallery->useSkin( $this->parser->getOptions()->getSkin() );
					foreach( $images as $image ) {
						$title = Title::makeTitleSafe( NS_IMAGE, $image->img_name );
						$gallery->add( $title );
					}
					return $gallery->toHtml();
				} else {
					return '<p>' . wfMsgForContent( 'userimages-noimages', $this->user->getName() ) . '</p>';
				}
			} else {
				return '<p>' . wfMsgForContent( 'nosuchusershort', $this->user->getName() ) . '</p>';
			}
		} else {
			return '<p>' . wfMsgForContent( 'userimages-noname' ) . '</p>';
		}
	}

	/**
	 * Retrieve the last X uploads from the queried user, respecting the limit
	 *
	 * @return array
	 */
	private function getImages() {
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'image', '*', array( 'img_user' => $this->user->getId() ), __METHOD__, array( 'ORDER BY' => 'img_timestamp', 'LIMIT' => $this->limit ) );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$images = array();
			while( $row = $dbr->fetchObject( $res ) )
				$images[] = $row;
			$dbr->freeResult( $res );
			return $images;
		} else {
			return array();
		}
	}

	/**
	 * Return the caption that should be used for output
	 *
	 * @return string
	 */
	private function getCaption() {
		return $this->caption ? $this->caption : wfMsgForContent( 'userimages-caption', $this->user->getName() );
	}
}
