<?php

/**
 * Handles fetching:
 *  - output of Nirvana controllers (HTML / JSON)
 *  - AssetsManager packages
 *  - SASS files
 *  - JS messages
 *  in a single request as JSON object
 *
 * @author Macbre
 */

class AssetsManagerController extends WikiaController {

	const CACHE_TTL = 86400;

	/**
	 * Return different type of assets in a single request
	 *
	 * @requestParam string templates - JSON encoded array of controllerName / methodName and optional params used to render a templaye
	 * @requestParam string styles - comma-separated list of SASS files
	 * @requestParam string scripts - comma-separated list of AssetsManager groups
	 * @requestParam string messages - comma-separated list of JSMessages packages
	 * @requestParam integer ttl - cache period for both varnish and browser (in seconds)
	 * @responseParam array templates - rendered templates (either HTML or JSON encoded string)
	 * @responseParam array styles - minified styles
	 * @responseParam array scripts - minified AssetsManager  packages
	 * @responseParam array messages - JS messages
	 */
	public function getMultiTypePackage() {
		$key = 'multitypepackage::' . md5(json_encode($this->request->getParams()));
		$data = $this->wg->Memc->get($key);

		if (empty($data)) {
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

			$this->wg->Memc->set($key, $this->response->getData(), self::CACHE_TTL);
		}
		else {
			$this->response->setData($data);
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
