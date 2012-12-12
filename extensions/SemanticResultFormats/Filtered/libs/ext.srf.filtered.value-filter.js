/**
 * File holding the value-filter plugin
 * 
 * For this plugin to work, the filtered plugin needs to be available first.
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

(function ($) {

	var methods = {
		
		init: function( args ){
			
			function update( filtered, filtercontrols, target ) {
				
					var values = filtered.data('ext.srf.filtered')['values'];
					var selectedInputs = filtercontrols.children('div.filtered-value-option').children('input:checked');
					
					// show all if no value is checked
					if ( selectedInputs.length == 0 ) {
						for ( i in values ) {
							filtered.filtered( 'voteItemVisibilityAndUpdate', {
								'filter': 'value', 
								'printout' : target, 
								'visible': true,
								'item': i
							});
						}
								
					} else {
								
						for ( i in values ) {

							var printoutValues = values[i]['printouts'][target]['values'];
							var useOr = filtered.filtered( 'getFilterData', {filter: 'value', printout: target, configvar: 'use or'} );

							if ( useOr ) {
								var selected = false;

								for ( var j in printoutValues ) {

									selectedInputs.each(function(){
										selected = selected || ( printoutValues[j] == $(this).attr('value') );
									});
								}
							} else {
								var selected = ( printoutValues.length > 0 );

								if ( selected ) {
									// try to find each required value
									selectedInputs.each(function(){

										var selectedFoundInPrintout = false;
										for ( var j in printoutValues ) {
											selectedFoundInPrintout = selectedFoundInPrintout || ( printoutValues[j] == $(this).attr('value') );

											if ( selectedFoundInPrintout ) {
												break;
											}
										}
										selected = selected && selectedFoundInPrintout;
									});
								}
							}

							filtered.filtered( 'voteItemVisibilityAndUpdate', {
								'filter': 'value', 
								'printout' : target, 
								'visible': selected,
								'item': i
							});

						}
					}
			}
			
			var filtered = this;
			
			var values = this.data('ext.srf.filtered')['values'];
			var target = args.printout;
			var switches = filtered.filtered( 'getFilterData', {filter: 'value', printout: target, configvar: 'switches'} );
			
			// find distinct values and set visibility for all items that have
			// some value for this printout
			var distinctValues = [];
			
			var i;
			for ( i in values ) {
				var printoutValues = values[i]['printouts'][target]['values'];
				
				for (var j in printoutValues) {
					distinctValues[ printoutValues[j] ] = true;
				}

				filtered.filtered( 'voteItemVisibility', {
					'filter': 'value', 
					'printout' : target, 
					'visible': true,
					'item': i
				});
			}
			
			// build filter controls
			var filtercontrols = this.children('.filtered-filters').children('.' + target).filter('.filtered-value');
			
			// insert the label of the printout this filter filters on
			filtercontrols.append('<div class="filtered-value-label"><span>' + values[i]['printouts'][target]['label'] + '</span></div>');

			// set default config values
			filtered.filtered( 'setFilterData', {filter: 'value', printout: target, configvar: 'use or', configvalue: true} );
			
			
			// insert switches
			if ( switches != null && switches.length > 0 ) {
			
				var switchControls = $('<div class="filtered-value-switches">');
			
				if ( $.inArray('and or', switches) >= 0 ) {

					var andorControl = $('<div class="filtered-value-andor">');
					var andControl = $('<input type="radio" name="filtered-value-andor ' +
						target + '"  class="filtered-value-andor ' + target + '" value="and">');

					var orControl = $('<input type="radio" name="filtered-value-andor ' +
						target + '"  class="filtered-value-andor ' + target + '" value="or" checked>');

					andControl
					.add( orControl )
					.change(function() {
						filtered.filtered( 'setFilterData', {filter: 'value', printout: target, configvar: 'use or', configvalue: orControl.is(':checked')} );
						update( filtered, filtercontrols, target );
					});

					andorControl
					.append( orControl )
					.append(' OR ')
					.append( andControl )
					.append(' AND ')
					.appendTo( switchControls );

				}
				
				filtercontrols.append( switchControls );
			}
			var sortedDistinctValues = [];
			
			for ( var i in distinctValues ) {
				sortedDistinctValues.push(i);
			}
			
			sortedDistinctValues.sort();
			
			// insert options (checkboxes and labels) and attach event handlers
			// TODO: Do we need to wrap these in a form?
			for ( var j in sortedDistinctValues ) {
				var option = $('<div class="filtered-value-option">');
				var checkbox = $('<input type="checkbox" class="filtered-value-value" value="' + sortedDistinctValues[j] + '"  >');
				
				// attach event handler
				checkbox.change(function( evt ){
					update(filtered, filtercontrols, target);
				});
				
				option
				.append(checkbox)
				.append(sortedDistinctValues[j]);
				
				filtercontrols
				.append(option);
				
			}
			
			return this;
		},
		
		alert: function(){
			alert('ValueFilter!');
			return this;
		}
		
	};

	valueFilter = function( method ) {
  
		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.filtered.listView' );
		}    


	};

	// attach ListView to all Filtered query printers
	// let them sort out, if ListView is actually applicable to them
	jQuery('.filtered').filtered('attachFilter', 'value', valueFilter );

})(jQuery);

