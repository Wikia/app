<?php

namespace Wikia\Swift\Net;

class Host {

	protected $cluster;
	protected $hostname;
	protected $authConfig;

	protected $active = true;
	protected $token;
	protected $storageUrl;

	public function __construct( Cluster $cluster, $hostname, $authConfig ) {
		$this->cluster = $cluster;
		$this->hostname = $hostname;
		$this->authConfig = $authConfig;
	}

	public function getHostname() { return $this->hostname; }
	public function getAuthConfig() { return $this->authConfig; }

	public function isActive() { return $this->active; }
	public function getToken() { return $this->token; }
	public function getUrl() { return $this->storageUrl; }

	public function setCredentials( $token, $storageUrl ) {
		$this->token = $token;
		$this->storageUrl = $storageUrl;
	}

	public function setActive( $state ) {
		$this->active = $state;
		$this->cluster->onHostStatusChange( $this );
	}

}

class Cluster {

	protected $name;
	protected $hostnames;
	protected $authConfig;

	protected $hosts = array();
	protected $active = array();

	public function __construct( $name, $hostnames, $authConfig ) {
		$this->name = $name;
		$this->hostnames = $hostnames;
		$this->authConfig = $authConfig;

		$this->init();
	}

	protected function init() {
		foreach ($this->hostnames as $hostname) {
			$authConfig = $this->authConfig;
			array_walk( $authConfig, function( &$v, $k, $data ) { $v = sprintf( $v, $data ); }, $hostname );
			$this->hosts[$hostname] = new Host($this,$hostname,$authConfig);
		}

		// perform authentication
		$auth = new SimpleHostAuthentication($this->hosts);
		$auth->authenticate();

		$this->active = $this->hosts;
	}

	public function getName() { return $this->name; }
	public function getAllHosts() { return $this->hosts; }
	public function getActiveHosts() { return $this->active; }

	public function onHostStatusChange( Host $host ) {
		$isActive = $host->isActive();
		$hostname = $host->getHostname();
		if ( $isActive ) {
			$this->active[$hostname] = $this->hosts[$hostname];
		} else {
			unset( $this->active[$hostname]);
		}
	}
}

interface IDirector {
	/**
	 * @return Host
	 */
	public function get( $except = array() );
}

class RandomDirector implements IDirector {
	protected $cluster;
	public function __construct( Cluster $cluster ) {
		$this->cluster = $cluster;
	}
	public function get( $except = array() ) {
		$active = $this->cluster->getActiveHosts();
		$available = array_diff(array_keys($active),$except);
		$id = array_rand($available);
		return $active[$available[$id]];
	}
}

class SimpleHostAuthentication {
	protected $hosts;

	public function __construct( $hosts ) {
		$this->hosts = $hosts;
	}
	public function authenticate() {
		/** @var Host $host */
		foreach ($this->hosts as $host) {
			$config = $host->getAuthConfig();

			$auth = new \CF_Authentication(
				$config['swiftUser'],
				$config['swiftKey'],
				null,
				$config['swiftAuthUrl']
			);
			$auth->authenticate();
			$credentials = $auth->export_credentials();
			$host->setCredentials($credentials['auth_token'],$credentials['storage_url']);
		}
	}
}

