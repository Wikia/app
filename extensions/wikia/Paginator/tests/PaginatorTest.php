<?php

class MessageMock {
	public function escaped() {
		return 'escaped-msg';
	}
}

class PaginatorTest extends WikiaBaseTest {

	private $alphabet = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';

	private $htmlPage13of13Selected = '
				<li><a href="http://url/?page=12" data-back="true" data-page="12" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=10" data-back="true" data-page="10" class="paginator-page">10</a></li>
				<li><a href="http://url/?page=11" data-back="true" data-page="11" class="paginator-page">11</a></li>
				<li><a href="http://url/?page=12" data-back="true" data-page="12" class="paginator-page">12</a></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page active">13</a></li>
				<li><span class="paginator-next disabled"><span>escaped-msg</span></span></li>
			';

	private $htmlPage12of13Selected = '
				<li><a href="http://url/?page=11" data-back="true" data-page="11" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=9" data-back="true" data-page="9" class="paginator-page">9</a></li>
				<li><a href="http://url/?page=10" data-back="true" data-page="10" class="paginator-page">10</a></li>
				<li><a href="http://url/?page=11" data-back="true" data-page="11" class="paginator-page">11</a></li>
				<li><a href="http://url/?page=12" data-page="12" class="paginator-page active">12</a></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage10of13Selected = '
				<li><a href="http://url/?page=9" data-back="true" data-page="9" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=7" data-back="true" data-page="7" class="paginator-page">7</a></li>
				<li><a href="http://url/?page=8" data-back="true" data-page="8" class="paginator-page">8</a></li>
				<li><a href="http://url/?page=9" data-back="true" data-page="9" class="paginator-page">9</a></li>
				<li><a href="http://url/?page=10" data-page="10" class="paginator-page active">10</a></li>
				<li><a href="http://url/?page=11" data-page="11" class="paginator-page">11</a></li>
				<li><a href="http://url/?page=12" data-page="12" class="paginator-page">12</a></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=11" data-page="11" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage7of13Selected = '
				<li><a href="http://url/?page=6" data-back="true" data-page="6" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=4" data-back="true" data-page="4" class="paginator-page">4</a></li>
				<li><a href="http://url/?page=5" data-back="true" data-page="5" class="paginator-page">5</a></li>
				<li><a href="http://url/?page=6" data-back="true" data-page="6" class="paginator-page">6</a></li>
				<li><a href="http://url/?page=7" data-page="7" class="paginator-page active">7</a></li>
				<li><a href="http://url/?page=8" data-page="8" class="paginator-page">8</a></li>
				<li><a href="http://url/?page=9" data-page="9" class="paginator-page">9</a></li>
				<li><a href="http://url/?page=10" data-page="10" class="paginator-page">10</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=8" data-page="8" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage4of13Selected = '
				<li><a href="http://url/?page=3" data-back="true" data-page="3" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><a href="http://url/?page=2" data-back="true" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-back="true" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page active">4</a></li>
				<li><a href="http://url/?page=5" data-page="5" class="paginator-page">5</a></li>
				<li><a href="http://url/?page=6" data-page="6" class="paginator-page">6</a></li>
				<li><a href="http://url/?page=7" data-page="7" class="paginator-page">7</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=5" data-page="5" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage2of13Selected = '
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-page active">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><a href="http://url/?page=5" data-page="5" class="paginator-page">5</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage1of13Selected = '
				<li><span class="paginator-prev disabled"><span>escaped-msg</span></span></li>
				<li><a href="http://url/?page=1" data-page="1" class="paginator-page active">1</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage1of13Selected1 = '
				<li><span class="paginator-prev disabled"><span>escaped-msg</span></span></li>
				<li><a href="http://url/?page=1" data-page="1" class="paginator-page active">1</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><span class="paginator-spacer">...</span></li>
				<li><a href="http://url/?page=13" data-page="13" class="paginator-page">13</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $alphabet2 = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z';

	private $htmlPage4of4Selected = '
				<li><a href="http://url/?page=3" data-back="true" data-page="3" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><a href="http://url/?page=2" data-back="true" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-back="true" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page active">4</a></li>
				<li><span class="paginator-next disabled"><span>escaped-msg</span></span></li>
			';

	private $htmlPage3of4Selected = '
				<li><a href="http://url/?page=2" data-back="true" data-page="2" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><a href="http://url/?page=2" data-back="true" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page active">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage2of4Selected = '
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-prev button secondary"><span>escaped-msg</span></a></li>
				<li><a href="http://url/?page=1" data-back="true" data-page="1" class="paginator-page">1</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-page active">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	private $htmlPage1of4Selected = '
				<li><span class="paginator-prev disabled"><span>escaped-msg</span></span></li>
				<li><a href="http://url/?page=1" data-page="1" class="paginator-page active">1</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-page">2</a></li>
				<li><a href="http://url/?page=3" data-page="3" class="paginator-page">3</a></li>
				<li><a href="http://url/?page=4" data-page="4" class="paginator-page">4</a></li>
				<li><a href="http://url/?page=2" data-page="2" class="paginator-next button secondary"><span>escaped-msg</span></a></li>
			';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/Paginator/Paginator.setup.php";
		parent::setUp();

