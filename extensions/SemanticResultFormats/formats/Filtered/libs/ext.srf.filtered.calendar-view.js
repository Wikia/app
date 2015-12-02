/**
 * File holding the calendar-view plugin
 *
 * For this plugin to work, the filtered plugin needs to be available first.
 * You will also need the fullcalendar jQuery plugin.
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

(function ($) {

	/**
	 * Internationalization (i18n) support
	 *
	 * @see http://arshaw.com/fullcalendar/docs/text/timeFormat/
	 * @see http://arshaw.com/fullcalendar/docs/text/titleFormat
	 * @see http://arshaw.com/fullcalendar/docs/agenda/axisFormat/
	 * @see http://arshaw.com/fullcalendar/docs/text/columnFormat/
	 *
	 * @todo this i18n support is borrowed from the eventcalendar format. can we somehow merge stuff?
	 */
	var _i18n= {
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

	if ( !Date.prototype.toISOString ) { // IE compatibility: IE does not know Date.toISOString()

		( function() {

			function pad(number) {
				var r = String(number);
				if ( r.length === 1 ) {
					r = '0' + r;
				}
				return r;
			}

			Date.prototype.toISOString = function() {
				return this.getUTCFullYear()
				+ '-' + pad( this.getUTCMonth() + 1 )
				+ '-' + pad( this.getUTCDate() )
				+ 'T' + pad( this.getUTCHours() )
				+ ':' + pad( this.getUTCMinutes() )
				+ ':' + pad( this.getUTCSeconds() )
				+ '.' + String(
					(this.getUTCMilliseconds()/1000).toFixed(3) ).slice( 2, 5 )
				+ 'Z';
			};

		}() );
	}

	var methods = {

		init: function( args ){

			var filteredData = this.data('ext.srf.filtered');
			var filteredView = this.find('.filtered-views-container').find('.filtered-calendar');

			// initialize the data for this view

			var values = filteredData.values;
			var viewData = filteredData.data.viewdata['calendar'];
			var titleId = viewData.title;

			for ( var i in values ) {

				var value = values[i]

				if ( typeof value.data['calendar-view'] == 'undefined' ){
					value.data['calendar-view'] = {};
				}

				var valueData = value.data['calendar-view'];

				if ( typeof valueData['title'] == 'undefined') {
					if ( typeof value.printouts[titleId] != 'undefined' &&
						typeof value.printouts[titleId]['values'][0] != 'undefined') {

						valueData['title'] = value.printouts[titleId]['values'][0];
					} else {
						valueData['title'] = '';
					}
				}
			}

			// initialize the calendar
			filteredView.fullCalendar({

				firstDay: viewData.firstDay,
				isRTL: viewData.isRTL,
				monthNames: _i18n.monthNames,
				monthNamesShort: _i18n.monthNamesShort,
				dayNames: _i18n.dayNames,
				dayNamesShort: _i18n.dayNamesShort,
				buttonText: _i18n.buttonText,
				allDayText: _i18n.allDayText,
				timeFormat: _i18n.timeFormat,
				titleFormat: _i18n.titleFormat,
				columnFormat: _i18n.columnFormat,

				eventRender: function( event, element, view ) {
					var title = filteredData.values[this.id].data['calendar-view'].title;
					if ( title ) {
						element.empty().append( title );
					}

					element.addClass( event.id );

					if ( filteredData.values[event.id].data.visibility.overall === true ) {
						element.show();
					} else {
						element.hide();
					}
				},
				events: function(start, end, callback) {
					var events = [];

					var values = filteredData.values;
					var startString = start.toISOString();
					var endString = end.toISOString();

					for ( var i in values ) {
						var valueData = values[i].data['calendar-view'];

						if ( typeof valueData['start'] != 'undefined' && filteredView.find( '.' + i ).length === 0 ){

							if ( valueData['start'] >= startString && valueData['start'] <= endString ||
								typeof valueData['end'] != 'undefined' && valueData['end'] >= startString && valueData['start'] <= endString ) {

								var eventdata = {
									id     : i,
									title  : valueData['title'],
									start  : valueData['start']
								};

								if ( typeof valueData['end'] != 'undefined' ){
									eventdata['end'] = valueData['end'];
								}

								if ( typeof valueData['url'] != 'undefined' ){
									eventdata['url'] = valueData['url'];
								}

								events.push( eventdata );
							}

						}
					}

					callback( events );
				}
			});

			return this;
		},

		alert: function(){
			alert('Calendar View!');
			return this;
		},

		updateItem: function(params){
			return calendarView.apply( this, ['updateAllItems'] );
		},

		updateAllItems: function(){

			var filteredView = this.find('.filtered-views-container').children('.filtered-calendar');
			var viewData = this.data('ext.srf.filtered')['data'].viewdata['calendar'];

			window.clearTimeout(viewData.refreshTimer);

			viewData.refreshTimer = window.setTimeout(function(){
				filteredView.fullCalendar('render');
			}, 10);

			return this;
		},

		show:  function() {
			jQuery(this)
			.show()
			.fullCalendar( 'render' );

		},

		hide:  function() {
			jQuery(this).hide();
		}

	};

	var calendarView = function( method ) {

		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.filtered.calendarView' );
		}


	};

	// attach ListView to all Filtered query printers
	// let them sort out, if ListView is actually applicable to them
	jQuery('.filtered').filtered('attachView', 'calendar', calendarView );

})(jQuery);

