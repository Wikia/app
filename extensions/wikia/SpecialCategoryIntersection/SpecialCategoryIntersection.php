<?php
/**
 * @author Sean Colombo
 *
 * Special page to demonstrate the CategoryIntersection API call, specifically as it relates to LyricWiki.
 *
 * This extension is designed to be portable, so it doesn't use the Nirvana framework.
 *
 * TODO: Autocompletion for the text-fields (if not, then pull "Category:" out in front of the textfield so they don't have to type it).
 * TODO: Autocompletion for the text-fields (if not, then pull "Category:" out in front of the textfield so they don't have to type it).
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

	static private $CAT_PREFIX = "category_";
	private $CATEGORY_NS_PREFIX;

	public function __construct() {
		parent::__construct( 'CategoryIntersection' );

		global $wgContLang;
		$this->CATEGORY_NS_PREFIX = $wgContLang->getNSText(NS_CATEGORY) . ":"; // the actual namespace prefix (includes the colon at the end).
	}

	public function getDocumentationUrl(){
		// TODO: Ideally, we should create documentation for the extension on MediaWiki.org, then instead of this function, we should use a static member var (string) for the URL.
		global $wgServer;
		return $wgServer."/api.php";
	}

	/**
	 * Manage forms to be shown according to posted data.
	 *
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function execute( $subpage ) {
		global $wgOut, $wgExtensionsPath;
		wfProfileIn( __METHOD__ );

		$wgOut->setPagetitle( wfMsg('categoryintersection') );

		// Just splurt some CSS onto the page for now (TODO: Make this an external file.. do it in a way that works for both AssetsManager and for MediaWiki in general)
		$wgOut->addHTML("
			<style type='text/css'>
				h3{
					font-weight:bold;
				}
				table{
					width:100%;
				}
				td{
					vertical-align:top;
					width: 512px; /* why does 50% not work? (causes the API query line to take massive width in Chrome) */
					word-wrap:break-word; /* so that the API query doesn't make the cell grow in Chrome */
				}
				td.form{
					padding: 20px 20px;
					background-color:#efefef;
					width:475px;
				}
				td.form input[type=text]{
					width:95%;
					height:30px;
					font-size:13px;
					padding-left:5px;
				}
				td.results{
					opacity:0.8;
					filter:alpha(opacity=80); /* For IE8 and earlier */
					padding: 20px 20px;
					background-color:#efefef;
					font-size:13px;
				}
				.autoCompleteWrapper{
					position: relative;
				}
				div.autoCompleteWrapper div{
					background-color:#000;
					background-color:#fff; /* Do we need to use an Oasis theme mixin? */
				}
				.autocomplete{
					border:1px solid;
					padding:3px;
				}
			</style>
		");

		// Show the header
		$wgOut->addHTML( "<h2>" . wfMsg('categoryintersection-header-title') . "</h2>" );
		$docLink = "<a href='".$this->getDocumentationUrl()."'>". wfMsg('categoryintersection-docs-linktext') ."</a>";
		$wgOut->addHTML( wfMsg('categoryintersection-header-body', $docLink) );
		$wgOut->addHTML( "<br/><br/>" );

		$wgOut->addHTML("<table><tr><td class='form'>"); // oh snap, tables for layout!
			$this->showForm( $wgOut );
		$wgOut->addHTML("</td><td class='results'>");

		$wgOut->addHTML("<h3>" . wfMsg('categoryintersection-instructions-title') . "</h3>");
		$wgOut->addHTML(wfMsg('categoryintersection-instructions'));

		$wgOut->addHTML("</td></tr></table>\n");

		$this->showResults( $wgOut );

		// Show a footer w/links to more info and some example queries
		$this->showFooter( $wgOut );

		// Javascript for the autocompletion - this must be done after the form exists since it does calculations on the form.
		$js = "{$wgExtensionsPath}/wikia/SpecialCategoryIntersection/CategoryAutoComplete.js";
		$wgOut->addScript('<script type="text/javascript" src="'.$js.'"></script>');

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

		$html .= "<div>\n";
		$html .= "<form name='categoryintersection' id='CategoryAutoComplete' class='WikiaForm' action='' method='GET'>\n";

			// Display a couple of rows
			$html .= $this->getHtmlForCategoryBox(1);
			$html .= wfMsg('categoryintersection-and') . "<br/>\n";
			$html .= $this->getHtmlForCategoryBox(2);

