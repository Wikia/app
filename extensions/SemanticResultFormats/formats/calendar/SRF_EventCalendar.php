<?php

/**
 * An event calendar printer using the FullCalendar JavaScript library.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 1.8
 *
 * @file SRF_EventCalendar.php
 * @ingroup SemanticResultFormats
 * @licence GNU GPL v2 or later
 *
 * @author mwjames
 */
class SRFEventCalendar extends SMWResultPrinter {

	/**
	 * Corresponding message name
	 *
	 */
	public function getName() {
		return wfMessage( 'srf-printername-eventcalendar' )->text();
	}

	/**
	 * Returns string of the query result
	 *
	 *
	 * @param SMWQueryResult $result
	 * @param $outputMode
	 *
	 * @return string
	 */
	protected function getResultText( SMWQueryResult $result, $outputMode ) {

		// Fetch the data set
		$data = $this->getEventData( $result, $outputMode );

		// Check data availability
		if ( $data === array() ) {
			return $result->addErrors( array( wfMessage( 'srf-error-result-processing-empty', 'gallery' )->inContentLanguage()->text() ) );
		} else {
			return $this->getCalendarOutput( $data );
		}
	}

	/**
	 * Returns an array of events
	 *
	 * The array index corresponds to FullCalendar eventObject specification
	 *
	 * id - Uniquely identifies the given event
	 * title - Required, The text on an event's element
	 * start - Required, The date/time an event begins
	 * end - Optional, The date/time an event ends
	 * url - Optional, A URL that will be used as href for when the event is clicked
	 * className - A CSS class (or array of classes) that will be attached to this event's element
	 * color - Sets an event's background and border color
	 * description is a non-standard Event Object field
	 * allDay if set false it will show the time
	 *
	 * @see http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
	 * @see http://arshaw.com/fullcalendar/docs/event_rendering/eventRender/
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $res
	 * @param $outputMode
	 *
	 * @return array
	 */
	protected function getEventData( SMWQueryResult $res, $outputMode ) {
		$data = array();

		while ( $row = $res->getNext() ) {
			// Loop over available fields (properties)
			$rowData = array();
			$rowDesc = array();

			/**
			 * Loop over the subject row
			 *
			 * @var SMWResultArray $field
			 */
			foreach ( $row as $field ) {

				// Property label
				$propertyLabel = $field->getPrintRequest()->getLabel();

				/**
				 * Loop over all values for a property
				 *
				 * @var SMWDataValue $object
				 */
				while ( ( $object = $field->getNextDataValue() ) !== false ) {

					// A subject (page or subobject id) is always the source for an event
					// Source -> a page -> subject -> is an event or
					// Source -> n subobject -> subject -> is n event
					if ( !isset( $rowData['url'] ) ) {
						$rowData['url'] = $this->getLinker( $this->mLinker ) !== null ? $field->getResultSubject()->getTitle()->getFullURL() : '';
						// The title is mandatory and for events that don't explicitly
						// specify their title use the subject text
						$rowData['title'] = $field->getResultSubject()->getTitle()->getText();
					}

					if ( $object->getDataItem()->getDIType() == SMWDataItem::TYPE_WIKIPAGE ) {

						// Identify properties with a specific inherent meaning through a fixed
						// identifier assigned to a property (Fixed identifiers are title, icon, color)
						// Its allows a property to be variable within a query while its identifier
						// reamain fixed without the need for extra parameters
						if ( $propertyLabel === 'title' ) {
							$rowData['title'] = $object->getWikiValue();
						} elseif ( $propertyLabel === 'icon' ) {
							$rowData['eventicon'] = $object->getWikiValue();
						} elseif ( $propertyLabel !== '' ) {
							// Items without fixed identifiers remain part of a description
							$rowDesc[] = $this->mShowHeaders === SMW_HEADERS_HIDE ? $object->getWikiValue() : $propertyLabel . ': ' . $object->getWikiValue();
						}

					} elseif ( $object->getDataItem()->getDIType() == SMWDataItem::TYPE_TIME ){
						// If the start date was set earlier we interfere that the next date
						// we found in the same row is an end date
						if ( array_key_exists( 'start', $rowData ) ) {
							$rowData['end'] = $object->getISO8601Date();
							// No time for an event means it is an all day event
							$rowData['allDay'] = $object->getTimeString() === '00:00:00' ? true : false;
						} else {
							$rowData['start'] = $object->getISO8601Date();
						}
					} elseif ( $object->getDataItem()->getDIType() == SMWDataItem::TYPE_URI ){
						// Get holiday feed url (google calendar etc.)
						// if ( $field->getPrintRequest()->getLabel() === $this->params['holidaycal'] && $this->params['holidaycal'] !== '' ) {
						// $this->holidayCal = $object->getURI();
						// }
					} else {
						// Check other types such as string or blob because a title
						// don't have to be of type wikipage
						if ( $propertyLabel === 'title' ) {
							$rowData['title'] = $object->getWikiValue();
						} elseif ( $propertyLabel === 'color' ) {
							// Identify the color which should be a string otherwise
							// #DDD color specs will cause an error
							$rowData['color'] = $object->getWikiValue();
						} elseif ( $propertyLabel !== '' ){
							// Collect remaining items as part of a description
							$rowDesc[] = $this->mShowHeaders === SMW_HEADERS_HIDE ? $object->getWikiValue() : $propertyLabel . ': ' . $object->getWikiValue();
						}
					}
				}
				// Concatenate fields
				$rowData['description'] = implode (', ', $rowDesc );
			}
			// Ensure that the array is not empty and has a start date
			if ( $rowData !== array() && array_key_exists( 'start', $rowData ) ) {
				$data[]= $rowData;
			}
		}
		return $data;
	}

