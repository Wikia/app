<?php

/**
 * A special page that allows pushing one or more pages to one or more targets.
 * Partly based on MediaWiki's Special:Export.
 *
 * @since 0.1
 *
 * @file Push_Body.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw  < jeroendedauw@gmail.com >
 */
class SpecialPush extends SpecialPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Push', 'bulkpush' );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}

	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 */
	public function setHeaders() {
		global $wgOut;
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setPageTitle( $this->getDescription() );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $arg
	 */
	public function execute( $arg ) {
		global $wgOut, $wgUser, $wgRequest, $egPushTargets;

		$this->setHeaders();
		$this->outputHeader();

		// If the user is authorized, display the page, if not, show an error.
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( count( $egPushTargets ) == 0 ) {
			$wgOut->addHTML( '<p>' . htmlspecialchars( wfMsg( 'push-tab-no-targets'  ) ) . '</p>' );
			return;
		}

		$doPush = false;

		if ( $wgRequest->getCheck( 'addcat' ) ) {
			$pages = $wgRequest->getText( 'pages' );
			$catname = $wgRequest->getText( 'catname' );

			if ( $catname !== '' && $catname !== null && $catname !== false ) {
				$t = Title::makeTitleSafe( NS_MAIN, $catname );
				if ( $t ) {
					/**
					 * @todo Fixme: this can lead to hitting memory limit for very large
					 * categories. Ideally we would do the lookup synchronously
					 * during the export in a single query.
					 */
					$catpages = $this->getPagesFromCategory( $t );
					if ( $catpages ) $pages .= "\n" . implode( "\n", $catpages );
				}
			}
		}
		elseif( $wgRequest->getCheck( 'addns' ) ) {
			$pages = $wgRequest->getText( 'pages' );
			$nsindex = $wgRequest->getText( 'nsindex', '' );

			if ( strval( $nsindex ) !== ''  ) {
				/**
				 * Same implementation as above, so same @todo
				 */
				$nspages = $this->getPagesFromNamespace( $nsindex );
				if ( $nspages ) $pages .= "\n" . implode( "\n", $nspages );
			}
		}
		elseif( $wgRequest->wasPosted() ) {
			$pages = $wgRequest->getText( 'pages' );
			if( $pages != '' ) $doPush= true;
		}
		else {
			$pages = '';
		}

		if ( $doPush ) {
			$this->doPush( $pages );
		}
		else {
			$this->displayPushInterface( $arg, $pages );
		}
	}

	/**
	 * Outputs the HTML to indicate a push is occurring and
	 * the JavaScript to needed by the push.
	 *
	 * @since 0.2
	 *
	 * @param string $pages
	 */
	protected function doPush( $pages ) {
		global $wgOut, $wgLang, $wgRequest, $wgSitename, $wgTitle, $egPushTargets, $egPushBulkWorkers, $egPushBatchSize;

		$pageSet = array(); // Inverted index of all pages to look up

		// Split up and normalize input
		foreach( explode( "\n", $pages ) as $pageName ) {
			$pageName = trim( $pageName );
			$title = Title::newFromText( $pageName );
			if( $title && $title->getInterwiki() == '' && $title->getText() !== '' ) {
				// Only record each page once!
				$pageSet[$title->getPrefixedText()] = true;
			}
		}

		// Look up any linked pages if asked...
		if( $wgRequest->getCheck( 'templates' ) ) {
			$pageSet = PushFunctions::getTemplates( array_keys( $pageSet ), $pageSet );
		}

		$pages = array_keys( $pageSet );

		$targets = array();
		$links = array();

		if ( count( $egPushTargets ) > 1 ) {
			foreach ( $egPushTargets as $targetName => $targetUrl ) {
				if ( $wgRequest->getCheck( str_replace( ' ', '_', $targetName ) ) ) {
					$targets[$targetName] = $targetUrl;
					$links[] = "[$targetUrl $targetName]";
				}
			}
		}
		else {
			$targets = $egPushTargets;
		}

		$wgOut->addWikiMsg( 'push-special-pushing-desc', $wgLang->listToText( $links ), $wgLang->formatNum( count( $pages ) ) );

		$wgOut->addHTML(
			Html::hidden( 'siteName', $wgSitename, array( 'id' => 'siteName' ) ) .
			Html::rawElement(
				'div',
				array(
					'id' => 'pushResultDiv',
					'style' => 'width: 100%; height: 300px; overflow: auto'
				),
				Html::rawElement(
					'div',
					array( 'class' => 'innerResultBox' ),
					Html::element( 'ul', array( 'id' => 'pushResultList' ) )
				)
			) . '<br />' .
			Html::element( 'a', array( 'href' => $wgTitle->getInternalURL() ), wfMsg( 'push-special-return' ) )
		);

		$wgOut->addInlineScript(
			'var wgPushPages = ' . FormatJson::encode( $pages ) . ';' .
			'var wgPushTargets = ' . FormatJson::encode( $targets ) . ';' .
			'var wgPushWorkerCount = ' . $egPushBulkWorkers . ';' .
			'var wgPushBatchSize = ' . $egPushBatchSize . ';' .
			'var wgPushIncFiles = ' . ( $wgRequest->getCheck( 'files' ) ? 'true' : 'false' ) . ';'
		);

		$this->loadJs();
	}

	/**
	 * @since 0.2
	 */
	protected function displayPushInterface( $arg, $pages ) {
		global $wgOut, $wgUser, $wgRequest, $egPushTargets, $egPushIncTemplates, $egPushIncFiles;

		$wgOut->addWikiMsg( 'push-special-description' );

		$form = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $this->getTitle()->getLocalUrl( 'action=submit' ) ) );
		$form .= Xml::inputLabel( wfMsg( 'export-addcattext' )    , 'catname', 'catname', 40 ) . '&#160;';
		$form .= Xml::submitButton( wfMsg( 'export-addcat' ), array( 'name' => 'addcat' ) ) . '<br />';

		$form .= Xml::namespaceSelector( $wgRequest->getText( 'nsindex', '' ), null, 'nsindex', wfMsg( 'export-addnstext' ) ) . '&#160;';
		$form .= Xml::submitButton( wfMsg( 'export-addns' ), array( 'name' => 'addns' ) ) . '<br />';

		$form .= Xml::element( 'textarea', array( 'name' => 'pages', 'cols' => 40, 'rows' => 10 ), $pages, false );
		$form .= '<br />';

		$form .= Xml::checkLabel(
			wfMsg( 'export-templates' ),
			'templates',
			'wpPushTemplates',
			$wgRequest->wasPosted() ? $wgRequest->getCheck( 'templates' ) : $egPushIncTemplates
		) . '<br />';

		if ( $wgUser->isAllowed( 'filepush' ) ) {
			$form .= Xml::checkLabel(
				wfMsg( 'push-special-inc-files' ),
				'files',
				'wpPushFiles',
				$wgRequest->wasPosted() ? $wgRequest->getCheck( 'files' ) : $egPushIncFiles
			) . '<br />';
		}

		if ( count( $egPushTargets ) == 1 ) {
			$names = array_keys( $egPushTargets );
			$form .= '<b>' . htmlspecialchars( wfMsgExt( 'push-special-target-is', 'parsemag', $names[0] ) ) . '</b><br />';
		}
		else {
			$form .= '<b>' . htmlspecialchars( wfMsg( 'push-special-select-targets' ) ) . '</b><br />';

			foreach ( $egPushTargets as $targetName => $targetUrl ) {
				$checkName = str_replace( ' ', '_', $targetName );
				$checked = $wgRequest->wasPosted() ? $wgRequest->getCheck( $checkName ) : true;
				$form .= Xml::checkLabel( $targetName, $checkName, $targetName, $checked ) . '<br />';
			}
		}

		$form .= Xml::submitButton( wfMsg( 'push-special-button-text' ), array( 'style' => 'width: 125px; height: 30px' ) );
		$form .= Xml::closeElement( 'form' );

		$wgOut->addHTML( $form );
	}

	/**
	 * Returns all pages for a category (up to 5000).
	 *
	 * @since 0.2
	 *
	 * @param Title $title
	 *
	 * @return array
	 */
	protected function getPagesFromCategory( Title $title ) {
		global $wgContLang;

		$name = $title->getDBkey();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_namespace', 'page_title' ),
			array( 'cl_from=page_id', 'cl_to' => $name ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$pages = array();

		foreach ( $res as $row ) {
			$n = $row->page_title;
			if ($row->page_namespace) {
				$ns = $wgContLang->getNsText( $row->page_namespace );
				$n = $ns . ':' . $n;
			}

			$pages[] = $n;
		}
		return $pages;
	}

	/**
	 * Returns all pages for a namespace (up to 5000).
	 *
	 * @since 0.2
	 *
	 * @param integer $nsindex
	 *
	 * @return array
	 */
	protected function getPagesFromNamespace( $nsindex ) {
		global $wgContLang;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array( 'page_namespace' => $nsindex ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$pages = array();

		foreach ( $res as $row ) {
			$n = $row->page_title;

			if ( $row->page_namespace ) {
				$ns = $wgContLang->getNsText( $row->page_namespace );
				$n = $ns . ':' . $n;
			}

			$pages[] = $n;
		}
		return $pages;
	}

	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 *
	 * @since 0.2
	 */
	protected static function loadJs() {
		global $wgOut;

		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $wgOut, 'addModules' ) ) ) {
			$wgOut->addModules( 'ext.push.special' );
		}
		else {
			global $egPushScriptPath;

			PushFunctions::addJSLocalisation();

			$wgOut->includeJQuery();

			$wgOut->addHeadItem(
				'ext.push.special',
				Html::linkedScript( $egPushScriptPath . '/specials/ext.push.special.js' )
			);
		}
	}

}
