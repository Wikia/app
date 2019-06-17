<?php
require_once __DIR__ . '/../Maintenance.php';
require_once( dirname( __FILE__ ) . '/../../includes/objectcache/BagOStuff.php' );
require_once( dirname( __FILE__ ) . '/../../includes/objectcache/MemcachedBagOStuff.php' );
require_once( dirname( __FILE__ ) . '/../../includes/objectcache/MemcachedPhpBagOStuff.php' );

class PurgeWikiCacheEverywhere extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addArg("memcachedServer", "Additional memcached server to purge. Defaults to prod.twemproxy.service.res.consul", false);
		$this->mDescription = 'Purges the WikiFactory ,Fastly cache and memcache of a single wiki';
	}

	public function execute() {
		global $wgCityId, $wgMemc;

		//config values
		$memCacheAlternativeServer = $this->getArg(0, 'prod.twemproxy.service.res.consul' );
		$prodKey = Wikia::wikiSurrogateKey( $wgCityId );
		$previewKey = 'staging-s1-wiki-' . $wgCityId;
		$verifyKey = 'staging-s2-wiki-' . $wgCityId;
		$key = "wikifactory:domains_by_city_id:".$wgCityId;

		//memcache purge
		$this->output( 'Purge memcache' );
		$wgMemc->delete( $key );
		WikiFactory::clearCache( $wgCityId );
		$mc = new MemcachedPhpBagOStuff(['servers' => [
			0 => $memCacheAlternativeServer . ':21000',
			1 => $memCacheAlternativeServer . ':31000',
		]]);
		$globalStateWrapper = new Wikia\Util\GlobalStateWrapper( [
			'wgMemc' => $mc
		] );
		$globalStateWrapper->wrap( function () use ( $wgCityId, $mc, $key ) {
			WikiFactory::clearCache( $wgCityId );
			$mc->delete( $key );
		} );

		//proxy purge
		$this->output( 'Purge prod surrogate keys' );
		Wikia::purgeSurrogateKey( $prodKey );
		Wikia::purgeSurrogateKey( $prodKey, 'mercury' );
		$this->output( 'Purge surrogate keys for preview' );
		Wikia::purgeSurrogateKey( $previewKey );
		Wikia::purgeSurrogateKey( $previewKey, 'mercury' );
		$this->output( 'Purge surrogate keys for verify' );
		Wikia::purgeSurrogateKey( $verifyKey );
		Wikia::purgeSurrogateKey( $verifyKey, 'mercury' );

		$this->output( 'Cache purged!' );
	}
}

$maintClass = 'PurgeWikiCacheEverywhere';
require_once RUN_MAINTENANCE_IF_MAIN;
