<?php

/**
 * Static class with methods to create and handle the push tab.
 *
 * @since 0.1
 *
 * @file Push_Tab.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class PushTab {
	
	/**
	 * Adds an "action" (i.e., a tab) to allow pushing the current article.
	 */
	public static function displayTab( $obj, &$content_actions ) {
		global $wgUser, $egPushTargets;
		
		// Make sure that this is not a special page, the page has contents, and the user can push.
		$title = $obj->getTitle();
		if (
			$title->getNamespace() != NS_SPECIAL
			&& $title->exists()
			&& $wgUser->isAllowed( 'push' )
			&& count( $egPushTargets ) > 0 ) {
				
			global $wgRequest;
			
			$content_actions['push'] = array(
				'text' => wfMsg( 'push-tab-text' ),
				'class' => $wgRequest->getVal( 'action' ) == 'push' ? 'selected' : '',
				'href' => $title->getLocalURL( 'action=push' )
			);
		}
		
		return true;
	}

	/**
	 * Function currently called only for the 'Vector' skin, added in
	 * MW 1.16 - will possibly be called for additional skins later
	 */
	public static function displayTab2( $obj, &$links ) {
		global $egPushShowTab;
		
		// The old '$content_actions' array is thankfully just a sub-array of this one
		$views_links = $links[$egPushShowTab ? 'views' : 'actions'];
		self::displayTab( $obj, $views_links );
		$links[$egPushShowTab ? 'views' : 'actions'] = $views_links;
		
		return true;
	}

	/**
	 * Handle actions not known to MediaWiki. If the action is push,
	 * display the push page by calling the displayPushPage method.
	 *  
	 * @param string $action
	 * @param Article $article
	 * 
	 * @return true
	 */
	public static function onUnknownAction( $action, Article $article ) {
		if ( $action == 'push' ) {
			return self::displayPushPage( $article );
		}
		else {
			return true;
		}
	}
	
	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 * 
	 * @since 0.1
	 */
	protected static function loadJs() {
		global $wgOut;
		
		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $wgOut, 'addModules' ) ) ) {
			$wgOut->addModules( 'ext.push.tab' );
		}
		else {
			global $egPushScriptPath;
			
			PushFunctions::addJSLocalisation();
			
			$wgOut->includeJQuery();
			
			$wgOut->addHeadItem(
				'ext.push.tab',
				Html::linkedScript( $egPushScriptPath . '/includes/ext.push.tab.js' )
			);
		}		
	}
	
	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages)
	 * 
	 * @since 0.1
	 */
	public static function displayPushPage( Article $article ) {
		global $wgOut, $wgUser, $wgTitle, $wgSitename, $egPushTargets;
		
		$wgOut->setPageTitle( wfMsgExt( 'push-tab-title', 'parsemag', $article->getTitle()->getText() ) );
		
		if ( !$wgUser->isAllowed( 'push' ) ) {
			$wgOut->permissionRequired( 'push' );
			return false;
		}		
		
		$wgOut->addHTML( '<p>' . htmlspecialchars( wfMsg( 'push-tab-desc'  ) ) . '</p>' );
		
		if ( count( $egPushTargets ) == 0 ) {
			$wgOut->addHTML( '<p>' . htmlspecialchars( wfMsg( 'push-tab-no-targets'  ) ) . '</p>' );
			return false;
		}
		
		self::loadJs();
		
		$wgOut->addHTML(
			Html::hidden( 'pageName', $wgTitle->getFullText(), array( 'id' => 'pageName' ) ) .
			Html::hidden( 'siteName', $wgSitename, array( 'id' => 'siteName' ) )
		);
		
		self::displayPushList();
		
		self::displayPushOptions();
		
		return false;
	}
	
	/**
	 * Displays a list with all targets to which can be pushed.
	 * 
	 * @since 0.1
	 */
	protected static function displayPushList() {
		global $wgOut, $egPushTargets, $wgLang;
		
		$items = array(
			Html::rawElement(
				'tr',
				array(),
				Html::element(
					'th',
					array( 'width' => '200px' ),
					wfMsg( 'push-targets' )
				) .
				Html::element(
					'th',
					array( 'style' => 'min-width:400px;' ),
					wfMsg( 'push-remote-pages' )
				) .
				Html::element(
					'th',
					array( 'width' => '125px' ),
					''
				)
			)
		);
		
		foreach ( $egPushTargets as $name => $url ) {
			$items[] = self::getPushItem( $name, $url );
		}
		
		// If there is more then one item, display the 'push all' row.
		if ( count( $egPushTargets ) > 1 ) {
			$items[] = Html::rawElement(
				'tr',
				array(),
				Html::element(
					'th',
					array( 'colspan' => 2, 'style' => 'text-align: left' ),
					wfMsgExt( 'push-targets-total', 'parsemag', $wgLang->formatNum( count( $egPushTargets ) ) )
				) .
				Html::rawElement(
					'th',
					array( 'width' => '125px' ),
					Html::element(
						'button',
						array(
							'id' => 'push-all-button',
							'style' => 'width: 125px; height: 30px',
						),
						wfMsg( 'push-button-all' )
					)				
				)
			);			
		}
		
		$wgOut->addHtml(
			Html::rawElement(
				'table',
				array( 'class' => 'wikitable', 'width' => '50%' ),
				implode( "\n", $items )
			)
		);
	}
	
	/**
	 * Returns the HTML for a single push target.
	 * 
	 * @since 0.1
	 * 
	 * @param string $name
	 * @param string $url
	 * 
	 * @return string
	 */
	protected static function getPushItem( $name, $url ) {
		global $wgTitle;
		
		static $targetId = 0;
		$targetId++;
		
		return Html::rawElement(
			'tr',
			array(),
			Html::element(
				'td',
				array(),
				$name
			) .
			Html::rawElement(
				'td',
				array( 'height' => '45px' ),
				Html::element(
					'a',
					array(
						'href' => $url . '/index.php?title=' . $wgTitle->getFullText(),
						'rel' => 'nofollow',
						'id' => 'targetlink' . $targetId
					),
					wfMsgExt( 'push-remote-page-link', 'parsemag', $wgTitle->getFullText(), $name ) 
				) . 
				Html::element(
					'div',
					array(
						'id' => 'targetinfo' . $targetId,
						'style' => 'display:none; color:darkgray'
					)
				) .
				Html::element(
					'div',
					array(
						'id' => 'targettemplateconflicts' . $targetId,
						'style' => 'display:none; color:darkgray'
					)
				) .	
				Html::element(
					'div',
					array(
						'id' => 'targetfileconflicts' . $targetId,
						'style' => 'display:none; color:darkgray'
					)
				) .	
				Html::element(
					'div',
					array(
						'id' => 'targeterrors' . $targetId,
						'style' => 'display:none; color:darkred'
					)
				)				
			) .	
			Html::rawElement(
				'td',
				array(),
				Html::element(
					'button',
					array(
						'class' => 'push-button',
						'pushtarget' => $url,
						'style' => 'width: 125px; height: 30px',
						'targetid' => $targetId,
						'targetname' => $name
					),
					wfMsg( 'push-button-text' )
				)
			)
		);
	}
	
	/**
	 * Outputs the HTML for the push options.
	 * 
	 * @since 0.4
	 */
	protected static function displayPushOptions() {
		global $wgOut, $wgUser, $wgTitle;
		
		$wgOut->addHTML( '<h3>' . htmlspecialchars( wfMsg( 'push-tab-push-options' ) ) . '</h3>' );
		
		$usedTemplates = array_keys(
			PushFunctions::getTemplates(
				array( $wgTitle->getFullText() ),
				array( $wgTitle->getFullText() => true )
			)
		);
		
		// Get rid of the page itself.
		array_shift( $usedTemplates );		
		
		self::displayIncTemplatesOption( $usedTemplates );
		
		if ( $wgUser->isAllowed( 'filepush' ) ) {
			self::displayIncFilesOption( $usedTemplates );
		}
	}
	
	/**
	 * Outputs the HTML for the "include templates" option.
	 * 
	 * @since 0.4
	 * 
	 * @param array $templates
	 */
	protected static function displayIncTemplatesOption( array $templates ) {
		global $wgOut, $wgLang, $egPushIncTemplates;

		$wgOut->addInlineScript(
			'var wgPushTemplates = ' . FormatJson::encode( $templates ) . ';'
		);				
		
		foreach ( $templates as &$template ) {
			$template = "[[$template]]";
		}

		$wgOut->addHTML(
			Html::rawElement(
				'div',
				array( 'id' => 'divIncTemplates', 'style' => 'display: table-row' ),
				Xml::check( 'checkIncTemplates', $egPushIncTemplates, array( 'id' => 'checkIncTemplates' ) ) .
				Html::element(
					'label',
					array( 'id' => 'lblIncTemplates', 'for' => 'checkIncTemplates' ),
					wfMsg( 'push-tab-inc-templates' )
				) .		
				'&#160;' . 
				Html::rawElement(
					'div',
					array( 'style' => 'display:none; opacity:0', 'id' => 'txtTemplateList' ),
					count( $templates ) > 0 ?
						 wfMsgExt( 'push-tab-used-templates', 'parseinline', $wgLang->listToText( $templates ), count( $templates ) ) :
						 htmlspecialchars( wfMsg( 'push-tab-no-used-templates' ) )
				)				
			)
		);		
	}
	
	/**
	 * Outputs the HTML for the "include files" option.
	 * 
	 * @since 0.4
	 * 
	 * @param array $templates
	 */	
	protected static function displayIncFilesOption( array $templates ) {
		global $wgOut, $wgTitle, $egPushIncFiles, $wgScript;
		
		$allFiles = self::getImagesForPages( array( $wgTitle->getFullText() ) );
		$templateFiles = self::getImagesForPages( $templates );		
		$pageFiles = array();
		
		foreach ( $allFiles as $file ) {
			if ( !in_array( $file, $templateFiles ) ) {
				$pageFiles[] = $file;
			}
		}
		
		$wgOut->addInlineScript(
			'var wgPushPageFiles = ' . FormatJson::encode( $pageFiles ) . ';' .
			'var wgPushTemplateFiles = ' . FormatJson::encode( $templateFiles ) . ';' .
			'var wgPushIndexPath = ' . FormatJson::encode( $wgScript )
		);

		$wgOut->addHTML(
			Html::rawElement(
				'div',
				array( 'id' => 'divIncFiles', 'style' => 'display: table-row' ),
				Xml::check( 'checkIncFiles', $egPushIncFiles, array( 'id' => 'checkIncFiles' ) ) .
				Html::element(
					'label',
					array( 'id' => 'lblIncFiles', 'for' => 'checkIncFiles' ),
					wfMsg( 'push-tab-inc-files' )
				) .		
				'&#160;' . 
				Html::rawElement(
					'div',
					array( 'style' => 'display:none; opacity:0', 'id' => 'txtFileList' ),
					''
				)
			)
		);
	}
	
	/**
	 * Returns the names of the images embedded in a set of pages.
	 * 
	 * @param array $pages
	 * 
	 * @return array
	 */
	protected static function getImagesForPages( array $pages ) {
		$images = array();
		
		$requestData = array(
			'action' => 'query',
			'format' => 'json',
			'prop' => 'images',
			'titles' => implode( '|', $pages ),
			'imlimit' => 500
		);
		
		$api = new ApiMain( new FauxRequest( $requestData, true ), true );
		$api->execute();
		$response = $api->getResultData();

		if ( is_array( $response ) && array_key_exists( 'query', $response ) && array_key_exists( 'pages', $response['query'] ) ) {
			foreach ( $response['query']['pages'] as $page ) {
				if ( array_key_exists( 'images', $page ) ) {
					foreach ( $page['images'] as $image ) {
						$title = Title::newFromText( $image['title'], NS_FILE );
						
						if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
							$images[] = $image['title'];
						}
					} 
				}
			}
		}

		return array_unique( $images );
	}
	
}