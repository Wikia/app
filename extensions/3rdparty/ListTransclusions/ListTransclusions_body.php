<?php
/**
 * ListTransclusions extension, Special page body
 *
 * @author Patrick Westerhoff [poke]
 */
class ListTransclusions extends SpecialPage
{
	protected $skin, $dbr;
	protected $target;
	protected $opts;

	/**
	 * constructor
	 */
	public function __construct ()
	{
		parent::__construct( 'ListTransclusions' );
	}

	/**
	 * Entry point for the special page.
	 *
	 * @param String $par Subpage of called special page
	 */
	public function execute ( $par )
	{
		global $wgRequest, $wgOut, $wgUser;
		
		$this->setHeaders();
		$this->dbr = wfGetDB( DB_SLAVE );
		$this->skin = $wgUser->getSkin();
		$this->opts = new FormOptions( );
		$this->opts->add( 'target', '' );
		$this->opts->fetchValuesFromRequest( $wgRequest );
		
		if ( isset( $par ) )
			$this->opts->setValue( 'target', $par );
		
		$this->target = Title::newFromURL( $this->opts->getValue( 'target' ) );
		
		// output :: showForm
		$wgOut->addHTML( $this->generateForm() );
		
		if ( !$this->target )
		{
			if ( trim( $this->opts->getValue( 'target' ) ) != '' )
				$wgOut->addWikiMsg( 'listtransclusions-invalid' );
			
			return;
		}
			
		// output :: titles
		$targetText = $this->target->getPrefixedText();
		$wgOut->setPageTitle( wfMsg( 'listtransclusions-title', $targetText ) );
		$wgOut->setSubtitle( wfMsg( 'listtransclusions-backlink',
				$this->skin->link( $this->target, htmlspecialchars( $targetText ), array(),
				array( 'redirect' => 'no' ) ) ) );
		
		// check target's existance
		if ( !$this->target->exists() )
		{
			$wgOut->addWikiMsg( 'listtransclusions-notexist', $targetText );
			return;
		}
		
		// receive transcluded pages
		$targetId   = $this->target->getArticleId();
		$loadedTpls = $this->loadTemplates( $targetId );
		$loadedImgs = $this->loadImages( $targetId );
		
		// output
		$wgOut->addWikiMsg( 'listtransclusions-header', $targetText );
		$wgOut->addHTML( $this->generatePagesList( $loadedTpls, 'listtransclusions-tpls' ) );
		$wgOut->addHTML( $this->generatePagesList( $loadedImgs, 'listtransclusions-imgs' ) );
		$wgOut->addWikiMsg( 'listtransclusions-footer', $targetText );
	}

	/**
	 * Loads the used templates on the target page
	 *
	 * @param String $targetId Target page
	 * @return Array Loaded templates
	 */
	private function loadTemplates ( $targetId )
	{
		$pages = array();
		$dbRes = $this->dbr->select(
				array( 'templatelinks' ),
				array( 'tl_namespace', 'tl_title' ),
				array( 'tl_from' => $targetId ),
				__METHOD__ );
		
		if ( $dbRes !== false )
		{
			foreach ( $dbRes as $row )
				$pages[] = Title::makeTitle( $row->tl_namespace, $row->tl_title );
		}
		$this->dbr->freeResult( $dbRes );
		return $pages;
	}

	/**
	 * Load the used images on the target page
	 *
	 * @param String $targetId Target page
	 * @return Array Loaded images
	 */
	private function loadImages ( $targetId )
	{
		$pages = array();
		$dbRes = $this->dbr->select(
				array( 'imagelinks' ),
				array( 'il_to' ),
				array( 'il_from' => $targetId ),
				__METHOD__ );
		
		if ( $dbRes !== false )
		{
			foreach ( $dbRes as $row )
				$pages[] = Title::makeTitle( NS_FILE, $row->il_to );
		}
		$this->dbr->freeResult( $dbRes );
		return $pages;
	}

	/**
	 * Generates a list of the pages using the message.
	 * The function uses the message and the message with an appended '-no'.
	 *
	 * @param Array $pages Array of the loaded pages
	 * @param String $msg Message name to use
	 * @return String Generated HTML code
	 */
	private function generatePagesList ( $pages, $msg )
	{
		if ( count( $pages ) <= 0 )
			return wfMsgExt( $msg . '-no', array( 'parse' ), $this->target->getPrefixedText() );
		
		usort( $pages, array( 'Title', 'compare' ) );
		$t = wfMsgExt( $msg, array( 'parse' ), $this->target->getPrefixedText() );
		$t .= "<ul>\n";
		foreach ( $pages as $titleObj )
		{
			$t .= '<li>' . $this->skin->link( $titleObj ) . ' (';
			$t .= $this->skin->link( $titleObj, wfMsg( 'hist' ), array(), array( 'action' => 'history' ) );
			$t .= ")</li>\n";
		}
		$t .= "</ul>\n";
		return $t;
	}

	/**
	 * Generates the form used for this special page
	 *
	 * @return String Generated HTML code
	 */
	private function generateForm ()
	{
		global $wgScript, $wgTitle;
		
		$this->opts->consumeValue( 'target' );
		$target = $this->target ? $this->target->getPrefixedText() : '';
		
		$f  = Xml::openElement( 'form', array( 'action' => $wgScript ) );
		$f .= Xml::fieldset( wfMsg( 'listtransclusions' ) );
		
		// hidden values
		$f .= Xml::hidden( 'title', $wgTitle->getPrefixedText() );
		foreach ( $this->opts->getUnconsumedValues() as $name => $value )
			$f .= Xml::hidden( $name, $value );
		
		// form elements
		$f .= Xml::inputLabel( wfMsg( 'listtransclusions-page' ), 'target',
			'mw-listtransclusions-target', 40, $target );
		$f .= ' ';
		$f .= Xml::submitButton( wfMsg( 'allpagessubmit' ) );
		
		$f .= Xml::closeElement( 'fieldset' ) . Xml::closeElement( 'form' );
		
		return $f . "\n";
	}
}