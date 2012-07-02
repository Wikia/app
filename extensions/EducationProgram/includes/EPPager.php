<?php

/**
 * Abstract class extending the TablePager with common functions
 * for pagers listing EPDBObject deriving classes and some compatibility helpers.
 *
 * @since 0.1
 *
 * @file EPPager.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class EPPager extends TablePager {

	/**
	 * Query conditions, full field names (inc prefix).
	 * @since 0.1
	 * @var array
	 */
	protected $conds;

	/**
	 * Name of the class deriving from EPDBObject.
	 * @since 0.1
	 * @var string
	 */
	protected $className;

	/**
	 * EPDBObject object constructed from $this->currentRow.
	 * @since 0.1
	 * @var EPDBObject
	 */
	protected $currentObject;

	/**
	 * Context in which this pager is being shown.
	 * @since 0.1
	 * @var IContextSource
	 */
	protected $context;

	/**
	 * Constructor.
	 *
	 * @param IContextSource $context
	 * @param array $conds
	 * @param string $className
	 */
	public function __construct( IContextSource $context, array $conds, $className ) {
		$this->conds = $conds;
		$this->className = $className;
		$this->context = $context;

		$this->mDefaultDirection = true;

		parent::__construct( $context );

		$this->context->getOutput()->addModules( 'ep.pager' );
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::formatRow()
	 */
	function formatRow( $row ) {
		$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
		$this->currentObject = $c::newFromDBResult( $row );

		$cells = array();

		foreach ( $this->getFieldNames() as $field => $name ) {
			if ( $field === '_select' ) {
				$value = Html::element(
					'input',
					array(
						'type' => 'checkbox',
						'value' => $this->currentObject->getId(),
						'id' => 'select-' . $this->getInstanceNumber() . '-' . $this->currentObject->getId(),
						'name' => 'epitemsselected',
						'class' => 'ep-select-item',
						'data-pager-id' => $this->getInstanceNumber(),
					)
				);
			}
			elseif ( $field === '_controls' ) {
				$value = $this->getLanguage()->pipeList( $this->getControlLinks( $this->currentObject ) );
			}
			else {
				$prefixedField = $c::getPrefixedField( $field );
				$value = isset( $row->$prefixedField ) ? $row->$prefixedField : null;
			}

			$formatted = strval( $this->formatValue( $field, $value ) );

			if ( $formatted == '' ) {
				$formatted = '&#160;';
			}

			$cells[] = Html::rawElement( 'td', $this->getCellAttrs( $field, $value ), $formatted );
		}

		return Html::rawElement( 'tr', $this->getRowAttrs( $row ), implode( '', $cells ) ) . "\n";
	}

	/**
	 * Returns the relevant field names.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getFieldNames() {
		$fields = array();

		if ( $this->hasMultipleItemControl() ) {
			$fields['_select'] = '';
		}

		foreach ( $this->getFields() as $field ) {
			if ( !array_key_exists( $field, $this->conds ) || is_array( $this->conds[$field] ) ) {
				$fields[$field] = $field;
			}
		}

		if ( $this->hasActionsColumn() ) {
			$fields['_controls'] = '';
		}

		return $fields;
	}

	/**
	 * Returns HTML for the multiple item control.
	 * With actions coming from @see getMultipleItemActions.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getMultipleItemControl() {
		if ( !$this->hasMultipleItemControl() ) {
			return '';
		}

		$controls = array();

		foreach ( $this->getMultipleItemActions() as $label => $attribs ) {
			if ( array_key_exists( 'class', $attribs ) ) {
				$attribs['class'] .= ' ep-pager-items-action';
			}
			else {
				$attribs['class'] = 'ep-pager-items-action';
			}

			$attribs['data-pager-id'] = $this->getInstanceNumber();

			$controls[] = Html::element(
				'button',
				$attribs,
				$label
			);
		}

		return
			'<fieldset>' .
				'<legend>' . wfMsgHtml( 'ep-pager-withselected' ) . '</legend>' .
				implode( '', $controls ) .
			'</fieldset>';
	}

	/**
	 * Return the multiple item actions the current user can do.
	 * Override in deriving classes to add actions.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getMultipleItemActions() {
		$actions = array();
		return $actions;
	}

	/**
	 * Returns whether the pager has multiple item actions and therefore should show the multiple items control.
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	protected function hasMultipleItemControl() {
		return count( $this->getMultipleItemActions() ) > 0;
	}

	/**
	 * Returns whether the pager should show an extra column for item actions.
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	protected function hasActionsColumn() {
		return true;
	}

	/**
	 * Returns the fields to display.
	 * Similar to @see getFieldNames, but fields should not be prefixed, and
	 * non-relevant fields will be removed.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected abstract function getFields();

	/**
	 * (non-PHPdoc)
	 * @see IndexPager::getQueryInfo()
	 */
	function getQueryInfo() {
		$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
		return array(
			'tables' => array( $c::getDBTable() ),
			'fields' => $c::getPrefixedFields( $c::getFieldNames() ),
			'conds' => $c::getPrefixedValues( $this->getConditions() ),
		);
	}

	/**
	 * Get the conditions to use in the query.
	 * This is done by merging the filter controls conditions with those provided to the constructor.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getConditions() {
		$conds = array();

		$filterOptions = $this->getFilterOptions();
		$this->addFilterValues( $filterOptions, false );

		foreach ( $filterOptions as $optionName => $optionData ) {
			if ( array_key_exists( 'value', $optionData ) && $optionData['value'] !== '' ) {
				$conds[$optionName] = $optionData['value'];
			}
		}

		return array_merge( $conds, $this->conds );
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::isFieldSortable()
	 */
	function isFieldSortable( $name ) {
		$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
		return in_array(
			$name,
			$c::getPrefixedFields( $this->getSortableFields() )
		);
	}

	function getDefaultSort() {
		$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
		return $c::getPrefixedField( 'id' );
	}

	/**
	 * Should return an array with the names of the fields that are sortable.
	 *
	 * @since 0.1
	 *
	 * @return array of string
	 */
	protected abstract function getSortableFields();

	/**
	 * Returns a list with the filter options.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getFilterOptions() {
		return array();
	}

	/**
	 * Gets the HTML for a filter control.
	 *
	 * @since 0.1
	 *
	 * @param boolean $hideWhenNoResults When true, there are no results, and no filters are applied, an empty string is returned.
	 *
	 * @return string
	 */
	public function getFilterControl( $hideWhenNoResults = true ) {
		$filterOptions = $this->getFilterOptions();

		foreach ( $this->conds as $name => $value ) {
			if ( array_key_exists( $name, $filterOptions ) ) {
				unset( $filterOptions[$name] );
			}
		}

		if ( count( $filterOptions ) < 1 ) {
			return '';
		}

		$this->addFilterValues( $filterOptions );

		if ( $hideWhenNoResults && $this->getNumRows() < 1 ) {
			$noFiltersSet = array_reduce( $filterOptions, function( $current, array $data ) {
				return $current && ( $data['value'] === '' || is_null( $data['value'] ) );
			} , true );

			$c = $this->className;  // Yeah, this is needed in PHP 5.3 >_>
			if ( $noFiltersSet || !$c::has() ) {
				return '';
			}
		}

		$controls = array();

		foreach ( $filterOptions as $optionName => $optionData ) {
			switch ( $optionData['type'] ) {
				case 'select':
					$select = new XmlSelect( 
						$this->filterPrefix . $optionName,
						$this->filterPrefix . $optionName,
						$optionData['value']
					);
					$select->addOptions( $optionData['options'] );
					$control = $select->getHTML();
					break;
			}

			$control = '&#160;' . $this->getMsg( 'filter-' . $optionName ) . '&#160;' . $control;

			$controls[] = $control;
		}

		$title = $this->getTitle()->getFullText();

		return
 			'<fieldset>' .
				'<legend>' . wfMsgHtml( 'ep-pager-showonly' ) . '</legend>' .
				'<form method="post" action="' . htmlspecialchars( wfAppendQuery( $GLOBALS['wgScript'], array( 'title' => $title ) ) ) . '">' .
					Html::hidden( 'title', $title ) .
					implode( '', $controls ) .
					'&#160;<input type="submit" class="ep-pager-go" value="' . wfMsgHtml( 'ep-pager-go' ) . '">' .
					'&#160;<button class="ep-pager-clear">' . wfMsgHtml( 'ep-pager-clear' ) . '</button>' .
				'</form>' .
			'</fieldset>';
	}

	/**
	 * Changes the provided filter options list by replacing the values by what's set
	 * in the request, or as fallback, what's set in the session.
	 *
	 * @since 0.1
	 *
	 * @param array $filterOptions
	 * @param boolean $cast Should values with non-string type be casted (ie to have a select with int values have the correct val selected).
	 *
	 * @return boolean If anything was changed from the default
	 */
	protected function addFilterValues( array &$filterOptions, $cast = true ) {
		$req = $this->getRequest();
		$changed = false;

		foreach ( $filterOptions as $optionName => &$optionData ) {
			if ( $req->getCheck( $this->filterPrefix . $optionName ) ) {
				$optionData['value'] = $req->getVal( $this->filterPrefix . $optionName );
				$req->setSessionData( $this->getNameForSession( $optionName ), $optionData['value'] );
				$changed = true;

				if ( $cast && array_key_exists( 'datatype', $optionData ) ) {
					switch ( $optionData['datatype'] ) {
						case 'int':
							$optionData['value'] = (int)$optionData['value'];
							break;
						case 'float':
							$optionData['value'] = (float)$optionData['value'];
							break;
					}
				}
			}
			elseif ( !is_null( $req->getSessionData( $this->getNameForSession( $optionName ) ) ) ) {
				$optionData['value'] = $req->getSessionData( $this->getNameForSession( $optionName ) );
				$changed = true;
			}
		}

		return $changed;
	}
	
	protected function getNameForSession( $optionName ) {
		return $this->filterPrefix . get_called_class() . $optionName;
	}
	
	protected $filterPrefix = '';
	
	public function setFilterPrefix( $filterPrefix ) {
		$this->filterPrefix = $filterPrefix;
	}

	/**
	 * Takes a message key and prefixes it with the extension name and name of the pager,
	 * feeds it to wfMsg, and returns it.
	 *
	 * @since 0.1
	 *
	 * @param string $messageKey
	 *
	 * @return string
	 */
	protected function getMsg( $messageKey ) {
		return wfMsg( strtolower( $this->className ) . 'pager-' . str_replace( '_', '-', $messageKey ) );
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::formatValue()
	 */
	public final function formatValue( $name, $value ) {
		return $this->getFormattedValue( $name, $value );
	}

	/**
	 * Similar to TablePager::formatValue, but passes along the name of the field without prefix.
	 * Returned values need to be escaped!
	 *
	 * @since 0.1
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return string
	 */
	protected abstract function getFormattedValue( $name, $value );

	/**
	 * Returns a list of (escaped, html) links to add in an additional column.
	 *
	 * @since 0.1
	 *
	 * @param EPDBObject $item
	 *
	 * @return array
	 */
	protected function getControlLinks( EPDBObject $item ) {
		return array();
	}

	/**
	 * Returns a deletion link.
	 *
	 * @since 0.1
	 *
	 * @param string $type
	 * @param integer $id
	 *
	 * @return string
	 */
	protected function getDeletionLink( $type, $id, $name ) {
		return Html::element(
			'a',
			array(
				'href' => '#',
				'class' => 'ep-pager-delete',
				'data-id' => $id,
				'data-type' => $type,
				'data-name' => $name,
			),
			wfMsg( 'delete' )
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::getStartBody()
	 *
	 * Mostly just a copy of parent class function.
	 * Allows for having a checlbox in the selection column header.
	 * Would obviously be better if parent class supported doing this nicer.
	 */
	function getStartBody() {
		global $wgStylePath;
		$tableClass = htmlspecialchars( $this->getTableClass() );
		$sortClass = htmlspecialchars( $this->getSortHeaderClass() );

		$s = "<table style='border:1;' class=\"mw-datatable $tableClass\"><thead><tr>\n";
		$fields = $this->getFieldNames();

		# Make table header
		foreach ( $fields as $field => $name ) {
			$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
			$prefixedField = $c::getPrefixedField( $field );
			$name = $name === '' ? '' : $this->getMsg( 'header-' . $name );

			if ( $field === '_select' ) {
				$s .= '<th width="30px">' . Html::element( 'input', array(
					'type' => 'checkbox',
					'name' => 'ep-pager-select-all-' . $this->getInstanceNumber(),
					'id' => 'ep-pager-select-all-' . $this->getInstanceNumber(),
					'class' => 'ep-pager-select-all',
				) ) . "</th>\n";
			}
			elseif ( strval( $name ) == '' ) {
				$s .= "<th>&#160;</th>\n";
			} elseif ( $this->isFieldSortable( $prefixedField ) ) {
				$query = array( 'sort' => $prefixedField, 'limit' => $this->mLimit );

				if ( $prefixedField == $this->mSort ) {
					# This is the sorted column
					# Prepare a link that goes in the other sort order
					if ( $this->mDefaultDirection ) {
						# Descending
						$image = 'Arr_d.png';
						$query['asc'] = '1';
						$query['desc'] = '';
						$alt = htmlspecialchars( wfMsg( 'descending_abbrev' ) );
					} else {
						# Ascending
						$image = 'Arr_u.png';
						$query['asc'] = '';
						$query['desc'] = '1';
						$alt = htmlspecialchars( wfMsg( 'ascending_abbrev' ) );
					}

					$image = htmlspecialchars( "$wgStylePath/common/images/$image" );
					$link = $this->makeLink(
								"<img width=\"12\" height=\"12\" alt=\"$alt\" src=\"$image\" />" .
					htmlspecialchars( $name ), $query );
					$s .= "<th class=\"$sortClass\">$link</th>\n";
				} else {
					$s .= '<th>' . $this->makeLink( htmlspecialchars( $name ), $query ) . "</th>\n";
				}
			}
			else {
				$s .= '<th>' . htmlspecialchars( $name ) . "</th>\n";
			}
		}
		$s .= "</tr></thead><tbody>\n";
		return $s;
	}

	protected $instanceNumber = null;

	protected function getInstanceNumber() {
		static $instanceCount = 0;

		if ( is_null( $this->instanceNumber ) ) {
			$this->instanceNumber = $instanceCount++;
		}

		return $this->instanceNumber;
	}

}
