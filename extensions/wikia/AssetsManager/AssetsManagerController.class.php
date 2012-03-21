<?php

class AssetsManagerController extends WikiaController {

	/**
	 * Return different type of assets in a single request
	 */
	public function getMultiTypePackage() {
		// TODO: handle templates via sendRequest

		// TODO: handle CSS/SASS files

		// handle assets manager packages
		$scripts = $this->request->getVal('scripts');
		if (!is_null($scripts)) {
			$scriptPackages = explode(',', $scripts);
			$scriptsOutput = array();

			foreach($scriptPackages as $package) {
				$builder = $this->getBuilder('group', $package);
				if (!is_null($builder)) {
					 $scriptsOutput[] = $builder->getContent();
				}
			}

			$this->response->setVal('scripts', $scriptsOutput);
		}

		// handle JSmessages
		$messages = $this->request->getVal('messages');
		if (!is_null($messages)) {
			$messagePackages = explode(',', $messages);
			$this->response->setVal('messages', F::getInstance('JSMessages')->getPackages($messagePackages));
		}

		// handle cache time
		$ttl = $this->request->getVal('ttl');
		if ($ttl > 0) {
			$this->response->setCacheValidity($ttl, $ttl, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		}

		$this->response->setFormat('json');
	}

	/**
	 * Returns instance of AssetsManager builder handling given type of assets
	 *
	 * @param string $type assets type ('one', 'group', 'groups', 'sass')
	 * @param string $oid assets / group name
	 * @return AssetsManagerBaseBuilder instance of builder
	 */
	private function getBuilder($type, $oid) {
		$type = ucfirst($type);
		$className = "AssetsManager{$type}Builder";

		if (class_exists($className)) {
			$request = new WebRequest();
			$request->setVal('oid', $oid);

			$builder = F::build($className, array($request));
			return $builder;
		}
		else {
			return null;
		}
	}
}
