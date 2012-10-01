<?php

require_once( 'WikiaSearchBaseTest.php' );

/* TODO

<?xml version="1.0" encoding="utf-8"?><search-results version="7.0"><error description="User-agent not passed as part of users headers | (Mozilla/5.0(Macintosh;IntelMacOSX10_7_4)AppleWebKit/536.5(KHTML,likeGecko)Chrome/19.0.1084.56Safari/536.5)" /></search-results>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>403 - Forbidden: Access is denied.</title>
<style type="text/css">
<!--
body{margin:0;font-size:.7em;font-family:Verdana, Arial, Helvetica, sans-serif;background:#EEEEEE;}
fieldset{padding:0 15px 10px 15px;} 
h1{font-size:2.4em;margin:0;color:#FFF;}
h2{font-size:1.7em;margin:0;color:#CC0000;} 
h3{font-size:1.2em;margin:10px 0 0 0;color:#000000;} 
#header{width:96%;margin:0 0 0 0;padding:6px 2% 6px 2%;font-family:"trebuchet MS", Verdana, sans-serif;color:#FFF;
background-color:#555555;}
#content{margin:0 0 0 2%;position:relative;}
.content-container{background:#FFF;width:96%;margin-top:8px;padding:10px;position:relative;}
-->
</style>
</head>
<body>
<div id="header"><h1>Server Error</h1></div>
<div id="content">
 <div class="content-container"><fieldset>
  <h2>403 - Forbidden: Access is denied.</h2>
  <h3>You do not have permission to view this directory or page using the credentials that you supplied.</h3>
 </fieldset></div>
</div>
</body>
</html>

*/

class WikiaSearchAdsTest extends WikiaSearchBaseTest {

