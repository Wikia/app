<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetModel extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'model',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-model',
		/**
		 * Data Source
		 * @datatype	DataCenterModel
		 */
		'model' => null,
		/**
		 * Options for DataCenterWidget::buildLink used for each row
		 * @datatype	array
		 */
		'link' => array(),
		/**
		 * Options for DataCenterWidget::buildEffects used for each row
		 * @datatype	array
		 */
		'effects' => array(),
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		// Sets Defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Renders model table recursively
		$xmlOutput .= DataCenterXml::table(
			DataCenterXml::headingCell(
				array( 'align' => 'left' ),
				DataCenterUI::message( 'field', 'name' )
			) .
			DataCenterXml::headingCell(
				array( 'align' => 'right' ),
				DataCenterUI::message( 'field', 'quantity' )
			) .
			DataCenterXml::headingCell(
				array( 'align' => 'left' ),
				DataCenterUI::message( 'field', 'model' )
			) .
			DataCenterXml::headingCell(
				array( 'align' => 'left' ),
				DataCenterUI::message( 'field', 'type' )
			) .
			self::renderModel(
				$parameters, $parameters['model']->getStructure()
			)
		);
		// Clears any floating
		$xmlOutput .= DataCenterXml::div(
			array( 'style' => 'clear:both' ), ' '
		);
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}

	/* Private Static Functions */

	private static function renderModel(
		$parameters,
		$structure,
		$level = 0
	) {
		$xmlOutput = '';
		foreach ( $structure as $model ) {
			$modelLink = DataCenterDB::getModelLink( $model->get( 'link' ) );
			if ( !DataCenterPage::userCan( 'change' ) ) {
				$rowAttributes = array();
			} else if ( $level == 0 && count( $parameters['link'] ) > 0 ) {
				$rowAttributes = array_merge(
					array( 'class' => 'link' ),
					DataCenterXml::buildLink( $parameters['link'], $model )
				);
			} else {
				$rowAttributes = array( 'class' => 'mute' );
			}
			$xmlOutput .= DataCenterXml::row(
				$rowAttributes,
				DataCenterXml::cell(
					DataCenterXml::div(
						array( 'style' => 'padding-left:' . $level * 15 . 'px' ),
						$modelLink->get( 'name' )
					)
				) .
				DataCenterXml::cell(
					array( 'align' => 'right' ),
					$modelLink->get( 'quantity' )
				) .
				DataCenterXml::cell( $model->get( 'name' ) ) .
				DataCenterXml::cell(
					DataCenterUI::message( 'type', $model->getType() )
				)
			);
			$xmlOutput .= self::renderModel(
				$parameters, $model->getStructure(), $level + 1
			);
		}
		return $xmlOutput;
	}
}