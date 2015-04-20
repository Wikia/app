/**
 * JavaScript for SRF event calendar module using the fullcalendar library
 * @see http://arshaw.com/fullcalendar/docs/
 * @see http://www.semantic-mediawiki.org/wiki/Help:Eventcalendar_format
 *
 * @since 1.8
 * @release 0.3
 *
 * @file
 * @ingroup SRF
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $ ) {
	'use strict';

	/*global mw:true*/

	////////////////////////// PRIVATE METHODS ////////////////////////

	// Create class reference
	var util = new srf.util(),
		tooltip = new smw.util.tooltip();

	/**
	 * Internationalization (i18n) support
	 *
	 * @see http://arshaw.com/fullcalendar/docs/text/timeFormat/
	 * @see http://arshaw.com/fullcalendar/docs/text/titleFormat
	 * @see http://arshaw.com/fullcalendar/docs/agenda/axisFormat/
	 * @see http://arshaw.com/fullcalendar/docs/text/columnFormat/
	 *
	 * @since 1.8
	 */
	var _i18n = {
		monthNames : [ mw.msg( 'january' ), mw.msg( 'february' ), mw.msg( 'march' ),
			mw.msg( 'april' ), mw.msg( 'may_long' ), mw.msg( 'june' ),
			mw.msg( 'july' ), mw.msg( 'august' ), mw.msg( 'september' ),
			mw.msg( 'october' ), mw.msg( 'november' ), mw.msg( 'december' )
		],
		monthNamesShort : [ mw.msg( 'jan' ), mw.msg( 'feb' ), mw.msg( 'mar' ),
			mw.msg( 'apr' ), mw.msg( 'may' ), mw.msg( 'jun' ),
			mw.msg( 'jul' ), mw.msg( 'aug' ), mw.msg( 'sep' ),
			mw.msg( 'oct' ), mw.msg( 'nov' ), mw.msg( 'dec' )
		],
		dayNames : [ mw.msg( 'sunday' ), mw.msg( 'monday' ), mw.msg( 'tuesday' ),
			mw.msg( 'wednesday' ), mw.msg( 'thursday' ), mw.msg( 'friday' ), mw.msg( 'saturday' )
		],
		dayNamesShort : [ mw.msg( 'sun' ), mw.msg( 'mon' ), mw.msg( 'tue' ),
			mw.msg( 'wed' ), mw.msg( 'thu' ), mw.msg( 'fri' ), mw.msg( 'sat' )
		],
		buttonText : {
			today:  mw.msg( 'srf-ui-eventcalendar-label-today' ),
			month: mw.msg( 'srf-ui-eventcalendar-label-month' ),
			week: mw.msg( 'srf-ui-eventcalendar-label-week' ),
			day: mw.msg( 'srf-ui-eventcalendar-label-day' )
		},
		allDayText : mw.msg( 'srf-ui-eventcalendar-label-allday' ),
		timeFormat : {
			'': mw.msg( 'srf-ui-eventcalendar-format-time' ),
			agenda: mw.msg( 'srf-ui-eventcalendar-format-time-agenda' )
		},
		axisFormat : mw.msg( 'srf-ui-eventcalendar-format-axis' ),
		titleFormat : {
			month: mw.msg( 'srf-ui-eventcalendar-format-title-month' ),
			week: mw.msg( 'srf-ui-eventcalendar-format-title-week' ),
			day: mw.msg( 'srf-ui-eventcalendar-format-title-day' )
		},
		columnFormat : {
			month: mw.msg( 'srf-ui-eventcalendar-format-column-month' ),
			week: mw.msg( 'srf-ui-eventcalendar-format-column-week' ),
			day: mw.msg( 'srf-ui-eventcalendar-format-column-day' )
		}
	};

	////////////////////////// PUBLIC METHODS ////////////////////////

	/**
	 * Calendar
	 *
	 * @since 1.8
	 */
	$.fn.srfEventCalendar = function() {

		var container = this.find( ".container" ),
			calendarID = container.attr( "id" ),
			json = mw.config.get( calendarID );

		// Parse json string and convert it back
		var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

		// Split start date (format is ISO8601 -> 2012-09-17T09:49Z)
		var calendarStart = data.options.calendarstart !== null ? data.options.calendarstart.split( '-', 3 ) : null;

		// Get Google holiday calendar url
		var gcalholiday = data.options.gcalurl === null ? '' : data.options.gcalurl;

		// Hide processing note
		util.spinner.hide( { context: this } );

		// Show container
		container.show();

		// Init calendar container
		container.fullCalendar( {
			header: {
				right: 'prev,next today',
				center: 'title',
				left: data.options.views
			},
			height: this.height(),
			defaultView: data.options.defaultview,
			firstDay: data.options.firstday,
			monthNames: _i18n.monthNames,
			monthNamesShort: _i18n.monthNamesShort,
			dayNames: _i18n.dayNames,
			dayNamesShort: _i18n.dayNamesShort,
			buttonText: _i18n.buttonText,
			allDayText: _i18n.allDayText,
			timeFormat: _i18n.timeFormat,
			titleFormat: _i18n.titleFormat,
			columnFormat: _i18n.columnFormat,
			theme: data.options.theme,
			editable: false,
			// Set undefined in case eventStart is not specified
			year: calendarStart !== null ? calendarStart[0] : undefined,
			// The value is 0-based, meaning January=0, February=1, etc.
			month: calendarStart !== null ? calendarStart[1] - 1 : undefined,
			// ...17T09:49Z only use the first two
			date: calendarStart !== null ? calendarStart[2].substring( 0, 2 ) : undefined,
			eventColor: '#48a0d5',
			eventSources: [ data.events, gcalholiday ],
			eventRender: function( event, element, view ) {
				// Handle event icons
				if ( event.eventicon ) {
					// Find image url and add an icon
					util.getImageURL( { 'title': event.eventicon },
							function( url ) { if ( url !== false ) {
								if ( element.find( '.fc-event-time' ).length ) {
									element.find( '.fc-event-time' ).before( $( '<img src=' + url + ' />' ) );
								} else {
									element.find( '.fc-event-title' ).before( $( '<img src=' + url + ' />' ) );
								}
							}
					} );
				}
				if ( event.description ) {
					// Show the tooltip for the month view and render any additional description
					// into the event for all other views
					if ( element.find( '.fc-event-title' ).length && view.name !== 'month' && view.name.indexOf( 'Day' ) >= 0 ) {
						element.find( '.fc-event-title' ).after( $( '<span class="srf-fc-description">' + event.description + '</span>' ) );
					} else {
						// Tooltip
						tooltip.show( {
							context: element,
							content: event.description.substring( 0, event.description.substr( 0, 100 ).lastIndexOf( " " ) ) + ' ...',
							title: mw.msg( 'smw-ui-tooltip-title-event' ),
							button: false
						} );
					}
				}
			},
			dayClick: function( date, allDay, jsEvent ) {
				// If the day number (where available) is clicked then switch to the daily view
				if ( allDay && data.options.dayview && $( jsEvent.target ).is( 'div.fc-day-number' ) ) {
					container.fullCalendar( 'changeView', 'agendaDay'/* or 'basicDay' */).fullCalendar( 'gotoDate', date );
				}
			}
		} );
	};

	////////////////////////// IMPLEMENTATION ////////////////////////

	$( document ).ready( function() {
		$( ".srf-eventcalendar" ).each( function() {
			$( this ).srfEventCalendar();
		} );
	} );
} )( window.jQuery );