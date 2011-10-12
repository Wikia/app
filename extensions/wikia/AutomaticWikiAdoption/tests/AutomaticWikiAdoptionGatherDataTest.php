<?php
global $wgAutoloadClasses, $IP;
$wgAutoloadClasses['AutomaticWikiAdoptionGatherData']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php';

class AutomaticWikiAdoptionGatherDataTest extends PHPUnit_Framework_TestCase {
	private $dataMapper;

	/**
	 * Script can do 3 actions, this tests all three
	 * @dataProvider maintenanceScriptDataProvider
	 */
	
	function testMaintenanceScript($action, $id, $days, $jobArgs) {
		
		$wikiData = array(
					'recentEdit' => strtotime('-' . $days . ' days'),
					'admins' => array(1,2,3)
				);
		
		$mock = $this->getMock('AutomaticWikiAdoptionGatherData', array('getRecentAdminEdits', 'getMaxWikiId', $action));
		$mock->expects($this->once())
				->method('getRecentAdminEdits')
				->will($this->returnValue(array($id => $wikiData)));

		$mock->expects($this->once())
				->method('getMaxWikiId')
				->will($this->returnValue(263000));
		
		$mock->expects($this->once())
				->method($action) //'setAdoptionFlag' or 'sendEmail'
				->with($this->anything(), $this->equalTo($jobArgs), $this->equalTo($id), $this->equalTo($wikiData));
		
		$mock->run(array('quiet'=>1));
	}
	
	function maintenanceScriptDataProvider() {
		return array(
			array('sendMail', 4, 46, array('mailType' => 'first')),
			array('sendMail', 4, 59, array('mailType' => 'second')),
			array('setAdoptionFlag', 4, 61, array())
		);
	}
}
