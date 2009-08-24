<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterLayoutTabs extends DataCenterLayout {

	/* Private Static Members */

	private static $parameters = array(
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'layout-tabs',
	);
	private static $sets = 0;

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Increment the number of tabbed layouts in existence
		self::$sets++;
		// Gets id for this set
		$set = self::$sets;
		// Begins layout
		$xmlOutput = parent::begin( self::$parameters['class'] );
		$xmlOutput .= DataCenterXml::open( 'div', array( 'class' => 'tabs' ) );
		// Loops over each content block
		$state = 'current';
		$tab = 0;
		foreach ( $parameters as $name => $content ) {
			if ( $content !== null ) {
				// Adds row
				$xmlOutput .= DataCenterXml::div(
					array(
						'class' => 'item-' . $state,
						'id' => 'tabs_' . $set . '_tab_' . $tab,
						'onclick' => DataCenterJs::callFunction(
							'dataCenter.ui.layouts.tabs.select',
							array(
								DataCenterJs::toScalar( $set ),
								DataCenterJs::toScalar( $tab ),
							)
						),
					),
					DataCenterUI::message( 'tab', $name )
				);
				$state = 'normal';
				$tab++;
			} else {
				$xmlOutput .= DataCenterXml::div(
					array( 'class' => 'item-disabled' ),
					DataCenterUI::message( 'tab', $name )
				);
			}
		}
		$xmlOutput .= DataCenterXml::close( 'div' );
		$xmlOutput .= DataCenterXml::clearFloating();
		// Loops over each content block
		$display = 'block';
		$tab = 0;
		foreach ( $parameters as $content ) {
			if ( $content !== null ) {
				// Adds row
				$xmlOutput .= DataCenterXml::div(
					DataCenterXml::div(
						array(
							'class' => 'page',
							'id' => 'tabs_' . $set . '_page_' . $tab,
							'style' => 'display:' . $display
						),
						$content
					)
				);
				$display = 'none';
				$tab++;
			}
		}
		// Ends layout
		$xmlOutput .= parent::end();
		// Builds javascript for layout
		$jsOutput = <<<END
			if ( !dataCenter.ui.layouts.tabs ) {
				dataCenter.ui.layouts.tabs = {
					sets: {},
					select: function(
						setID, tabID
					) {
						if ( this.sets[setID] ) {
							for ( var i = 0; i < this.sets[setID].count; i++ ) {
								var page = document.getElementById(
									'tabs_' + setID + '_page_' + i
								);
								var tab = document.getElementById(
									'tabs_' + setID + '_tab_' + i
								);
								if ( tab && page ) {
									if ( i == tabID ) {
										page.style.display = 'block';
										tab.className = 'item-current';
									} else {
										page.style.display = 'none';
										tab.className = 'item-normal';
									}
								}
							}
						}
					},
					addSet: function(
						name,
						count
					) {
						this.sets[name] = {};
						this.sets[name].count = count;
					}
				}
			}
			// Add information for this set
			dataCenter.ui.layouts.tabs.addSet( {$set}, {$tab} );
END;
		// Adds script
		$xmlOutput .= DataCenterXml::script( $jsOutput );
		// Returns results
		return $xmlOutput;
	}
}