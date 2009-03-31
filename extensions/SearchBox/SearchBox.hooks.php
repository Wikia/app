<?php
/**
 * Hooks for SearchBox extension
 *
 * @file
 * @ingroup Extensions
 */

// SearchBox hooks
class SearchBoxHooks {

	/* Functions */

	// Initialization
	public static function register() {
		global $wgParser;

		// Register the hook with the parser
		$wgParser->setHook( 'searchbox', 'SearchBoxHooks::render' );

		// Continue
		return true;
	}

	// Render the input box
	public static function render( $input, $args, $parser ) {
		global $wgContLang;

		// Internationalization
		wfLoadExtensionMessages( 'SearchBox' );

		/*
		 * Label
		 *
		 * Inserted before the text input box.
		 *
		 * default:	''
		 * format:	string
		 * example:	'Search this wiki for:'
		 */
		if ( !isset( $args['label'] ) ) {
			$args['label'] = '';
		} else {
			$args['label'] = $parser->recursiveTagParse( $args['label'] );
		}

		/*
		 * SearchLabel
		 *
		 * Applied as the value of the search button
		 *
		 * default:	internationalized message
		 * format:	string
		 * example:	'Find It!'
		 */
		if ( !isset( $args['searchlabel'] ) ) {
			$args['searchlabel'] = wfMsg( 'searchbox-search' );
		}

		/*
		 * GoLabel
		 *
		 * Applied as the value of the go button
		 *
		 * default:	internationalized message
		 * format:	string
		 * example:	'Go!'
		 */
		if ( !isset( $args['golabel'] ) ) {
			$args['golabel'] = wfMsg( 'searchbox-go' );
		}

		/*
		 * Hide
		 *
		 * A list of elements to hide
		 *
		 * default:	''
		 * format:	List of comma delimited names: input | go | search | namespaces
		 * example:	'go'
		 */
		if ( !isset( $args['hide'] ) ) {
			$args['hide'] = array();
		} else {
			$args['hide'] = explode( ',', $args['hide'] );
			foreach ( $args['hide'] as $key => $value  ) {
				$args['hide'][strtolower( trim( $value ) )] = true;
			}
		}

		/*
		 * NamespacesLabel
		 *
		 * Inserted before the list of namespace checkboxes
		 *
		 * default:	internationalized message
		 * format:	string
		 * example:	'Namespaces to search:'
		 */
		if ( !isset( $args['namespaceslabel'] ) ) {
			$args['namespaceslabel'] = wfMsg( 'searchbox-namespaces' );
		} else {
			$args['namespaceslabel'] = $parser->recursiveTagParse( $args['namespaceslabel'] );
		}

		/*
		 * Namespaces
		 *
		 * If there is more than 1 valid namespace in this list, a list of checkboxes
		 * will be inserted after the text input box and before the search button, in
		 * place of the go button.
		 *
		 * default:	''
		 * format: 	List of comma delimited names, items with ** in them are check by default
		 * example:	'**Main,Special,User**'
		 */
		if ( !isset( $args['namespaces'] ) ) {
			$args['namespaces'] = '';
		}

		/*
		 * Align
		 *
		 * Applied to the entire box
		 *
		 * default:	'center'
		 * format:	'left' | 'center' | 'right'
		 * example:	'left'
		 */
		if ( !isset( $args['align'] ) ) {
			// Use default
			$args['align'] = 'center';
		} else {
			// Validate
			$valid = false;
			foreach ( array( 'left', 'center', 'right' ) as $value ) {
				if ( strtolower( $args['align'] ) == $value ) {
					$valid = true;
				}
			}
			if ( !$valid ) {
				// Use default
				$args['align'] == 'center';
			}
		}

		/*
		 * Style
		 *
		 * CSS applied to the entire box
		 *
		 * default:	''
		 * format:	inline CSS
		 * example:	'border:1px solid red;'
		 */
		if ( !isset( $args['style'] ) ) {
			$args['style'] = '';
		}

		/*
		 * Default
		 *
		 * Applied as the value of the text input box
		 *
		 * default:	''
		 * format:	string
		 * example:	'something in particular'
		 */
		if ( !isset( $args['default'] ) ) {
			$args['default'] = '';
		}

		/*
		 * Size
		 *
		 * Applied as the width (in characters) of the text input box
		 *
		 * default:	50
		 * format:	integer
		 * example:	20
		 */
		if ( !isset( $args['size'] ) ) {
			$args['size'] = 50;
		} else {
			$args['size'] = intval( $args['size'] <= 0 ? 50 : $args['size'] );
		}

		/*
		 * Width
		 *
		 * Applied as the width (in pixels) of the text input box
		 *
		 * default:	'auto'
		 * format:	integer | 'auto'
		 * example:	25
		 */
		if ( !isset( $args['width'] ) ) {
			$args['width'] = 'auto';
		} else {
			if ( $args['width'] !== 'auto' ) {
				// Force positive integer
				$args['width'] = abs( intval( $args['width'] ) );
			}
		}

		/*
		 * Spacing
		 *
		 * Applied to all controls in the box as amount of space (in pixels) between them
		 *
		 * default:	5
		 * format:	integer
		 * example:	10
		 */
		if ( !isset( $args['spacing'] ) ) {
			$args['spacing'] = 5;
		} else {
			// Force positive integer
			$args['spacing'] = intval( $args['spacing'] < 0 ? 5 : $args['spacing'] );
		}

		// Build HTML
		$htmlOut = Xml::openElement( 'div',
			array(
				'align' => $args['align'],
				'style' => $args['style']
			)
		);
		$htmlOut .= Xml::openElement( 'form',
			array(
				'name' => 'searchbox',
				'id' => 'searchbox',
				'class' => 'searchbox',
				'action' => SpecialPage::getTitleFor( 'Search' )->escapeLocalUrl(),
			)
		);

		// If the label is not empty (label is already safe HTML)
		if ( !empty( $args['label'] ) ) {
			// Label
			$htmlOut .= Xml::tags( 'label',
				array(
					'for' => 'search',
					'style' => 'margin:' . $args['spacing'] . 'px'
				),
				$args['label']
			);
		}

		// If the input box is not on the hide list
		if ( !isset( $args['hide']['input'] ) ) {
			// Input box
			$htmlOut .= Xml::element( 'input',
				array(
					'name' => 'search',
					'id' => 'search',
					'type' => 'text',
					'value' => $args['default'],
					'size' => $args['size'],
					'style' => 'margin:' . $args['spacing'] . 'px'
				)
			);
		} else {
			// If the default is not empty
			if ( !empty( $args['default'] ) ) {
				// Hidden query field
				$htmlOut .= Xml::element( 'input',
					array(
						'name' => 'search',
						'type' => 'hidden',
						'value' => $args['default'],
					)
				);
			}
		}

		// Build namespace checkboxes
		$htmlNamespaces = '';
		$matchedNamespaces = 0;
		if ( !empty( $args['namespaces'] ) ) {
			$namespaces = $wgContLang->getNamespaces();
			$namespacesArray = explode( ',', $args['namespaces'] );

			// If the namespaces controls are not on the hide list
			if ( !isset( $args['hide']['namespaces'] ) ) {
				// Namespaces controls
				$htmlNamespaces .= Xml::openElement( 'div',
					array(
						'align' => $args['align']
					)
				);

				// If the namespaces label is not empty (namespaceslabel is already safe HTML)
				if ( !empty( $args['namespaceslabel'] ) ) {
					// Namespaces label
					$htmlNamespaces .= Xml::tags( 'label',
						array(
							'style' => 'margin:' . $args['spacing'] . 'px'
						),
						$args['namespaceslabel']
					);
				}
				// Insert checkboxes
				foreach ( $namespacesArray as $userNamespace ) {
					$checked = array();

					// Checked by default if flagged with **
					if ( strstr( $userNamespace, '**' ) || count( $namespacesArray ) == 1 ) {
						// Remove the flag
						$userNamespace = str_replace( '**', '', $userNamespace );

						// Create the checked attribute
						$checked = array( 'checked' => 'checked' );
					}

					// Namespace checkboxes
					foreach ( $namespaces as $i => $name ) {
						// Recognize 0 as the Main namespace, and skip negetive numbers
						if ( $i < 0 ) {
							continue;
						} elseif ( $i == 0 ) {
							$name = 'Main';
						}
						// Only show checkboxes for existing namespaces
						if ( $userNamespace == $name ) {
							$matchedNamespaces++;

							// Checkbox
							$htmlNamespaces .= Xml::element( 'input',
								array(
									'type' => 'checkbox',
									'name' => 'ns' . $i,
									'id' => 'ns' . $i,
									'value' => 1,
									'style' => 'vertical-align:middle;margin:' . $args['spacing'] . 'px;margin-right:0px;',
									'align' => 'absmiddle'
								) + $checked
							);

							// Label
							$htmlNamespaces .= Xml::element( 'label',
								array(
									'for' => 'ns' . $i,
									'style' => 'margin:' . $args['spacing'] . 'px'
								),
								$userNamespace
							);
						}
					}
				}
				$htmlNamespaces .= Xml::closeElement( 'div' );
			} else {
				// Still include the namespaces, only as hidden fields
				foreach ( $namespacesArray as $userNamespace ) {
					// Remove flags if any
					$userNamespace = str_replace( '**', '', $userNamespace );

					// Namespace hidden fields
					foreach ( $namespaces as $i => $name ) {
						// Recognize 0 as the Main namespace, and skip negetive numbers
						if ( $i < 0 ) {
							continue;
						} elseif ( $i == 0 ) {
							$name = 'Main';
						}

						// Only insert hidden fields for existing namespaces
						if ( $userNamespace == $name ) {
							// Hidden field
							$htmlNamespaces .= Xml::element( 'input',
								array(
									'type' => 'hidden',
									'name' => 'ns' . $i,
									'value' => 1
								)
							);
						}
					}
				}
			}
		}
		// If there are no namespaces
		if ( $matchedNamespaces <= 1 ) {
			// If the go button is not on the hide list
			if ( !isset( $args['hide']['go'] ) ) {
				// Go button
				$htmlOut .= Xml::element( 'input',
					array(
						'type' => 'submit',
						'name' => 'go',
						'value' => $args['golabel'],
						'style' => 'font-weight:bold;margin:' . $args['spacing'] . 'px'
					)
				);
			}
		} else {
			// Insert namespaces controls
			$htmlOut .= $htmlNamespaces;
		}

		// If the search button is not on the hide list
		if ( !isset( $args['hide']['search'] ) ) {
			// Search button
			$htmlOut .= Xml::element( 'input',
				array(
					'type' => 'submit',
					'name' => 'fulltext',
					'value' => $args['searchlabel'],
					'style' => 'margin:' . $args['spacing'] . 'px'
				)
			);
		}
		$htmlOut .= Xml::closeElement( 'form' );
		$htmlOut .= Xml::closeElement( 'div' );

		// Return HTML
		return $htmlOut;
	}
}
