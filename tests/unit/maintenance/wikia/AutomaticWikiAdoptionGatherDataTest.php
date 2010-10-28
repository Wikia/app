<?php
global $wgAutoloadClasses, $IP;
$wgAutoloadClasses['AutomaticWikiAdoptionGatherData']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php';
$wgAutoloadClasses['AutomaticWikiAdoptionGatherDataMapper']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherDataMapper.php';
$wgAutoloadClasses['AutomaticWikiAdoptionJobSendMail']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionJobSendMail.php';
$wgAutoloadClasses['AutomaticWikiAdoptionJobSetAdoptionFlag']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionJobSetAdoptionFlag.php';
$wgAutoloadClasses['AutomaticWikiAdoptionJobFactory']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionJobFactory.php';

class AutomaticWikiAdoptionGatherDataTest extends PHPUnit_Framework_TestCase {
	private $dataMapper;

	/**
	 * set flag when wiki has < 1000 articles and all of sysops have not edited for more than 30 days
	 * @dataProvider ensureFlagIsSetDataProvider
	 */
	function testEnsureFlagIsSet($days, $jobName, $jobArgs) {
		$wikiData = array(
					'recentEdit' => strtotime('-' . $days . ' days'),
					'admins' => array(1,2,3)
				);
		$dataMapper = $this->getMock('AutomaticWikiAdoptionGatherDataMapper');
		$dataMapper->expects($this->once())
			->method('getData')
			->will($this->returnValue(array(
				4 => $wikiData
			)));
		$this->dataMapper = $dataMapper;
		$jobArgs['dataMapper'] = $dataMapper;

		$job = $this->getMock('AutomaticWikiAdoptionJobSetAdoptionFlag');
		$job->expects($this->once())
			->method('execute')
			->with($this->anything(), $this->equalTo($jobArgs), $this->equalTo(4), $this->equalTo($wikiData));

		$factory = $this->getMock('AutomaticWikiAdoptionJobFactory');
		$factory->expects($this->once())
			->method('produce')
			->with($jobName)
			->will($this->returnValue($job));

		$task = new AutomaticWikiAdoptionGatherData();
		$task->setDataMapper($dataMapper);
		$task->setJobFactory($factory);
		$task->run(array('quiet'=>1));
	}

	function ensureFlagIsSetDataProvider() {
		return array(
			array(16, 'AutomaticWikiAdoptionJobSendMail', array('mailType' => 'first')),
			array(29, 'AutomaticWikiAdoptionJobSendMail', array('mailType' => 'second')),
			array(31, 'AutomaticWikiAdoptionJobSetAdoptionFlag', array())
		);
	}
}