/**
 * File holding the filtered plugin
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

(function ($) {

	var methods = {
		
		init: function( args ){

			return this.each( function() {
				var data = args['data'];
				$(this).data( 'ext.srf.filtered', data );

				data['data']['pending-filters'] = [];
				data['data']['pending-views'] = [];
				
				for (var i in data['data']['filterhandlers']) {
					data['data']['pending-filters'].push(i);
				}
				
				for (var i in data['data']['viewhandlers']) {
					data['data']['pending-views'].push(i);
				}
				
				// init housekeeping on values
				for (i in data['values']) {

					data['values'][i]['data'] =	{
						
						'visibility': {
							'overall' : true,
							'votes' : {}
						}
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
				}
				
				var pendingViews = $this.data('ext.srf.filtered')['data']['pending-views'];
				
				var i = $.inArray(viewName, pendingViews);
				pendingViews.splice(i, 1);
				
				if ( pendingViews.length == 0 && $this.data('ext.srf.filtered')['data']['pending-filters'].length == 0) {					

					for (var i in viewhandlers){
						viewhandlers[i].apply( $this, ['updateAllItems'] );
					}
				}
				
				return this;
			});
		},
		
		attachFilter : function( filterName, filter ) {
			return this.each( function() {
				
				var $this = $(this);
				
				var handlers = $this.data('ext.srf.filtered')['data']['filterhandlers'];
				
				if ( filterName in handlers ) {
					handlers[filterName] = filter;
					var printouts = $this.data('ext.srf.filtered')['data']['filterdata'][filterName];
					
					for ( var i in printouts ) {
						(handlers[filterName]).apply($this, [ 'init', {
							printout: i
						} ] );
					}
					
				}

				var pendingFilters = $this.data('ext.srf.filtered')['data']['pending-filters'];
				
				// take attached filter from list of pending filters
				var i = $.inArray(filterName, pendingFilters);
				pendingFilters.splice(i, 1);
				
				if ( pendingFilters.length == 0 && $this.data('ext.srf.filtered')['data']['pending-views'].length == 0) {
					var viewhandlers = $this.data('ext.srf.filtered')['data']['viewhandlers'];

					for (var i in viewhandlers){
						viewhandlers[i].apply( $this, ['updateAllItems'] );
					}
				}				
				return this;
			});
		},
		
		voteItemVisibility : function( params ) {
			var item = this.data('ext.srf.filtered')['values'][params['item']];
			var votes = item.data['visibility']['votes'];
			
			// Figure out if the vote changed from the filter in the params
			var voteChanged = 
				votes[params['filter'] + ' ' + params['printout']] == undefined ||
				votes[params['filter'] + ' ' + params['printout']] != params['visible'];
			
			// Store the new vote
			votes[params['filter'] + ' ' + params['printout']] = params['visible'];
			
			// If vote from filter changed, figure out if it has an impact on the end result
			if ( voteChanged ) {
				
				var visible=true;
				for ( var i in votes ) {
					visible = visible && votes[i];
				}
				
				voteChanged = item.data['visibility']['overall'] != visible;
				
				// Store new end result
				item.data['visibility']['overall'] = visible;
			}
				
			
			return voteChanged;
		},
		
		voteItemVisibilityAndUpdate : function( params ) {

			
			if ( methods.voteItemVisibility.apply(this, [params]) ) {

				var handlers = this.data('ext.srf.filtered')['data']['viewhandlers'];

				for (var i in handlers){
					handlers[i].apply( this, ['updateItem', params] );
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
