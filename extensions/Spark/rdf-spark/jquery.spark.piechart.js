/**
 * Spark query result format "piechart"
 * 
 * == Description ==
 * Displays the result set as a pie chart using jqPlot.
 * 
 * == SPARQL variable names ==
 * ?entity URI of the entity this slice is about 
 * ?value of type numeric, deciding on the size of the pie
 * ?label for naming the pie slice
 * 
 * == Parameters ==
 * none for now
 *    
 * == Additional required files ==
 * jquery.jqplot.js
 * jqplot.pieRenderer.js
 * jquery.jqplot.css
 * 
 * == Notes ==
 * Feel free to extend the parameters.
 * If there are multiple values for time or value in one field, only one will
 * be chosen randomly. This should be regarded as a bug.
 */
(function($){
	$.jqplot.config.enablePlugins = true;
	
	var pieargs = function(values) {
		var res = [];
		$.each(values, function(entity, properties) {
			res.push([properties.label[0], parseInt(properties.value[0], 10)]);
		});
		return res;
	};
		
	$.spark.format.piechart = function(element, result, reduced, params) {
		if (element.attr('id') === '')
			element.attr('id', 'p' + Math.floor(Math.random()*10000000000000000));
		element.html('');
		$.jqplot(element.attr('id'), [pieargs(reduced)], {
			seriesDefaults : {
				renderer : $.jqplot.PieRenderer,
				rendererOptions : {
					showDataLabels : true,
					dataLabels : 'label'
				}
			}
		});
	};
})(jQuery);
