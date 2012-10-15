/**
 * @author Pawel Rychly
 * @author Piotr Pawlowski ( Pepe )
 */

/**
 * Description of plot's line
 * @param bool _show
 * @param bool _fill
 * @param rgb_color _color
 * @return line object
 */

function linesDescription( _show, _fill, _color ) {
	return {
		show: _show,
		fill: _fill,
		fillColor: _color
	}
}
/**
 * Description of plot's data
 * @param array( array() ) _data
 * @param string _label
 * @param bool _stack
 * @param rgb_color _color
 * @param line_object _lines
 * @returns data_desc_object
 */
function data_series_description( _data, _label, _stack, _color, _lines ) {
	var axis = 1;
	if ( _label == 1 ) {
		axis = 2;
	}
	return  {
		data: _data,
		label: "P"+_label,
		stack: _stack,
		color: _color,
		xaxis: axis,
		lines: _lines
	}
}

$(function () {

	//COLORS
	var p = [
		"rgba( 180, 1, 1, 0.6 )",
		"rgba( 255, 127, 39, 0.6 )",
		"rgba( 217, 217, 0, 0.6 )",
		"rgba( 92, 163, 79, 0.6 )",
		"rgba( 85, 109, 12, 0.6 )",
		"rgba( 0, 101, 145, 0.6 )",
		"rgba( 91, 37, 112, 0.6 )"
	];

	data[0].xticks.pop();

	var l = data[0].day_of_month[data[0].day_of_month.length - 2];
	data[0].day_of_month[data[0].day_of_month.length-1][1] = 0;

	//$().log( data );

	var markings = [
	     { color: '#CCCCCC', xaxis: { from: l[0] } }
	    ];

	var gradient = [ { brightness: 1, opacity: 1 }, { brightness: 1, opacity: 1 } ];
	var gradient2 = [ { brightness: 1, opacity: 0.3 }, { brightness: 1, opacity: 0.3 } ];

	var bars_variable = { show: true, barWidth: 1.0, fillColor: { colors: gradient } };
	var bars_variable2 = { show: true, barWidth: 1.0, fillColor: { colors: gradient2 } };
	// BUGS AGE
	$.plot( $( "#bugs_age" ), [ {
			data: data[0].opened, label: "Active", xaxis: 1 }, {
			data: data[0].resolved, label: "Resolved", xaxis: 1 }, {
			data: data[0].all, label: "All", xaxis: 2 }
	      ], {
			grid: { markings: markings} , legend: {
				position: 'nw', container: $( "#bugs_age_legend" ), noColumns: 3
			} , xaxes: [
			    { position: 'bottom', ticks: data[0].day_of_month },
			    { position: 'bottom', ticks: data[0].xticks }
			    ]
	} );

	// ACCUMULATED BY PRIORITY
	var bugs_acummulated_data_series = new Array(7);
	for ( var i = 6; i >= 0; i-- ) {
		var line_desc = linesDescription( true, true, p[i] );
		bugs_acummulated_data_series[6-i] = data_series_description( data[1][i], i + 1, true, p[i], line_desc );
	}

 	var plot1 = $.plot( $( "#bugs_accumulated_by_priority" ), bugs_acummulated_data_series
	, {
 		grid: { markings: markings} , legend: { position: 'nw', container: $( "#bugs_accumulated_by_priority_legend" ), noColumns: 7 }, xaxes: [ {
 			position: 'bottom', ticks: data[0].day_of_month }, { position: 'bottom', ticks: data[0].xticks } ] } );

	var bugs_acummulated_data_series = Array( 7 );
	for ( var i = 6; i >= 0; i-- ) {
		var line_desc = linesDescription( true, true, p[i] );
		bugs_acummulated_data_series[6-i] = data_series_description( data[2][i], i+1, true, p[i], {} );
	}

	// CREATED BY PRIORITY IN %
	$.plot( $( "#bugs_created_by_priority" ),
		bugs_acummulated_data_series
		, { series: { bars: bars_variable  },  grid: { markings: markings} , legend: {
			position: 'nw', container: $( "#bugs_created_by_priority_legend" ), noColumns: 7
			}, xaxes: [ { position: 'bottom', ticks: data[0].day_of_month }, {
				position: 'bottom', ticks: data[0].xticks
				}
			]
		}
	);

	// CREATED P1, P2 AND P3 (weekly)
	$.plot( $( "#p1_p2_p3_bugs_created" ), [ {
			data: data[2][2], label: "P3", stack: true, color: p[2], xaxis: 1 }, {
        	data: data[2][1], label: "P2", stack: true, color: p[1], xaxis: 1 }, {
			data: data[2][0], label: "P1", stack: true, color: p[0], xaxis: 2
	                             }
	], { series: {bars: bars_variable  }, grid: { markings: markings} , legend: {
		position: 'nw', container: $( "#created_p1_p2_p3_legend" ), noColumns: 3   }, xaxes: [
           { position: 'bottom', ticks: data[0].day_of_month },
		   { position: 'bottom', ticks: data[0].xticks }
           ]
		}
	);

	// RESOLVED - CREATED (diff)
	$.plot( $( "#bugs_resolved_opened_diff" ), [ {
				data: data[3].diff, label: "Resolved - Created",
				threshold: { below: 0, color: "rgb(255, 70, 70)" },
				xaxis: 2,

	    	}, {
	    		data: data[3].diff, label: null, color: "rgb(30, 180, 20)",
				xaxis: 1,
				lines: { show: false, steps: false }

	        }
	], { series: { bars: bars_variable2 }, grid: { markings: markings }, legend: {
			show: false, position: 'nw', container: $( "#resolved_minus_created_legend" ) }, xaxes: [
		        { position: 'bottom', ticks: data[0].day_of_month },
		    	{ position: 'bottom', ticks: data[0].xticks }
		    ]
		}
	);

});
