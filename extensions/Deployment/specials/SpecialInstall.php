<?php

/**
 * A special page that allows browing and searching through extensions that are in the connected extension repository.
 * 
 * @file SpecialInstall.php
 * @ingroup Deployment
 * @ingroup SpecialPage
 * 
 * @author Jeroen De Dauw
 */
class SpecialInstall extends SpecialPage {

	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */	
	public function __construct() {
		parent::__construct( 'Install', 'siteadmin' );
	}
	
	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}	

	/**
	 * Main method.
	 * 
	 * @since 0.1 
	 * 
	 * @param $arg String
	 */	
	public function execute( $arg ) {
		global $wgOut, $wgUser, $wgRequest;
		
		$wgOut->setPageTitle( wfMsg( 'install-title' ) );
		
		// If the user is authorized, display the page, if not, show an error.
		if ( $this->userCanExecute( $wgUser ) ) {
			if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$this->showCompactSearchOptions();
				
				$extensions = $this->findExtenions( $wgRequest->getText( 'filtertype' ), $wgRequest->getText( 'filtervalue' ) );
				
				if ( count( $extensions ) > 0 ) {
					$this->showExtensionList( $extensions );
					// TODO: detect further results and have some sort of paging
				}
				else {
					// TODO
				}
			}
			else {
				$this->showFullSearchOptions();
			}
		} else {
			$this->displayRestrictionError();
		}			
	}
	
	/**
	 * Created the HTML for the full set of search options controls and adds it to $wgOut.
	 * 
	 * @since 0.1
	 */
	protected function showFullSearchOptions() {
		global $wgOut, $wgUser, $wgRepositoryLocation;
		
		$wgOut->addWikiMsg( 'extensions-description', $wgRepositoryLocation );
		
		$searchHtml = Html::element( 'h2', array(), wfMsg( 'search-extensions' ) );
		$searchHtml .= wfMsg( 'search-extensions-long' );
		
		$wgOut->addHTML( $this->getPluginSearcher() );
		
		$tagHtml = Html::element( 'h2', array(), wfMsg( 'popular-extension-tags' ) );
		$tagHtml .= wfMsg( 'popular-extension-tags-long' );
		
		$wgOut->addHTML( $tagHtml );
	}
	
	/**
	 * Created the HTML for the compact search options and adds it to $wgOut.
	 * 
	 * @since 0.1
	 */	
	protected function showCompactSearchOptions() {
		global $wgOut, $wgRequest;
		
		$wgOut->addHTML(
			$this->getPluginSearcher(
				$wgRequest->getText( 'filtertype' ),
				$wgRequest->getText( 'filtervalue' )
			)
		);
	}
	
	/**
	 * Creates and returns the HTML for the plugin search control.
	 * 
	 * @since 0.1
	 * 
	 * @param $selectedType String
	 * @param $value String
	 * 
	 * @return string
	 */
	protected function getPluginSearcher( $selectedType = 'term', $value = '' ) {
		global $wgUser;
		
		$searchHtml = Html::openElement(
			'form',
			array(
				'id' => 'searchform',
				'name' => 'searchform',
				'method' => 'post',
				'action' => $this->getTitle()->getLocalURL(),				
			)
		);
		
		// TODO: It might be nice to build the dropdown with a more generic function.
		$termSelected = $selectedType == 'term' ? ' selected' : '';
		$authroSelected = $selectedType == 'author' ? ' selected' : '';
		$tagSelected = $selectedType == 'tag' ? ' selected' : '';
		
		$searchHtml .= Html::rawElement(
			'select',
			array(
				'name' => 'filtertype',
				'id' => 'filtertype'
			),
			"<option value='term'$termSelected>" . htmlspecialchars( wfMsg( 'search-term' ) ) . '</option>' .
			"<option value='author'$authroSelected>" . htmlspecialchars( wfMsg( 'search-author' ) ) . '</option>' .
			"<option value='tag'$tagSelected>" . htmlspecialchars( wfMsg( 'search-tag' ) ) . '</option>'
		);
		
		$searchHtml .= '&#160;&#160;';
		
		$searchHtml .= Html::input( 'filtervalue', $value );
		
		$searchHtml .= '&#160;&#160;';
		
		$searchHtml .= Html::input(
			'',
			wfMsg( 'search-extensions-button' ),
			'submit',
			array( 'id' => 'searchform-button' )
		);
		
		$searchHtml .= Html::hidden( 'wpEditToken', $wgUser->editToken() );
		
		$searchHtml .= Html::closeElement( 'form' );

		return $searchHtml;
	}
	
	/**
	 * Queries the repository for a list of extensions matching the search criteria
	 * and returns these.
	 * 
	 * @since 0.1
	 * 
	 * @param $filterType String
	 * @param $filterValue String
	 * 
	 * @return arrau
	 */
	protected function findExtenions( $filterType, $filterValue ) {
		$repository = wfGetRepository();
		
		return $repository->findExtenions( $filterType, $filterValue );
	}
	
	/**
	 * Show the extensions that where found in a list.
	 * This method assumes it gets only called when there are more then 0 extensions.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensions Array
	 */
	protected function showExtensionList( array $extensions ) {
		global $wgOut;
		
		$listHtml = Html::openElement(
			'table',
			array( 'class' => 'wikitable', 'style' => 'width:100%' )
		);
		
		$listHtml .= '<tr>' . 
			Html::element( 'th', array(), wfMsg( 'extensionlist-name' ) ) .
			Html::element( 'th', array(), wfMsg( 'extensionlist-version' ) ) .
			Html::element( 'th', array(), wfMsg( 'extensionlist-stability' ) ) .
			Html::element( 'th', array(), wfMsg( 'extensionlist-description' ) )
			.  '</tr>';
		
		foreach ( $extensions as $extension ) {
			$listHtml .= $this->getExtensionForList( $extension );
		}			
		
		$listHtml .= Html::closeElement( 'table' );
		
		$wgOut->addHTML( $listHtml );
	}
	
	/**
	 * Creates and returns the html for a single extension in the list.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensions Object
	 * 
	 * @return string
	 */	
	protected function getExtensionForList( $extension ) {
		$html = '<tr>';
		
		$html .= Html::rawElement(
			'td',
			array(),
			Html::element( 'b', array(), $extension->name ) .
			'<br />' .
			Html::element(
				'a',
				array(
					'href' => $extension->url,
					'class' => 'external text'
				),
				wfMsg( 'extensionlist-details' )		
			) .
			' | ' .
			Html::element(
				'a',
				array(
					'href' => $extension->download,
					'class' => 'external text'
				),
				wfMsg( 'extensionlist-download' )		
			)			
		);
		
		$html .= Html::element( 'td', array(), $extension->version );
		$html .= Html::element( 'td', array(), 'Stable' ); // TODO
		
		$html .= Html::element(
			'td',
			array(),
			$extension->description . ' ' . 
				wfMsgExt( 'extensionlist-createdby', 'parsemag', $extension->authors )
		);
		
		return $html . '</tr>';
	}
	
}