	private $raw_search_results = '<?xml version="1.0" encoding="utf-8"?><search-results search-type="by-relevance" version="7.0"><details><input-query>cars</input-query><anti-phrase>cars</anti-phrase><adult>false</adult><navigational>false</navigational><marketingnavigational>false</marketingnavigational></details><collection query="cars" origin="explicit"><group category="web" group-by="relevance" type="main"><details><paid-links>6</paid-links><unpaid-links>0</unpaid-links><max-count>0</max-count></details><group group-by="relevance"><details><results-count>0</results-count><results-start>0</results-start><results-end>0</results-end></details></group></group><group category="web" group-by="relevance" type="extra-cat" region="top"><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.hyundaiusa.com%2f2013-Cars&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dL%26ai%3dCBZRir5_GT7-rBqqziAKbsIDPBd_TieIC37HOsTOQx8oFEAEgitfYGygGULCqi838_____wFgyQaIAQHIAQGqBBpP0BTbbLPTZRZJ1G8Z8YjfivPbIbFD0rgXGA%26num%3d1%26sig%3dAOD64_3X_GgWZzYlX5MaSOL3zmvYwDPbrQ%26adurl%3dhttp%3a%2f%2fclk.atdmt.com%2fIWC%2fgo%2f388506240%2fdirect%2f01%2f&amp;ld=20120530&amp;ap=1&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=1&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=1&amp;mid=9&amp;hash=C8BD07595FAB47E48C14E5A66E6ACE95</site-link><paid>true</paid><display-url>http://www.hyundaiusa.com/2013-Cars/</display-url><title>2013 Hyundai® &lt;strong&gt;Cars&lt;/strong&gt; </title><description>Considering a New &lt;strong&gt;Car&lt;/strong&gt;? Discover the Hyundai® Veloster Turbo Today!  </description></result><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.dodge.com%2fAvenger&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dl%26ai%3dC2rTyr5_GT7-rBqqziAKbsIDPBfLpt5MEotGWvEeVzu0FEAIgitfYGygGUKWW6rEDYMkGiAEBoAH2i4raA8gBAaoEH0_QFNtss9NmHkkkbA4J6RTuw9Fo6wY4X96X9c2vK5E%26num%3d2%26sig%3dAOD64_2PG1QuSmdm2UcqVRWz6VCAV0RHyA%26adurl%3dhttp%3a%2f%2fclickserve.us2.dartsearch.net%2flink%2fclick%253Flid%253D43000000142419630%2526ds_s_kwgid%253D58000000001742153%2526ds_e_adid%253D19093914106%2526ds_e_matchtype%253Dsearch%2526ds_url_v%253D2&amp;ld=20120530&amp;ap=2&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=2&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=2&amp;mid=9&amp;hash=43597FDE387C397B7D41EC90CCC1D4E8</site-link><paid>true</paid><display-url>http://www.dodge.com/Avenger/</display-url><title>The 2012 Dodge® Avenger </title><description>Locate A Dodge Dealer Near You &amp; Find Out Deals On The New Avenger!  </description></result><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.cars.com%2f&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dL%26ai%3dC4WKOr5_GT7-rBqqziAKbsIDPBajI0PkB-OKUlCPIguSFARADIIrX2BsoBlCXpKCGAmDJBogBAcgBAaoEGU_QVPjFqchcL4Ae_QTYYxlQI0LiNy9Z-to%26num%3d3%26sig%3dAOD64_1UHK3KskJw7uGut3xa_SEyCBERHQ%26adurl%3dhttp%3a%2f%2fwww.cars.com%2fgo%2findex.jsp%253FKNC%253DLedGogBRDnsNmmNAP%2526aff%253Dgogsema%2526jadid%253D9350919984%2526jk%253Dcars.%2526js%253D1%2526jmt%253D1_e_%2526jp%253D%2526jkId%253D8a8ae4cd34f320c0013511856e432e61%2526jt%253D1%2526jsid%253D24398%2526mkwid%253Dsh5trZnDQ_pcrid_9350919984_pmt_e_pkw_cars.%2526pse%253Dgoogle&amp;ld=20120530&amp;ap=3&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=3&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=3&amp;mid=9&amp;hash=87448E7C3D53550A9E0B17379EE8461A</site-link><paid>true</paid><display-url>http://www.cars.com/</display-url><title>&lt;strong&gt;Cars&lt;/strong&gt;.com™ Official Site </title><description>&lt;strong&gt;Car&lt;/strong&gt; Listings, Prices and Reviews. Shop with Confidence at &lt;strong&gt;Cars&lt;/strong&gt;.com™  </description></result><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.autotrader.com%2f&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dL%26ai%3dCLad2r5_GT7-rBqqziAKbsIDPBbTOzssC1N-HqyD8qPAEEAQgitfYGygGUOPb3uz6_____wFgyQaIAQHIAQGqBBxP0BTJ4KnPXC-AHsFVvVkZUCNC4jcvWfran1y6%26num%3d4%26sig%3dAOD64_0bVL8zKE43b3DjwmEBXWe9V25djg%26adurl%3dhttp%3a%2f%2ftrack.searchignite.com%2fsi%2fcm%2ftracking%2fclickredirect.aspx%253Fsiplacement%253D%2526simobile%253D%2526sinetwork%253Ds%2526sicontent%253D0%2526sicreative%253D8586593820%2526sitrackingid%253D261042037&amp;ld=20120530&amp;ap=4&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=4&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=4&amp;mid=9&amp;hash=49F800496BEC7DE355EBFFC0843BF4AC</site-link><paid>true</paid><display-url>http://www.autotrader.com/</display-url><title>AutoTrader.com® </title><description>Find &lt;strong&gt;Cars&lt;/strong&gt; For Sale In Your Area. Compare Millions of Listings Now!  </description></result><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.honda.com%2fcertified&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dl%26ai%3dCLQRFr5_GT7-rBqqziAKbsIDPBc-XhNMDl4nbsjbhk9YOEAUgitfYGygGUM2Ii-QHYMkGiAEBoAGpzIDkA8gBAaoEHE_QZJGEqc5cL4Ae-hrgUBlQI0LiNy9Z-tqfXLo%26num%3d5%26sig%3dAOD64_01oczfWuNRjC2XUqYkdPR59Sxi1w%26adurl%3dhttp%3a%2f%2fpixel.everesttech.net%2f1097%2fcq%253Fev_sid%253D3%2526ev_ln%253Dcars%252520used%2526ev_crx%253D14502552463%2526ev_mt%253Db%2526ev_n%253Ds%2526ev_ltx%253D%2526ev_pl%253D%2526url%253Dhttp%25253A%2f%2fwww.honda.com%2fgoogle&amp;ld=20120530&amp;ap=5&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=5&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=5&amp;mid=9&amp;hash=0106A5699A2C1F8BD9098506E54CFFE0</site-link><paid>true</paid><display-url>http://www.honda.com/certified/</display-url><title>Used Honda in Your Area </title><description>Everything you expect from Honda. See local Honda inventory &amp; prices.  </description></result><result><site-link>http://click.infospace.com/ClickHandler.ashx?du=www.carbargainsweekly.com%2fCheap_Cars&amp;ru=http%3a%2f%2fwww.google.com%2faclk%3fsa%3dl%26ai%3dChwqyr5_GT7-rBqqziAKbsIDPBa6OmcIC3u2exSb3jdIFEAYgitfYGygGULqhjOkCYMkGiAEBoAGW25DxA8gBAaoEH0_QVPjFqc1cL8gebA4JzQe69dFo6wY4X96X9c2vK5M%26num%3d6%26sig%3dAOD64_3QzmS6KuiiV-tUTliVqyLbK67nrw%26adurl%3dhttp%3a%2f%2fwww.carbargainsweekly.com%2f%253Fsc1%253D5845030%2526sc2%253D40000%2526&amp;ld=20120530&amp;ap=6&amp;app=1&amp;c=wikiag&amp;s=wikiag&amp;coi=245874&amp;cop=topnav&amp;euip=10.10.10.10&amp;npp=0&amp;p=1&amp;pp=6&amp;pvaid=d96418a6079e4f349a39c3995feef9f9&amp;ep=6&amp;mid=9&amp;hash=E59313CB3C0D120A66431EA68D579759</site-link><paid>true</paid><display-url>http://www.carbargainsweekly.com/Cheap_Cars/</display-url><title>&lt;strong&gt;Cars&lt;/strong&gt; For Cheap </title><description>Find Cheap &lt;strong&gt;Cars&lt;/strong&gt; For Sale! Get Free Qutoes From Local Dealers.  </description></result></group></collection></search-results>';

