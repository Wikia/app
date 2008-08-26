<?php
/**
 * Special:Player, a media playback page
 *
 * @addtogroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

class SpecialPlayer extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		SpecialPage::SpecialPage( 'Player', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest;

		wfLoadExtensionMessages( 'Player' );

		$file = $wgRequest->getVal( 'playfile', $par );

		$options = $wgRequest->getVal( 'options', '' );
		$options = urldecodeMap($options);

		$options['width'] = (int)$wgRequest->getVal( 'width', @$options['width'] );
		$options['height'] = (int)$wgRequest->getVal( 'height', @$options['height']  );

		$options['forcegeneric'] = ( @$options['forcegeneric'] || $wgRequest->getCheck( 'forcegeneric' ) );
		$options['playersize'] = $wgRequest->getVal( 'playersize', @$options['playersize'] );

		$title = $file ? Title::makeTitleSafe(NS_IMAGE, $file) : NULL;

		if ( $title ) {
			$this->showPlayer( $title, $options );
		}
		else {
			$this->showForm();
		}
	}

	function showForm() {
		global $wgOut;

		$wgOut->setPagetitle( wfMsg( "player-title" ) );
		$wgOut->addWikiText( wfMsg( "player-pagetext" ) );

		$titleObj = SpecialPage::getTitleFor( "Player" );
		$action = $titleObj->getLocalURL( "action=submit" );

		$wgOut->addHTML( Xml::openElement( 'form', array('id' => 'player', 'method' => 'post', 'action' => $action) ) );
		$wgOut->addHTML( '<div>' );
		$wgOut->addHTML( Xml::inputLabel( wfMsg('player-file'), 'playfile', 'playfile' ) );
		$wgOut->addHTML( ' ' );
		$wgOut->addHTML( Xml::submitButton( wfMsg('player-play') ) );
		$wgOut->addHTML( '</div>' );
		$wgOut->addHTML( Xml::closeElement( 'form' ) );
	}

	function showPlayer( $title, $options ) {
		global $wgOut, $wgUser;
		$skin = $wgUser->getSkin();

		$wgOut->setPagetitle( wfMsg( "player-playertitle", htmlspecialchars($title->getText()) )  );
		$wgOut->addWikiText( wfMsg( "player-pagetext" ) );

		try {
			$player = Player::newFromTitle( $title, $options );
			$html = $player->getPlayerHTML( );

			$wgOut->addHTML( '<div id="player-display" style="text-align:center">' );
			$wgOut->addHTML( $html );
			$wgOut->addHTML( '</div>' );
		}
		catch (PlayerException $ex) {
			$wgOut->addHTML( "<div class='error'>" . $ex->getMessage() . "</div>" );
		}

		$wgOut->addHTML( wfMsg( 'player-imagepage-header', $skin->makeLinkObj( $title ) ) );

		if (@$player) {
			$page = new PlayerImagePage( $player->image );
			$page->view();
		}
	}
}


class PlayerImagePage extends ImagePage {
	function __construct( $image ) {
		parent::__construct( $image->getTitle() );

		$this->img = $image;
	}

	/** mostly copied from ImagePage class, removed stuff not needed for Special:Player **/
	function view() {
		global $wgOut, $wgShowEXIF, $wgRequest, $wgUser;

		if ($wgShowEXIF && $this->img->exists()) { //TODO: separate exif option for the player page?
			$exif = $this->img->getExifData();
			$showmeta = count($exif) ? true : false;
		} else {
			$exif = false;
			$showmeta = false;
		}

		//$this->openShowImage();

		# No need to display noarticletext, we use our own message, output in openShowImage()
		if ( $this->getID() ) {
			Article::view();
		} else {
			# Just need to set the right headers
			$wgOut->setArticleFlag( false );
			$wgOut->setRobotpolicy( 'noindex,nofollow' );
			$this->viewUpdates();
		}

		# Show shared description, if needed
		if ( $this->mExtraDescription ) {
			$fol = wfMsg( 'shareddescriptionfollows' );
			if( $fol != '-' ) {
				$wgOut->addWikiText( $fol );
			}
			$wgOut->addHTML( '<div id="shared-image-desc">' . $this->mExtraDescription . '</div>' );
		}

		//$this->closeShowImage();

		//TODO: make a global option for showing links & history...
		$this->imageHistory();
		$this->imageLinks();

		if ( $exif ) {
			global $wgStylePath, $wgStyleVersion;
			$expand = htmlspecialchars( wfEscapeJsString( wfMsg( 'metadata-expand' ) ) );
			$collapse = htmlspecialchars( wfEscapeJsString( wfMsg( 'metadata-collapse' ) ) );
			$wgOut->addHTML( Xml::element( 'h2', array( 'id' => 'metadata' ), wfMsg( 'metadata' ) ). "\n" );
			$wgOut->addWikiText( $this->makeMetadataTable( $exif ) );
			$wgOut->addHTML(
				"<script type=\"text/javascript\" src=\"$wgStylePath/common/metadata.js?$wgStyleVersion\"></script>\n" .
				"<script type=\"text/javascript\">attachMetadataToggle('mw_metadata', '$expand', '$collapse');</script>\n" );
		}
	}
}
