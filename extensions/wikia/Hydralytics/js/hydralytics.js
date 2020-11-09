$(function() {

	// Line Charts
	var chartColor = {
		background: '#00D6D6',
		border: '#00D6D6',// '#212121',
		background2: '#002A32',
		border2: '#002A32'
	};
	// Pie Charts
    var chartColors = [
		'#00D6D6',
		'#002A32',
		'#FF776D',
		'#DFEC24',
		'#EE1A41',
		'#5A2E4A',
		'#e74c3c',
		'#95a5a6'
	]

	log = function() {
		if (mw.config.get('debug')) {
			var newparams = ['%cHydralytics', 'color: #212121; background: #b0e03b; padding: 2px 5px;'];
			console.log.apply(null, _.concat(newparams,arguments));
		}
	}

	banner = function(v) {
		if (mw.config.get('debug')) {
			console.log('%c'+v, 'color: #212121; background: #b0e03b; font-family: sans-serif; font-weight: bold; font-size: 80px; padding: 20px;');
		}
	}

	header = function() {
		banner('Hydralytics');
	}

	convertNumber = function(number) {
		try {
			var ret =  mw.language.convertNumber(number);
		} catch (e) {
			var ret = number;
		}
		return ret;
	}

	/**
	 * Number of Page Views.
	 */
	buildNumberOfPageViews = function() {
		var selector = 'number_of_pageviews';
		if (!$('#'+selector).length) { return; }
		var data = sectionData(selector);

		var labels = [];
		var dataSet = [];
		for (var ts in data['per_day']) {
			labels.push(moment.unix(ts).format('MM-DD-YYYY'));
			dataSet.push(parseInt(data['per_day'][ts]));
		}

		var config = chartConfigHelper('line', {
			data: {
				labels: labels,
				datasets: [{
					label: message("page_views"),
					backgroundColor: chartColor.background,
					borderColor: chartColor.border,
					data: dataSet,
					fill: false,
				}]
			},
			options: {
				title: {
					display: true,
					text: data['total'] + " " + message("total_page_views")
				},
				scales: {
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: message("page_views")
						}
					}]
				}
			}
		});

		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, config);

	}

	/**
	 * Build the number_of_visitors data.
	 * Pie Graph for 'users' and 'newUsers'
	 */
	buildNumberOfVisitors = function() {
		var selector = 'number_of_visitors';
		if (!$('#'+selector).length) { return; }

		var newUsers = parseInt(sectionData(selector).newUsers);
		var totalUsers = parseInt(sectionData(selector).users);
		var returningUsers = parseInt(sectionData(selector).returningUsers);

		var config = {
			data: {
				labels: [
					message("returning_visitors"),
					message("new_visitors")
				],
				datasets: [{
					data: [
						returningUsers,
						newUsers
					],
					backgroundColor: chartColors
				}]
			},
			options: {
				title: {
					display: true,
					text:  convertNumber(totalUsers) +" "+ message("total_visitors")
				}
			}
		};
		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, chartConfigHelper('pie', config));
	}

	/**
	 *	Build a Pie Chart displaying Desktop vs Mobile
	 */
	buildDesktopVsMobile = function() {
		var selector = 'desktop_vs_mobile';
		if (!$('#'+selector).length) { return; }

		var data = sectionData(selector); // extract labels and data;

		var l = [];
		var d = [];
		for (var name in data) {
			// Format them to be upper case, for more prettyness
			var formattedName = (name.charAt(0).toUpperCase() + name.slice(1));
			l.push(formattedName);
			d.push(data[name])
		}

		var config = {
			data: {
				labels: l,
				datasets: [{
					data: d,
					backgroundColor: chartColors
				}]
			}
		};
		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, chartConfigHelper('pie', config));
	}

	/**
	 *	Build Browser Breakdown
	 */
	buildBrowserBreakdown = function() {
		var selector = 'browser_breakdown';
		if (!$('#'+selector).length) { return; }

		var data = sectionData(selector);

		/* Track only browsers that match these */
		var browsersMain = [
			"Chrome",
			"Firefox",
			"Internet Explorer",
			"Safari",
			"Edge",
			"Other"
		];

		var labels = [];
		var series = [];
		var otherTotal = 0;

		/* Grab main browser Types */
		for (var name in data) {
			if (browsersMain.indexOf(name) !== -1) {
				labels.push(name);
				series.push(Number(data[name]));
			} else {
				otherTotal += Number(data[name]);
			}
		}

		labels.push(message("device_other"));
		series.push(otherTotal);

		var config = {
			data: {
				labels: labels,
				datasets: [{
					data: series,
					backgroundColor: chartColors
				}]
			}
		};
		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, chartConfigHelper('pie', config));
	}

	/**
	 * Build Edits Per Day Line Chart
	 */
	buildEditsPerDay = function() {
		var selector = 'edits_per_day';
		if (!$('#'+selector).length) { return; }

		var data = sectionData(selector);

		var labels = [];
		var dataSet = [];
		for (var ts in data) {
			labels.push(moment.unix(ts).format('MM-DD-YYYY'));
			dataSet.push(parseInt(data[ts]));
		}

		var config = chartConfigHelper('line', {
			data: {
				labels: labels,
				datasets: [{
					label: message("edits"),
					backgroundColor: chartColor.background,
					borderColor: chartColor.border,
					data: dataSet,
					fill: false,
				}]
			},
			options: {
				scales: {
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: message("edits")
						}
					}]
				}
			}
		});

		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, config);

	}

	/**
	 * Build Logged in vs Logged Out breakdown
	 */
	buildLoggedInOut = function() {
		var selector = 'logged_in_out';
		if (!$('#'+selector).length) { return; }

		var data = sectionData(selector);
		var seriesDataIn = [];

		var labels = [];
		var dataSet = [];
		var dataSet2 = [];

		for (var ts in data.in) {
			labels.push(moment.unix(ts).format('MM-DD-YYYY'));
			dataSet.push(parseInt(data.in[ts]));
		}
		var seriesDataOut = [];
		for (var ts in data.out) {
			dataSet2.push(parseInt(data.out[ts]));
		}

		var config = chartConfigHelper('line', {
			data: {
				labels: labels,
				datasets: [{
					label: message("logged_in"),
					backgroundColor: chartColor.background,
					borderColor: chartColor.border,
					data: dataSet,
					fill: false,
				},{
					label: message("logged_out"),
					backgroundColor: chartColor.background2,
					borderColor: chartColor.border2,
					data: dataSet2,
					fill: false,
				}]
			},
			options: {
				scales: {
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: message("edits")
						}
					}]
				}
			}
		});

		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, config);
	}

	/**
	 * Append the 30 days notice
	 */
	appendLast30DaysNote = function() {
		var last30 = [
			'number_of_pageviews',
			'logged_in_out',
			'edits_per_day',
			'top_search_terms',
			'top_viewed_pages',
			'most_visited_files',
			'desktop_vs_mobile',
			'browser_breakdown',
			'geolocation'
		];
		for (var x in last30) {
			if ($("#"+last30[x]).length) {
				$("#"+last30[x]).append("<div class=\"last30 chart-footer\">"+ message("based_on_last_30") +"</div>");
			}
		}
	}

	/**
	 * Build the admin_count_graph data.
	 */
	buildAdminCountGraph = function() {
		var selector = 'admin_count_graph';
		if (!$('#'+selector).length) { return; }

		var data = sectionData(selector);

		var engaged_admins = parseInt(data.active_admin_count);
		var nonengaged_admins = parseInt(data.admin_count) - engaged_admins;

		var config = {
			data: {
				labels: [
					message("engaged_admins"),
					message("nonengaged_admins")
				],
				datasets: [{
					data: [
						engaged_admins,
						nonengaged_admins
					],
					backgroundColor: chartColors
				}]
			},
			options: {
				title: {
					display: false,
					//text:  convertNumber(returningUsers + newUsers) +" "+ message("total_visitors")
				}
			}
		};
		var ctx = chartSelector(selector);
		var chart = new Chart(ctx, chartConfigHelper('pie', config));
	}

	/**
	 * Wrapper function to call all individual chart build functions.
	 */
	buildCharts = function() {
		if (typeof GAPropID !== 'undefined') {
			log('Building data from GA property ID ' + GAPropID );
		}
		buildDesktopVsMobile();
		buildBrowserBreakdown();
		buildEditsPerDay();
		buildLoggedInOut();
		buildNumberOfPageViews();
		buildNumberOfVisitors();
		buildAdminCountGraph();
		appendLast30DaysNote();
	}

	/**
	 * Get jQuery object for the chart placement selector
	 */
	chartSelector = function(id,jquery = false) {
		var newid = id + "_chart";
		var selector = '#' + newid;
		if (!$(selector).length) {
			log('Creating a new canvas at '+selector, sectionData(id));

			$("#" + id + " .grid_box_inner").remove();
			$("#" + id).append('<div class="grid_box_chart"><canvas id="' + newid + '" class="chart_canvas"></canvas></diV>');
		}
		if (jquery) {
			return $(selector);
		} else {
			return document.getElementById(newid).getContext('2d')
		}
	}

	/**
	 *
	 */
	sectionData = function(id) {
		return sectionsData[id];
	}

	/**
	 * Save time configuring identical configured charts
	 */
	chartConfigHelper = function(name,passedData) {
		switch(name){
			case 'pie':
			/*
				PIE CHART CONFIG HELPER.
			*/
				var config = {
					type: 'pie',
					options: {
						responsive: true,
						tooltips: {
							mode: 'index',
							intersect: true,
							callbacks: {
							  label: function(tooltipItem, data) {
								/* Locaization of Tooltips that only include values */
								var label = data.datasets[tooltipItem.datasetIndex].label || false;
								if (!label) {
									label = data.labels[tooltipItem.index] || '';
								}
								if (label) {
									label += ': ';
								}

								var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
								label += convertNumber(value);

								var dataset = data.datasets[tooltipItem.datasetIndex];
								var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
								  return previousValue + currentValue;
								});
								var currentValue = dataset.data[tooltipItem.index];
								var precentage = Math.floor(((currentValue/total) * 100)+0.5);

								label += " (" + precentage + "%)";

								return label;
							  }
							}
						  }
					}
				}
			/************************************/
				break;
			case 'line':
			/*
				LINE CHART CONFIG HELPER
			*/
				var config = {
					type: 'line',
					options: {
						tooltips: {
							mode: 'index',
							intersect: true,
							callbacks: {
								label: function(tooltipItem, data) {
									/* Locaization of Tooltips that only include values */
									var label = data.datasets[tooltipItem.datasetIndex].label || false;
									if (!label) {
										label = data.labels[tooltipItem.index] || '';
									}
									if (label) {
										label += ': ';
									   }
									var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
									label += convertNumber(value);
									return label;
								}
							}
						},
						showLines: true,
						spanGaps: false,
						responsive: true,
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: ''
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'y axes'
								},
								ticks: {
									callback: function(value, index, values) {
										/* Locaization of yAxis ticks on line charts */
										return convertNumber(value);
								   }
								}
							}]
						}
					}
				}
			/************************************/
				break;
			default:
				log('Invalid option passed to Chart Config Helper: '+name);
				break;
		}

		/**
		 *  THESE CONFIG OPTIONS WILL MERGE INTO EVERY CHART
		 */
		var globalToAll = {
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: '',
					fontColor: 'black'
				},
				hover: {
					mode: 'index',
					intersect: true
				},
				legend: {
					display: true,
					labels: {
						fontColor: 'black'
					}
				}
			}
		}
		/************************************/

		var merged = _.merge(config, globalToAll);
			merged = _.merge(merged, passedData);

		return merged;
	}

	/**
	 * Shortcut incase this needs to be modified
	 */
	message = function(str) {
		return mw.message(str).escaped();
	}

	/*
		Preemtive strike against any weird resource loader issues.
		Probably not necessary to test all these parts, but extra
		safety when dealing with mediawiki is never a bad thing.
		This will keep checking a max of 2.5 seconds for the object to have properties.
	*/
	var waitLoop = 0;
	waitForChart = function() {
		if (typeof Chart !== 'undefined') {
			log('Chart library exists. Building Charts...');
			buildCharts();
		} else {
			waitLoop++;
			if (waitLoop > 10) {
				log("Chart library doesn't seem to exist...");
				return;
			}
			setTimeout(waitForChart, 250);
		}
	}
	waitForData = function() {
		if (Object.keys(sectionsData).length) {
			log('Sections data found to act upon. Lets do this.');
			waitLoop = 0;
			waitForChart();
		} else {
			waitLoop++;
			if (waitLoop > 10) {
				log("Unable to load Section Data. Exiting.");
				return;
			}
			setTimeout(waitForData, 250);
		}
	}
	header();
	waitForData();

	// Wikia change
	// Wikia.Tracker:  trackingevent editor-ck/impression/draft-conflict/ [analytics track]
	require(['wikia.tracker'], function(tracker) {
		tracker.track({
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			category: 'wikia_analytics'
		});
	})
});
