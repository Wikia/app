var activeEditors = { 
	divTarget: "chartActiveEditors",
	title: 'Active Editors',
	plotVar: {},
	apiCalls: {
		edit5: "../wiki/api.php?action=analytics&metric=dumpactiveeditors5&startmonth=2008-05&endmonth=2011-08&selectprojects=wp&selecteditors=registered&data=timeseries&format=json",
		edit100: "../wiki/api.php?action=analytics&metric=dumpactiveeditors100&startmonth=2008-05&endmonth=2011-08&selectprojects=wp&selecteditors=registered&data=timeseries&format=json",
		editorTargets: "../wiki/api.php?action=analytics&metric=editortargets&startmonth=2008-05&endmonth=2011-08&format=json"
	},
	plotData: function(apiDataArray){
			var scaleYfunction = function(Y){return Y;}
			var edit5data = p_getDataOnly(apiDataArray.edit5, "SUM(editors_ge_5)", true, scaleYfunction);
			var edit100data = p_getDataOnly(apiDataArray.edit100, "SUM(editors_ge_100)", true, scaleYfunction);
			var editorTargets = p_getDataSimple(apiDataArray.editorTargets,"value", true, scaleYfunction);

			var labels = ["SUM(editors_ge_5)", "SUM(editors_ge_100)", "editorTargets"];

			seriesArray = new Array(labels.length);

			for(var i = 0; i < seriesArray.length; i++){
				if(seriesOptions[labels[i]]){
					seriesArray[i] = seriesOptions[labels[i]];
				}
				else{
					seriesArray[i] = {};
				}
			}

			//var paddedEdData = padWithZeroes(edit100data.data[0], editorTargets.data[0]);
			//console.dir(paddedEdData);
			//console.log("BLA");
			//console.log( $.merge(edit100data.data, paddedEdData) );

			$('#' + this.divTarget ).empty();
			this.plotVar = $.jqplot(this.divTarget,$.merge(edit5data.data, $.merge(edit100data.data, editorTargets.data)),{
				title: this.title,
				legend: {show: true, placement: "outsideGrid"} ,
				series: seriesArray,
				cursor: {show: true, zoom:false, showTooltip:false, dblClickReset:true, zoom:true},
				grid: {
					background: "#FFF",
					borderColor: "#CCC",
					borderWidth: 1,
					shadow: false,
					gridLineWidth: 1.0
				},
				seriesDefaults: {
					fill: false,
					shadow: false,
					showMarker : false
				    //markerOptions: {
					//size: 5,
				//}
				},
				axes: {
					xaxis: {
						renderer: $.jqplot.DateAxisRenderer,
						min: edit5data.minDate,
						tickInterval: '90 days',
						tickOptions:
						{
						formatString:'%b %y',
						fontSize: '7pt',
						textColor: "#000"
					   },
						max: edit5data.maxDate,
								showMinorTicks: true,
								labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
								labelOptions: {
								  fontSize: '14pt',
								  textColor: '#F44'
								}
						},
				yaxis: {
					  min: 0
				  /*max: parsedData.maxY,
						  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
						  tickOptions: {
							 formatString: '&nbsp;%d',
							 textColor: "#000" ,
						  },
						  tickInterval: parsedData.maxY / 4, */
				}
				}
			});

	}
}; //activeEditors
