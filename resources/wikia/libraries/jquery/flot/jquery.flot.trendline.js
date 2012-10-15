/*
@author Ricardo Vega - "ricardoe" in the google mail system
@author Marooned for Wikia, inc. - fixes to original plugin
Flot plugin for trendlines. Controlled through the option
"trendline" in the global series options

  series: {
	trendline: {
		[show:boolean],
		[lineWidth:integer],
		[fill:boolean],
		[fillColor:color],
		[steps:boolean]
	}
  }

This plugin needs to add a new hook called here "processParsedData"
that is fired at the bottom of the for-loop in parseData function
*/

(function ($) {
	function init(plot) {
		var opts, enabled = false,
			defaultLine = { show: true },
			defaultOther = { show: false };

		function checkEnabled(plot, options) {
			if ('trendline' in options && options.trendline.show) {
				enabled = true;
				opts = options;
				plot.hooks.processParsedData.push(bestfit);
			}
		}

		function bestfit(plot, series, data) {
			var ii=0, x, y, x0, x1, y0, y1, dx,
				m = 0, b = 0, cs, ns,
				n = data.length, Sx = 0, Sy = 0, Sxy = 0, Sx2 = 0, S2x = 0;

			// Not enough data or disabled
			if(n < 2 || !enabled) return;

			// Do math stuff
			for(ii; ii<n; ii++){
				x = data[ii][0];
				y = data[ii][1];
				Sx += x;
				Sy += y;
				Sxy += (x*y);
				Sx2 += (x*x);
			}
			// Calculate slope and intercept
			m = (n*Sx2 - S2x) != 0 ? (n*Sxy - Sx*Sy) / (n*Sx2 - Sx*Sx) : 0;
			b = (Sy - m*Sx) / n;

			// Calculate minimal coordinates to draw the trendline
			x0 = parseFloat(data[0][0]);
			y0 = parseFloat(m*x0 + b);
			x1 = parseFloat(data[ii-1][0]);
			y1 = parseFloat(m*x1 + b);

			// We extend add the new serie to the series array
			ns = $.extend(true, {}, opts.series, { data:[[x0,y0],[x1,y1]], label: 'trend', bars: defaultOther, lines: defaultLine, points:defaultOther, color: series[series.length-1].color } );
			series.push(ns);
		}

		plot.hooks.processOptions.push(checkEnabled);
	}

	var options = { trendline: { show:false, lineWidth:2, fill:false, fillColor:null, steps:false } };

	$.plot.plugins.push({
		init: init,
		options: options,
		name: "trendline",
		version: "0.1"
	});
})(jQuery);