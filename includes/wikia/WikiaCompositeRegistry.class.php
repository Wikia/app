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

	public function countRegistries() {
		return count($this->registries);
	}
	
	public function addRegistry(WikiaRegistry $registry, $namespace) {
		if ($this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" already exist in "%s"', $namespace, get_class($this)));
		}
		$this->registries[$namespace] = $registry;
		return $this;
	}

	public function removeRegistry($namespace) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		unset($this->registries[$namespace]);
		return $this;
	}

	public function getRegistry($namespace) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		return $this->registries[$namespace];
	}

	public function hasRegistry($namespace) {
		return isset($this->registries[$namespace]);
	}

	public function get($propertyName, $namespace = WikiaCompositeRegistry::DEFAULT_NAMESPACE) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		if ($this->getRegistry($namespace)->has($propertyName)) {
			return $this->registries[$namespace]->get($propertyName);
		}

		return null;
	}

	public function set($propertyName, $value, $namespace = self::DEFAULT_NAMESPACE) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		$this->getRegistry($namespace)->set($propertyName, $value);
		return $this;
	}

	public function remove($propertyName, $namespace = self::DEFAULT_NAMESPACE) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		$this->getRegistry($namespace)->remove($propertyName);
		return $this;
	}

	public function has($propertyName, $namespace = self::DEFAULT_NAMESPACE) {
		if (!$this->hasRegistry($namespace)) {
			throw new WikiaException(sprintf('Namespace "%s" does not exist in "%s"', $namespace, get_class($this)));
		}
		return $this->getRegistry($namespace)->has($propertyName);
	}
}