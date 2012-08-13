<?php
/**
 * WikiaApiNirvana
 * Api access point to get to Nirvana API
 *
 * @author Jakub Olek
 *
 */

$wgAPIModules['wikia'] = 'WikiaApiNirvana';

class WikiaApiNirvana extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, '' /* prefix for parameters... so controller becomes $controller */ );
	}

	/**
	 * See functions below for expected URL params
	 */
	public function execute() {
		$app = F::app();
		$app->wf->profileIn(__METHOD__);

		$format = 'html';

		extract( $this->extractRequestParams() );

		if( !empty( $controller ) ) {

			if( empty( $method ) ) {
				$method = 'index';
			}

			if( !empty( $parameters ) ) {
				$par = array();
				$params = explode( '|', $parameters );
				foreach( $params as $param ) {
					$p = explode( ':', $param );
					$par[$p[0]] = $p[1];
				}
			} else {
				$params = null;
			}

			$resp = $app->sendRequest( $controller , $method, $params );

			if( $format == 'html' || $format == 'json' ) {
				$resp = $resp->toString();
			}

			$this->getResult()->addValue( $this->getModuleName(), $controller,  $resp );
		} else {
			$this->getResult()->addValue( $this->getModuleName(), 'Error',  'No Controller Specified' );
		}

		$app->wf->profileOut(__METHOD__);
	}

	public function getAllowedParams() {
		return array (
			'controller' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
			'method' => array(
				ApiBase :: PARAM_TYPE => "string"
			),
			'format' => array (
				ApiBase :: PARAM_TYPE => "string"
			),
			'parameters' => array (
				ApiBase :: PARAM_TYPE => "string"
			)
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiNirvana.php jolek';
	}

	public function getParamDescription()
	{
		return array
		(
			'controller' => 'name of a Nirvana controller',
			'method' => 'name of a method. If not specified "index" is used by default',
			'format' => 'allowed formats: html, json',
			'parameters' => 'parameters of a controller, key:value'
		);
	}

	public function getDescription()
	{
		global $wgExtensionCredits;
		$descriptions = array("This module is used to get to Wikia API through MediaWiki API.");

		foreach( $wgExtensionCredits["other"] as $extension ) {
			if( !empty( $extension['api'] ) ) {
				$api = $extension['api'];

				if( !empty( $api['controllers'] ) && !empty( $extension['name'] ) ) {
					array_push( $descriptions, '', 'Name: '.$extension['name'], 'Description: ' . $extension['description'], '');
					array_push( $descriptions, '  Controllers:' );

					if( is_array( $api['controllers'] ) ) {
						foreach( $api['controllers'] as $controller ) {
							array_push( $descriptions, '   - '.$controller );
						}
					} else {
						array_push( $descriptions, '   - ' . $api['controllers'] );
					}
				} else {
					break;
				}

				if( !empty( $api['methods'] ) ) {
					array_push( $descriptions, '  Methods:' );
					if( is_array( $api['methods'] ) ) {
						foreach( $api['methods'] as $method ) {
							array_push( $descriptions, '   - '. $method );
						}
					} else {
						array_push( $descriptions, '   - ' . $api['methods'] );
					}
				}

				if( !empty( $api['parameters'] ) ) {
					array_push( $descriptions, '  Parameters:');
					if( is_array( $api['parameters'] ) ) {
						foreach( $api['parameters'] as $parameter ) {
							array_push( $descriptions, '   - '. $parameter );
						}
					} else {
						array_push( $descriptions, '   - ' . $api['parameters'] );
					}
				}

				if( !empty( $api['examples'] ) ) {
					array_push( $descriptions, '  Examples:' );
					if( is_array( $api['examples'] ) ) {
						foreach( $api['examples'] as $example ) {
							array_push( $descriptions, '     '. $example );
						}
					} else {
						array_push( $descriptions, $api['examples'] );
					}
				}
			};
		}
		return $descriptions;
	}
}