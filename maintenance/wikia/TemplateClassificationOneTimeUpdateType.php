<?php

require_once __DIR__ . '/../Maintenance.php';

use \Swagger\Client\ApiException,
	Wikia\TemplateClassification\Logger;
/**
 * DAT-3568 One time update reference to references for user provider
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @ingroup Maintenance
 */
class TCReferencesUpdate extends Maintenance {

	const ORIGIN = 'maintenance_update_reference_to_references';

	public function __construct() {
		parent::__construct();
	}

	public function execute() {

		if ( ( $resource = fopen ( __DIR__.'/template_classification_reference.csv','r' ) ) !== false ) {
			$tcs = new UserTemplateClassificationService();

			while ( ( $data = fgetcsv( $resource, null, ',' ) ) !== false )  {
				try {
					$tcs->classifyTemplate(
						$data[0],
						$data[1],
						TemplateClassificationService::TEMPLATE_REFERENCES,
						self::ORIGIN
					);
				} catch( ApiException $e ) {
					( new Logger() )->exception( $e );
				}
			}
			fclose ( $resource );
		}

	}
}

$maintClass = 'TCReferencesUpdate';
require_once RUN_MAINTENANCE_IF_MAIN;