	private $raw_search_results_broken = 'foo bar baz';

	private $url_params = array('camera', '127.0.0.1', 'Mozilla/4.0');
	private $url_result = 'http://wikia.infospace.com/wikiagy/wsapi/results?query=camera&category=web&resultsBy=relevance&enduserip=127.0.0.1&X-Insp-User-Headers=User-Agent%3AMozilla%2F4.0&family-friendly=on&bold=on&qi=1';

	public function testGetAds() {
		$controllerStub = $this->getMock('WikiaSearchAdsController', array('getSearchResults'));
		$controllerStub->expects($this->any())
						->method('getSearchResults')
						->will($this->returnValue($this->raw_search_results));
		F::setInstance('WikiaSearchAdsController', $controllerStub);
		$this->mockApp();

		$response = $this->app->sendRequest('WikiaSearchAdsController', 'getAds');

		$responseData = $response->getVal('ads');
		
		$this->assertInternalType( 'array', $responseData );
		$this->assertEquals( 6, count($responseData) ); // we don't have assertCount
		
		foreach ($responseData as $e) {
			foreach (array('site-link', 'paid', 'display-url', 'title', 'description') as $param) {
				$this->assertNotEmpty($e[$param]);
			}
		}
		
		foreach ($responseData as $e) {
			$this->assertEquals('true', $e['paid']); // assertTrue won't work, it's a string, not a bool
		}

		F::unsetInstance('WikiaSearchAdsController');
	}

	public function testBrokenXML() {
		$controllerStub = $this->getMock('WikiaSearchAdsController', array('getSearchResults'));
		$controllerStub->expects($this->any())
						->method('getSearchResults')
						->will($this->returnValue($this->raw_search_results_broken));
		F::setInstance('WikiaSearchAdsController', $controllerStub);
		$this->mockApp();

		$response = $this->app->sendRequest('WikiaSearchAdsController', 'getAds');

		$responseData = $response->getVal('ads');
		
		$this->assertInternalType( 'array', $responseData );
		$this->assertEquals( 0, count($responseData) ); // we don't have assertCount

		F::unsetInstance('WikiaSearchAdsController');
	}

	public function _testBackend() {
		$this->markTestSkipped('FIXME: mock post data');

		$this->mockApp();

		$response = $this->app->sendRequest('WikiaSearchAdsController', 'getAds');

		$responseData = $response->getVal('ads');
		
		$this->assertInternalType( 'array', $responseData );
		$this->assertEquals( 6, count($responseData) ); // we don't have assertCount
	}
	
	public function testGetURL() {
		$this->mockApp();

		//$response = $this->app->sendRequest('WikiaSearchAdsController', 'getUrl');

		$responseData = WikiaSearchAdsController::getURL();

		$this->assertInternalType( 'string', $responseData );
		$this->assertEmpty( $responseData );

		$responseData = WikiaSearchAdsController::getURL($this->url_params[0], $this->url_params[1], $this->url_params[2]);

		$this->assertInternalType( 'string', $responseData );
		$this->assertEquals( $this->url_result, $responseData );

		$responseData = WikiaSearchAdsController::getURL('foo', 'bar', 'baz');

		$this->assertInternalType( 'string', $responseData );
		$this->assertNotEquals( $this->url_result, $responseData );
		
	}

	public function testGetPartnerId() {
		$this->mockApp();

		$this->assertEquals( 'wikiagy', WikiaSearchAdsController::getPartnerId() );

		global $wgInfospaceSearchSub_IDS;
		$wgInfospaceSearchSub_IDS = 42;
		$this->assertEquals( 'wikiagy_42', WikiaSearchAdsController::getPartnerId() );

		$wgInfospaceSearchSub_IDS = null;
		$this->assertEquals( 'wikiagy', WikiaSearchAdsController::getPartnerId() );
	}
}