// TODO: Display a button to make more rows....
// TODO: Display a button to make more rows....

			// Display limit (default to this->defaultLimit)
			$html .= wfMsg('categoryintersection-limit') . " <select name='limit' style='margin:10px 0 35px 0'>";
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
		$html .= "</div>\n";

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
		$formName = self::$CAT_PREFIX . "$num";
		$value = $wgRequest->getVal($formName);
		// The wrapper is what the auto-complete popupwill be appended to.
		$zIndex = (300 - $num); // make the top boxes show up on top of anything below them
		return "<div class='autoCompleteWrapper' style='z-index:$zIndex'><input type='text' name='$formName' value='$value' autocomplete='off' placeholder='".$this->CATEGORY_NS_PREFIX."...'/></div>\n";
	} // end getHtmlForCategoryBox()

	/**
	 * Prints results to the OutputPage provided, if there was a query for an intersection of categories. Otherwise
	 * prints some placeholder text.
	 *
	 * @param out - OutputPage to add HTML to.
	 */
	private function showResults($out){
		wfProfileIn( __METHOD__ );
		global $wgRequest, $wgServer, $wgScriptPath;

		$html = "";
		$html .= "<div class='ci_results'>\n";

			$html .= "<h2>". wfMsg('categoryintersection-results-title') ."</h2>\n";

			$submit = $wgRequest->getVal('wpSubmit');
			if(!empty($submit)){
				$limit = $wgRequest->getVal('limit', $this->defaultLimit);

				$categories = array();
				$keys = array_keys($_GET);
				foreach($keys as $key){
					if(startsWith($key, self::$CAT_PREFIX)){
						$cat = $wgRequest->getVal($key);
						if(!empty($cat)){
							$categories[] = $cat;

							if(!startsWith($cat, $this->CATEGORY_NS_PREFIX)){
								$html .= "<em>Warning: \"$cat\" does not start with \"{$this->CATEGORY_NS_PREFIX}\".</em><br/>\n";
							}
						}
					}
				}

				// Use the API to get actual results.
				$apiParams = array(
					'action' => 'query',
					'list' => 'categoryintersection',
					'limit' => $limit,
					'categories' => implode("|", $categories)
				);
				$apiData = ApiService::call($apiParams);
				if (empty($apiData)) {
					$RESULTS_FOUND = 0;
					$html .= "<em>".wfMsg('categoryintersection-summary', implode($categories, ", "), $limit, $RESULTS_FOUND)."</em>\n";
					$html .= "<em>". wfMsg('categoryintersection-noresults'). "</em>\n";
				} else {
					$articles = $apiData['query']['categoryintersection'];

					// Summary of the query and the results.
					$html .= "<small><em>".wfMsg('categoryintersection-summary', implode($categories, ", "), $limit, count($articles))."</em></small><br/>\n";

					$html .= "<ul>\n";
					foreach($articles as $articleData){
						$title = $articleData['title'];
						$titleObj = Title::newFromText($title);
						$html .= "<li><a href='".$titleObj->getFullURL()."'>$title</a></li>\n";
					}
					$html .= "</ul>\n";
				}

				// Display the URL that could be used to make that API call.
				$apiUrl = $wgServer.$wgScriptPath."/api.php?".http_build_query($apiParams);
				$apiUrl = strtr($apiUrl, array( // several of the very commonly used characters shouldn't be encoded (less confusing URL this way)
								"%3A" => ":",
								"%2F" => "/",
								"%7C" => "|"
							));
				$html .= "<br/><strong>" . wfMsg('categoryintersection-query-used') . "</strong><br/>\n";
				$html .= "<a href='$apiUrl'>$apiUrl</a>\n";
			} else {
				// TODO: Some placeholder text that explains that you should use the form on the left to make a query.
				// TODO: Some placeholder text that explains that you should use the form on the left to make a query.
			}

		$html .= "</div>\n";

		$out->addHTML( $html );

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
		global $wgServer, $wgScriptPath;

		$html = "";
		$html .= "<h2>" . wfMsg('categoryintersection-footer-title') . "</h2>";
		$html .= wfMsgExt('categoryintersection-footer-body', 'parse');

		// Examples will be an array of arrays where each sub-array contains items for a single example.
		$examples = array();

		// Examples are now kept in wikitext so that each wiki can have its own examples if it wishes.
		$exampleText = wfMsg('categoryintersection-footer-examples');
		$rawExamples = explode("\n\n", $exampleText);
		foreach($rawExamples as $singleExample){
			$items = explode("\n", trim($singleExample));
			if(count($items) > 0){
				$examples[] = $items;
			}
		}

		// Format and output the examples.
		$html .= "<ul>\n";
		foreach($examples as $exampleCategories){
			$readableCats = array();
			$queryParams = array(
				"wpSubmit" => "Example" // so that the page can detect that there was a request for API data
			);
			$catNum = 1;
			foreach($exampleCategories as $cat){
				$queryParams[self::$CAT_PREFIX . $catNum++] = $cat;
				if(startsWith($cat, $this->CATEGORY_NS_PREFIX)){
					$readableCats[] = substr($cat, strlen($this->CATEGORY_NS_PREFIX));
				} else {
					$readableCats[] = $cat;
				}
			}

			// Create URL
			$baseUrl = $this->getTitle()->getFullURL();
			$baseUrl .= ((strpos($baseUrl, "?")===false) ? "?" : "&" ); // first delimiter depends on whether there has been a '?' in the url already
			$link = $baseUrl . http_build_query($queryParams);

			// Create readable text
			$html .= "<li><a href='$link'>(". implode($readableCats, "), (") .")</a></li>\n";
		}
		$html .= "</ul>\n";

		$out->addHTML( $html );

		wfProfileOut( __METHOD__ );
	} // end showFooter()

} // end class SpecialCategoryIntersection
