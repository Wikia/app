var gSize = "s";
var gTimeSpan = "3m";
var gSymbol = "AAPL";
var gVolume = "";
var gOverlay = "s";
var gLine = "l";

function isIE() {
	var ua = navigator.userAgent.toLowerCase();
	var isIE=((ua.indexOf("msie")!=-1)&&(ua.indexOf("opera")==-1)&&(ua.indexOf("webtv")==-1) );
	return (isIE);
}

function enableTab(chart, obj, scale) {
	for (i=0; i < 8; i++) {
		document.getElementById("ch_tab"+i+"_"+chart).className=(i == obj)?"ch_tabactive":"ch_tab";
		document.getElementById("ch_tab"+i+"_"+chart).style.cursor=(i == obj)?"default":(isIE())?"hand": "pointer";
		document.getElementById("ch_tab"+i+"_"+chart).style.borderTopWidth=(i == obj)?"0px":"1px";
	}
	gTimeSpan = scale;
	chartRedraw(chart);
}

function chartRedraw(chart) {
	ChartElement = document.getElementById("chart_" + chart);
	ChartElement.src =getUrl(chart);
}

function getUrl(chart) {
	var ran_number = Math.floor(Math.random()*5); 
	return "http://" + eval('gDomain_' + chart) + "/z?s=" + eval('gSymbol_' + chart) + "&t=" + gTimeSpan + "&q=" + gLine + "&l=on&z=" + gSize + "&p=" + gOverlay + "&a=" + gVolume + "&rand=" + ran_number;
}

function getDomain(symbol) {
	start = symbol.indexOf('.');
	exchange = '';
	
	if (start > -1) {
		srtlength = symbol.length - start;
		exchange = symbol.substr(start, srtlength);
	}
	
	if (exchange == '.T') {
		return "tchart.yahoo.co.jp";
	} else {
		return "ichart.finance.yahoo.com";	
	}
}
