<?php
/**
 * MemcacheClientShadower
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class MemcacheClientShadower extends MemCachedClientforWiki {
	const KEY_SUFFIX = ':shadow';
	private $shadow;

	public function __construct($args) {
		parent::__construct($args);
		$this->shadow = new MemcacheMoxiCluster($args);
	}

	public function get($key) {
		$this->shadow->get($key);
		return parent::get($key);
	}
}