/**
 * File holding the distance-filter plugin
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
			
			function update( filtered, filterDistance, target ) {
				
				for ( i in filtered.data('ext.srf.filtered')['values'] ) {

					filtered.filtered( 'voteItemVisibilityAndUpdate', {
						'filter': 'value', 
						'printout' : target, 
						'visible': values[i]['data']['distance-filter'] <= filterDistance,
						'item': i
					});

				}
				
			}  // function update( filtered, filterDistance, target )
			
			
			var filtered = this;
			
			var target = args.printout;
			var values = this.data('ext.srf.filtered')['values'];
			var data = this.data('ext.srf.filtered')['data']['filterdata']['distance'][target];
			
			var iniValue = data['initial value']?data['initial value']:data['max'];

			for ( var i in values ) {

				filtered.filtered( 'voteItemVisibility', {
					'filter': 'value', 
					'printout' : target, 
					'visible': values[i]['data']['distance-filter'] <= iniValue,
					'item': i
				});

			}

			// build filter controls
			var filtercontrols = this.children('.filtered-filters').children('.filtered-distance');
			
			var readout = $('<div class="filtered-distance-readout">' + iniValue + '</div>' );

			var table = $('<table class="filtered-distance-table"><tbody><tr><td class="filtered-distance-min-cell">0</td>' + 
				'<td class="filtered-distance-slider-cell"><div class="filtered-distance-slider"></div></td>' + 
				'<td class="filtered-distance-max-cell">' + data['max'] + '</td></tr>' +
				'<tr><td colspan=3 class="filtered-distance-unit-cell">' + data['unit'] + '</td></tr></tbody></table>');
			
			filtercontrols
			.append( '<div class="filtered-distance-label"><span>' + values[i]['printouts'][target]['label'] + '</span></div>' )
			.append( table );

			var slider = table.find('.filtered-distance-slider');

			slider.slider({
				animate: true,
				max: data['max'],
				value: iniValue,
				slide: function(event, ui) {
					readout.empty().append( ui.value );
				},
				change: function(event, ui) {
					update( filtered, ui.value, target );
				}
			});

			var handle = slider.find('.ui-slider-handle');

			handle
			.append( readout );
			
			return this;
		},
		
		alert: function(){
			alert('DistanceFilter!');
			return this;
		}
		
	};

	distanceFilter = function( method ) {
  
		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.filtered.distanceFilter' );
		}    


	};

	// attach ListView to all Filtered query printers
	// let them sort out, if ListView is actually applicable to them
	jQuery('.filtered').filtered('attachFilter', 'distance', distanceFilter );

})(jQuery);

