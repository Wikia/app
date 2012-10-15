<?php

class CentralNoticePager extends TemplatePager {
	var $viewPage, $special;
	var $editable;

	function __construct( $special ) {
		parent::__construct( $special );
	}

	/**
	 * Pull banners from the database
	 */
	function getQueryInfo() {
		$notice = $this->mRequest->getVal( 'notice' );
		$noticeId = CentralNotice::getNoticeId( $notice );
		if ( $noticeId ) {
			// Return all the banners not already assigned to the current campaign
			return array(
				'tables' => array( 'cn_assignments', 'cn_templates' ),
				'fields' => array( 'cn_templates.tmp_name', 'cn_templates.tmp_id' ),
				'conds' => array( 'cn_assignments.tmp_id IS NULL' ),
				'join_conds' => array(
					'cn_assignments' => array(
						'LEFT JOIN',
						"cn_assignments.tmp_id = cn_templates.tmp_id " .
						"AND cn_assignments.not_id = $noticeId"
					)
				)
			);
		} else {
			// Return all the banners in the database
			return array(
				'tables' => 'cn_templates',
				'fields' => array( 'tmp_name', 'tmp_id' ),
			);
		}
	}

	/**
	 * Generate the content of each table row (1 row = 1 banner)
	 */
	function formatRow( $row ) {

		// Begin banner row
		$htmlOut = Xml::openElement( 'tr' );

		if ( $this->editable ) {
			// Add box
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				Xml::check( 'addTemplates[]', '', array ( 'value' => $row->tmp_name ) )
			);
			// Weight select
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				Xml::listDropDown( "weight[$row->tmp_id]",
					CentralNotice::dropDownList(
						wfMsg( 'centralnotice-weight' ), range ( 0, 100, 5 )
					) ,
					'',
					'25',
					'',
					'' )
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
	 */
	function getStartBody() {
		$htmlOut = '';
		$htmlOut .= Xml::openElement( 'table', array( 'cellpadding' => 9 ) );
		$htmlOut .= Xml::openElement( 'tr' );
		if ( $this->editable ) {
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'width' => '5%' ),
				 wfMsg ( "centralnotice-add" )
			);
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'width' => '5%' ),
				 wfMsg ( "centralnotice-weight" )
			);
		}
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left' ),
			wfMsg ( 'centralnotice-templates' )
		);
		$htmlOut .= Xml::closeElement( 'tr' );
		return $htmlOut;
	}

	/**
	 * Close table
	 */
	function getEndBody() {
		$htmlOut = '';
		$htmlOut .= Xml::closeElement( 'table' );
		return $htmlOut;
	}
}
