<?php

/**
 * The resource module definitions for the Semantic Result Formats extension.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 1.7
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author mwjames
 */

$moduleTemplate = array(
	'localBasePath' => __DIR__ ,
	'remoteExtPath' => 'SemanticResultFormats'
);

$formatModule = array(
	'localBasePath' => __DIR__ . '/formats',
	'remoteExtPath' => 'SemanticResultFormats/formats'
);

$calendarMessages = array( 'messages' => array(
		'january', 'february', 'march', 'april', 'may_long', 'june', 'july', 'august',
		'september', 'october', 'november', 'december',
		'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec',
		'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',
		'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat',
		'srf-ui-eventcalendar-label-today', 'srf-ui-eventcalendar-label-month',
		'srf-ui-eventcalendar-label-week', 'srf-ui-eventcalendar-label-day',
		'srf-ui-eventcalendar-label-allday', 'srf-ui-eventcalendar-format-time',
		'srf-ui-eventcalendar-format-time-agenda', 'srf-ui-eventcalendar-format-axis',
		'srf-ui-eventcalendar-format-title-month', 'srf-ui-eventcalendar-format-title-week',
		'srf-ui-eventcalendar-format-title-day', 'srf-ui-eventcalendar-format-column-month',
		'srf-ui-eventcalendar-format-column-week', 'srf-ui-eventcalendar-format-column-day'
	)
);

