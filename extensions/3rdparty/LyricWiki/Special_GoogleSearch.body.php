<?php
////
// Author: Sean Colombo
// Date: 20080720
//
//
////

require_once 'extras.php';

class GoogleSearchResults extends SpecialPage
{
	function __construct()
	{
		parent::__construct("GoogleSearchResults");
	}

	function execute( $par )
	{
		$this->setHeaders();	// this is required for 1.7.1 to work

		global $wgOut,$wgRequest;

		// The search-form itself is actually located in 3 places (these should be combined somehow).  Here, Monobook.php (for the sidebar) and /htmlets/googlesearch2.html
		$wgOut->addHTML("
<form action=\"http://lyricwiki.org/Special:GoogleSearchResults\" id=\"cse-search-box\">
  <div>
    <input type=\"hidden\" name=\"cx\" value=\"partner-pub-7265006513689515:enbi50a4igp\" />
    <input type=\"hidden\" name=\"cof\" value=\"FORID:9\" />
    <input type=\"hidden\" name=\"ie\" value=\"UTF-8\" />
    <input type=\"text\" name=\"q\" size=\"16\" />
    <input type=\"submit\" name=\"sa\" value=\"Search\" />
  </div>
</form>
<script type=\"text/javascript\" src=\"http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en\"></script>


<div id=\"cse-search-results\"></div>
<script type=\"text/javascript\">
  var googleSearchIframeName = \"cse-search-results\";
  var googleSearchFormName = \"cse-search-box\";
  var googleSearchFrameWidth = 800;
  var googleSearchDomain = \"www.google.com\";
  var googleSearchPath = \"/cse\";
</script>
<script type=\"text/javascript\" src=\"http://www.google.com/afsonline/show_afs_search.js\"></script>
");
	} // end execute()

} // end class GoogleSearchResults

