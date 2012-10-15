var uniqueVisitors = {
	divTarget: "chartUniqueVisitors",
	title: 'comScore unique visitors (millions)',
	plotVar: {},
	apiCalls: {
		uniqueVisitors: "../wiki/api.php?action=analytics&metric=comscoreuniquevisitors&startmonth=2008-04&endmonth=2011-08&selectregions=AS,EU,LA,MA,NA,US,W&reportlanguage=en&format=json",
		offlineEstimate: "../wiki/api.php?action=analytics&metric=estimateoffline&startmonth=2004-08&endmonth=2011-10&format=json"
	},
	plotData: function(apiDataArray){
			var data = apiDataArray.uniqueVisitors;
			var scaleYfunction = function(Y){return Y/1000000;}
			var parsedData = p_getData(data, "region_code", "visitors", true, scaleYfunction, true);
			var offlineData = p_getDataSimple(apiDataArray.offlineEstimate, "readers", true, scaleYfunction);

			var labels = parsedData.labels;
			labels.push("OfflineEst");

			parsedData.maxY = maxYaxis (parsedData.maxY) ;

			var worldIndex = labels.indexOf("W");

			offlineData.bandedSeries = buildErrorBand( parsedData.data[worldIndex], offlineData.data );

			seriesArray = new Array(labels.length);
			for(var i = 0; i < seriesArray.length; i++){
				if(seriesOptions[labels[i]]){
					seriesArray[i] = seriesOptions[labels[i]];
				}
				else{
					seriesArray[i] = {};
				}
			}

			seriesArray[worldIndex].rendererOptions =  {
				bands: {
					// draw bands at 1.7 "units" above and below line.
					interval: 9
				},
				//bandData: offlineData.bandedSeries,
				// turn on smoothing
			   smooth: true
			};
			console.log(seriesArray);


			$('#' + this.divTarget ).empty();
			this.plotVar = $.jqplot(this.divTarget,$.merge(parsedData.data, offlineData.data),{
				title: this.title,
				legend: {show: true, placement: "outsideGrid"} ,
				series: seriesArray,
				cursor: {show: true, zoom:false, showTooltip:false, dblClickReset:true, zoom:true},
				grid: {
				  background: "#FFF",
				  borderColor: "#CCC",
				  borderWidth: 1,
				  shadow: false,
				  gridLineWidth: 1.0,
				},
				seriesDefaults: {
				  fill: false,
				  shadow: false,
				  showMarker : false
				  // markerOptions: {
				  //  size: 5,
				  // }
				},
				axes: {
					xaxis: {
						renderer: $.jqplot.DateAxisRenderer,
						min: parsedData.minDate,
						tickInterval: '90 days',
						tickOptions:
						{
						formatString:'%b %y',
						fontSize: '7pt',
						textColor: "#000"
					   },
						max: parsedData.maxDate,
								showMinorTicks: true,
								labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
								labelOptions: {
								  fontSize: '14pt',
								  textColor: '#F44'
								}
						},
				yaxis: {
					  min: 0,
				  max: parsedData.maxY,
						  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
						  tickOptions: {
							 formatString: '&nbsp;%d',
							 textColor: "#000"
						  },
						  tickInterval: parsedData.maxY / 4,
				}
				}
			});

	}
}; //unique visitors