	/**
	 * Prepare calendar output
	 *
	 * @since 1.8
	 *
	 * @param array $events
	 * @return string
	 */
	protected function getCalendarOutput( array $events ) {

		// Init
		static $statNr = 0;
		$calendarID = 'calendar-' . ++$statNr;

		$this->isHTML = true;

		// Consistency of names otherwise fullCalendar throws an error
		$defaultVS   = array ( 'day', 'week');
		$defaultVR   = array ( 'Day', 'Week');
		$defaultView = str_replace ( $defaultVS, $defaultVR, $this->params['defaultview'] );

		// Add options
		$dataObject['events']  = $events;
		$dataObject['options'] = array(
			'defaultview'   => $defaultView,
			'calendarstart' => $this->getCalendarStart( $events, $this->params['start'] ),
			'dayview'       => $this->params['dayview'],
			'firstday'      => date( 'N', strtotime( $this->params['firstday'] ) ),
			'theme'         => in_array( $this->params['theme'], array( 'vector' ) ),
			'views' => 'month,' .
				( strpos( $defaultView, 'Week') === false ? 'basicWeek' : $defaultView ) . ',' .
				( strpos( $defaultView, 'Day' ) === false ? 'agendaDay' : $defaultView ),
		);

		// Encode data objects
		$requireHeadItem = array ( $calendarID => FormatJson::encode( $dataObject ) );
		SMWOutputs::requireHeadItem( $calendarID, Skin::makeVariablesScript($requireHeadItem ) );

		// RL module
		SMWOutputs::requireResource( 'ext.srf.eventcalendar' );

		// Processing placeholder
		$processing = SRFUtils::htmlProcessingElement( $this->isHTML );

		// Container placeholder
		$calendar = Html::rawElement(
			'div',
			array( 'id' => $calendarID, 'class' => 'container', 'style' => 'display:none;' ),
			null
		);

		// Beautify class selector
		$class = $this->params['class'] ? ' ' . $this->params['class'] : '';

		// General wrappper
		return Html::rawElement(
			'div',
			array( 'class' => 'srf-eventcalendar' . $class ),
			$processing . $calendar
		);
	}

	/**
	 * Return either the earliest or latest date of an array
	 *
	 * @since 1.8
	 *
	 * @param array $events
	 * @param $option
	 *
	 * @return string
	 */
	private function getCalendarStart( array $events , $option ){
		if ( in_array( $option, array( 'earliest', 'latest' ) ) ){
			// Sort with an anoymous function
			usort( $events, function ( $arr1, $arr2 ) use( $option ) {
					return strcmp( $arr1['start'], $arr2['start'] ) * ( $option === 'latest' ? -1 : 1 );
			} );
			return $events[0]['start'];
		} else {
			return null;
		}
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['defaultview'] = array(
			'message' => 'srf-paramdesc-calendardefaultview',
			'default' => 'month',
			'values' => array ( 'month', 'basicweek', 'basicday', 'agendaweek', 'agendaday' )
		);

		$params['firstday'] = array(
			'message' => 'srf-paramdesc-calendarfirstday',
			'default' => 'Sunday',
			'values' => array ( "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" )
		);

		$params['start'] = array(
			'message' => 'srf-paramdesc-calendarstart',
			'default' => 'current',
			'values' => array ( 'current', 'earliest', 'latest' )
		);

		$params['dayview'] = array(
			'type' => 'boolean',
			'message' => 'srf-paramdesc-dayview',
			'default' => '',
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		$params['theme'] = array(
			'message' => 'srf-paramdesc-theme',
			'default' => 'basic',
			'values' => array ( 'basic', 'vector' )
		);

		return $params;
	}
}
