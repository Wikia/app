<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="NavigationApi",
 *     basePath="http://muppet.wikia.com"
 * )
 *
 * @SWG\Model( id="NavigationResultSet" )
 * 		@SWG\Property(
 * 			name="navigation",
 * 			type="NavigationItem",
 * 			required="true",
 * 			description="Wrapper for navigation objects"
 * 		)
 *
 * @SWG\Model( id="NavigationItem" )
 * 		@SWG\Property(
 * 			name="wikia",
 * 			type="Array",
 * 			items="$ref:WikiaItem",
 * 			required="true",
 * 			description="On the wiki navigation bar data"
 * 		)
 * 		@SWG\Property(
 * 			name="wiki",
 * 			type="Array",
 * 			items="$ref:WikiaItem",
 * 			required="true",
 * 			description="User set navigation bars"
 * 		)
 *
 * @SWG\Model( id="WikiaItem" )
 * 		@SWG\Property(
 * 			name="text",
 * 			type="string",
 * 			required="true",
 * 			description="On wiki navigation bar text"
 * 		)
 * 		@SWG\Property(
 * 			name="href",
 * 			type="string",
 * 			required="true",
 * 			description="URL path"
 * 		)
 * 		@SWG\Property(
 * 			name="children",
 * 			type="Array",
 * 			items="$ref:ChildrenItem",
 * 			required="true",
 * 			description="Children collection containing article or special pages data"
 * 		)
 *
 * @SWG\Model( id="ChildrenItem" )
 * 		@SWG\Property(
 * 			name="text",
 * 			type="string",
 * 			required="true",
 * 			description="Article or special page title"
 * 		)
 * 		@SWG\Property(
 * 			name="href",
 * 			type="string",
 * 			required="true",
 * 			description="URL path"
 * 		)
 *
 */

	/**
	 * Controller to get Wiki Navigation for a wiki
	 *
	 * @author Jakub "Student" Olek
	 */

class NavigationApiController extends WikiaApiController {

	/**
	 * Fetches wiki navigation
	 *
	 * @responseParam array $navigation Wiki Navigation
	 *
	 * @example
	 */

	/**
	 *
	 * @SWG\Api(
	 *     path="/wikia.php?controller=ActivityApi&method=getData",
	 *     description="Fetches wiki navigation",
	 *     @SWG\Operations(
	 *         @SWG\Operation(
	 *             httpMethod="GET",
	 *             summary="Fetches wiki navigation",
	 *             nickname="getData",
	 *             responseClass="NavigationResultSet"
	 *         )
	 *     )
	 * )
	 */
	public function getData(){
		$model = new NavigationModel();
		$nav = $model->getWiki();

		$this->response->setCacheValidity(
			NavigationModel::CACHE_TTL, //3 hours
			NavigationModel::CACHE_TTL,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$ret = array();

		foreach( $nav as $type => $list ){
			$ret[$type] = $this->getChildren( $list );
		}

		$this->response->setVal( 'navigation', $ret );

		$errors = $model->getErrors();

		if ( !empty( $errors ) ) {
			throw new InvalidDataApiException( implode(', ', array_keys( $errors ) ) );
		}
	}

	private function getChildren( $list, $i = 0 ){
		$children = array();
		$next = array();

		$element = $list[$i];

		if ( isset( $element['children'] ) ) {
			foreach( $element['children'] as $child ){
				$children[] = $this->getChildren( $list, $child );
			}
		}

		if ( isset( $element['text'] ) ) {
			$next = array(
				'text' => $element['text'],
				'href' => $element['href']
			);

			if( !empty( $children ) ) {
				$next['children'] = $children;
			}

		} else if ( !empty( $children ) ) {
			$next = $children;
		}

		return $next;
	}
}