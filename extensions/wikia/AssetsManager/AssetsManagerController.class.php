<?php

class AssetsManagerController extends WikiaController {

	/**
	 * Return different type of assets in a single request
	 */
	public function getMultiTypePackage() {
		// handle templates via sendRequest
		$templates = $this->request->getVal('templates');
		if (!is_null($templates)) {
			if (!is_array($templates)) {
				$templates = json_decode($templates, true /* $assoc */);
			}
			$templatesOutput = array();

			foreach($templates as $template) {
				$params = !empty($template['params']) ? $template['params'] : array();
				$res = $this->sendRequest($template['controllerName'], $template['methodName'], $params);
				$templatesOutput[] = $res->__toString();
			}

			$this->response->setVal('templates', $templatesOutput);
		}

		// handle SASS files
		$styles = $this->request->getVal('styles');
		if (!is_null($styles)) {
			$styleFiles = explode(',', $styles);
			$stylesOutput = '';

			foreach($styleFiles as $styleFile) {
				$builder = $this->getBuilder('sass', $styleFile);
				if (!is_null($builder)) {
					 $stylesOutput .= $builder->getContent();
				}
			}

			$this->response->setVal('styles', $stylesOutput);
		}

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

		// TODO: add a factory method to AssetsManager
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
