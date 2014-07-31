<?php
class ArticleMetadataModelTest extends WikiaBaseTest {
	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		$this->setupFile = $dir . 'POI.setup.php';

		parent::setUp();
	}

	public function testReadData() {

		$propValue = ['quest_id' => 1,
						'fingerprints' => ['fa','fb','fc'],
						'map_region' => 3];



		$stub = $this->getMock('ArticleMetadataModel', ['getWikiaProp', 'setWikiaProp'], array(1));
		$stub->expects($this->any())->method('getWikiaProp')->willReturn($propValue);
		$stub->load();

		$this->assertEquals(1, $stub->getField('quest_id'), 'quest_id');
		$this->assertEquals(3, $stub->getField('map_region'), 'region');
		$this->assertTrue(is_array($stub->getField('fingerprints')), 'fingerprints');

		$meta = $stub->getMetadata();
		$this->assertEquals($meta['fingerprints'][1], $propValue['fingerprints'][1], 'fingerprint elem');
	}


	public function testSave() {
		$stub = $this->getMock('ArticleMetadataModel', ['getWikiaProp', 'setWikiaProp'], array(1));

		$propValue = ['quest_id' => 1,
						'fingerprints' => ['fa','fb','fc'],
						'map_region' => 3];

		$stub->expects($this->any())
				->method('setWikiaProp')
				->with(ArticleMetadataModel::article_prop_name, 1, $propValue);

		$stub->setField('quest_id', 1);
		$stub->setField('map_region', 3);
		$stub->addFingerprint('fa');
		$stub->addFingerprint('fb');
		$stub->addFingerprint('fc');

		$stub->save();
	}
}