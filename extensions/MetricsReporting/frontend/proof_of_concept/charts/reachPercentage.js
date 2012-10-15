var reachPercentage = {
	divTarget: "chartreachPercentage",
	title: 'comScore Reach Percentage by Region',
	plotVar: {},
	apiCalls: {
		reachPercentage: "../wiki/api.php?action=analytics&metric=comscorereachpercentage&startmonth=2008-04&endmonth=2011-08&selectregions=AS,EU,LA,MA,NA,US,W&reportlanguage=en&format=json"
	},
	plotData: function(apiDataArray){

			var data = apiDataArray.reachPercentage;
			var scaleYfunction = function(Y){return Y;}
			var parsedData = p_getData(data, "region_code", "reach", true, scaleYfunction, true);


			parsedData.minY -= parsedData.minY % 5 ;
			if (parsedData.maxY % 5 != 0)
			{ parsedData.maxY += 5 - (parsedData.maxY % 5) ; }

			var labels = parsedData.labels;


			var seriesArray = new Array(labels.length);
			for(var i = 0; i < seriesArray.length; i++){
				if(seriesOptions[labels[i]]){
					seriesArray[i] = seriesOptions[labels[i]];
				}
				else{
					seriesArray[i] = {};
				}
			}
			$('#' + this.divTarget ).empty();
			this.plotVar = $.jqplot(this.divTarget, parsedData.data  ,{
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
				  showMarker : false,
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
								  textColor: '#F44',
								}
						},
				yaxis: {
					  min: parsedData.minY,
				  max: parsedData.maxY,
						  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
						  tickOptions: {
							 formatString: '&nbsp;%d\%',
							 textColor: "#000" ,
						  },
						  tickInterval:5
				}
				}
			});

	}
}; //reachPercentage
