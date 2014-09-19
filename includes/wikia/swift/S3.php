<?php

namespace Wikia\Swift\S3;

use Wikia\Swift\Entity\Container;
use Wikia\Swift\Entity\Remote;
use Wikia\Swift\Http\SimpleHttpGetRequest;
use Wikia\Swift\Net\Cluster;
use Wikia\Swift\Net\RandomDirector;

class Bucket {
	const HARD_ITEMS_LIMIT = 1e7;
	protected $cluster;
	protected $path;
	protected $items;

	public function __construct( Cluster $cluster, Container $container ) {
		$this->cluster = $cluster;
		$this->container = $container;
	}

	protected function load() {
		$container = $this->container->getName();
		$director = new RandomDirector($this->cluster);
		$url = "/{$container}?max-keys=".self::HARD_ITEMS_LIMIT;
		$http = new SimpleHttpGetRequest($director,$url);
		$contents = $http->execute();
		$this->parse($contents);
	}

	protected function parse( $contents ) {
		if (!preg_match("/^<\\?xml[^>]*><ListBucketResult[^>]*>/",$contents)) {
			throw new \Exception("Invalid response from server");
		}
		$items = array();
		if (preg_match_all("#<Contents>.*?<Key>(.*?)</Key>.*?<ETag>(.*?)</ETag>.*?<Size>(.*?)</Size>.*?</Contents>#",$contents,$m,PREG_SET_ORDER)) {
			foreach ($m as $r) {
				$r[1] = html_entity_decode($r[1],ENT_QUOTES|ENT_XML1);
				$items[$r[1]] = new Remote($r[1],trim(html_entity_decode($r[2]),'"'),intval($r[3]));
			}
		}
		$this->items = $items;
	}

	public function getItems() {
		if ( $this->items === null ) {
			$this->load();
		}
		return $this->items;
	}

}
