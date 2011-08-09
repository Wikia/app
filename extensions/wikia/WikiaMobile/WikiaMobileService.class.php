<?php
/**
 * WikiaMobile page
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileService extends WikiaService {
	const CACHE_MANIFEST_PATH = 'wikia.php?controller=WikiaMobileAppCacheController&method=serveManifest&format=html';
	
	static private $initialized = false;
	
	private $templateObject;
	
	function init(){
		if ( !self::$initialized ) {
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
			$this->wf->LoadExtensionMessages( 'WikiaMobile' );
		}
	}
	
	/**
	 * @brief Sets the template object for internal use
	 * 
	 * @requestParam QuickTeamplate $templateObject
	 */
	public function setTemplateObject(){
		$this->templateObject = $this->getVal( 'templateObject') ;
	}
	
	public function index() {
		$jsFiles = '';
		$cssFiles = '';
		$tmpOut = new OutputPage();
		
		$tmpOut->styles = array(  ) + $this->wg->Out->styles;

		foreach( $tmpOut->styles as $style => $options ) {	
			if ( isset( $options['media'] ) || strstr( $style, 'shared' ) || strstr( $style, 'index' ) ) {
				unset( $tmpOut->styles[$style] );
			}
		}
		
		//force skin main CSS file to be the first so it will be always overridden by other files
		$cssFiles .= "<link rel=\"stylesheet\" href=\"" . AssetsManager::getInstance()->getSassCommonURL( 'skins/wikiamobile/css/main.scss' ) . "\"/>";
		$cssFiles .= $tmpOut->buildCssLinks();
		
		$srcs = AssetsManager::getInstance()->getGroupCommonURL('wikiamobile_js');
		//TODO: add scripts from $wgOut as needed

		foreach ( $srcs as $src ) {
			$jsFiles .= "<script type=\"{$this->wg->JsMimeType}\" src=\"$src\"></script>\n";
		}
		
		$this->appCacheManifestPath = ( $this->wg->DevelEnvironment && !$this->wg->Request->getBool( 'appcache' ) ) ? null : self::CACHE_MANIFEST_PATH . "&{$this->wg->StyleVersion}";
		$this->mimeType = $this->templateObject->data['mimetype'];
		$this->charSet = $this->templateObject->data['charset'];
		$this->showAllowRobotsMetaTag = !$this->wg->DevelEnvironment;
		$this->pageTitle = $this->wg->Out->getPageTitle();
		$this->cssLinks = $cssFiles;
		$this->headLinks = $this->wg->Out->getHeadLinks();
		$this->languageCode = $this->templateObject->data['lang'];
		$this->languageDirection = $this->templateObject->data['dir'];
		$this->wikiaNavigation = $this->sendRequest( 'WikiaMobileNavigationService', 'index' )->toString();
		$this->wikiHeaderContent = $this->sendRequest( 'WikiaMobileWikiHeaderService', 'index' )->toString();
		$this->pageContent = $this->sendRequest( 'WikiaMobileBodyService', 'index', array( 'bodyText' => $this->templateObject->data['bodytext'] ))->toString();
		$this->jsFiles = $jsFiles;
	}
}