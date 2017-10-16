/**
 * File holding the filtered plugin
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

(function ($) {

	var activeHandler = null;

	var methods = {

		init: function( args ){

			return this.each( function() {
				var data = args['data'];
				$(this).data( 'ext.srf.filtered', data );

				// take note of filters, views and sorters we expect to be loaded
				data['data']['pending-filters'] = [];
				data['data']['pending-views'] = [];
				data['data']['pending-sorters'] = [];

				for (var i in data['data']['filterhandlers']) {
					data['data']['pending-filters'].push(i);
				}

				for (var i in data['data']['viewhandlers']) {
					data['data']['pending-views'].push(i);
				}

				for (var i in data['data']['sorthandlers']) {
					data['data']['pending-sorters'].push(i);
				}

				// init housekeeping on values
				for (i in data['values']) {

					data['values'][i]['data']['visibility'] =	{
						'overall' : true,
						'votes' : {}
					}

				}

				return this;
			});
		},

		attachView : function( viewName, view ) {
			return this.each( function() {

				var $this = $(this);

				var viewhandlers = $this.data('ext.srf.filtered')['data']['viewhandlers'];

				if ( viewName in viewhandlers ) {

					viewhandlers[viewName] = view;

					var pendingViews = $this.data('ext.srf.filtered')['data']['pending-views'];

					var i = $.inArray(viewName, pendingViews);
					pendingViews.splice(i, 1);

					$this.filtered( 'tryInitAllViews' );
				}

				return this;
			});
		},

		attachFilter : function( filterName, filter ) {
			return this.each( function() {

				var $this = $(this);

				var filterhandlers = $this.data('ext.srf.filtered')['data']['filterhandlers'];

				if ( filterName in filterhandlers ) {
					filterhandlers[filterName] = filter;

					// get the printouts this filter should be applied on
					var printouts = $this.data('ext.srf.filtered')['data']['filterdata'][filterName];

					// init filter for every applicable printout
					for ( var i in printouts ) {
						(filterhandlers[filterName]).apply($this, [ 'init', {
							printout: i
						} ] );
					}

				}

				var pendingFilters = $this.data('ext.srf.filtered')['data']['pending-filters'];

				// take attached filter from list of pending filters
				var i = $.inArray(filterName, pendingFilters);
				pendingFilters.splice(i, 1);

				$this.filtered( 'tryInitAllViews' );

				return this;
			});
		},

		attachSorter : function( sorterName, sorter ) {
			return this.each( function() {

				var $this = $(this);

				var sorthandlers = $this.data('ext.srf.filtered')['data']['sorthandlers'];

				if ( sorterName in sorthandlers ) {
					sorthandlers[sorterName] = sorter;

					// get the printouts this filter should be applied on
					var printouts = $this.data('ext.srf.filtered')['data']['sorterdata'][sorterName];

					// init filter for every applicable printout
					for ( var i in printouts ) {
						(sorthandlers[sorterName]).apply($this, [ 'init', {
							printout: i
						} ] );
					}

				}

				var pendingSorters = $this.data('ext.srf.filtered')['data']['pending-sorters'];

				// take attached filter from list of pending filters
				var i = $.inArray(sorterName, pendingSorters);
				pendingSorters.splice(i, 1);

				$this.filtered( 'tryInitAllViews' );

				return this;
			});
		},

		tryInitAllViews: function( ) {

			var $this = $(this);

			if ( $this.data('ext.srf.filtered')['data']['pending-filters'].length == 0 &&
				$this.data('ext.srf.filtered')['data']['pending-sorters'].length == 0 &&
				$this.data('ext.srf.filtered')['data']['pending-views'].length == 0	) {

				var viewhandlers = $this.data('ext.srf.filtered')['data']['viewhandlers'];
				var viewelements = $this.data('ext.srf.filtered')['data']['viewelements'];

				for (var i in viewhandlers){
					viewhandlers[i].apply( $this, ['init'] );
					viewhandlers[i].apply( $this, ['updateAllItems'] );
				}

				// find all selectors
				var selectors = $this.find( '.filtered-view-selector');

				// if we have selector tabs attach event handlers for selecting views
				if ( selectors.length > 0 ) {

					// find all selectors
					var views = $this.find( '.filtered-view');

					// register event on selectors that toggles the active selector
					// and view
					selectors.click(function(){

						// toggle classes for selectors
						jQuery( this ).removeClass( 'inactive' ).addClass( 'active' );
						selectors.not( this ).removeClass( 'active' ).addClass( 'inactive' );

						// find id of clicked selector
						var classes = jQuery( this ).attr( 'class' );
						var re = /filtered-view-id[^ ]*/;
						var id = re.exec( classes )[0];

						// toggle classes for the view corresponding to the clicked selector
						for ( var handlerName in viewhandlers ) {
							if ( 'filtered-view-id' + viewelements[handlerName] == id ) {
								viewhandlers[handlerName].apply( views.filter( '.' + id ), ['show'] );
								activeHandler = viewhandlers[handlerName];
							} else {
								views.not( '.' + id ).each( function(){
									viewhandlers[handlerName].apply( this, ['hide'] );
								});
							}
						}
					});

					// simulate click on first selector
					selectors.first().click();
				} else if ( viewhandlers.length > 0 ) {
					activeHandler = viewhandlers[0];
				}
			}

			$this.children('.filtered-views').show();
		},

		/**
		 * Each filter can vote (well veto) on the visibility of an item
		 */
		voteItemVisibility : function( params ) {
			var item = this.data('ext.srf.filtered')['values'][params['item']];
			var votes = item.data['visibility']['votes'];
			var visible = params['visible'];

			// Figure out if the vote changed from the filter in the params
			var voteChanged =
			votes[params['filter'] + ' ' + params['printout']] == undefined ||
			votes[params['filter'] + ' ' + params['printout']] != visible;

			// Store the new vote
			votes[params['filter'] + ' ' + params['printout']] = visible;

			// If vote from filter changed, figure out if it has an impact on the end result
			if ( voteChanged ) {

				// if this filter wants it visible, see what the other filters want
				if ( visible ) {
					for ( var i in votes ) {
						visible = visible && votes[i];
						if ( !visible ) break;
					}
				}

				voteChanged = item.data['visibility']['overall'] != visible;

				// Store new end result
				item.data['visibility']['overall'] = visible;
			}


			return voteChanged;
		},

		voteItemVisibilityAndUpdate : function( params ) {

			if ( methods.voteItemVisibility.apply(this, [params]) ) {

				if ( activeHandler !== null ) {
					activeHandler.apply( this, ['updateItem', params] );
				}

				var handlers = this.data('ext.srf.filtered')['data']['viewhandlers'];

				for (var i in handlers){
					if (handlers[i] != activeHandler){
						handlers[i].apply( this, ['updateItem', params] );
					}
				}
			}
			return this;
		},

		updateAllItems : function( params ) {

			if ( activeHandler !== null ) {
				activeHandler.apply( this, ['updateAllItems', params] );
			}

			var handlers = this.data('ext.srf.filtered')['data']['viewhandlers'];

			for (var i in handlers){
				if (handlers[i] != activeHandler){
					handlers[i].apply( this, ['updateAllItems', params] );
				}
			}

			return this;
		},

		getFilterData : function ( params ) {
			if ( params['filter'] == undefined ) {
				return this.data('ext.srf.filtered')['data']['filterdata']
			} else if ( params['printout'] == undefined ) {
				return this.data('ext.srf.filtered')['data']['filterdata'][params['filter']];
			} else if ( params['configvar'] == undefined ) {
				return this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']];
			} else {
				if (this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']] != null) {
					return this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']][params['configvar']];
				} else {
					return null;
				}
			}
		},

		setFilterData : function ( params ) {
			if ( params['filter'] == undefined ||
				params['printout'] == undefined ||
				params['configvar'] == undefined ||
				params['configvalue'] == undefined ) {
				return null;
			} else {
				if (this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']] == null) {
					this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']] = {}
				}
				this.data('ext.srf.filtered')['data']['filterdata'][params['filter']][params['printout']][params['configvar']] = params['configvalue'];
			}
		},

		getValues : function ( params ) {
			return this.data('ext.srf.filtered')['data'];
		},

		isVisible : function ( item ) {
			return this.data('ext.srf.filtered')['values'][item]['data']['visibility']['overall'];
		}
	};

	$.fn.filtered = function( method ) {

		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}


	};

})(jQuery);

// initialize all Filtered
for ( id in srf_filtered_values ) {
	jQuery('.' + id).filtered( {
		'data' : srf_filtered_values[ id ]
	});
}
