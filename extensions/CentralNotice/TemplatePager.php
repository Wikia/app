<?php

/**
 * Provides pagination functionality for viewing banner lists in the CentralNotice admin interface.
 */
class TemplatePager extends ReverseChronologicalPager {
	var $onRemoveChange, $viewPage, $special;
	var $editable;

	function __construct( $special ) {
		$this->special = $special;
		$this->editable = $special->editable;
		parent::__construct();

		// Override paging defaults
		list( $this->mLimit, /* $offset */ ) = $this->mRequest->getLimitOffset( 20, '' );
		$this->mLimitsShown = array( 20, 50, 100 );

		$msg = Xml::encodeJsVar( wfMsg( 'centralnotice-confirm-delete' ) );
		$this->onRemoveChange = "if( this.checked ) { this.checked = confirm( $msg ) }";
		$this->viewPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
	}

	/**
	 * Set the database query to retrieve all the banners in the database
	 * @return array of query settings
	 */
	function getQueryInfo() {
		return array(
			'tables' => 'cn_templates',
			'fields' => array( 'tmp_name', 'tmp_id' ),
		);
	}

	/**
	 * Sort the banner list by tmp_id (generally equals reverse chronological)
	 * @return string
	 */
	function getIndexField() {
		$dbr = wfGetDB( DB_SLAVE );
		return $dbr->tableName( 'cn_templates' ) . '.tmp_id';
	}

	/**
	 * Generate the content of each table row (1 row = 1 banner)
	 * @param $row object: database row
	 * @return string HTML
	 */
	function formatRow( $row ) {

		// Begin banner row
		$htmlOut = Xml::openElement( 'tr' );

		if ( $this->editable ) {
			// Remove box
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				Xml::check( 'removeTemplates[]', false,
					array(
						'value' => $row->tmp_name,
						'onchange' => $this->onRemoveChange
					)
				)
			);
		}

		// Link and Preview
		$render = new SpecialBannerLoader();
		$render->siteName = 'Wikipedia';
		$render->language = $this->mRequest->getVal( 'wpUserLanguage' );
		try {
			$preview = $render->getHtmlNotice( $row->tmp_name );
		} catch ( SpecialBannerLoaderException $e ) {
			$preview = wfMsg( 'centralnotice-nopreview' );
		}
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
			$this->getSkin()->makeLinkObj( $this->viewPage,
				htmlspecialchars( $row->tmp_name ),
				'template=' . urlencode( $row->tmp_name ) ) .
			Xml::fieldset( wfMsg( 'centralnotice-preview' ),
				$preview,
				array( 'class' => 'cn-bannerpreview')
			)
		);

		// End banner row
		$htmlOut .= Xml::closeElement( 'tr' );

		return $htmlOut;
	}

	/**
	 * Specify table headers
	 * @return string HTML
	 */
	function getStartBody() {
		$htmlOut = '';
		$htmlOut .= Xml::openElement( 'table', array( 'cellpadding' => 9 ) );
		$htmlOut .= Xml::openElement( 'tr' );
		if ( $this->editable ) {
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'width' => '5%' ),
				wfMsg ( 'centralnotice-remove' )
			);
		}
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left' ),
			wfMsg ( 'centralnotice-templates' )
		);
		$htmlOut .= Xml::closeElement( 'tr' );
		return $htmlOut;
	}

	/**
	 * Close table and add Submit button
	 * @return string HTML
	 */
	function getEndBody() {
		global $wgUser;
		$htmlOut = '';
		$htmlOut .= Xml::closeElement( 'table' );
		if ( $this->editable ) {
			$htmlOut .= Html::hidden( 'authtoken', $wgUser->editToken() );
			$htmlOut .= Xml::tags( 'div',
				array( 'class' => 'cn-buttons' ),
				Xml::submitButton( wfMsg( 'centralnotice-modify' ) )
			);
		}
		return $htmlOut;
	}
}
