<?php
class SkeleSkinService extends WikiaService {
	static private $initialized = false;
	
	private $templateObject;
	
	function init(){
		if ( !self::$initialized ) {
			F::setInstance( __CLASS__, $this );
			self::$initialized = true;
			$this->wf->LoadExtensionMessages( 'SkeleSkin' );
		}
	}
	
	/**
	 * @brief Sets the template object for internal use
	 * 
	 * @requestParam QuickTeamplate $templateObject
	 */
	public function setTemplateObject(){
		$this->templateObject = $this->getVal( 'templateObject' );
	}
	
	public function index() {
		$jsFiles = '';
		$tmpOut = new OutputPage();
		
		$this->setVal( 'pagetitle', htmlspecialchars( $this->wg->Out->mPagetitle ) );
		
		$tmpOut->styles = $this->wg->Out->styles;

		foreach( $tmpOut->styles as $style => $options ) {	
			if ( isset( $options['media'] ) || strstr( $style, 'shared' ) || strstr( $style, 'index' ) ) {
				unset( $tmpOut->styles[$style] );
			}
		}
			
		// render link tags
		$this->setVal( 'csslinks', $tmpOut->buildCssLinks() );
		$this->setVal( 'headlinks', $this->wg->Out->getHeadLinks());
		
		$srcs = AssetsManager::getInstance()->getGroupCommonURL('skeleskin_js');
		//TODO: add scripts from $wgOut as needed

		foreach ( $srcs as $src ) {
			$jsFiles .= "<script type=\"{$this->wg->JsMimeType}\" src=\"$src\"></script>\n";
		}
		
		$this->setVal( 'jsFiles', $jsFiles);
		$this->setVal( 'body', $this->sendRequest( 'SkeleSkinBodyService', 'index', array( 'bodyText' => $this->templateObject->data['bodytext'] ))->toString());
	}
}