var editorsByGeography = {
	divTarget: "chartEditorsByGeography",
	title: 'Active Editors by Geography',
	plotVar: {},
	apiCalls: {
		//us, de, gb, fr, jp, it, au, ca, es, in
		editorsByGeographyUS: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=us&endmonth=2011-07&format=json",
		editorsByGeographyDE: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=de&endmonth=2011-07&format=json",
		editorsByGeographyGB: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=gb&endmonth=2011-07&format=json",
		editorsByGeographyFR: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=fr&endmonth=2011-07&format=json",
		editorsByGeographyJP: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=jp&endmonth=2011-07&format=json",
		editorsByGeographyIT: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=it&endmonth=2011-07&format=json",
		editorsByGeographyAU: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=au&endmonth=2011-07&format=json",
		editorsByGeographyCA: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=ca&endmonth=2011-07&format=json",
		editorsByGeographyES: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=es&endmonth=2011-07&format=json",
		editorsByGeographyIN: "../wiki/api.php?action=analytics&metric=editorsbygeography&startmonth=2004-08&selectcountries=in&endmonth=2011-07&format=json"
	},
	plotData: function(apiDataArray){

			var data = apiDataArray.editorsByGeographyUS;
			var scaleYfunction = function(Y){return Y;}
			var parsedData = p_getData(data, "country_code", "value", true, scaleYfunction, false);

			var parsedData2 = p_getData(apiDataArray.editorsByGeographyDE, "country_code", "value", true, scaleYfunction, false);
			var parsedData3 = p_getData(apiDataArray.editorsByGeographyGB, "country_code", "value", true, scaleYfunction, false);
			var parsedData4 = p_getData(apiDataArray.editorsByGeographyFR, "country_code", "value", true, scaleYfunction, false);
			var parsedData5 = p_getData(apiDataArray.editorsByGeographyJP, "country_code", "value", true, scaleYfunction, false);
			var parsedData6 = p_getData(apiDataArray.editorsByGeographyIT, "country_code", "value", true, scaleYfunction, false);
			var parsedData7 = p_getData(apiDataArray.editorsByGeographyAU, "country_code", "value", true, scaleYfunction, false);
			var parsedData8 = p_getData(apiDataArray.editorsByGeographyCA, "country_code", "value", true, scaleYfunction, false);
			var parsedData9 = p_getData(apiDataArray.editorsByGeographyES, "country_code", "value", true, scaleYfunction, false);
			var parsedData10 = p_getData(apiDataArray.editorsByGeographyIN, "country_code", "value", true, scaleYfunction, false);

			parsedData.minY -= parsedData.minY % 5 ;
			if (parsedData.maxY % 5 != 0)
			{ parsedData.maxY += 5 - (parsedData.maxY % 5) ; }

			var labels = parsedData.labels;
			labels = labels.concat(['de','gb','fr','jp','it','au','ca','es','in']);

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

			var allData = $.merge(parsedData.data, $.merge(parsedData2.data,$.merge(parsedData3.data,$.merge(parsedData4.data,$.merge(parsedData5.data,$.merge(parsedData6.data,$.merge(parsedData7.data,$.merge(parsedData8.data,$.merge(parsedData9.data, parsedData10.data)))))))));

			var ticks = ['June', 'July'];
			this.plotVar = $.jqplot(this.divTarget, allData ,{
				title: this.title,
				legend: {show: true, placement: "outsideGrid"} ,
				series: seriesArray,
				cursor: {show: true, zoom:false, showTooltip:true, dblClickReset:true, zoom:false},
				highlighter:{show:false},
				grid: {
				  background: "#FFF",
				  borderColor: "#CCC",
				  borderWidth: 1,
				  shadow: false,
				  gridLineWidth: 1.0,
				},
				seriesDefaults: {
				 renderer:$.jqplot.BarRenderer,
				  //fill: false,
				  //shadow: false,
				  //showMarker : false,
				   //markerOptions: {
					//size: 5,
				   //}
				   rendererOptions: {
					barDirection: 'horizontal',
					highlightMouseOver: false,
					highlightMouseDown: true,
					barPadding: 0

					}
				},
				 axes:{
				 yaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
					ticks: ticks
				}}


				/*axes: {
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
						 // tickOptions: {
						  //   formatString: '&nbsp;%d\%',
						  //   textColor: "#000" ,
						  //},
						  tickInterval:5
				}
				}*/
			});

	}
}; //reachPercentage
