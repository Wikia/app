/**
 * Example Spark Result Formatter.
 * 
 * When writing your own Spark Result Formatters, note the following:
 * 
 *  * call the format the same as the last element of the URL before the
 *    file .js extension. I.e. this file is called
 *    "jquery.spark.simpletable.js". The last element in that name before the
 *    extension is "simpletable", thus this is the name of the format described
 *    in this file. This allows to integrate new formats by simply using the
 *    URL of their implementation file as the format name, i.e., for this
 *    example, 
 *    data-spark-format = "http://rdf-spark.googlecode.com/svn/trunk/src/jquery.spark.simpletable.js"
 *    
 *  * create a function with the name of the format, e.g. "simpletable" in this
 *    example, as a property of the $.spark.format object, i.e. call it
 *    $.spark.format.simpletable and assign it a function with the following
 *    four parameters:
 *     o element: This is the HTML element that is supposed to hold the
 *       result set formatting. Use this any way you seem fit in order to
 *       create the visualization. A possible approach is to create the actual
 *       HTML code in the html variable (as below), and then replace the
 *       element's content with that html, i.e. with the element.html(html)
 *       call in the last line of the example function below.
 *     o result: This is the SPARQL result set in JSON, as defined by the
 *       standard.
 *     o reduced: This is the reduced version of the SPARQL result set, i.e.
 *       applying the transformation of the relational answer to the tree-like-
 *       model that usually lends to a simpler processing for the
 *       visualization.
 *     o params: an object with all parameters Spark knows of. Usually they are
 *       added to the markup as data-spark-param-name and can be accessed here
 *       as params.param.name. In this example, there is a head parameter that,
 *       if set to "nohead", will lead to skip the head line of the table.
 *    
 *  * upload the source file of your new format under the URL you have decided
 *    for it. Remember to keep the last part of the URL consistent with the
 *    name of the formatting function.
 *    
 *  * Don't forget to provide a documentation of your new Spark query result
 *    format. This should include at least what the formatting does,
 *    all required query variable names and types and descriptions,
 *    and all parameters and their possible values, and a list of additionally
 *    required files that need to be included by the HTML file in order for the
 *    formatter to function. An example is given below.
 *    
 *    For further code examples, check also the piechart and datechart
 *    visualizers out.
 */

/**
 * Spark query result format "simpletable"
 * 
 * == Description ==
 * Displays the result set in a simple HTML table. The headers of the table
 * columns are the SPARQL variable names, and the columns of the table are
 * the individual results.
 * 
 * == SPARQL variable names ==
 * None required. No type required. The variable names
 * are used as the headers for the respective columns, i.e. a query like
 * SELECT ?movie ?actor WHERE ... will be displayed as a table
 *  +------------+------------+
 *  | movie      | actor      |
 *  +------------+------------+
 *  | ...        | ...        |
 * 
 * == Parameters ==
 * data-spark-param-head: If set to "nohead", no heads for the columns will
 *    be shown. Default and for all other values, the head line will be shown.
 *    
 * == Additional required file ==
 * none
 * 
 * == Notes ==
 * There should also be a much more complicated, proper "table" format. The
 * "simpletable" format given here is to provide a nice, rewriteable
 * programming template for further formats.
 */
(function($){
	$.spark.format.simpletable = function(element, result, reduced, params) {
		// Start creating the HTML that will contain the formatting
		var html = '<table><tbody>';
		// If the data-spark-param-head attribute is set to "nohead"...
		// This is the way that attribute values are accessed
		if (params.param.head != "nohead") {
			html += '<tr>';
			$.each(result.head.vars, function(item, column) {
				html += '<th>' + column + '</th>';
			});
			html += '</tr>';
		};
		// This iterates over all items in the reduced result set. Note that
		// you usually would like to iterate over the reduced set and ignore
		// the full SPARQL result set.
		$.each(reduced, function(item, values) {
			html += '<tr>';
			html += '<td>' + item + '</td>';
			// This iterates over all property value pairs of the current
			// item.
			$.each(values, function(property, object) {
				html += '<td>' + object + '</td>';
			});
			html += '</tr>';
		});
		html += '</tbody></table>';
		// Replace the content of the marked up element with the newly
		// created formatting.
		element.html(html);
	};
})(jQuery);
