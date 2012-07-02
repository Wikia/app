/**
 * Example Spark Result Formatter.
 * 
 *  * Spark query result format "OAT pivot"
 * 
 * == Description ==
 * Displays the result set as a pivot table using OAT Framework [1].
 * 
 * [1] http://oat.openlinksw.com/
 *
 * 
 * == SPARQL variable names ==
 * No specific names, but the last variable is used as to-be-analysed value
 * 
 * == Parameters ==
 * none for now
 *    
 * == Additional required files ==
 * 
 * Can all be found at OAT Framework [1].
 * 
 * /lib/oat/loader.js
 * /lib/oat/bootstrap.js
 * /lib/oat/animation.js
 * /lib/oat/barchart.js
 * /lib/oat/ghostdrag.js
 * /lib/oat/instant.js
 * /lib/oat/pivot.js
 * /lib/oat/statistics.js
 * /lib/oat/styles/pivot.css
 * 
 * == Notes ==
 * - Feel free to extend the visualisation.
 * - There are some options for the OAT pivot visualisation, but we simply use the defaults and do 
 * not allow to change them (yet). In the beginning, we display some manual, please feel free to 
 * enhance.
 * 
 * - OAT makes use of Prototypes Framework [2]. Therefore, if OAT pivot visualisation is used
 * for…in to iterate over an array is not possible and the visualisation will not work, then.
 * 
 *  [2] http://www.prototypejs.org/api/array
 * 
 */
(function($) {
	$.spark.format.oatpivot = function(element, result, reduced, params) {
		// Start creating the HTML that will contain the formatting
		var html = '<p><p><b>Manual</b></p><ul><li>Remove property from filter to show it in table below</li><li>Use select-boxes above the table to select a desired aggregate function</li><li>Use buttons below the table to toggle charts</li><li>Click the main heading (left top corner) to change numerical type and </li><li>Click any aggregate heading to change the order, filter values and toggle subtotals</li><li>Drag any aggregate heading to any place that becomes red</li></ul>Aggregate function: <select id="pivot_agg2"></select><br /> Subtotals aggregate function: <select id="pivot_agg_totals2"></select><br /><p><b>Filter list</b></p><div id="pivot_page2"></div><div id="pivot_content2"></div><div id="pivot_chart2"></div></p>';

		// Data
		// Template
		// var header = ["Company","Year","Quarter","Color","$$$'s spent on
		// pencils"];
		// var data = [];
		// var Companies = ["IBM","Novell","Microsoft"];
		// var Years = ["2003","2004","2005"];
		// var Quarters = ["1st","2nd","3rd","4th"];
		// var Colors = ["Red","Blue","Black"];
		// for (var i=0;i<Companies.length;i++)
		// for (var j=0;j<Years.length;j++)
		// for (var k=0;k<Quarters.length;k++)
		// for (var l=0;l<Colors.length;l++) {
		// var value = Math.round(Math.random()*100);
		// data.push([Companies[i],Years[j],Quarters[k],Colors[l],value]);
		// }

		var oatheader = [];
		// We want with identifier, the full thing.
		
		for ( var i = 0; i < result.head.vars.length; ++i) {
			oatheader.push(result.head.vars[i].toString());
		}

		/*
		 * OAT wants the data like this: For each combination a number. Do I
		 * have this in SMART? We have a long table. The measure is at the end,
		 * all the others are dimensions. Our oatdata will have:
		 * data.push(dim1,dim2,dim3,...,value)
		 */
		var oatdata = [];

		$.each(reduced, function(item, values) {

			var oatrow = [];
			// With identifier
			oatrow.push(item);
			// This iterates over all property value pairs of the current
			// item.
			$.each(values, function(property, object) {
				oatrow.push(object.toString());
			});

			oatdata.push(oatrow);
		});

		// Start creating the HTML that will contain the formatting
		// For debugging purposes, show data
		/*
		html += '<table><tbody>';
		// If the data-spark-param-head attribute is set to "nohead"...
		// This is the way that attribute values are accessed
		html += '<tr>';
		$.each(oatheader, function(item, column) {
			html += '<th>' + column + '</th>';
		});
		html += '</tr>';

		// This iterates over all items in the reduced result set. Note that
		// you usually would like to iterate over the reduced set and ignore
		// the full SPARQL result set.
		$.each(oatdata, function(item, values) {

			html += '<tr>';
			// This iterates over all property value pairs of the current
			// item.
			$.each(values, function(property, object) {
				html += '<td>' + object + '</td>';
			});
			html += '</tr>';
		});
		html += '</tbody></table>';
		*/

		// Replace the content of the marked up element with the newly
		// created formatting.
		element.html(html);

		// Filter array
		var filterarray = new Array(oatheader.length-1);

		for ( var i = 0; i < oatheader.length-1; ++i) {
			filterarray[i] = i;
		}

		var valueindex = oatheader.length - 1;
		// filterarray = [0,1,2,3,4,5];

		var DEMO = {};
		window.cal = false;
		// TODO: maybe I need? var featureList=["pivot","statistics","barchart"];
		DEMO.pivot = {
			panel : 1,
			tab : 5,
			div : "pivot",
			needs : [ "pivot", "statistics" ],
			cb : function() {
				/*
				 * We need to configure it correctly
				 * 
				 */
				var pivot = new OAT.Pivot("pivot_content2", "pivot_chart2",
						"pivot_page2", oatheader, oatdata, [], [], filterarray,
						valueindex, {
							agg : 0,
							showChart : 0,
							showRowChart : 0,
							showColumnChart : 0,
							showEmpty : 0,
							subtotals : 0,
							totals : 0
						});
				var aggRef = function() {
					pivot.options.agg = parseInt($v("pivot_agg2"));
					pivot.go();
				}
				var aggRefTotals = function() {
					pivot.options.aggTotals = parseInt($v("pivot_agg_totals2"));
					pivot.go();
				}
				/* create agg function list */
				OAT.Dom.clear("pivot_agg2");
				OAT.Dom.clear("pivot_agg_totals2");
				for ( var i = 0; i < OAT.Statistics.list.length; i++) {
					var item = OAT.Statistics.list[i];
					OAT.Dom.option(item.shortDesc, i, "pivot_agg2");
					OAT.Dom.option(item.shortDesc, i, "pivot_agg_totals2");
					if (pivot.options.agg == i) {
						$("pivot_agg2").selectedIndex = i;
					}
					if (pivot.options.aggTotals == i) {
						$("pivot_agg_totals2").selectedIndex = i;
					}
				}
				OAT.Dom.attach("pivot_agg2", "change", aggRef);
				OAT.Dom.attach("pivot_agg_totals2", "change", aggRefTotals);
			}
		}

		/* create dimmer element */
		var dimmerElm = OAT.Dom.create("div", {
			border : "2px solid #000",
			padding : "1em",
			position : "absolute",
			backgroundColor : "#fff"
		});
		dimmerElm.innerHTML = "OAT Components loading...";
		document.body.appendChild(dimmerElm);
		OAT.Dom.hide(dimmerElm);

		var obj = DEMO.pivot;
		if (!obj.drawn) {
			if (obj.cb) {
				// OAT.Dimmer.show(dimmerElm);
				// OAT.Dom.center(dimmerElm,1,1);
				var ref = function() {
					// if (!window.location.href.match(/:source/)) {
					// OAT.Dimmer.hide(); }
					obj.cb();
					obj.drawn = true;
				}
				OAT.Loader.loadFeatures(obj.needs, ref);
			} else {
				obj.drawn = true;
			}
		} /* if not yet included & drawn */
	};
})(jQuery);
