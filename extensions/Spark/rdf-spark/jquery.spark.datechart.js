/**
 * Spark query result format "datechart"
 * 
 * == Description ==
 * Displays the result set as a date chart using jqPlot.
 * 
 * == SPARQL variable names ==
 * ?series Is the identifier for the series, so that values for several
 *         entities can be displayed at the same time
 * ?series_label a label for the series (used for the legend)
 * ?time of type time, point of time when the given value is correct
 * ?value of type numeric, the value of the property at the given time
 * Remember that the first SPARQL variable is the reduction target, i.e.
 * it must be a unique identifier for the single datapoint.
 * 
 * == Parameters ==
 * No parameters, yet.
 * 
 * == Additional required file ==
 * jquery.jqplot.js
 * jqplot.dateAxisRenderer.js
 * jquery.jqplot.css
 * 
 * == Notes ==
 * Feel free to extend the parameters.
 * If there are multiple values for time or value in one field, only one will
 * be chosen randomly. This should be regarded as a bug.
 */

(function($) {
	$.jqplot.config.enablePlugins = true;

	var chartargs = function(values, params) {
		var intermediate = {};
		$.each(values, function(entity, properties) {
			if (intermediate[properties.series[0]] === undefined)
				intermediate[properties.series[0]] = [];

			intermediate[properties.series[0]].push([ properties.time[0],
					parseInt(properties.value[0]) ]);
		});
		var res = [];
		$.each(intermediate, function(series, datapoints) {
			res.push(datapoints);
		});
		return res;
	};
	
	/**
	 * Prepare series for legend
	 */
	var legendargs = function(values, params) {
		var intermediate = {};
		$.each(values, function(entity, properties) {
			if (intermediate[properties.series[0]] === undefined)
				intermediate[properties.series[0]] = [];
			
			intermediate[properties.series[0]].push([ properties.time[0],
					parseInt(properties.value[0]) ]);
		});
		var res = [];
		$.each(intermediate, function(series_label, datapoints) {
			
			//res.push(series);
			res.push({label:series_label});
		});
		return res;
	};

	$.spark.format.datechart = function(element, result, reduced, params) {
		if (element.attr('id') === '')
			element.attr('id', 'p'
					+ Math.floor(Math.random() * 10000000000000000));
		element.html('');
		$.jqplot(element.attr('id'), chartargs(reduced, params), {
			axes : {
				xaxis : {
					renderer : $.jqplot.DateAxisRenderer
				}
			},
	        legend: {
	            show: true,
	            showSwatches: true
	        },
			series:legendargs(reduced, params)
		});
	};
})(jQuery);
