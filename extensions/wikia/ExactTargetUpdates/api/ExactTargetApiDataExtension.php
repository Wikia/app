<?php
namespace Wikia\ExactTarget;

class ExactTargetApiDataExtension extends ExactTargetApi {

	const OBJECTS_PER_REQUEST_LIMIT = 2500;

	/**
	 * An entry point for DataExtension Create requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'DataExtension' => [
	 * 			// 1st DE object params
	 * 			[
	 * 				'CustomerKey' => 'DE customer key',
	 * 				'Properties' =>
	 * 					[
	 * 						'Fieldname #1' => 'Value #1',
	 * 						'Fieldname #2' => 'Value #2',
	 * 						(...)
	 * 					]
	 * 			],
	 * 			// 2nd DE object params
	 * 			[
	 * 				(...)
	 * 			],
	 * 			(...)
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function createRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeCreateRequest( $aDE );
		return $oResults;
	}

	/**
	 * An entry point for DataExtension Retrieve requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'DataExtension' => [
	 * 			'ObjectType' => "DataExtensionObject[customer key]",
	 * 			'Properties' => [ 'fieldnames', 'to', 'retrieve' ],
	 * 		],
	 * 		// SimpleFilterPart is an equivalent of a WHERE statement
	 * 		'SimpleFilterPart' => [
	 * 			'Property' => 'Key fieldname',
	 * 			'Value' => 'Value to match',
	 * 			'SimpleOperator' => 'IN', // optional (default: equals)
	 * 			// for IN operator provide array in Value field
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function retrieveRequest( Array $aApiCallParams ) {
		$aCallObjectParams = $aApiCallParams['DataExtension'];
		$aSimpleFilterParams = $aApiCallParams['SimpleFilterPart'];
		$oResults = $this->makeRetrieveRequest( $aCallObjectParams, $aSimpleFilterParams );
		return $oResults;
	}

	/**
	 * An entry point for DataExtension Update requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'DataExtension' => [
	 * 			// 1st DE object params
	 * 			[
	 * 				'CustomerKey' => 'DE customer key',
	 * 				'Keys' =>
	 * 					[
	 * 						'Fieldname #1' => 'Value to compare',
	 * 						'Fieldname #2' => 'Value to compare',
	 * 						(...)
	 * 					],
	 * 				'Properties' =>
	 * 					[
	 * 						'Fieldname #1' => 'Value #1',
	 * 						'Fieldname #2' => 'Value #2',
	 * 						(...)
	 * 					]
	 * 			],
	 * 			// 2nd DE object params
	 * 			[
	 * 				(...)
	 * 			],
	 * 			(...)
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function updateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeUpdateRequest( $aDE );
		return $oResults;
	}

	/**
	 * An entry point for DataExtension Update requests
	 * @param  Array  $aApiCallParams  Uses the same format as the Update request (@see updateRequest())
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function updateFallbackCreateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeUpdateCreateRequest( $aDE );
		return $oResults;
	}

	/**
	 * An entry point for DataExtension Update requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'DataExtension' => [
	 * 			// 1st DE object params
	 * 			[
	 * 				'CustomerKey' => 'DE customer key',
	 * 				'Keys' =>
	 * 					[
	 * 						'Fieldname #1' => 'Value to compare',
	 * 						'Fieldname #2' => 'Value to compare',
	 * 						(...)
	 * 					],
	 * 			],
	 * 			// 2nd DE object params
	 * 			[
	 * 				(...)
	 * 			],
	 * 			(...)
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function deleteRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );		
		$oResults = $this->makeDeleteRequest( $aDE );
		return $oResults;
	}

}
