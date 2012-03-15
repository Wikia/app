<?php 
require_once dirname(__FILE__) . '/../WikiaHomePage.setup.php';

class WikiaHomePageControllerTest extends WikiaBaseTest {
	
	/**
	 * @dataProvider getListDataProvider
	 */
	public function testGetList($mediaWikiMsg, $expectedStatus, $expectedResult, $expectedExceptionMsg) {
		$whpc = $this->getMock('WikiaHomePageController', array('getMediaWikiMessage'));
		$whpc
			->expects($this->any())
			->method('getMediaWikiMessage')
			->will($this->returnValue($mediaWikiMsg));
		$this->mockClass('WikiaHomePageController', $whpc);
		
		$response = $this->app->sendRequest('WikiaHomePageController', 'getList', array());
		
		$responseData = $response->getVal('data');
		$this->assertEquals($expectedResult, $responseData);
		
		$responseData = $response->getVal('exception');
		$this->assertEquals($expectedExceptionMsg, $responseData);
		
		$responseData = $response->getVal('status');
		$this->assertEquals($expectedStatus, $responseData);
	}
	
	public function getListDataProvider() {
		return array(
			array(																			//mediawiki msg is empty
				'', 
				false, 
				null, 
				wfMsg('wikia-home-parse-source-empty-exception')
			),
			array(																			//percentage in verticals' lines as a sum < 100%
				"*Gaming|50
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
*Entertainment|25
**Muppet Wiki|http://muppet.wikia.com|image|description", 
				false, 
				null, 
				wfMsg('wikia-home-parse-source-invalid-percentage')
			),
			array(																			//percentage in verticals' lines as a sum > 100%
				"*Gaming|60
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
*Entertainment|60
**Muppet Wiki|http://muppet.wikia.com|image|description", 
				false, 
				null, 
				wfMsg('wikia-home-parse-source-invalid-percentage')
			),
			array(																			//two parameters have to be set (seperated with a |) for a vertical (vertical name and percentage)
				"*Gaming
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
*Entertainment
**Muppet Wiki|http://muppet.wikia.com|image|description", 
				false, 
				null, 
				wfMsg('wikia-home-parse-vertical-invalid-data')
			),
			array(																			//at least three parameters have to be set (seperated with a |) for a wiki (wiki name, wiki url, wiki image)
				"*Gaming|50
**The Call of Duty Wiki
*Entertainment|50
**Muppet Wiki|http://muppet.wikia.com", 
				false, 
				null, 
				wfMsg('wikia-home-parse-wiki-too-few-parameters')
			),
			array(																			//percentage in verticals' lines as a sum incorrect after overriding a vertical
				"*Gaming|50
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
*Entertainment|50
**Muppet Wiki|http://muppet.wikia.com|image|description
*Gaming|250
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description", 
				false, 
				null, 
				wfMsg('wikia-home-parse-source-invalid-percentage')
			),
			array(																			//everything's OK
				"*Gaming|50
**The Call of Duty Wiki|http://callofduty.wikia.com/|image|description
*Entertainment|50
**Muppet Wiki|http://muppet.wikia.com|image|description", 
				true, 
				'[{"vertical":"gaming","percentage":50,"wikilist":[{"wikiname":"The Call of Duty Wiki","wikiurl":"http:\/\/callofduty.wikia.com\/","wikiimage":"image","wikidesc":"description","wikinew":false}]},{"vertical":"entertainment","percentage":50,"wikilist":[{"wikiname":"Muppet Wiki","wikiurl":"http:\/\/muppet.wikia.com","wikiimage":"image","wikidesc":"description","wikinew":false}]}]', 
				null
			),
			array(																			//everything's OK but data has spacebars here and there
				"    *Gaming|    50
            **The Call of Duty Wiki|   http://callofduty.wikia.com/   |    image    |     description     
                           *          Entertainment       |    50
                      **          Muppet Wiki       |    http://muppet.wikia.com       |    image        |      description      ", 
				true, 
				'[{"vertical":"gaming","percentage":50,"wikilist":[{"wikiname":"The Call of Duty Wiki","wikiurl":"http:\/\/callofduty.wikia.com\/","wikiimage":"image","wikidesc":"description","wikinew":false}]},{"vertical":"entertainment","percentage":50,"wikilist":[{"wikiname":"Muppet Wiki","wikiurl":"http:\/\/muppet.wikia.com","wikiimage":"image","wikidesc":"description","wikinew":false}]}]', 
				null
			),
		);
	}
	
}