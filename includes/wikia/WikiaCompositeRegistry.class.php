<?php

class WikiaCompositeRegistry extends WikiaRegistry {
	const DEFAULT_NAMESPACE = 'mediawiki';
	private $registries = array();

	public function __construct(Array $registries = null) {
		if(is_array($registries)) {
			foreach($registries as $namespace => $registry) {
				$this->addRegistry($registry, $namespace);
			}
		}
	}

	public function addRegistry($registry, $namespace) {
		$this->registries[$namespace] = $registry;
		return $this;
	}

	public function getRegistry($namespace) {
		return $this->registries[$namespace];
	}

	public function get($propertyName, $namespace = WikiaCompositeRegistry::DEFAULT_NAMESPACE) {
		if ($this->registries[$namespace]->has($propertyName)) {
			return $this->registries[$namespace]->get($propertyName);
		}

		return null;
	}

	public function set($propertyName, $value, $namespace = self::DEFAULT_NAMESPACE) {
		$this->registries[$namespace]->set($propertyName, $value);
		return $this;
	}

	public function remove($propertyName, $namespace = self::DEFAULT_NAMESPACE) {
		$this->registries[$namespace]->remove($propertyName);
		return $this;
	}

	public function has($propertyName, $namespace = self::DEFAULT_NAMESPACE) {
		return $this->registries[$namespace]->has($propertyName);
	}
}