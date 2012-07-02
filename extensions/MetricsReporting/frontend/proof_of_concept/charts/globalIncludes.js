var seriesOptions = {
	//regions
	"AS": { "label": "Asia Pacific", "color": "#f37d12" },//"#884433"}, //brownish
	"EU": { "label": "Europe", "color": "#449980"}, //bluegreen
	"LA": { "label": "Latin-America", "color": "#804499"}, //purpleish
	"MA": { "label": "Middle-East/Africa", "color": "#e61d0a"},// "#99445e"},
	"NA": { "label": "North America", "color": "#0a0aa4"},//"#5e9944"}, //green!
	"W" : { "label": "World", "color": "#5cc3f0",//"#448899"//theme
			"lineWidth": 1, //5,
			"fillColor":"#F0F"
		   },
	"us" : { "label" : "United States", "color" : "blue"},
	"ca" : { "label" : "Canada", "color": "red" },
	//us, de, gb, fr, jp, it, au, ca, es, in
	"de" : { "label" : "Germany"},
	"gb" : { "label" : "UK"},
	"fr" : { "label" : "France"},
	"jp" : { "label" : "Japan"},
	"it" : { "label" : "Italy"},
	"au" : { "label" : "Australia"},
	"es" : { "label" : "Spain"},
	"in" : { "label" : "India"},
	"SUM(editors_ge_5)": { "label":"At least 5 edits", "color":"#448899" },
	"SUM(editors_ge_100)": { "label":"At least 100 edits", "color": "#e61d0a" },
	"OfflineEst" : { "label": "Offline Estimate", "color": "black"},
	"SUM(views_mobile_raw)": { "label":"Mobile Views to Gateway", "color":"#448899" },
	"SUM(views_non_mobile_raw)": { "label":"Non Mobile Views", "color":"#e61d0a" },
	 "SUM(views_mobile_normalized)": { "label":"Mobile Views to Gateway", "color":"#448899" },
	"SUM(views_non_mobile_normalized)": { "label":"Non Mobile Views", "color":"#e61d0a" },
	"mobile_only": {"label": "Total Mobile Views", "color": "#804499"},
	"editorTargets": { "label": "Editor Targets"}

};


/*
* makes API calls based
*/
function makeAPICall(plotObj){
		var apiDataReturns = {};
		apiCallsSize = 0;
		for(var i in plotObj.apiCalls){
			apiCallsSize++;
		}
		//Note: all this is possible b/c JS execution is not actually parallel
		completedAPICalls = 0;
		for(var i in plotObj.apiCalls){
			var datafunction = function(val){
				return function(data){
					apiDataReturns[val] = data;
					completedAPICalls++;
					if(completedAPICalls >= apiCallsSize){
						plotObj.plotData(apiDataReturns);
					}
					};
				}(i);
				$.get(plotObj.apiCalls[i], datafunction,"json");
		}
}


/*
* Function to lazy load chart objects
*/
function lazyLoad(llobj){
	if(jQuery.isEmptyObject(llobj.plotVar)){
				makeAPICall(llobj);
			} else {
				llobj.plotVar.replot();
			}
  }


/*
 * Function to get Y axis max
*/
function maxYaxis(yaxis_max) {
	mult = 1 ;
	while (yaxis_max > 1) {
	   yaxis_max /= 10 ;
	   mult *= 10 ;
	}
	if (yaxis_max < 0.1) {
	   yaxis_max = 0.1 ;
	} else
	if (yaxis_max < 0.2) {
	  yaxis_max = 0.2 ;
	}  else
	if (yaxis_max < 0.5) {
	   yaxis_max = 0.5 ;
	}
	else {
	   yaxis_max = 1 ;
	   }
	yaxis_max *= mult ;
  return (yaxis_max) ;
}

/*
* Function to extract just the data series from the API return object as suited for JQplot
*/
function extractAPIData(apiData){
	var retval = new Array();
	for(var i in apiData){
		for(var j in apiData[i]){
			if(apiData[i][j].data){
				retval.push(findYaxisMinMax ( apiData[i][j].data));
			}
		}
	}
	return retval;
}

/*
* get labels from API return object
*/
function getLabels(apiData, labelName){
	var retval = new Array();
	for(var i in apiData){
		for(var j in apiData[i]){
			if(apiData[i][j][labelName]){
				retval.push(apiData[i][j][labelName]);
			}
		}
	}
	return retval;
}

/*
* go from MW date format to date format used by jqplot
*/
function mw2month(date){
	date = date+"";
	return date.substring(0,4)+"-"+date.substring(4,6)+"-"+date.substring(6,8);
}


