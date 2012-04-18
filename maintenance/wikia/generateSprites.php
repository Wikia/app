<?php
/*
 * This script generates sprites used in edit pages
 * Run like: sudo SERVER_ID=177 php generateSpriteSheet.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/.." );

$optionsWithArgs = array(
	'sprite',
);
require_once( "commandLine.inc" );


class SpriteGeneratorMaintenance {

	protected $configLoaded = false;
	protected $config = array();
	protected $name = null;

	public function __construct( $options ) {
		if (@$options['sprite']) {
			$this->name = $options['sprite'];
		}
	}

	public function getConfig() {
		if (!$this->configLoaded) {
			global $IP;
			$config = array();
			require "$IP/config/wikia/sprites.php";
			if (is_array($config)) {
				$this->config = $config;
			}
			$this->configLoaded = true;
		}
		return $this->config;
	}

	public function generate( $name ) {
		echo "Generating sprite and stylesheet: $name...\n";
		$configAll = $this->getConfig();
		if (!isset($configAll[$name])) {
			echo "  failed: configuration doesn't exist.\n";
			return false;
		}
		$settings = $configAll[$name];
		$conservative = isset($settings['conservative']) && $settings['conservative'];

		try {
//			var_dump($settings);
			$spriteService = new SpriteService($settings);
//var_dump($spriteService);
			$spriteService->process($conservative);
			echo "  ...done.\n";
		} catch (Exception $e) {
			echo "  failed: " . $e->getMessage() . "\n";
			return false;
		}
		return true;
	}
	
	public function execute() {
		if ($this->name) {
			$this->generate($this->name);
		} else {
			$configAll = $this->getConfig();
			foreach ($configAll as $name => $config)
				$this->generate($name);
		}
	}

}

$maintenance = new SpriteGeneratorMaintenance( $options );
$maintenance->execute();

//$dir = dirname(__FILE__);
//echo $dir ."\n";

$dir = "$IP/extensions/wikia/EditPageLayout";

$srv = new SpriteService(array(
	'name' => 'edit-page',
	'source' => "{$dir}/images/sprite-edit-page/",
	'sprite' => "{$dir}/images/sprite-edit-page.png",
	'scss' => "{$dir}/css/mixins/_sprite-edit-page.scss",
));

$srv->process(false);

SpriteService::newStandard(
	'page-layout-builder',
	"$IP/extensions/wikia/PageLayoutBuilder"
)->process(false);

/*
$dir = realpath( "$IP/extensions/wikia/EditPageLayout" );
$srv = new SpriteService(array(
	'name' => 'edit-page',
	'source' => $dir.'/images/sprite-edit-page/',
	'sprite' => $dir.'/images/sprite-edit-page.png',
	'scss' => $dir.'/css/_sprite-edit-page.scss',
));
$srv->process();

$dir = realpath( "$IP/extensions/wikia/PageLayoutBuilder" );
$srv = new SpriteService(array(
	'name' => 'page-layout-builder',
	'source' => $dir.'/images/sprite-page-layout-builder/',
	'sprite' => $dir.'/images/sprite-page-layout-builder.png',
	'scss' => $dir.'/css/_sprite-page-layout-builder.scss',
));
$srv->process();
*/
