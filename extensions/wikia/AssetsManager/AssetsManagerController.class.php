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
	const MEMCKEY_PREFIX = 'multitypepackage';
	const MEMC_TTL = 604800;

	/**
	 * Return different type of assets in a single request
	 *
	 * @requestParam string templates - JSON encoded array of controller / method and optional params used to render a template
	 * @requestParam string styles - comma-separated list of SASS files
	 * @requestParam string scripts - comma-separated list of AssetsManager groups
	 * @requestParam string messages - comma-separated list of JSMessages packages
	 * @requestParam integer ttl - cache period for varnish and browser (in seconds),
	 *
	 * @responseParam array templates - rendered templates (either HTML or JSON encoded string)
	 * @responseParam array styles - minified styles
	 * @responseParam array scripts - minified AssetsManager packages
	 * @responseParam array messages - JS messages
	 */
	public function getMultiTypePackage() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$key = null;
		$data = null;
		$templates = $this->request->getVal( 'templates', null );
		$styles = $this->request->getVal( 'styles', null );
		$scripts = $this->request->getVal( 'scripts', null );
		$messages = $this->request->getVal( 'messages', null );
		$mustache = $this->request->getVal( 'mustache', null );

		// handle templates via sendRequest
		if ( !is_null( $templates ) ) {
			$profileId = __METHOD__ . "::templates::{$templates}";
			wfProfileIn( $profileId );
			$templates = json_decode( $templates, true /* $assoc */ );
			$templatesOutput = array();

			foreach( $templates as $template ) {
				$params = !empty( $template['params'] ) ? $template['params'] : array();

				if ( !empty( $template['controller'] ) && !empty( $template['method'] ) ) {
					$res = $this->sendRequest( $template['controller'], $template['method'], $params );
					$templatesOutput["{$template['controller']}_{$template['method']}"] = $res->__toString();
				} else {
					$templatesOutput[] = "Controller or method not given";
				}
			}

			$this->response->setVal( 'templates', $templatesOutput );
			wfProfileOut( $profileId );
		}

		// handle SASS files
		if ( !is_null( $styles ) ) {
			$profileId = __METHOD__ . "::styles::{$styles}";
			wfProfileIn( $profileId );

			$key = $this->getComponentMemcacheKey( $styles );
			$data = $this->wg->Memc->get( $key );

			if ( empty( $data ) ) {
				$styleFiles = explode( ',', $styles );
				$data = '';

				foreach( $styleFiles as $styleFile ) {
					$builder = $this->getBuilder( 'sass', $styleFile );

					if ( !is_null( $builder ) ) {
						 $data .= $builder->getContent();
					}
				}

				$this->wg->Memc->set( $key, $data, self::MEMC_TTL );
			}

			$this->response->setVal('styles', $data);
			wfProfileOut( $profileId );
		}

		// handle assets manager JS packages
		if ( !is_null( $scripts ) ) {
			$profileId = __METHOD__ . "::scripts::{$scripts}";
			wfProfileIn( $profileId );

			$key = $this->getComponentMemcacheKey( $scripts );
			$data = $this->wg->Memc->get( $key );

			if ( empty( $data ) ) {
				$scriptPackages = explode( ',', $scripts );
				$data = array();

				foreach( $scriptPackages as $package ) {
					$builder = $this->getBuilder( 'group', $package );

					if ( !is_null( $builder ) ) {
						 $data[] = $builder->getContent();
					}
				}

				$this->wg->Memc->set( $key, $data, self::MEMC_TTL );
			}

			$this->response->setVal( 'scripts', $data );
			wfProfileOut( $profileId );
		}

		// handle JSMessages
		if ( !is_null( $messages ) ) {
			$profileId = __METHOD__ . "::messages::{$messages}";
			wfProfileIn( $profileId );

			$messagePackages = explode( ',', $messages );

			$this->response->setVal( 'messages', JSMessages::getPackages( $messagePackages ) );
			wfProfileOut( $profileId );
		}

		// handle mustache templates (BugId:30841)
		if ( !is_null( $mustache ) ) {
			$profileId = __METHOD__ . "::mustache::{$mustache}";
			wfProfileIn( $profileId );

			$mustacheTemplates = explode( ',', $mustache );

			$this->response->setVal( 'mustache', $this->getMustacheTemplates($mustacheTemplates));
			wfProfileOut( $profileId );
		}

		$this->response->setCacheValidity( WikiaResponse::CACHE_LONG );

		$this->response->setFormat( 'json' );
		wfProfileOut( __METHOD__ );
	}

	private function getComponentMemcacheKey( $par ) {
		return self::MEMCKEY_PREFIX . '::' . md5( $par ) . '::' . $this->wg->StyleVersion;
	}

	/**
	 * Returns instance of AssetsManager builder handling given type of assets
	 *
	 * @param string $type assets type ('one', 'group', 'groups', 'sass')
	 * @param string $oid assets / group name
	 * @return AssetsManagerBaseBuilder instance of builder
	 */
	private function getBuilder( $type, $oid ) {
		$type = ucfirst($type);

		// TODO: add a factory method to AssetsManager
		$className = "AssetsManager{$type}Builder";

		if (class_exists($className)) {
			$request = new WebRequest();
			$request->setVal('oid', $oid);

			$builder = new $className($request);
			return $builder;
		}
		else {
			return null;
		}
	}

	/**
	 * Get raw content of mustache templates
	 *
	 * @param array String relative paths to mustache templates
	 * @return array templates content
	 * @throws WikiaException
	 */
	private function getMustacheTemplates($mustacheTemplates) {
		wfProfileIn(__METHOD__);

		$IP = $this->app->getGlobal('IP');
		$ret = array();

		foreach($mustacheTemplates as $mustachePath) {
			$path = $IP . '/' . ltrim($mustachePath, '/');

			// check file validity
			if (!is_readable($path)) {
				throw new WikiaException("Mustache template not found: '{$mustachePath}'");
			}

			// check file extension
			if (substr($path, -9) != '.mustache') {
				throw new WikiaException("Mustache template has incorrect extension: '{$mustachePath}'");
			}

			$ret[] = file_get_contents($path);
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Returns the current style version (cache buster).
	 *
	 * @return string
	 */
	public function getStyleVersion() {
		wfProfileIn( __METHOD__ );
		$this->response->setVal( 'styleVersion', $this->app->wg->StyleVersion );
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT );
		$this->response->setFormat( 'json' );
		wfProfileOut( __METHOD__ );
	}
}