// provisional: get Data function
 function p_getData(apiReturnObj, labelName, dataName, isInt, scaleYfunction, returnDate){
	var apiData;
	for(var robj in apiReturnObj){
		apiData = apiReturnObj[robj];
	}
	var labels = new Array();
	var dataArray = new Array();
	var minDate = "9999";
	var maxDate = "";

	var yaxis_min =  9999999999 ;
	var yaxis_max = -9999999999 ;

	var findYaxisMinMax = function(value){
		if (value < yaxis_min)
		{ yaxis_min = value ; }
		if (value > yaxis_max)
		{ yaxis_max = value ; }
	  return (value) ;
	};

	for(var i in apiData){
		var tempDataArray = new Array();
		labels.push(apiData[i][labelName]);
		for(var j in apiData[i].data){

			if(apiData[i].data[j].date < minDate){
				minDate = apiData[i].data[j].date;
			}
			if(apiData[i].data[j].date > maxDate){
				maxDate = apiData[i].data[j].date;
			}

			var YVal = parseFloat(apiData[i].data[j][dataName]);

			if(isInt){
				YVal = parseInt(apiData[i].data[j][dataName]);
			}
			YVal = findYaxisMinMax (scaleYfunction(YVal));
			if(returnDate){
				tempDataArray.push( [apiData[i].data[j].date, YVal]);
			}
			else{
				tempDataArray.push(YVal);
			}
		}
		dataArray.push(tempDataArray);
	}

		maxDate = maxDate.substr(0,8)+'01' ; // last month is outside range
		var returnObj = { "labels": labels, "data": dataArray,
						  "minDate": minDate, "maxDate": maxDate,
						  "minY":  yaxis_min, "maxY": yaxis_max };
	return returnObj;

 }

function p_getDataDefault(apiReturnObj, labelName, dataName, isInt){
	var defaultScale = function(Y){return Y;};
	return p_getData(apiReturnObj, labelName, dataName, isInt, defaultScale , true);
}


 function p_getDataDate(apiReturnObj, labelName, dataName, isInt, scaleYfunction){
	return p_getData(apiReturnObj, labelName, dataName, isInt, scaleYfunction, true);
 }


 /* provisional: get data only function (labels set in the function that draws the chart) */
 function p_getDataOnly(apiReturnObj, dataName, isInt, scaleYfunction){
	var apiData;
	for(var robj in apiReturnObj){
		apiData = apiReturnObj[robj];
	}
	var dataArray = new Array();
	var minDate = "9999";
	var maxDate = "";

	for(var i in apiData){
		var tempDataArray = new Array();
		for(var j in apiData[i].data){

			if(apiData[i].data[j].date < minDate){
				minDate = apiData[i].data[j].date;
			}
			if(apiData[i].data[j].date > maxDate){
				maxDate = apiData[i].data[j].date;
			}
			if(isInt){
				tempDataArray.push( [apiData[i].data[j].date, scaleYfunction(parseInt(apiData[i].data[j][dataName])) ]);
				}else{
				tempDataArray.push( [apiData[i].data[j].date, scaleYfunction(parseFloat(apiData[i].data[j][dataName])) ]);
			}
		}
		dataArray.push(tempDataArray);
	}
	var returnObj = {"data": dataArray, "minDate": minDate, "maxDate": maxDate};
	return returnObj;

 }

// provisional: get data simple, for unformatted API data
function p_getDataSimple(apiData, dataName, isInt, scaleYfunction){
	var dataArray = new Array();
	var minDate = "9999";
	var maxDate = "";

	for(var i in apiData){
		var tempDataArray = new Array();
		for(var j in apiData[i]){

			if(apiData[i][j].date < minDate){
				minDate = apiData[i][j].date;
			}
			if(apiData[i][j].date > maxDate){
				maxDate = apiData[i][j].date;
			}
			if(isInt){
				tempDataArray.push( [apiData[i][j].date, scaleYfunction(parseInt(apiData[i][j][dataName])) ]);
				}else{
				tempDataArray.push( [apiData[i][j].date, scaleYfunction(parseFloat(apiData[i][j][dataName])) ]);
			}
		}
		dataArray.push(tempDataArray);
	}
	var returnObj = {"data": dataArray, "minDate": minDate, "maxDate": maxDate};
	return returnObj;

 }




function buildErrorBand(originalSeries, errorSeriesWrapped){
	var errorSeries = errorSeriesWrapped[0];
	var bandedHi = new Array(originalSeries.length);
	var bandedLo = new Array(originalSeries.length);

	var j = 0;
	var endFound = false;
	for(var i = 0; i < originalSeries.length; i++){
		if(originalSeries[i][0] == errorSeries[0][0]){
			//j = i;
			endFound = true;
			//debugger;
		}
		if(!endFound){
			bandedHi[i] = originalSeries[i];
			bandedLo[i] = originalSeries[i];
		}
		else{
			bandedHi[i] = [originalSeries[i][0], originalSeries[i][1] + errorSeries[j][1]];
			bandedLo[i] = [originalSeries[i][0], originalSeries[i][1]];
			originalSeries[i][1] = originalSeries[i][1] + errorSeries[j][1]/2;
			j++;
		}
	}
	return [bandedHi, bandedLo];
}

function padWithZeroes(originalSeries, seriesToPad){
	var returnSeries = new Array(originalSeries.length);
	var j = 0;
	var endFound = false;
	for(var i = 0; i < originalSeries.length; i++){
		if(originalSeries[i][0] == seriesToPad[0][0]){
			endFound = true;
		}
		if(!endFound){
			returnSeries[i] = 0;
		}
		else{
			if(j < seriesToPad.length){
				returnSeries[i] = seriesToPad[j][1];
			}
			else{
				returnSeries[i] = 0;
			}
			j++;
		}
	}
	return [returnSeries];
}



