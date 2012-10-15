var mobileViews = {
	divTarget: "chartMobileViews",
	title: 'Page Views (millions)',
	plotVar: {},
	apiCalls: {
		pageViews: "../wiki/api.php?action=analytics&metric=squidpageviews&startmonth=2004-08&endmonth=2011-08&normalized=Y&format=json",
		mobileViews: "../wiki/api.php?action=analytics&metric=mobilepageviews&startmonth=2004-08&endmonth=2011-08&format=json"
	},
	plotData: function(apiDataArray){
			var data = apiDataArray.pageViews;
			var scaleYfunction = function(Y){return Y/1000000;}
			var scaleYfunctionThousand = function(Y){return Y/1000;}

			var mobileData = p_getDataSimple(data, "SUM(views_mobile_normalized)", true, scaleYfunction);
			var nonMobileData = p_getDataSimple(data, "SUM(views_non_mobile_normalized)", true, scaleYfunction);
			var mobileOnly = p_getDataSimple(apiDataArray.mobileViews,"value", true, scaleYfunctionThousand);

			var labels = ["SUM(views_mobile_normalized)", "SUM(views_non_mobile_normalized)", "mobile_only"];

			//parsedData.maxY = maxYaxis (parsedData.maxY) ;

			seriesArray = new Array(labels.length);
			for(var i = 0; i < seriesArray.length; i++){
				if(seriesOptions[labels[i]]){
					seriesArray[i] = seriesOptions[labels[i]];
				}
				else{
					seriesArray[i] = {};
				}
			}

			$('#' + this.divTarget ).empty();
			this.plotVar = $.jqplot(this.divTarget,$.merge(mobileData.data, $.merge(nonMobileData.data, mobileOnly.data)),{
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
						min: mobileData.minDate,
						tickInterval: '90 days',
						tickOptions:
						{
						formatString:'%b %y',
						fontSize: '7pt',
						textColor: "#000"
					   },
						max: mobileData.maxDate,
								showMinorTicks: true,
								labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
								labelOptions: {
								  fontSize: '14pt',
								  textColor: '#F44',
								}
						},
				yaxis: {
					  min: 0,
				  //max: parsedData.maxY,
						  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
						  tickOptions: {
							 formatString: '&nbsp;%d',
							 textColor: "#000" ,
						  }//,
						  //tickInterval: parsedData.maxY / 4,
				}
				}
			});

	}
}; //mobileViews
