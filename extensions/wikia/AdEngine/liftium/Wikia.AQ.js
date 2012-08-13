// AQ, a class used for ContextWeb DAR

/*
 * There is a problem with this file and Athena:
 *
 * It seems Athena is only defined as seen in Wikia.Athena.js and
 * missing the following methods (that are called from this file):
 *
 * d, print_r, e, iframeHop, hop, debug, beaconCall, clone, buildQueryString
 *
 * And members:
 *
 * baseUrl, rand
 */

window.AQ = window.AQ || (function(window, Athena, undef) {
	'use strict';

	var inIframe = (window.top !== window)
		, AQ = this;

	return {
		eventUrls : [],
		chain : {},
		allTags : {},
		cwpid : 504082, // Our account number
		priceFloor : 0, // Tag must be worth this to serve it
		tries : 0,
		next: function(slotgroup) {
			Athena.d("AQ.next called with " + slotgroup, 3);
			Athena.d("AQ.chain for " + slotgroup + ": " + Athena.print_r(AQ.chain[slotgroup]), 5);

			// Mark the last tag as rejected
			var i, nexti = 0;
			for (i = AQ.chain[slotgroup].length - 1; i >= 0; i -= 1) {
				if (!Athena.e(AQ.chain[slotgroup][i].skipped)) {
					// Last one was skipped
					nexti = i + 1;
					break;
				} else if (!Athena.e(AQ.chain[slotgroup][i].attempt)) {
					// Send reject beacon. Mark as reject in the chain
					AQ.beacon(AQ.chain[slotgroup][i].id, 'reject');
					AQ.chain[slotgroup][i].reject = true;
					Athena.d("AQ tag #" + AQ.chain[slotgroup][i].id + " rejected in " + slotgroup, 3);
					nexti = i + 1;
					break;
				}
			}

			if (nexti > AQ.chain[slotgroup].length - 1) {
				// End of the chain
				Athena.d("AQ: End of ContextWeb chain", 5);
				if (inIframe) {
					Athena.iframeHop(AQ.win.location);
				} else {
					Athena.hop();
				}
			} else {
				Athena.debug("AQ.next calling tag #" + AQ.chain[slotgroup][nexti].id + " with a value of " + AQ.chain[slotgroup][nexti].fValue, 3);
				AQ.tag(slotgroup, AQ.chain[slotgroup][nexti].id);
			}
		},
		/* Context Web Beacon */
		beacon: function(cwtagid, action) {
			if (Athena.rand < 0.5) {
				return;
			}
			var url = Athena.baseUrl + 'event/set?event=contextWebBeacon&cwtagid=' + cwtagid + '&action=' + action;
			Athena.d("AQ event beacon url: " + url, 3);
			AQ.eventUrls.push(url);
			Athena.beaconCall(url);
		},
		checkForLoad: function(slotgroup) {
			/*
			 * Context Web populates a strCreative global variable. When the ad returns.
			 * If this variable does not exist, check again in a few milliseconds
			 *
			 * Otherwise, figure out if it was a load or a reject by seeing if it is marked as "reject" in the chain, which is done by the AQ.next function
			 *
			 */
			var i, recall;

			Athena.d("AQ.checkForLoad called for " + slotgroup, 4);
			if (Athena.e(window.strCreative)){
				if (AQ.tries < 100){
					recall = "AQ.checkForLoad('" + slotgroup + "');";
					Athena.d("AQ: Recalling " + recall + " in 100 ms", 6);
					window.setTimeout(recall, 100);
					AQ.tries += 1;
				} else {
					Athena.d("Giving up after 100 tries in AQ.checkForLoad");
				}
				return;
			}

			// Walk backwards through the chain and find the first attempt
			for (i = AQ.chain[slotgroup].length - 1; i >= 0; i -= 1) {
				if (!Athena.e(AQ.chain[slotgroup][i].attempt)) {
					// Found one that was started. See if AQ.next marked it as reject
					if (Athena.e(AQ.chain[slotgroup][i].reject)) {
						// It loaded!
						AQ.beacon(AQ.chain[slotgroup][i].id, 'load');
						AQ.chain[slotgroup][i].load = true;
						Athena.d("AQ tag #" + AQ.chain[slotgroup][i].id + " loaded in " + slotgroup, 3);
					}

					break;
				}
			}
		},
		randomTag: function(slotgroup, win) {
			var i, j, found, r, oldChain
				, chooseFrom = [];

			AQ.randomTagCalled = true;

			// Find a the tags to choose from that aren't already in the chain
			for (i = 0; i < AQ.allTags[slotgroup].length; i += 1) {
				found = false;
				for (j = 0; j < AQ.chain[slotgroup].length; j += 1) {
					if (AQ.allTags[slotgroup][i].id === AQ.chain[slotgroup][j].id){
						found = true;
						break;
					}
				}
				if (!found) {
					chooseFrom.push(Athena.clone(AQ.allTags[slotgroup][i]));
				}
			}

			if (Athena.e(chooseFrom)) {
				// They are all there, no need to randomize.
				AQ.tag(slotgroup, AQ.chain[slotgroup][0].id, win);
				return;
			}

			// Build a new chain with the random one on top
			r = Math.floor(Math.random() * chooseFrom.length);

			Athena.d("AQ.randomTag calling tag " + r + " in the chain for " + slotgroup, 2);

			oldChain = AQ.chain[slotgroup];
			AQ.chain[slotgroup] = [];
			AQ.chain[slotgroup].push(Athena.clone(chooseFrom[r]));
			AQ.chain[slotgroup][0].random = true;
			AQ.chain[slotgroup].push(Athena.clone(oldChain[0]));
			AQ.chain[slotgroup].push(Athena.clone(oldChain[1]));

			AQ.tag(slotgroup, AQ.chain[slotgroup][0].id, win);
		},
		tag: function(slotgroup, cwtagid, win) {
			var i, currenti, size, w, h, cwurl, cwpage, cwp;

			if (win === undef) {
				// Keep track of which window to write to.
				AQ.win = win;
			}
			Athena.d("AQ.tag called for " + slotgroup + " with tag #" + cwtagid, 3);

			AQ.lastTag = cwtagid;

			// Determine which tag in the chain we are dealing with
			for (i = 0; i < AQ.chain[slotgroup].length; i += 1){
				if (AQ.chain[slotgroup][i].id === cwtagid) {
					currenti = i;
					break;
				}
			}

			// Get size from slotgroup
			switch (slotgroup) {
				case 'MR': size = "300x250"; w = 300; h = 250; break;
				case 'LB': size = "728x90"; w = 728; h = 90; break;
				case 'WS': size = "160x600"; w = 160; h = 600; break;
				default: document.write('<!-- Invalid slotgroup for AQ.tag -->'); return false;
			}

			// Try to figure out the page we are on using multiple methods
			try {
				cwpage = "http://" + Athena.getPageVar("hostname") + Athena.getPageVar("request");
			} catch (e) {
				if (inIframe && !Athena.e(document.referrer)) { // iframe
					cwpage = document.referrer;
				}
			}

			// Build the cw url
			cwurl = 'http://tag.contextweb.com/TAGPUBLISH/getad.aspx';
			cwp = {
				"tagver": 1,
				"if": 0,
				"ca": "VIEWAD",
				"cp": AQ.cwpid,
				"ct": cwtagid,
				"cf": size,
				"cn": 1,
				"cr": 200,
				"cw": w,
				"ch": h,
				"cads": 0,
				"rq": 1,
				"cwu": cwpage,
				"mrnd": Athena.rand
			};
			cwurl += '?' + Athena.buildQueryString(cwp, '&');

			// Send attempt beacon
			AQ.beacon(cwtagid, 'attempt');

			// Mark the chain.
			AQ.chain[slotgroup][currenti].attempt = true;

			if ( currenti === 0 ) {
				// Check for load, only on the first tag
				window.setTimeout(function() {
					AQ.checkForLoad(slotgroup);
				}, 750 * AQ.chain[slotgroup].length);
			}

			// Write the tag
			AQ.win.document.write('<script type="text/javascript" src="' + cwurl + '"><\/scr' + 'ipt>');
			AQ.win.document.write('<script><\/script>');

			return true;
		}
	};
}(window, window.top.Athena));

window.AQNext = window.AQ.next; // Backward compatibility
