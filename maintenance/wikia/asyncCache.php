<?php
/**
 * asyncCache
 *
 * This script is a CLI interface to the AsyncCache class
 *
 */

putenv( 'SERVER_ID=177' );

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class AsyncCacheCLI
 */
class AsyncCacheCLI extends Maintenance {

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "A CLI interface to the AsyncCache class";

		$this->addOption( 'get', 'Get the value of a memc key', false, true, 'g' );
		$this->addOption( 'purge', 'Purge the value of a memc key', false, true, 'p' );

		$this->addOption( 'ttl', 'TTL for the cached value', false, true, 'l' );
		$this->addOption( 'neg-ttl', 'TTL for negative responses', false, true, 'n' );
		$this->addOption( 'regen-ttl', 'TTL for serving stale values', false, true, 'e' );

		$this->addOption( 'generate-method', 'Method to regenerate value', false, true, 'm' );
		$this->addOption( 'generate-args', 'Comma separated args for --generate-method', false, true, 'a' );

		$this->addOption( 'block', 'Block on value regeneration when cache is stale', false, false, 'b' );
	}

	public function execute() {

		if ( $this->hasOption( 'purge' ) ) {
			$cacheKey = $this->getOption( 'purge' );
			( new Wikia\Cache\AsyncCache() )->purge( $cacheKey );
			echo "Purged '$cacheKey'\n";
			exit(0);
		}

		$cacheKey   = $this->getOption( 'get' );

		$ttl      = $this->getOption( 'ttl', 300 );
		$negTTL   = $this->getOption( 'neg-ttl', 0 );
		$regenTTL = $this->getOption( 'regen-ttl', 60 );

		$block    = $this->hasOption( 'block' );

		$method = $this->getOption( 'generate-method', 'Wikia\Cache\AsyncCacheTestGenerator::getValue' );
		$args   = explode( ',', $this->getOption( 'generate-args', '' ) );

		$start = time();

		echo "\n";
		echo "Retrieving key '$cacheKey'\n";
		echo "\t- TTL: $ttl\n";
		echo "\t- Negative Response TTL: $negTTL\n";
		echo "\t- Time to regenerate: $regenTTL\n";
		echo "\t- Value regeneration method: $method(".implode(', ', $args).")\n";

		$cache = ( new Wikia\Cache\AsyncCache() )
			->key( $cacheKey )
			->ttl( $ttl )
			->negativeResponseTTL( $negTTL )
			->staleOnMiss( $regenTTL )
			->callback( $method, [ $args ] );

		if ( $block ) {
			$cache->blockOnMiss();
		}

		$value = $cache->value();

		echo "\n";

		if ( $cache->foundInCache() ) {
			echo "## Key found in cache\n";
			echo "-- TTL Remaining: " . $cache->ttlRemain() . "\n";
		}

		if ( $cache->isCacheStale() ) {
			echo "## Cache is stale\n";
			echo "-- Stale TTL Remaining: " . $cache->staleTTLRemain() . "\n";
		}

		if ( $cache->isTaskScheduled() ) {
			echo "## Regenerate task scheduled\n";
		}

		echo "VALUE: $value\n";

		echo "\nFinished in ".( time() - $start )." secs\n";
	}
}

$maintClass = "AsyncCacheCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

