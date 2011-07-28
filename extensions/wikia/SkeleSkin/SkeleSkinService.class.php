<?php
class SkeleSkinService extends WikiaService {
	
	public function index() {
		$this->setVal( 'date', date('l jS \of F Y h:i:s A') );
		global $wgOut;
		$jsFiles = '';
		$tmpOut = new OutputPage();
		
		$this->setVal( 'pagetitle', htmlspecialchars( $wgOut->mPagetitle ) );
		
		$tmpOut->styles = $wgOut->styles;

		foreach( $tmpOut->styles as $style => $options ) {	
			if ( isset( $options['media'] ) || strstr( $style, 'shared' ) || strstr( $style, 'index' ) ) {
				unset( $tmpOut->styles[$style] );
			}
		}	
		// render CSS <link> tags
		$this->setVal( 'csslinks', $tmpOut->buildCssLinks() );
		
		$srcs = AssetsManager::getInstance()->getGroupCommonURL('skeleskin_js');

		foreach($srcs as $src) {
			$jsFiles .= "<script src=\"$src\"></script>\n";
		}
		
		$this->setVal( 'jsFiles', $jsFiles);
	}
}