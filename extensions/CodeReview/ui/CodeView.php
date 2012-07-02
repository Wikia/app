<?php

/**
 * Extended by CodeRevisionListView and CodeRevisionView
 */
abstract class CodeView {
	/**
	 * @var CodeRepository
	 */
	var $mRepo;

	/**
	 * @var Skin
	 */
	var $skin;

	/**
	 * @var CodeCommentLinkerHtml
	 */
	var $codeCommentLinkerHtml;

	/**
	 * @var CodeCommentLinkerWiki
	 */
	var $codeCommentLinkerWiki;

	function __construct( $repo ) {
		$this->mRepo = ( $repo instanceof CodeRepository )
			? $repo
			: CodeRepository::newFromName( $repo );

		global $wgUser;
		$this->skin = $wgUser->getSkin();

		$this->codeCommentLinkerHtml = new CodeCommentLinkerHtml( $this->mRepo );
		$this->codeCommentLinkerWiki = new CodeCommentLinkerWiki( $this->mRepo );
	}

	function validPost( $permission ) {
		global $wgRequest, $wgUser;
		return $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) )
			&& $wgUser->isAllowed( $permission );
	}

	abstract function execute();

	function authorLink( $author, $extraParams = array() ) {
		$repo = $this->mRepo->getName();
		$special = SpecialPage::getTitleFor( 'Code', "$repo/author/$author" );
		return $this->skin->link( $special, htmlspecialchars( $author ), array(), $extraParams );
	}

	function statusDesc( $status ) {
		return wfMsg( "code-status-$status" );
	}

	function formatMessage( $text ) {
		$text = nl2br( htmlspecialchars( $text ) );
		return $this->codeCommentLinkerHtml->link( $text );
	}

	function messageFragment( $value ) {
		global $wgLang;
		$message = trim( $value );
		$lines = explode( "\n", $message, 2 );
		$first = $lines[0];

		$html = $this->formatMessage( $first );
		$truncated = $wgLang->truncateHtml( $html, 80 );

		if ( count( $lines ) > 1  ) { // If multiline, we might want to add an ellipse
			$ellipsis = wfMsgExt( 'ellipsis', array() );
			// Hack: don't add if the end is already an ellipse
			if ( substr( $truncated, -strlen( $ellipsis ) ) !== $ellipsis ) {
				$truncated .= $ellipsis;
			}
		}

	    return $truncated;
	}
	/**
	 * Formatted HTML array for properties display
	 * @param array fields : 'propname' => HTML data
	 */
	function formatMetaData( $fields ) {
		$html = '<table class="mw-codereview-meta">';
		foreach ( $fields as $label => $data ) {
			$html .= "<tr><td>" . wfMsgHtml( $label ) . "</td><td>$data</td></tr>\n";
		}
		return $html . "</table>\n";
	}

	function getRepo() {
		if ( $this->mRepo ) {
			return $this->mRepo;
		}
		return false;
	}
}

abstract class SvnTablePager extends TablePager {

	/**
	 * @var CodeRepository
	 */
	protected $mRepo;

	/**
	 * @var CodeView
	 */
	protected $mView;

	/**
	 * @param $view CodeView
	 *
	 */
	function __construct( $view ) {
		global $IP;
		$this->mView = $view;
		$this->mRepo = $view->mRepo;
		$this->mDefaultDirection = true;
		$this->mCurSVN = SpecialVersion::getSvnRevision( $IP );
		parent::__construct();
	}

	function isFieldSortable( $field ) {
		return $field == $this->getDefaultSort();
	}

	function formatRevValue( $name, $value, $row ) {
		return $this->formatValue( $name, $value );
	}

	// Note: this function is poorly factored in the parent class
	function formatRow( $row ) {
		$css = "mw-codereview-status-{$row->cr_status}";
		$s = "<tr class=\"$css\">\n";
		// Some of this stolen from Pager.php...sigh
		$fieldNames = $this->getFieldNames();
		$this->mCurrentRow = $row;  # In case formatValue needs to know
		foreach ( $fieldNames as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatRevValue( $field, $value, $row ) );
			if ( $formatted == '' ) {
				$formatted = '&#160;';
			}
			$class = 'TablePager_col_' . htmlspecialchars( $field );
			$s .= "<td class=\"$class\">$formatted</td>\n";
		}
		$s .= "</tr>\n";
		return $s;
	}

	function getStartBody() {
		global $wgOut;
		$wgOut->addModules( 'ext.codereview.overview' );
		return parent::getStartBody();
	}
}