		$this->mockGlobalFunction( 'wfMessage', new MessageMock() );
	}

	private function casesForEdgeBehavior() {
		return [
			// Pages beyond the last one will still display the last one
			[ 8, $this->alphabet, 5, 'y,z', $this->htmlPage4of4Selected ],
			[ 8, $this->alphabet, 6, 'y,z', $this->htmlPage4of4Selected ],
			[ 8, $this->alphabet, 100, 'y,z', $this->htmlPage4of4Selected ],

			// Page 0, -1, -2, -100 acts the same as 1
			[ 8, $this->alphabet, 0, 'a,b,c,d,e,f,g,h', $this->htmlPage1of4Selected ],
			[ 8, $this->alphabet, -1, 'a,b,c,d,e,f,g,h', $this->htmlPage1of4Selected ],
			[ 8, $this->alphabet, -2, 'a,b,c,d,e,f,g,h', $this->htmlPage1of4Selected ],
			[ 8, $this->alphabet, -100, 'a,b,c,d,e,f,g,h', $this->htmlPage1of4Selected ],
		];
	}

	private function casesForStandardUse() {
		return [
			// Pages 1...4
			[ 8, $this->alphabet, 1, 'a,b,c,d,e,f,g,h', $this->htmlPage1of4Selected ],
			[ 8, $this->alphabet, 2, 'i,j,k,l,m,n,o,p', $this->htmlPage2of4Selected ],
			[ 8, $this->alphabet, 3, 'q,r,s,t,u,v,w,x', $this->htmlPage3of4Selected ],
			[ 8, $this->alphabet, 4, 'y,z', $this->htmlPage4of4Selected ],

			// More pages, check the ellipsis behavior
			[ 4, $this->alphabet2, 1, 'a,b,c,d', $this->htmlPage1of13Selected ],
			[ 4, $this->alphabet2, 2, 'e,f,g,h', $this->htmlPage2of13Selected ],
			[ 4, $this->alphabet2, 4, 'm,n,o,p', $this->htmlPage4of13Selected ],
			[ 4, $this->alphabet2, 7, 'y,z,A,B', $this->htmlPage7of13Selected ],
			[ 4, $this->alphabet2, 10, 'K,L,M,N', $this->htmlPage10of13Selected ],
			[ 4, $this->alphabet2, 12, 'S,T,U,V', $this->htmlPage12of13Selected ],
			[ 4, $this->alphabet2, 13, 'W,X,Y,Z', $this->htmlPage13of13Selected ],

			// One page only -> no pagination, page number ignored
			[ 10, 'a,b,c,d', 10, 'a,b,c,d', '' ],
			[ 10, 'a,b,c,d', 1, 'a,b,c,d', '' ],
			[ 10, 'a,b,c,d', -100, 'a,b,c,d', '' ],
			[ 4, 'a,b,c,d', 1, 'a,b,c,d', '' ],
			[ 4, '', 1, '', '' ],

			// Min per-page is 4:
			[ 3, 'a,b,c,d', 1, 'a,b,c,d', '' ],
			[ 2, 'a,b,c,d', 1, 'a,b,c,d', '' ],
		];
	}

	public function dataProviderCallStyle1() {
		return array_merge(
			$this->casesForStandardUse(),
			$this->casesForEdgeBehavior()
		);
	}

	public function dataProviderCallStyle2() {
		return array_merge(
			$this->casesForStandardUse()
		);
	}

	/**
	 * Test the basic API of the class, style #1 of using it
	 *
	 * Create an object of Paginator using Paginator::newFromArray and then set an active page
	 * number and get the current slice of the input array using Paginator::getPage and then
	 * generate the HTML for the pagination bar by Paginator::getBarHTML
	 *
	 * This style of calling the class is used by:
	 *
	 *  * CategoryExhibitionSection
	 *  * CategoryExhibitionSection
	 *  * CrunchyrollVideo
	 *
	 *
	 * @dataProvider dataProviderCallStyle1
	 */
	public function testCallStyle1( $itemsPerPage, $allDataString, $pageNo, $pageDataString, $expectedHtml ) {
		$url = 'http://url/?page=%s';
		$allData = explode( ',', $allDataString );
		$expectedPageData = explode( ',', $pageDataString );
		$pages = Paginator::newFromArray( $allData, $itemsPerPage );
		$onePageData = $pages->getPage( $pageNo, true );
		$html = $pages->getBarHTML( $url );
		$this->assertEquals( $expectedPageData, $onePageData );
		$this->assertHtmlEquals( $expectedHtml, $html );
	}

	/**
	 * Test the basic API of the class, style #2 of using it
	 *
	 * Create an object of Paginator using Paginator::newFromArray and then set an active page
	 * number using Paginator::setActivePage and then generate the HTML for the pagination bar
	 * by Paginator::getBarHTML + generate the head item with rel="prev/next" links
	 *
	 * This style of calling the class is used by:
	 *
	 *  * InsightsPaginator
	 *  * ManageWikiaHomeController
	 *  * UserActivity\SpecialController
	 *  * SpecialVideosHelper
	 *
	 * @dataProvider dataProviderCallStyle2
	 */
	public function testCallStyle2( $itemsPerPage, $allDataString, $pageNo, $pageDataString, $expectedHtml ) {
		$url = 'http://url/?page=%s';
		$allData = explode( ',', $allDataString );
		$pages = Paginator::newFromArray( $allData, $itemsPerPage );
		$pages->setActivePage( $pageNo - 1 );
		$html = $pages->getBarHTML( $url );
		$this->assertHtmlEquals( $expectedHtml, $html );
	}

	private function assertHtmlEquals( $expectedHtml, $actualHtml ) {
		if ( $expectedHtml ) {
			$expectedHtml = "<div class=\"wikia-paginator\">\n<ul>$expectedHtml</ul>\n</div>";
		}
		$this->assertEquals(
			array_map( 'trim', explode( "\n", str_replace( '" >', '">', preg_replace( '/ {2,}/', ' ', trim( $expectedHtml ) ) ) ) ),
			array_map( 'trim', explode( "\n", str_replace( '" >', '">', preg_replace( '/ {2,}/', ' ', trim( $actualHtml ) ) ) ) )
		);
	}
}
