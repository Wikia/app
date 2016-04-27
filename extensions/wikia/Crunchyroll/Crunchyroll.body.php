<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class Crunchyroll extends SpecialPage {

	var $playerWidth = 635;
	var $playerHeight = 450;
	var $playerRelatedNo = 12;

	var $episodeId = 0;
	var $serieId = 0;
	var $page = 1;


	public function __construct() {
		parent::__construct( "Crunchyroll" , '' /*restriction*/);
	}

	/**
	 * showRandomVideo - displays Special:RelatedVideo with random Video.
	 * Content of the video depends on categories selected in $wgRelatedVideoCategories
	 * Doesn't show related videos gallery below.
	 *
	 * @return void
	 */

	public function execute( $param = '' ) {

		$wgSupressPageSubtitle = true;

		$params = explode( '/', $param );
		$this->episodeId = ( isset( $params[ 2 ] ) ) ? (int)$params[ 2 ]: 0;
		$this->serieId = ( isset( $params[ 1 ] ) ) ? (int)$params[ 1 ]: 0;
		$this->page = ( isset( $params[ 0 ] ) ) ? (int)$params[ 0 ]: 1;

		$this->showSerie();
	}

	protected function getPlayer(){

		global $wgOut;

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/Crunchyroll/css/Crunchyroll.scss'));
		if ( ( $this->episodeId ) > 0 && ( !empty( $this->serieId ) ) ){

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
				array(
				    'episodeId'	=> $this->episodeId
				)
			);
			return $oTmpl->render( "CrunchyrollPlayer" );
		} else {
			return '';
		}
	}

	protected function showSerie(){

		global $wgOut;

		$Video = new CrunchyrollVideo();
		$Video->setSerieId( $this->serieId );
		$gallery = $Video->getPaginatedGallery( $this->page );

		$wgOut->addHTML( '<h1>'.$Video->title.'</h1>' );
		$wgOut->addHTML( $this->getPlayer() );
		$wgOut->addHTML( $gallery ) ;
	}
}

\Wikia\Logger\WikiaLogger::instance()->warning( 'Crunchyroll extension in use' );
