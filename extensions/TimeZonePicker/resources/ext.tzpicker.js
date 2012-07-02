/**
 * TimeZonePicker extension
 * @copyright 2011 Brion Vibber <brion@pobox.com>
 */

(function($, mw) {

// Run our setup after everything's done so we have DOM and data ready :D
$(function() {

var mapState = {
	nearest: null,
	selected: null,
	offset: 0,
	mapOffset: 0,
	mouseThreshold: 50,
	zoom: 1,
	points: []
};

var hhmmToMinutes = function(hhmm) {
	var matches = /^\s*([+-]?)(\d+)(?::(\d\d))?\s*$/.exec(hhmm);
	if (!matches) {
		return 0;
	}

	var plusminus = matches[1];
	var hours = parseInt(matches[2], 10) || 0;
	var mins = parseInt(matches[3], 10) || 0;

	var mult = (plusminus == '-') ? -1 : 1;
	var minutes = mult * (hours * 60 + mins);
	return minutes;
};

/**
 * Pull just the zones that match our current offset.
 *
 * @param localOffset: int
 * @return Array of TZ info objects
 */
var matchingZones = function(localOffset) {
	// A list of {name, offset, location}
	// location is {country_code, latitude, longitude, comments}
	// @fixme read these via AJAX so we only have to ask for matching ones?
	var zoneInfo = window.mw_ext_tzpicker_ZoneInfo;
	//return zoneInfo; // uncomment this to try showing all zones. not yet ideal

	var zones = [];
	$.each(zoneInfo, function() {
		if (this.offset == localOffset) {
			zones.push(this);
		}
	});
	return zones;
};

var plotLabel = function( marker ) {
	var labelNode = marker.data('label');
	if (labelNode == null) {
		var zone = marker.data('zone');
		var sx = marker.data('sx');
		var sy = marker.data('sy');

		var label = $( '<div class="mw-tzpicker-label"></div>' );
		label.text( zone.name );
		label.data('zone', zone);
		label.css('left', (sx + 16) + 'px');
		label.css('top', (sy - 8) + 'px');
		$('#mw-tzpicker-map').append(label);

		marker.data('label', label[0]);
	}
};

/**
 * @param {object} zone
 * @return DOMElement
 */
var plotZone = function( zone ) {
	//var width = 360;
	//var height = 280; //280;
	//var centerX = 180;
	//var centerY = 280 / 2;
	var width = 720;
	var height = 720;
	var centerX = width / 2;
	var centerY = 558 / 2;
	var offset = mapState.mapOffset;

	var lon = zone.location.longitude;
	var lat = zone.location.latitude;
	if (lat == -90.0) {
		// hack for south pole
		lat = -78.5; // fit it in the cut-off mercator :P
		lon = 180;
	}

	// Normalize longitude for offset & wraparound
	lon = lon - offset;
	if (lon < -180) {
		lon += 360;
	} else if (lon > 180) {
		lon -= 360;
	}

	// Mercator projection per http://en.wikipedia.org/wiki/Mercator_projection#Mathematics_of_the_projection
	var lat_rad = lat * Math.PI / 180.0;
	var x = lon / 180;
	var y = 0.5 * Math.log(
		(1 + Math.sin(lat_rad)) /
		(1 - Math.sin(lat_rad))
	);

	var sx = ((x * width / 2.0) + centerX) * mapState.zoom;
	var sy = ((y * height / -6.0) + centerY) * mapState.zoom;
	if (mapState.zoom > 1) {
		sx -= 360;
	}

	var marker = $('<div class="mw-tzpicker-marker"></div>')
		.data('zone', zone)
		.data('sx', sx)
		.data('sy', sy)
		.css('left', (sx - 4) + 'px')
		.css('top', (sy - 4) + 'px');
	if (parseInt(zone.offset) != parseInt(mapState.offset)) {
		marker.addClass('far');
	}
	$('#mw-tzpicker-map').append(marker);

	// hack hack
	/*
	if (className) {
		plotLabel(marker);
	}
	*/
   mapState.points.push({
	   x: sx,
	   y: sy,
	   zone: zone,
	   marker: marker[0]
   });
   return marker[0];
};

var plotMatchingZones = function( localOffset, selectedName ) {
	var map = $('#mw-tzpicker-map');
	map.empty();
	mapState.offset = localOffset;
	mapState.points = [];

	var overlay = $('<div id="mw-tzpicker-overlay"></div>');
	var idealDegrees = localOffset * 360 / (24 * 60);
	var idealPixels = idealDegrees * 2 * mapState.zoom;
	if (mapState.zoom > 1) {
		idealPixels += 360;
	}
	map.css('background-position', (-1 * idealPixels) + 'px 0');
	mapState.mapOffset = idealDegrees;
	map.append(overlay);

	var zones = matchingZones(localOffset);
	$.each(zones, function() {
		var markerNode = plotZone(this);
		if (selectedName == this.name) {
			mapState.selected = markerNode;
			$(markerNode).addClass('selected');
			plotLabel($(markerNode));
		}
	});
};

var selectZoneByName = function(zoneName) {
	$('#mw-input-wptimecorrection option').each(function() {
		var data = $(this).val().split('|');
		if( data[0] == 'ZoneInfo' ) {
			var offset = data[1];
			var name = data[2];
			if (name == zoneName) {
				$(this).attr('selected', true);
				$('#mw-input-wptimecorrection').change();
			}
		}
	});
};

var plotLocalZones = function() {
	var localClock = new Date();

	// Note that Date.getTimezoneOffset returns the inverse of what we use
	// elsewhere: UTC+1:00 gives -60 minutes. Convert back to match ZoneInfo...
	var localOffset = -1 * localClock.getTimezoneOffset();
	plotMatchingZones(localOffset);
};

var findNearestMarker = function(x, y) {
	var markers = $('#mw-tzpicker-map .mw-tzpicker-marker');
	var nearest = null;
	var min2 = mapState.mouseThreshold * mapState.mouseThreshold;

	var points = mapState.points;
	var n = points.length;
	for (var i = 0; i < n; i++) {
		var point = points[i];
		var dx = point.x - x, dy = point.y - y;
		var dx2 = dx * dx, dy2 = dy * dy;
		if (dx2 > min2 || dy2 > min2) {
			continue;
		}
		var dist2 = dx2 + dy2;
		if (dist2 < min2) {
			min2 = dist2;
			nearest = point.marker;
		}
	}
	return nearest;
};

// Maaaagic
var setupTimezones = function() {
	$('#mw-htmlform-timeoffset tbody')
		.append('<tr class="mw-tzpicker-row"><td>' +
				'<td class="mw-input">' +
				'<div id="mw-tzpicker">' +
			    '<div id="mw-tzpicker-map"></div>' +
			    '</div>' +
				'</td></tr>');

	var map = $('#mw-tzpicker-map');
	if (mapState.zoom > 1) {
		map.addClass('zoom');
	}
	map.mousemove(function(e) {
		var offset = map.offset();
		var x = e.pageX - offset.left;
		var y = e.pageY - offset.top;

		var nearest = findNearestMarker(x, y, 100);
		if (nearest) {
			var marker = $(nearest);
			plotLabel(marker);
			marker.addClass('selected');
		}
		if (mapState.nearest && mapState.nearest != nearest && mapState.nearest != mapState.selected) {
			var oldMarker = $(mapState.nearest);
			oldMarker.removeClass('selected');
			var oldLabel = oldMarker.data('label');
			if (oldLabel) {
				$(oldMarker).data('label', null);
				$(oldLabel).remove();
			}
		}
		mapState.nearest = nearest;
	});
	map.click(function(e) {
		var offset = map.offset();
		var x = e.pageX - offset.left;
		var y = e.pageY - offset.top;

		var nearest = findNearestMarker(x, y, 100);
		if (nearest && nearest != mapState.selected) {
			var marker = $(nearest);
			var zone = marker.data('zone');
			selectZoneByName(zone.name);
		}
	});
	map.dblclick(function(e) {
		if (mapState.zoom == 1) {
			mapState.zoom = 2;
			map.addClass('zoom');
		} else if (mapState.zoom == 2) {
			mapState.zoom = 1;
			map.removeClass('zoom');
		}
		if (mapState.selected) {
			var zone = $(mapState.selected).data('zone');
			plotMatchingZones(zone.offset, zone.name);
		} else {
			plotLocalZones();
		}
	});

	var selector = $('#mw-input-wptimecorrection');
	var ping = function() {
		var data = $(this).val().split('|');
		if( data[0] == 'ZoneInfo' ) {
			var offset = data[1];
			var name = data[2];
			plotMatchingZones(offset, name);
		} else if (data[0] == 'guess') {
			plotLocalZones();
		} else {
			var hhmm = $('#mw-input-wptimecorrection-other').val();
			var minutes = hhmmToMinutes(hhmm);
			plotMatchingZones(minutes);
		}
	};
	selector.change(function() {
		// horrible hack! slight delay to get the server offset
		window.setTimeout(function() {
			ping.call(selector[0]);
		}, 50);
	});
	ping.call(selector[0]);
};

setupTimezones();

});

})(jQuery, mediaWiki);
