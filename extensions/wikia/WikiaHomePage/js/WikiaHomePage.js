var WikiaHomePageRemix = function(params) {
	this.NUMBEROFSLOTS = 17;
	this.PRELOADTIMEOUT = 200; 

	this.wikis = [];
	this.currentset = [];
	this.newset = [];
	this.preloadlist = [];
};

WikiaHomePageRemix.prototype = {
	randOrd : function() {
		return (Math.round(Math.random()) - 0.5);
	},
	init : function(wikiList) {
		this.wikis = wikiList;

		$(".remix a").click(
				function(event) {
					event.preventDefault();
					WikiaRemixInstance.updateVisualisation();
					return false;
				}
			);
		$().log('WikiaHomePageRemix initialised');
	},
	preloadnextimage : function() {
		if(this.preloadlist.length > 0) {
			var imagepath = this.preloadlist.pop();
			if(typeof imagepath != 'undefined') {
				var image = new Image();
				$(image).load(WikiaRemixInstance.preloadnextimage());
				image.src = imagepath;
			}
		} else {
			$().log('WikiaHomePageRemix preload ended');
		}
	},	
	preload : function () {
		var totalverticals = this.newset.length;
		
		for ( var verticalcount = 0; verticalcount < totalverticals; verticalcount++) {
			var numberofwikis = this.newset[verticalcount].length;
			for (var wikicount = 0; wikicount < numberofwikis; wikicount++) { 
				if(this.newset[verticalcount][wikicount].imagebig) {
					this.preloadlist.push(this.newset[verticalcount][wikicount].imagebig);
				}
				if(this.newset[verticalcount][wikicount].imagemedium) {
					this.preloadlist.push(this.newset[verticalcount][wikicount].imagemedium);
				}
				if(this.newset[verticalcount][wikicount].imagesmall) {
					this.preloadlist.push(this.newset[verticalcount][wikicount].imagesmall);
				}
			}
		}
		this.preloadnextimage();
		$().log('WikiaHomePageRemix preload started');
	},
	remix : function() {
		$().log('WikiaHomePageRemix remixing');
		var totalverticals = this.wikis.length;
		var totalwikispulled = 0;

		this.newset = [];

		for ( var verticalcount = 0; verticalcount < totalverticals; verticalcount++) {
			var numberofverticalwikis;
			if (verticalcount < totalverticals - 1) {
				numberofverticalwikis = 2 * Math.round((this.NUMBEROFSLOTS * this.wikis[verticalcount].percentage) / 100.00);
				totalwikispulled += numberofverticalwikis;
			} else {
				// last vertical may have fewer wikis to match total of NUMBEROFSLOTS * 2
				numberofverticalwikis = this.NUMBEROFSLOTS * 2 - totalwikispulled;
			}

			this.newset[verticalcount] = this.wikis[verticalcount].wikilist.sort(this.randOrd).slice(0, numberofverticalwikis);

			var duplicatedindices = [];
			if (this.currentset.length > 0) {
				if (this.currentset[verticalcount]) {
					// this is O(N^2), but the number of loop body runs is NUMBEROFSLOTS * NUMBEROFSLOTS * 2, making 
					// it 578 operations total 
					for ( var newcount = 0; newcount < this.newset[verticalcount].length; newcount++) {
						for ( var currentcount = 0; currentcount < this.currentset[verticalcount].length; currentcount++) {
							if (this.newset[verticalcount][newcount] == this.currentset[verticalcount][currentcount]) {
								duplicatedindices.push(newcount);
							}
						}
					}
					for ( var cutloop = 0; cutloop < duplicatedindices.length; cutloop++) {
						// we cannot leave less than half of wikis
						if(this.newset[verticalcount].length > (numberofverticalwikis / 2)) {
							this.newset[verticalcount].splice(duplicatedindices[cutloop], 1);
						}
					}
				}

				this.newset[verticalcount] = this.newset[verticalcount].slice(0, numberofverticalwikis / 2);
			} else {
				// old set empty - just take the first half
				this.newset[verticalcount] = this.newset[verticalcount].slice(0, numberofverticalwikis / 2);
			}

			// assign to currentset
			this.currentset[verticalcount] = this.newset[verticalcount];
		}
		this.preload();
		$().log('WikiaHomePageRemix data remixed');
	},		
	reassign : function() {
	    var flatwikilist = [];	    
	    var totalverticals = this.wikis.length;

	    for ( var verticalcount = 0; verticalcount < totalverticals; verticalcount++) {
	    	for ( var wikicount = 0; wikicount < this.newset[verticalcount].length; wikicount++) {
	    		flatwikilist.push(this.newset[verticalcount][wikicount]);
	    	}
	    }

	    flatwikilist.sort(this.randOrd);	    

	    $('#visualization .wikia-slot').each(function(slot) {
	    	if(typeof flatwikilist[slot] != 'undefined') {
	    		if($(this).hasClass('slot-small')) {
	    			$(this).find('img').attr('src',flatwikilist[slot].imagesmall);
		    	} else if($(this).hasClass('slot-medium')) {
	    			$(this).find('img').attr('src',flatwikilist[slot].imagemedium);	
		    	} else if($(this).hasClass('slot-big')) {
	    			$(this).find('img').attr('src',flatwikilist[slot].imagebig);
		    	}

	    		if($(this).is('a')) {
    				$(this).attr('href',flatwikilist[slot].wikiurl);
    				$(this).attr('title',flatwikilist[slot].wikiname);
    			}

	    		$(this).find('span').remove();

	    		var wikinamehtml = $("<span></span>");

    			if(flatwikilist[slot].wikinew) {
    				wikinamehtml.append('<strong class="new">New</strong');
    			}

    			if(flatwikilist[slot].wikihot) {
    				wikinamehtml.append('<strong class="hot">Hot</strong');
    			}

    			wikinamehtml.append(flatwikilist[slot].wikiname);
	    		$(this).append(wikinamehtml);
	    	}
	    });
	    $().log('WikiaHomePageRemix data assigned');
	},
	updateVisualisation: function() {
		this.reassign();
		this.remix();
	}
	
};

var WikiaRemixInstance = new WikiaHomePageRemix();
$(function() {
	if((wikiaHomePageVisualizationStatus || 0) == 0) {
		$().log("WikiaHomePageRemix Failover data init");
		WikiaRemixInstance.init(wikiaHomeFailoverPageVisualizationData);		
	} else {
		$().log("WikiaHomePageRemix WikiMedia Message data init");
		WikiaRemixInstance.init(wikiaHomePageVisualizationData);
	}	
	WikiaRemixInstance.remix();	
	WikiaRemixInstance.updateVisualisation();
	WikiaRemixInstance.preload();
});
