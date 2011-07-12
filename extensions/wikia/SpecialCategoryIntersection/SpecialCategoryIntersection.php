<?php
/**
 * @author Sean Colombo
 *
 * Special page to demonstrate the CategoryIntersection API call, specifically as it relates to LyricWiki.
 *
 * This extension is designed to be portable, so it doesn't use the Nirvana framework.
 *
 * TODO: Autocompletion for the text-fields
 *
 * @file
 * @ingroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

$wgSpecialPages[ "CategoryIntersection" ] = "SpecialCategoryIntersection";
$wgExtensionMessagesFiles['CategoryIntersection'] = dirname( __FILE__ ) . '/SpecialCategoryIntersection.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CategoryIntersection',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo', // TODO: Update with a link to appropriate extension info page (such as MediaWiki.org) if this extension gets committed upstream.
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'categoryintersection-desc',
	'version' => '1.0',
);


/**
 * A class to deal with displaying CategoryIntersections provided by the MediaWiki API.
 * @ingroup SpecialPage
 */
class SpecialCategoryIntersection extends SpecialPage {
	public $defaultLimit = 25;

	public function __construct() {
		parent::__construct( 'CategoryIntersection' );
	}

	/**
	 * Manage forms to be shown according to posted data.
	 *
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function execute( $subpage ) {
		global $wgOut;
		wfProfileIn( __METHOD__ );
	
		wfLoadExtensionMessages( 'CategoryIntersection' );

		$wgOut->setPagetitle( wfMsg('categoryintersection') );
		
		// Show the header
		$wgOut->addHTML( wfMsg('categoryintersection-header') );

		$wgOut->addHTML("<table><tr><td width='50%'>"); // oh snap, tables for layout!
			$this->showForm( $wgOut );
		$wgOut->addHTML("</td><td width='50%'>");
			$this->showResults( $wgOut );
		$wgOut->addHTML("</td></tr></table>\n");
		
		// Show a footer w/links to more info and some example queries
		$this->showFooter( $wgOut );

		wfProfileOut( __METHOD__ );
	} // end execute()
	
	/**
	 * Prints a form to the OutputPage provided, which will alow the user to make a query for multiple categories.
	 *
	 * @param out - OutputPage to add HTML to.
	 */
	private function showForm($out){
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$html = "";
		$html .= "<h3>". wfMsg('categoryintersection-form-title') ."</h3>";

		$html .= "<form name='categoryintersection' action='' method='GET'>\n";

			// Display a couple of rows
			$html .= $this->getHtmlForCategoryBox(1);
			$html .= wfMsg('categoryintersection-and') . "<br/>\n";
			$html .= $this->getHtmlForCategoryBox(2);
			
	// TODO: Display a button to make more rows....
	// TODO: Display a button to make more rows....

			// Display limit (default to this->defaultLimit)
			$html .= wfMsg('categoryintersection-limit') . "<select name='limit'>";
			$limit = $wgRequest->getVal('limit', $this->defaultLimit);
			$limits = array(10, 25, 50, 100);
			foreach($limits as $currLimit){
				$selected = (($currLimit == $limit)? " selected='selected'" : "");
				$html .= "\t<option value='$currLimit'$selected>$currLimit</option>\n";
			}
			$html .= "</select><br/>\n";

			// Display submit button
			$html .= "<input class='wikia-button' type='submit' name='wpSubmit' value='". wfMsg('categoryintersection-form-submit') ."'/>\n";

		$html .= "</form>\n";

		$out->addHTML($html);
		
		wfProfileOut( __METHOD__ );
	} // end showForm()
	
	/**
	 * @param num - a sequential number for the category box so that a bunch of them can be made.  The first should be "1"
	 * @return a string which contains HTML for a text field for a category.  Will be pre-populated with a value if this page
	 * is a form submission
	 */
	private function getHtmlForCategoryBox($num){
		global $wgRequest;
		$id = "category_$num";
// TODO: If there is no value, provide hint-text
// TODO: If there is no value, provide hint-text
		$value = $wgRequest->getVal($id);
		return "<input type='text' name='$id' value='$value'/><br/>\n";
	} // end getHtmlForCategoryBox()

	/**
	 * Prints results to the OutputPage provided, if there was a query for an intersection of categories. Otherwise
	 * prints some placeholder text.
	 *
	 * @param out - OutputPage to add HTML to.
	 */
	private function showResults($out){
		wfProfileIn( __METHOD__ );

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

		wfProfileOut( __METHOD__ );
	} // end showResults()
	
	/**
	 * Prints a footer to the OutputPage provided, which contains example queries to get people thinking and show them some options.
	 * In addition, links to the documentation.
	 *
	 * @param out - OutputPage to add HTML to.
	 */
	private function showFooter($out){
		wfProfileIn( __METHOD__ );
		
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
		
		wfProfileOut( __METHOD__ );
	} // end showFooter()

} // end class SpecialCategoryIntersection