return array(
	//SRF common and non printer specific resources
	'ext.jquery.easing' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.easing/jquery.easing-1.3.pack.js'
	),

	// Fancybox
	'ext.jquery.fancybox' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.fancybox/jquery.fancybox-1.3.4.pack.js',
		'styles'  => 'resources/jquery.fancybox/jquery.fancybox-1.3.4.css',
		'dependencies' => 'ext.jquery.easing',
	),

	// jqgrid
	'ext.jquery.jqgrid' => $moduleTemplate + array(
		'scripts' => array(
			'resources/jquery.jqgrid/jquery.jqGrid.4.4.0min.js',
			'resources/jquery.jqgrid/grid.locale-en.js'
		),
		'styles' => 'resources/jquery.jqgrid/ui.jqgrid.css',
		'dependencies' => 'jquery.ui.core'
	),

	// Flot
	'ext.jquery.flot' => $moduleTemplate + array(
		'scripts' => array(
			'resources/jquery.flot/jquery.flot.js',
			'resources/jquery.flot/jquery.flot.selection.js'
		)
	),

	// jStorage was added in MW 1.20 and for all other releases register as compat module
	'ext.jquery.jStorage' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jstorage/jquery.jStorage.js',
		'dependencies' => 'jquery.json',
	),

	// SRF specific printer independent utility resources
	'ext.srf' => $moduleTemplate + array(
		'scripts' => 'resources/ext.srf.js',
		'styles'  => 'resources/ext.srf.css',
		'position' => 'top',
		'group' => 'ext.srf'
	),
	'ext.srf.util' => $moduleTemplate + array(
		'scripts' => 'resources/ext.srf.util.js',
		'dependencies' => array (
			'ext.srf',
			'ext.jquery.jStorage'
		),
		'group' => 'ext.srf'
	),
	'ext.srf.util.grid' => $moduleTemplate + array(
		'scripts' => 'resources/ext.srf.util.grid.js',
		'styles'  => 'resources/ext.srf.util.grid.css',
		'dependencies' => array(
			'jquery.ui.tabs',
			'ext.srf.util',
			'ext.jquery.jqgrid',
		),
		'messages' => array(
			'ask',
			'srf-ui-gridview-label-series',
			'srf-ui-gridview-label-item',
			'srf-ui-gridview-label-value',
			'srf-ui-gridview-label-chart-tab',
			'srf-ui-gridview-label-data-tab',
			'srf-ui-gridview-label-info-tab'
		),
		'position' => 'top',
		'group' => 'ext.srf'
	),

	// Sparkline
	'ext.jquery.sparkline' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.sparkline/jquery.sparkline.min.js'
	),
	'ext.srf.sparkline' => $formatModule + array(
		'scripts' => 'sparkline/resources/ext.srf.sparkline.js',
		'dependencies' => array(
			'ext.srf.util',
			'ext.jquery.sparkline'
		),
		'group' => 'ext.srf',
		'position' => 'top',
	),

	// Dygraphs
	'ext.dygraphs.combined' => $moduleTemplate + array(
		'scripts' => 'resources/dygraphs/dygraph-combined.js'
	),
	'ext.srf.dygraphs' => $formatModule + array(
		'scripts' => array(
			'dygraphs/resources/ext.srf.dygraphs.js',
			'../resources/dygraphs/dygraph-combined.js'
		),
		'styles' => 'dygraphs/resources/ext.srf.dygraphs.css',
		'dependencies' => array(
			'jquery.client',
			'jquery.async',
			'ext.srf.util',
			'ext.smw.tooltip',
			'ext.dygraphs.combined',
		),
		'messages' => array (
			'srf-ui-common-label-datasource',
			'srf-ui-common-label-request-object',
			'srf-ui-common-label-ajax-error',
			'srf-ui-common-label-help-section',
			'srf-ui-tooltip-title-scope'
		),
		'position' => 'top',
	),

	// Listnave
	'ext.jquery.listnav' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.listnav/jquery.listnav.min-2.1.js'
	),

	// Listmenu
	'ext.jquery.listmenu' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.listmenu/jquery.listmenu.min-1.1.js'
	),

	// pajinate
	'ext.jquery.pajinate' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.pajinate/jquery.pajinate.js'
	),

	// Listwidget
	'ext.srf.listwidget' => $formatModule + array(
		'scripts' => 'widget/resources/ext.srf.listwidget.js',
		'styles'  => 'widget/resources/ext.srf.listwidget.css',
		'dependencies' => 'ext.srf.util',
		'messages' => array(
			'srf-module-nomatch'
		)
	),
	'ext.srf.listwidget.alphabet' => $formatModule + array(
		'dependencies' => array (
			'ext.srf.listwidget',
			'ext.jquery.listnav'
		),
		'position' => 'top'
	),
	'ext.srf.listwidget.menu' => $formatModule + array(
		'dependencies' => array (
			'ext.srf.listwidget',
			'ext.jquery.listmenu'
		),
		'position' => 'top'
	),
	'ext.srf.listwidget.pagination' => $formatModule + array(
		'dependencies' => array (
			'ext.srf.listwidget',
			'ext.jquery.pajinate'
		),
		'position' => 'top'
	),

	// Dynamiccarousel
	'ext.jquery.dynamiccarousel' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.dynamiccarousel/plugin.js'
	),

	// Pagewidget
	'ext.srf.pagewidget.carousel' => $formatModule + array(
		'scripts' => 'widget/resources/ext.srf.pagewidget.carousel.js',
		'styles' => 'widget/resources/ext.srf.pagewidget.carousel.css',
		'dependencies' => array(
			'ext.jquery.dynamiccarousel',
			'ext.srf.util'
		),
		'messages' => array(
			'srf-ui-navigation-prev',
			'srf-ui-navigation-next',
			'srf-ui-common-label-source',
		),
		'position' => 'top',
	),

	// jqPlot
	// jQuery plugin specific declarations
	'ext.jquery.jqplot.core' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jquery.jqplot.js',
		'styles' => 'resources/jquery.jqplot/jquery.jqplot.css'
	),

	// excanvas is required only for pre- IE 9 versions
	'ext.jquery.jqplot.excanvas' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/excanvas.js'
	),

	// JSON data formatting according the the City Index API spec
	'ext.jquery.jqplot.json' => $moduleTemplate + array(
		'scripts' => array (
			'resources/jquery.jqplot/jqplot.json2.js',
			'resources/jquery.jqplot/jqplot.ciParser.js'
		)
	),

	// Plugin class representing the cursor
	'ext.jquery.jqplot.cursor' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.cursor.js'
	),

	// Plugin class to render a logarithmic axis
	'ext.jquery.jqplot.logaxisrenderer' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.logAxisRenderer.js'
	),

	// Plugin class to render a mekko style chart
	'ext.jquery.jqplot.mekko' => $moduleTemplate + array(
		'scripts' => array (
			'resources/jquery.jqplot/jqplot.mekkoRenderer.js',
			'resources/jquery.jqplot/jqplot.mekkoAxisRenderer.js'
		)
	),

	// Plugin class to render a bar/line style chart
	'ext.jquery.jqplot.bar' => $moduleTemplate + array(
		'scripts' => array(
			'resources/jquery.jqplot/jqplot.canvasAxisTickRenderer.js',
			'resources/jquery.jqplot/jqplot.canvasTextRenderer.js',
			'resources/jquery.jqplot/jqplot.canvasAxisLabelRenderer.js',
			'resources/jquery.jqplot/jqplot.categoryAxisRenderer.js',
			'resources/jquery.jqplot/jqplot.barRenderer.js'
		),
		'dependencies' => 'ext.jquery.jqplot.core',
	),

	// Plugin class to render a pie style chart
	'ext.jquery.jqplot.pie' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.pieRenderer.js',
		'dependencies' => 'ext.jquery.jqplot.core'
	),

	// Plugin class to render a bubble style chart
	'ext.jquery.jqplot.bubble' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.bubbleRenderer.js',
		'dependencies' => 'ext.jquery.jqplot.core'
	),

	// Plugin class to render a donut style chart
	 'ext.jquery.jqplot.donut' => $moduleTemplate + array(
		'scripts' =>'resources/jquery.jqplot/jqplot.donutRenderer.js',
		'dependencies' => 'ext.jquery.jqplot.pie'
	),

	'ext.jquery.jqplot.pointlabels' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.pointLabels.js'
	),

	'ext.jquery.jqplot.highlighter' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.highlighter.js'
	),

	'ext.jquery.jqplot.enhancedlegend' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.enhancedLegendRenderer.js'
	),

	// Plugin class to render a trendline
	'ext.jquery.jqplot.trendline' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jqplot/jqplot.trendline.js'
	),

	// General jqplot/SRF specific declarations
	// Plugin class supporting themes
	'ext.srf.jqplot.themes' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.themes.js',
		'dependencies' => 'jquery.client'
	),

	//
	'ext.srf.jqplot.cursor' => $moduleTemplate + array(
		'dependencies' => array (
			'ext.srf.jqplot.bar',
			'ext.jquery.jqplot.cursor',
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.enhancedlegend' => $moduleTemplate + array(
		'dependencies' => array (
			'ext.srf.jqplot.bar',
			'ext.jquery.jqplot.enhancedlegend',
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.pointlabels' => $moduleTemplate + array(
		'dependencies' => array (
			'ext.srf.jqplot.bar',
			'ext.jquery.jqplot.pointlabels',
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.highlighter' => $moduleTemplate + array(
		'dependencies' => array (
			'ext.srf.jqplot.bar',
			'ext.jquery.jqplot.highlighter',
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.trendline' => $moduleTemplate + array(
		'dependencies' => array (
			'ext.srf.jqplot.bar',
			'ext.jquery.jqplot.trendline',
		),
		'position' => 'top',
	),

	// Chart specific declarations
	'ext.srf.jqplot.chart' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.chart.js',
		'styles'  => 'jqplot/resources/ext.srf.jqlpot.chart.css',
		'dependencies' => array(
			'jquery.async',
			'ext.srf.util',
			'ext.srf.jqplot.themes'
		)
	),

	//
	'ext.srf.jqplot.bar' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.chart.bar.js',
		'dependencies' => array (
			'ext.jquery.jqplot.bar',
			'ext.srf.jqplot.chart'
		),
		'messages' => array (
			'srf-error-jqplot-stackseries-data-length'
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.pie' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.chart.pie.js',
		'dependencies' => array (
			'ext.jquery.jqplot.pie',
			'ext.srf.jqplot.chart'
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.bubble' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.chart.bubble.js',
		'dependencies' => array (
			'ext.jquery.jqplot.bubble',
			'ext.srf.jqplot.chart'
		),
		'messages' => array (
			'srf-error-jqplot-bubble-data-length'
		),
		'position' => 'top',
	),

	//
	'ext.srf.jqplot.donut' => $formatModule + array(
		'scripts' => 'jqplot/resources/ext.srf.jqplot.chart.pie.js',
		'dependencies' => array (
			'ext.jquery.jqplot.donut',
			'ext.srf.jqplot.chart'
		),
		'position' => 'top',
	),

	// Timeline
	'ext.smile.timeline' => $formatModule + array(
		'scripts' => 'timeline/resources/SimileTimeline/timeline-api.js'
	),
	'ext.srf.timeline' => $formatModule + array(
		'scripts' => 'timeline/resources/ext.srf.timeline.js',
		'dependencies' => array(
			'ext.smile.timeline',
			'mediawiki.legacy.wikibits'
		)
	),

	// D3
	'ext.d3.core' => $moduleTemplate + array(
		'scripts' => 'resources/d3/d3.v2.min.js'
	),

	//
	'ext.d3.layout.cloud' => $moduleTemplate + array(
		'scripts' => 'resources/d3/d3.layout.cloud.js',
		'dependencies' => 'ext.d3.core'
	),

	//
	'ext.srf.d3.common' => $formatModule + array(
		'scripts' => 'd3/resources/ext.srf.d3.common.js',
		'styles'  => 'd3/resources/ext.srf.d3.common.css',
		'dependencies' => 'ext.srf.util'
	),

	//
	'ext.srf.d3.chart.treemap' => $formatModule + array(
		'scripts' => 'd3/resources/ext.srf.d3.chart.treemap.js',
		'styles'  => 'd3/resources/ext.srf.d3.chart.treemap.css',
		'dependencies' => array ( 'ext.d3.core', 'ext.srf.d3.common' ),
		'position'     => 'top',
	),

	//
	'ext.srf.d3.chart.bubble' => $formatModule + array(
		'scripts' => 'd3/resources/ext.srf.d3.chart.bubble.js',
		'styles'  => 'd3/resources/ext.srf.d3.chart.bubble.css',
		'dependencies' => array ( 'ext.d3.core', 'ext.srf.d3.common' ),
		'position'     => 'top',
	),


	// JitGraph
	'ext.srf.jquery.progressbar' => $formatModule + array(
		'scripts' => array(
			'JitGraph/jquery.progressbar.js',
		),
	),
	'ext.srf.jit' => $formatModule + array(
		'scripts' => array(
			'JitGraph/Jit/jit.js',
		),
	),
	'ext.srf.jitgraph' => $formatModule + array(
		'scripts' => array(
			'JitGraph/SRF_JitGraph.js',
		),
		'styles' => array(
			'JitGraph/base.css',
		),
		'dependencies' => array(
			'mediawiki.legacy.wikibits',
			'ext.srf.jquery.progressbar',
			'ext.srf.jit',
		),
		'position' => 'top',
	),

	// Gallery

	// jcarousel
	'ext.jquery.jcarousel' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.jcarousel/jquery.jcarousel.min.js',
	),

	// responsiveslides
	'ext.jquery.responsiveslides' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.responsiveslides/jquery.responsiveslides.1.32.min.js',
	),

	//
	'ext.srf.gallery.carousel' => $formatModule + array(
		'styles'  => 'gallery/resources/ext.srf.gallery.carousel.css',
		'scripts' => 'gallery/resources/ext.srf.gallery.carousel.js',
		'dependencies' => array(
			'ext.srf.util',
			'ext.jquery.jcarousel'
		),
		'position' => 'top',
	),

	//
	'ext.srf.gallery.slideshow' => $formatModule + array(
		'scripts' => 'gallery/resources/ext.srf.gallery.slideshow.js',
		'styles'  => 'gallery/resources/ext.srf.gallery.slideshow.css',
		'dependencies' => array(
			'ext.srf.util',
			'ext.jquery.responsiveslides'
		),
		'messages' => array(
			'srf-gallery-navigation-previous',
			'srf-gallery-navigation-next'
		),
		'position' => 'top',
	),

	//
	'ext.srf.gallery.overlay' => $formatModule + array(
		'scripts' => 'gallery/resources/ext.srf.gallery.overlay.js',
		'styles'  => 'gallery/resources/ext.srf.gallery.overlay.css',
		'dependencies' => array(
			'ext.srf.util',
			'ext.jquery.fancybox'
		),
		'messages' => array(
			'srf-gallery-overlay-count',
			'srf-gallery-image-url-error'
		),
		'position' => 'top',
	),

	//
	'ext.srf.gallery.redirect' => $formatModule + array(
		'scripts' => 'gallery/resources/ext.srf.gallery.redirect.js',
		'styles'  => 'gallery/resources/ext.srf.gallery.redirect.css',
		'dependencies' => 'ext.srf.util',
		'messages' => array(
			'srf-gallery-image-url-error'
		),
		'position' => 'top',
	),


	// Eventcalendar
	'ext.jquery.fullcalendar' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.fullcalendar/fullcalendar.js',
		'styles' => 'resources/jquery.fullcalendar/fullcalendar.css',
	// If you have MW 1.20+ the definitions below will work but not for earlier
	// MW installations
	//	'styles' => array(
	//		'resources/jquery.fullcalendar/fullcalendar.css' => array( 'media' => 'screen' ),
	//		'resources/jquery.fullcalendar/fullcalendar.print.css' => array( 'media' => 'print' ),
	//	)
	),

	//
	'ext.jquery.gcal' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.fullcalendar/gcal.js',
	),

	//
	'ext.srf.eventcalendar' => $formatModule + $calendarMessages + array(
		'scripts' => 'calendar/resources/ext.srf.eventcalendar.js',
		'dependencies' => array (
			'jquery.ui.core',
			'jquery.ui.widget',
			'ext.smw.tooltip',
			'ext.srf.util',
			'ext.jquery.fullcalendar'
		),
	),

	//
	'ext.srf.eventcalendar.gcal' => $formatModule + array(
		'dependencies' => array (
			'ext.srf.eventcalendar',
			'ext.jquery.gcal'
		)
	),

	// Filtered
	'ext.srf.filtered' => $formatModule + array(
		'scripts' => array(
			'Filtered/libs/ext.srf.filtered.js',
		),
		'styles' => array(
			'Filtered/skins/ext.srf.filtered.css',
		),
	),

	//
	'ext.srf.filtered.list-view' => $formatModule + array(
		'scripts' => array(
			'Filtered/libs/ext.srf.filtered.list-view.js',
		),
		'dependencies' => array(
			'ext.srf.filtered'
		),
	),

	//
	'ext.srf.filtered.calendar-view' => $formatModule + $calendarMessages + array(
		'scripts' => array(
			'Filtered/libs/ext.srf.filtered.calendar-view.js',
		),
		'styles' => array(
			'Filtered/skins/ext.srf.filtered.calendar-view.css',
		),
		'dependencies' => array(
			'ext.srf.filtered',
			'ext.jquery.fullcalendar'
		),
	),

	//
	'ext.srf.filtered.value-filter' => $formatModule + array(
		'scripts' => array(
			'Filtered/libs/ext.srf.filtered.value-filter.js',
		),
		'styles' => array(
			'Filtered/skins/ext.srf.filtered.value-filter.css',
		),
		'dependencies' => array(
			'ext.srf.filtered'
		),
	),

	//
	'ext.srf.filtered.distance-filter' => $formatModule + array(
		'scripts' => array(
			'Filtered/libs/ext.srf.filtered.distance-filter.js',
		),
		'styles' => array(
			'Filtered/skins/ext.srf.filtered.distance-filter.css',
		),
		'dependencies' => array(
			'ext.srf.filtered',
			'jquery.ui.slider'
		),
	),

	// Slideshow
	'ext.srf.slideshow' => $formatModule + array(
		'scripts' => 'slideshow/resources/ext.srf.slideshow.js',
		'styles'  => 'slideshow/resources/ext.srf.slideshow.css',
		'dependencies' =>'mediawiki.legacy.ajax'
	),

	// Tag cloud
	// excanvas is only needed for pre-9.0 Internet Explorer compatibility
	'ext.jquery.tagcanvas.excanvas' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.tagcanvas/excanvas.js'
	),

	//
	'ext.jquery.tagcanvas' => $moduleTemplate + array(
		'scripts' => 'resources/jquery.tagcanvas/jquery.tagcanvas.1.18.min.js'
	),

	//
	'ext.srf.tagcloud.sphere' => $formatModule + array(
		'scripts' => 'tagcloud/resources/ext.srf.tagcloud.sphere.js',
		'styles'  => 'tagcloud/resources/ext.srf.tagcloud.sphere.css',
		'dependencies' => array(
			'jquery.async',
			'jquery.client',
			'ext.srf.util',
			'ext.jquery.tagcanvas'
		),
		'position' => 'top',
	),

	//
	'ext.srf.tagcloud.wordcloud' => $formatModule + array(
		'scripts' => 'tagcloud/resources/ext.srf.tagcloud.wordcloud.js',
		'dependencies' => array (
			'jquery.async',
			'ext.d3.layout.cloud',
			'ext.srf.d3.common'
		),
		'position'     => 'top',
	),

	// Timeseries
	'ext.srf.flot.core' => $formatModule + array(
		'styles'  => 'timeseries/resources/ext.srf.flot.core.css',
	),

	'ext.srf.timeseries.flot' => $formatModule + array(
		'scripts' => 'timeseries/resources/ext.srf.timeseries.flot.js',
		'dependencies' => array(
			'jquery.async',
			'ext.jquery.flot',
			'ext.srf.util',
			'ext.srf.flot.core'
		),
		'position' => 'top'
	),

	// Boilerplate example registration
	/*
		// Simple implementation
		'ext.srf.boilerplate.simple' => $formatModule + array(
			'scripts' => 'boilerplate/resources/ext.srf.boilerplate.simple.js',
			'styles'  => 'boilerplate/resources/ext.srf.boilerplate.css',
			'messages' => array(
				'srf-boilerplate-message'
			),
		);

		// Using the semanticFormats namespace class implementation
		'ext.srf.boilerplate.namespace' => $formatModule + array(
			'scripts' => 'boilerplate/resources/ext.srf.boilerplate.namespace.js',
			'styles'  => 'boilerplate/resources/ext.srf.boilerplate.css',
			'dependencies' => array (
				'ext.srf.util'
			),
			'messages' => array(
				'srf-boilerplate-message'
			),
		);
	*/
);