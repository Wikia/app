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
					for ( valueId in values ) {
						filtered
						.filtered( 'voteItemVisibility', {
							'filter': 'value',
							'printout' : target,
							'visible': true,
							'item': valueId
						});
					}

					filtered
					.filtered( 'updateAllItems');
				} else {

					var useOr = filtered.filtered( 'getFilterData', {
						filter: 'value',
						printout: target,
						configvar: 'use or'
					} );
					
					var printoutValues;
					var selected;
					
					var targetValues = new Array();
					selectedInputs.each(function(){
						targetValues.push( $(this).attr('value') );
					});

					for ( valueId in values ) {

						printoutValues = values[valueId]['printouts'][target]['values'];
						
						if ( printoutValues.length > 0 ){
							if ( useOr ) {
								
								selected = false;

								for ( var k = 0; k < targetValues.length && ! selected; ++k ) {
									for ( var j = 0; j < printoutValues.length && ! selected; ++j ) {
										selected = selected || ( printoutValues[j] == targetValues[k] );
									}
								}

							} else {
								
								selected = true;

								// try to find each required value
								for ( var k = 0; k < targetValues.length && selected; ++k ) {

									var selectedFoundInPrintout = false;
									
									for ( var j = 0; j < printoutValues.length && ! selectedFoundInPrintout; ++j ) {
										selectedFoundInPrintout = selectedFoundInPrintout || ( printoutValues[j] == targetValues[k] );
									}
									
									selected = selected && selectedFoundInPrintout;
								}
							}
						}
						
						filtered.filtered( 'voteItemVisibilityAndUpdate', {
							'filter': 'value',
							'printout' : target,
							'visible': selected,
							'item': valueId
						});

					}
				}
			}  // function update( filtered, filtercontrols, target )


			var filtered = this;

			var values = this.data('ext.srf.filtered')['values'];
			var target = args.printout;
			var switches = filtered.filtered( 'getFilterData', {
				filter: 'value',
				printout: target,
				configvar: 'switches'
			} );
			var collapsible = filtered.filtered( 'getFilterData', {
				filter: 'value',
				printout: target,
				configvar: 'collapsible'
			} );
			var height = filtered.filtered( 'getFilterData', {
				filter: 'value',
				printout: target,
				configvar: 'height'
			} );
			var fixedValues = filtered.filtered( 'getFilterData', {
				filter: 'value',
				printout: target,
				configvar: 'values'
			} );

			var valueId; // just some valid value ID
			if ( fixedValues == null ) {
				// build filter values from available values in result set

				// find distinct values and set visibility for all items that have
				// some value for this printout
				var distinctValues = [];

				for ( valueId in values ) {
					var printoutValues = values[valueId]['printouts'][target]['values'];

					for (var j in printoutValues) {
						distinctValues[ printoutValues[j] ] = true;
					}

					filtered.filtered( 'voteItemVisibility', {
						'filter': 'value',
						'printout' : target,
						'visible': true,
						'item': valueId
					});
				}

				var sortedDistinctValues = [];

				for ( var i in distinctValues ) {
					sortedDistinctValues.push(i);
				}

				sortedDistinctValues.sort();
			} else {
				// use given values
				sortedDistinctValues = fixedValues.split(/\s*,\s*/);

				for ( valueId in values ) break; // get some valid value ID
			}

			// build filter controls
			var filtercontrols = this.children('.filtered-filters').children('.' + target).filter('.filtered-value');

			// insert the label of the printout this filter filters on
			filtercontrols.append('<div class="filtered-value-label"><span>' + values[valueId]['printouts'][target]['label'] + '</span></div>');

			if ( collapsible != null && ( collapsible == 'collapsed' || collapsible == 'uncollapsed') ) {

				var showControl = $('<span class="filtered-value-show">[+]</span>');
				var hideControl = $('<span class="filtered-value-hide">[-]</span>');

				filtercontrols
				.prepend(showControl)
				.prepend(hideControl);

				filtercontrols = $('<div class="filtered-value-collapsible">')
				.appendTo(filtercontrols);

				var outercontrols = filtercontrols

				showControl.click(function(){
					outercontrols.slideDown();
					showControl.hide();
					hideControl.show();
				});

				hideControl.click(function(){
					outercontrols.slideUp();
					showControl.show();
					hideControl.hide();
				});

				if ( collapsible == 'collapsed' ) {
					hideControl.hide();
					outercontrols.slideUp(0);
				} else {
					showControl.hide();
				}

			}

			// set default config values
			filtered.filtered( 'setFilterData', {
				filter: 'value',
				printout: target,
				configvar: 'use or',
				configvalue: true
			} );


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
						filtered.filtered( 'setFilterData', {
							filter: 'value',
							printout: target,
							configvar: 'use or',
							configvalue: orControl.is(':checked')
							} );
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

			if ( height != null ) {
				filtercontrols = $( '<div class="filtered-value-scrollable">' )
				.appendTo( filtercontrols );

				filtercontrols.height( height );
			}


			// insert options (checkboxes and labels) and attach event handlers
			// TODO: Do we need to wrap these in a form?
			for ( var j in sortedDistinctValues ) {
				var option = $('<div class="filtered-value-option">');
				var checkbox = $('<input type="checkbox" class="filtered-value-value" value="' + sortedDistinctValues[j] + '"  >');

				// attach event handler
				checkbox.change(function( evt ){
					setTimeout(function(){
						update(filtered, filtercontrols, target);
					}, 0);
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

	var valueFilter = function( method ) {

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

