/**
 * This is a Liftium 2013 (a.k.a Nick's Liftium.js drop-in replacement)
 *
 * It's comming from liftium-private/dist/Liftium-Wikia.min.js (with uglifyjs set to beautify
 * instead of uglifying).
 *
 * Note: the following change was needed: tagwikia/ -> tag/
 *
 * TODO: incorporate the following changes to this version as well:
 *
 * git diff 25f7bb9305527fc7d468ffaf961f6574248ba1ac extensions/wikia/AdEngine/liftium/Liftium.js
 *
 * Loading of this one instead of the regular extensions/wikia/AdEngine/liftium/Liftium.js
 * is triggered with wgAdDriverUseLiftium2013 or ?useliftium2013=1 URL param
 *
 */

// The extra var, so we can simply determine if we're using the 2013 version or the older one
var Liftium2013 = true;

var LiftiumOptions = window.LiftiumOptions || {};

if (!window.Liftium) {
    var Liftium = {
        baseUrl: LiftiumOptions.baseUrl || "http://liftium.wikia.com/",
        chain: {},
        currents: [],
        eventsTracked: 0,
        geoUrl: LiftiumOptions.geoUrl || "http://liftium.wikia.com/",
        loadDelay: 100,
        maxHops: LiftiumOptions.maxHops || 5,
        slotHops: {},
        rejTags: [],
        slotPlacements: [],
        slotTimeouts: 0,
        slotTimer: [],
        slotTimer2: [],
        hopRegister: [],
        maxLoadDelay: LiftiumOptions.maxLoadDelay || 2500,
        isCalledAfterOnload: LiftiumOptions.isCalledAfterOnload || 0,
        hasMoreCalls: LiftiumOptions.hasMoreCalls || 0,
        slotnames: {},
        fingerprint: "a",
        version: 2
    };
    Liftium._ = function(a) {
        return document.getElementById(a);
    }, Liftium.addEventListener = function(a, b, c) {
        return window.addEventListener ? a.addEventListener(b, c, !1) : window.attachEvent ? a.attachEvent("on" + b, c) : !1;
    }, Liftium.beaconCall = function(a, b) {
        if (window.Wikia && window.Wikia.AbTest && window.Wikia.AbTest.inGroup("LIFTIUM_DR", "LIFTIUM_DISABLED")) return void Liftium.d("(Fake) AB experiment LIFTIUM_DR, group LIFTIUM_DISABLED", 1);
        var c = new Image(0, 0);
        b !== !1 && (a += "&cb=" + Math.random().toString().substring(2, 8)), a.length > 1e3 && (Liftium.d("Truncating beacon call url to 1000 characters"), 
        a = a.substring(0, 1e3)), Liftium.d("Beacon call: " + a, 7), c.src = a;
    }, Liftium.buildChain = function(a) {
        var b = Liftium.getSizeForSlotname(a) || Liftium.getSizeForSlotname(Liftium.slotnames[a]), c = new Date();
        Liftium.slotTimer[a] = c.getTime();
        var d = [];
        if (Liftium.chain[a] = [], Liftium.slotPlacements[a] ? Liftium.d("Slot placement for " + a + " already set to " + Liftium.slotPlacements[a], 7) : window.LiftiumPlacement ? (Liftium.slotPlacements[a] = window.LiftiumPlacement, 
        window.LiftiumPlacement = null) : (Liftium.slotPlacements[a] = LiftiumOptions.placement, 
        LiftiumOptions.placement = null), "1x1" == b && (b = "0x0"), Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)) return Liftium.d("Error, config is empty in buildChain(" + a + ")", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/no_config",
            ga_action: "buildChain",
            ga_label: a,
            trackingMethod: "ad"
        }), !1;
        if (Liftium.e(Liftium.config.sizes) || Liftium.e(Liftium.config.sizes[b])) return Liftium.d("Error, unrecognized size " + b + " (" + a + ")", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/unrecognized_size",
            ga_action: b,
            ga_label: a,
            trackingMethod: "ad"
        }), !1;
        "undefined" != typeof window.top.wgEnableAdMeldAPIClient && window.top.wgEnableAdMeldAPIClient && (Liftium.d("Calling AdMeldAPIClient.adjustLiftiumChain for " + b, 3), 
        window.top.AdMeldAPIClient.adjustLiftiumChain(Liftium.config.sizes[b])), Liftium.setAdjustedValues(Liftium.config.sizes[b]), 
        Liftium.config.sizes[b].sort(Liftium.chainSort);
        var e = Liftium.getRequestVal("liftium_tag");
        if (!Liftium.e(e)) for (var f = 0, g = Liftium.config.sizes[b].length; g > f; f++) {
            var h = Liftium.clone(Liftium.config.sizes[b][f]);
            h.tag_id == e && (Liftium.d("Forcing tagid #" + e + " on the front of the chain.", 1, h), 
            Liftium.config.sizes[b][f].inChain = !0, Liftium.chain[a].push(h), d.push(h.network_name + ", #" + h.tag_id));
        }
        for (var i = 0, j = Liftium.config.sizes[b].length; j > i; i++) {
            var k = Liftium.clone(Liftium.config.sizes[b][i]);
            if (Liftium.isValidCriteria(k, a)) {
                if (Liftium.config.sizes[b][i].inChain = !0, Liftium.chain[a].push(k), d.push(k.network_name + ", #" + k.tag_id), 
                1 == k.always_fill) {
                    Liftium.d("Chain complete - last ad is always_fill", 2, d);
                    break;
                }
                if (Liftium.chain[a].length == Liftium.maxHops - 1) break;
            } else Liftium.rejTags.push(k.tag_id);
        }
        if (0 === Liftium.chain[a].length) return Liftium.d("Error building chain for " + a + ". No matching tags?", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/no_matching_tags",
            ga_action: a,
            trackingMethod: "ad"
        }), !1;
        if (1 != Liftium.chain[a][Liftium.chain[a].length - 1].always_fill) {
            var l = Liftium.getAlwaysFillAd(b, a);
            l !== !1 && (Liftium.chain[a].push(l), d.push("AlwaysFill: " + l.network_name + ", #" + l.tag_id));
        }
        var m = Liftium.getSampledAd(b);
        return m !== !1 && Liftium.isValidCriteria(m, a) && "1" != Liftium.chain[a][0].tier && (Liftium.chain[a].reverse(), 
        Liftium.chain[a].push(m), Liftium.chain[a].reverse(), d.push("Sampled: " + m.network_name + ", #" + m.tag_id)), 
        Liftium.d("Chain for " + a + " = ", 3, d), !0;
    }, Liftium.buildQueryString = function(a, b) {
        if (Liftium.e(a)) return "";
        "undefined" == typeof b && (b = "&");
        var c = "";
        for (var d in a) Liftium.e(a[d]) || (c += b + encodeURIComponent(d) + "=" + encodeURIComponent(a[d]));
        return c.substring(b.length);
    }, Liftium.callAd = function(a, b) {
        if (window.Wikia && window.Wikia.AbTest && window.Wikia.AbTest.inGroup("LIFTIUM_DR", "LIFTIUM_DISABLED")) return void Liftium.d("(Fake) AB experiment LIFTIUM_DR, group LIFTIUM_DISABLED", 1);
        if (LiftiumOptions.offline) return Liftium.d("Not printing tag because LiftiumOptions.offline is set"), 
        !1;
        if (Liftium.e(Liftium.config)) {
            Liftium.d("Error downloading config (" + a + ")", 1), Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/error_downloading_config",
                ga_action: a,
                trackingMethod: "ad"
            });
            var c = Liftium.fillerAd(a, "Error downloading config");
            return document.write(c.tag), !1;
        }
        if (Liftium.config.error) {
            Liftium.d("Config error " + Liftium.config.error + " (" + a + ")", 1), Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/config_error",
                ga_action: a,
                ga_label: Liftium.config.error || "unknown",
                trackingMethod: "ad"
            });
            var d = Liftium.fillerAd(a, Liftium.config.error);
            return document.write(d.tag), !1;
        }
        var e = Liftium.getUniqueSlotname(a);
        return b && (Liftium.d("Setting placement of slot " + e + " to " + b, 3), Liftium.slotPlacements[e] = b), 
        Liftium.wikiaTrack({
            eventName: "liftium.slot",
            ga_category: "slot/" + a,
            ga_action: b,
            ga_label: "liftium js",
            trackingMethod: "ad"
        }), document.write('<div id="' + e + '">'), Liftium._callAd(e), document.write("</div>"), 
        !0;
    }, Liftium._callAd = function(a, b) {
        var c = Liftium.getNextTag(a);
        if (c === !1) return c = Liftium.fillerAd(a, "getNextTag returned false"), b ? Liftium.clearPreviousIframes(a) : (document.write("<!-- Liftium Tag #" + c.tag_id + "-->\n"), 
        document.write(c.tag)), !1;
        Liftium.handleNetworkOptions(c), Liftium.d("Ad #" + c.tag_id + " for " + c.network_name + " called in " + a), 
        Liftium.d("Config = ", 6, c);
        try {
            Liftium.e(b) ? (Liftium.d("Tag :" + c.tag, 5), Liftium.lastTag = c, Liftium.lastSlot = a, 
            document.write(c.tag), Liftium.lastTag = null) : (Liftium.clearPreviousIframes(a), 
            Liftium.callIframeAd(a, c));
        } catch (d) {
            Liftium.d("Error loading tag #" + c.tag_id + " (" + a + ")", 1, d), Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/_callAd",
                ga_action: a,
                ga_label: "tag " + c.tag_id,
                trackingMethod: "ad"
            });
        }
        return !0;
    }, Liftium.callIframeAd = function(a, b, c) {
        Liftium.d("Calling Iframe Ad for " + a, 1);
        var d = Liftium.getIframeUrl(a, b);
        if (Liftium.e(d) || "about:blank" == d) return void Liftium.d("Skipping No iframe ad called for No Ad for " + a, 3);
        if (Liftium.slotTimer2[a + "-" + b.tag_id] = Liftium.debugTime(), Liftium.d("slotTimer2 begin for #" + b.tag_id + " in " + a, 3, Liftium.slotTimer2), 
        "object" == typeof c) c.src = d; else {
            c = document.createElement("iframe");
            var e = b.size.split("x");
            c.src = d, c.width = e[0], c.height = e[1], c.scrolling = "no", c.frameBorder = 0, 
            c.marginHeight = 0, c.marginWidth = 0, c.allowTransparency = !0, c.id = a + "_" + b.tag_id, 
            c.style.display = "block";
            var f = b.tag_name && b.tag_name.match(/ [0-9]+x[0-9]+ /);
            if (f && (f = f[0].match(/[0-9]+x[0-9]+/), f = f[0].split("x"), f[0] != c.width || f[1] != c.height)) {
                Liftium.d("Forced size " + f[0] + "x" + f[1] + " for " + a, 3), c.className += " jumbo", 
                c.width = f[0], c.height = f[1];
                var g = d.match(/;sz=[0-9x,]+;/);
                g && (d = d.replace(/;sz=[0-9x,]+;/, ";sz=" + f[0] + "x" + f[1] + ";"), Liftium.d("Forced size " + f[0] + "x" + f[1] + " in Dart URL: " + d, 3), 
                c.src = d);
            }
            Liftium._(a).appendChild(c);
        }
    }, Liftium.callInjectedIframeAd = function(a, b, c) {
        if (Liftium.d("Calling injected Iframe Ad for " + a, 1), window.Wikia && window.Wikia.AbTest && window.Wikia.AbTest.inGroup("LIFTIUM_DR", "LIFTIUM_DISABLED")) return void Liftium.d("(Fake) AB experiment LIFTIUM_DR, group LIFTIUM_DISABLED", 1);
        var d = Liftium.getUniqueSlotname(c || a);
        b.parentNode.id = d, c && (Liftium.d("Setting placement of slot " + d + " to " + c, 3), 
        Liftium.slotPlacements[d] = c);
        var e = b.id.replace(/_iframe$/, "");
        Liftium.wikiaTrack({
            eventName: "liftium.slot",
            ga_category: "slot/" + a,
            ga_action: e,
            ga_label: "liftium",
            trackingMethod: "ad"
        });
        var f = Liftium.getNextTag(d);
        if (!f) return Liftium.d("No tag found for " + a + ". Collapsing frame.", 1), b.width = 0, 
        void (b.height = 0);
        var g = Liftium.getIframeUrl(d, f);
        if (b.src = g, Liftium.slotTimer2[d + "-" + f.tag_id] = Liftium.debugTime(), Liftium.d("slotTimer2 begin for #" + f.tag_id + " in " + d, 3, Liftium.slotTimer2), 
        "about:blank" == g) return Liftium.d("Forced size 0x0 for " + d, 3), b.width = 0, 
        void (b.height = 0);
        var h = f.tag_name && f.tag_name.match(/ [0-9]+x[0-9]+ /);
        if (h) {
            if (h = h[0].match(/[0-9]+x[0-9]+/), h = h[0].split("x"), h[0] == b.width && h[1] == b.height) return;
            Liftium.d("Forced size " + h[0] + "x" + h[1] + " for " + d, 3), b.className += " jumbo", 
            b.width = h[0], b.height = h[1];
            var i = g.match(/;sz=[0-9x,]+;/);
            return void (i && (g = g.replace(/;sz=[0-9x,]+;/, ";sz=" + h[0] + "x" + h[1] + ";"), 
            Liftium.d("Forced size " + h[0] + "x" + h[1] + " in Dart URL: " + g, 3), b.src = g));
        }
    }, Liftium.catchError = function(a, b, c) {
        try {
            var d;
            d = "object" == typeof a ? "Error object: " + Liftium.print_r(a) : "Error on line #" + c + " of " + b + " : " + a, 
            Liftium.d("ERROR! " + d), Liftium.e(Liftium.lastTag) ? Liftium.reportError(d, "onerror") : Liftium.reportError("Tag error for tag " + Liftium.print_r(Liftium.lastTag) + "\n" + d, "tag"), 
            Liftium.e(window.failTestOnError) || (window.LiftiumTest.testFailed(), window.alert(a));
        } catch (e) {}
        return !1;
    }, Liftium.chainSort = function(a, b) {
        var c = parseInt(a.tier, 10) || 0, d = parseInt(b.tier, 10) || 0;
        if (d > c) return -1;
        if (c > d) return 1;
        var e = parseFloat(a.adjusted_value) || 0, f = parseFloat(b.adjusted_value) || 0, g = e + e * Math.random() * .75, h = f + f * Math.random() * .75;
        return h - g;
    }, Liftium.clearPreviousIframes = function(a) {
        var b = Liftium._(a);
        if (null === b) return !1;
        for (var c = b.getElementsByTagName("iframe"), d = 0, e = c.length; e > d; d++) c[d].style.display = "none";
        return !0;
    }, Liftium.clone = function(a) {
        if ("object" == typeof a) {
            if (null === a) return Liftium.d("Liftium.clone: obj == null", 7), "";
            var b = new a.constructor();
            for (var c in a) b[c] = Liftium.clone(a[c]);
            return b;
        }
        return a;
    }, Liftium.crossDomainMessage = function(a) {
        XDM.allowedMethods = [ "Liftium.iframeHop", "LiftiumTest.testPassed" ], XDM.executeMessage(a.data);
    }, Liftium.cookie = function(a, b, c) {
        if (arguments.length > 1) {
            c = c || {}, Liftium.e(b) && (b = "", c.expires = -1);
            var d = "";
            if (c.expires && ("number" == typeof c.expires || c.expires.toUTCString)) {
                var e;
                "number" == typeof c.expires ? (e = new Date(), Liftium.d("Setting cookie expire " + c.expires + " milliseconds from " + e.toUTCString(), 7), 
                e.setTime(e.getTime() + c.expires)) : e = c.expires, d = "; expires=" + e.toUTCString();
            }
            var f = c.path ? "; path=" + c.path : "", g = c.domain ? "; domain=" + c.domain : "", h = c.secure ? "; secure" : "";
            return Liftium.d("Set-Cookie: " + [ a, "=", encodeURIComponent(b), d, f, g, h ].join(""), 6), 
            document.cookie = [ a, "=", encodeURIComponent(b), d, f, g, h ].join(""), !0;
        }
        var i = null;
        if (!Liftium.e(document.cookie)) for (var j = document.cookie.split(";"), k = 0, l = j.length; l > k; k++) {
            var m = j[k].replace(/^\s+|\s+$/g, "");
            if (m.substring(0, a.length + 1) == a + "=") {
                i = decodeURIComponent(m.substring(a.length + 1));
                break;
            }
        }
        return i;
    }, Liftium.debug = function(a, b, c) {
        return Liftium.e(Liftium.debugLevel) ? !1 : b > Liftium.debugLevel ? !1 : ("object" == typeof console && console.dir ? (console.log(Liftium.debugTime() + " Liftium: " + a), 
        arguments.length > 2 && console.dir(c)) : "object" == typeof console && console.log && (console.log(Liftium.debugTime() + " Liftium: " + a), 
        arguments.length > 2 && console.log(Liftium.print_r(c))), !0);
    }, Liftium.d = Liftium.debug, Liftium.debugTime = function() {
        return new Date().getTime() - Liftium.startTime;
    }, Liftium.formatTrackTime = function(a, b) {
        return isNaN(a) ? (Liftium.d("Error, time tracked is NaN: " + a, 7), "NaN") : 0 > a ? (Liftium.d("Error, time tracked is a negative number: " + a, 7), 
        "negative") : (a /= 1e3, a > b ? "more_than_" + b : a.toFixed(1));
    }, Liftium.dec2hex = function(a) {
        var b = parseInt(a, 10).toString(16);
        return "0" == b.toString() ? "00" : b.toUpperCase();
    }, Liftium.empty = function(a) {
        if ("object" == typeof a) {
            for (var b in a) return !1;
            return !0;
        }
        return void 0 === a || "" === a || 0 === a || null === a || a === !1 || "number" == typeof a && isNaN(a) || !1;
    }, Liftium.e = Liftium.empty, Liftium.fillerAd = function(a, b) {
        var c = "", d = -1, e = /[0-9]{1,4}x[0-9]{1,4}/.exec(a), f = e && e[0] || "300x250";
        return Liftium.e(b) || (c += '<div class="LiftiumError" style="display:none">Liftium message: ' + b + "</div>"), 
        f.match(/300x250/) ? d = 2198 : f.match(/728x90/) ? d = 2197 : f.match(/160x600/) ? d = 2199 : c += '<span style="display: none">No available ads</span>', 
        {
            tag_id: d,
            network_name: "Internal Error",
            tag: c,
            size: f
        };
    }, Liftium.getAdColor = function(a) {
        try {
            switch (a) {
              case "link":
                var b = document.getElementsByTagName("a");
                return Liftium.e(b) ? null : Liftium.normalizeColor(Liftium.getStyle(b[0], "color"));

              case "bg":
                return Liftium.normalizeColor(Liftium.getStyle(document.body, "background-color"));

              case "text":
                return Liftium.normalizeColor(Liftium.getStyle(document.body, "color"));

              default:
                return null;
            }
        } catch (c) {
            return Liftium.d("Error in Liftium.getAdColor: " + c.message), null;
        }
    }, Liftium.getCookieDomain = function() {
        var a = document.domain, b = a.match(/(?:wikia(?:-dev)?\.com|wowwiki\.com|wiki\.ffxiclopedia\.org|memory-alpha\.org|websitewiki\.de|yoyowiki\.org|marveldatabase\.com|www\.jedipedia\.de)$/);
        return Liftium.e(b) ? Liftium.wikiaTrack({
            eventName: "liftium.varia",
            ga_category: "varia/cookie_domain",
            ga_action: a,
            trackingMethod: "ad"
        }) : a = b[0], Liftium.d("cookie domain is " + a, 7), a;
    }, Liftium.getPageVar = function(a, b) {
        return LiftiumOptions["kv_" + a] || b || "";
    }, Liftium.getStyle = function(a, b) {
        var c = b.replace(/\-(\w)/g, function(a, b) {
            return b.toUpperCase();
        });
        return a.currentStyle ? a.currentStyle[c] || "" : document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(a, "")[c] || "" : a.style[c] || "";
    }, Liftium.getAlwaysFillAd = function(a, b) {
        if (Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)) return Liftium.d("Error, config is empty in getAlwaysFillAd(" + a + ", " + b + ")", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/no_config",
            ga_action: "getAlwaysFillAd",
            ga_label: a + "/" + b,
            trackingMethod: "ad"
        }), !1;
        for (var c = 0, d = Liftium.config.sizes[a].length; d > c; c++) {
            var e = Liftium.config.sizes[a][c];
            if (1 == e.always_fill && Liftium.isValidCriteria(e, b)) return Liftium.clone(e);
        }
        return !1;
    }, Liftium.getCountry = function() {
        if (!Liftium.e(Liftium.getCountryFound)) return Liftium.getCountryFound;
        var a, b = Liftium.geo || window.Geo;
        if (Liftium.e(Liftium.getRequestVal("liftium_country"))) {
            if (Liftium.e(b) || Liftium.e(b.country)) return Liftium.d("Unable to find a country for this IP, defaulting to unknown"), 
            "unknown";
            a = b.country.toLowerCase();
        } else a = Liftium.getRequestVal("liftium_country"), Liftium.d("Using liftium_country for geo targeting (" + a + ")", 8);
        return "gb" === a && (a = "uk"), Liftium.getCountryFound = a, a;
    }, Liftium.getBrowserLang = function() {
        var a = window.navigator, b = a.language || a.systemLanguage || a.browserLanguage || a.userLanguage || "";
        return b.substring(0, 2);
    }, Liftium.getIframeUrl = function(a, b) {
        var c, d = b.tag ? b.tag.match(/<iframe[\s\S]+src="([^"]+)"/) : null;
        if (null !== d) c = d[1].replace(/&amp;/g, "&"), Liftium.d("Found iframe in tag, using " + c + " for " + a, 3); else if ("No Ad" == b.network_name) Liftium.d("Using about:blank for 'No Ad' to avoid iframe in " + a, 3), 
        c = "about:blank"; else if ("DART" == b.network_name) c = window.LiftiumDART.getUrl(Liftium.slotPlacements[a], b.size, b.network_options, !0); else {
            var e = {
                tag_id: b.tag_id,
                size: b.size,
                slotname: a,
                placement: Liftium.slotPlacements[a]
            };
            c = Liftium.baseUrl + "tag/?" + Liftium.buildQueryString(e), Liftium.d("No iframe found in tag, using " + c + " for " + a, 4);
        }
        return c;
    }, Liftium.getMinutesSinceMidnight = function() {
        var a = new Date();
        return 60 * a.getHours() + a.getMinutes();
    }, Liftium.getMinutesSinceReject = function(a) {
        var b = Liftium.getTagStat(a, "m");
        return null === b ? null : Liftium.getMinutesSinceMidnight() - b;
    }, Liftium.getNextTag = function(a) {
        if (Liftium.e(Liftium.chain[a]) && Liftium.buildChain(a) === !1) return Liftium.reportError("Error building chain " + a, "chain"), 
        !1;
        if (Liftium.slotHops[a] = Liftium.slotHops[a] || 0, Liftium.slotHops[a]++, Liftium.slotHops[a] > 10) return Liftium.reportError("Maximum number of hops exceeded: 10", "chain"), 
        !1;
        var b = new Date(), c = Liftium.chain[a].length, d = Liftium.currents[a] || 0, e = b.getTime() - Liftium.slotTimer[a];
        if (e > Liftium.maxHopTime) {
            Liftium.d("Liftium.maxHopTime=" + Liftium.maxHopTime, 5), Liftium.d("Hop Time of " + Liftium.maxHopTime + " exceeded, it's " + e + " now. Using the always_fill for " + a, 2);
            var f = e / 1e3;
            Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/hop_timeout",
                ga_action: "slot " + a + ", net " + Liftium.chain[a][d].network_id + ", tag " + Liftium.chain[a][d].tag_id,
                ga_label: f.toFixed(1),
                trackingMethod: "ad"
            }), Liftium.slotTimeouts++;
            var g = c - 1;
            return Liftium.currents[a] = g, Liftium.chain[a][g].started = b.getTime(), Liftium.chain[a][g];
        }
        for (var h = d, i = c; i > h; h++) if (Liftium.e(Liftium.chain[a][h].started)) return Liftium.chain[a][h].started = b.getTime(), 
        Liftium.currents[a] = h, Liftium.chain[a][h];
        return Liftium.reportError("No more tags left in the chain - " + a + " Last ad in the chain marked as always fill but actually hopped? :" + Liftium.print_r(Liftium.chain[a][Liftium.chain[a].length - 1]), "chain"), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/last_hopped",
            ga_action: a,
            trackingMethod: "ad"
        }), Liftium.fillerAd(a, "No more tags left in the chain");
    }, Liftium.getPagesSinceSearch = function() {
        var a = Liftium.getReferringKeywords();
        if (Liftium.e(a)) return null;
        var b = Liftium.cookie("Lps");
        return Liftium.e(b) ? b = 1 : b++, Liftium.cookie("Lps", b), null;
    }, Liftium.getPropertyCount = function(a) {
        if ("object" != typeof a || null === a) return 0;
        if (Object.keys) return Object.keys(a).length;
        var b = 0;
        for (var c in a) a.hasOwnProperty(c) && b++;
        return b;
    }, Liftium.getReferrer = function() {
        return LiftiumOptions.referrer || document.referrer;
    }, Liftium.getReferringKeywords = function() {
        var a, b = Liftium.getReferrer(), c = b.match(/\?(.*)$/);
        c = Liftium.e(c) ? [] : c[1];
        for (var d = [ "q", "p", "query" ], e = 0; e < d.length && (a = Liftium.getRequestVal(d[e], "", c), 
        Liftium.e(a)); e++) ;
        var f = Liftium.cookie("Lrk");
        return Liftium.e(a) ? Liftium.e(f) ? null : f : (Liftium.cookie("Lrk", a), a);
    }, Liftium.getRequestVal = function(a, b, c) {
        if (!c && self != top) {
            var d = /\?(.+)$/.exec(document.referrer);
            d && (c = d[1]);
        }
        var e = Liftium.parseQueryString(c || window.location.search);
        return "undefined" != typeof e[a] ? e[a] : "undefined" != typeof b ? b : "";
    }, Liftium.getSampledAd = function(a) {
        if (Liftium.e(Liftium.config) || Liftium.e(Liftium.config.sizes)) return Liftium.d("Error, config is empty in getSampledAd(" + a + ")", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/no_config",
            ga_action: "getSampledAd",
            ga_label: a,
            trackingMethod: "ad"
        }), !1;
        for (var b = [], c = 0, d = 100 * Math.random(), e = 0, f = Liftium.config.sizes[a].length; f > e; e++) {
            var g = parseFloat(Liftium.config.sizes[a][e].sample_rate);
            Liftium.e(g) || (c += g, Liftium.d("Sample Rate for " + Liftium.config.sizes[a][e].tag_id + " is " + g, 7), 
            b.push({
                upper_bound: c,
                index: e
            }));
        }
        Liftium.d("Sample Array = ", 7, b);
        for (var h = 0, i = b.length; i > h; h++) if (d < b[h].upper_bound) {
            var j = b[h].index;
            return Liftium.clone(Liftium.config.sizes[a][j]);
        }
        return !1;
    }, Liftium.getSlotnameFromElement = function(a) {
        if ("object" != typeof a) return !1;
        for (var b = a, c = 0; b && 10 > c; ) {
            if (b.id && b.id.match(/^Liftium_/)) return b.id;
            b = b.parentNode, c++;
        }
        return !1;
    }, Liftium.getStatRegExp = function(a) {
        return new RegExp(Liftium.now.getDay() + "_" + a + "l([0-9]+)r*([0-9]*)m*([0-9]*)");
    }, Liftium.getSizeForSlotname = function(a) {
        var b = Liftium.config.sizes;
        if (b[a]) return a;
        for (var c in b) if (b.hasOwnProperty(c)) for (var d = 0; d < b[c].length; d++) {
            var e = b[c][d].criteria && b[c][d].criteria.placement;
            if (e && e.indexOf(a) > -1) return c;
        }
        return !1;
    }, Liftium.getTagStat = function(a, b) {
        var c = null;
        Liftium.e(Liftium.tagStats) && (Liftium.tagStats = Liftium.getRequestVal("liftium_tag_stats", null) || Liftium.cookie("LTS") || "");
        var d = Liftium.tagStats.match(Liftium.getStatRegExp(a));
        if (!Liftium.e(d)) {
            var e = d.length;
            if ("l" === b && e >= 2) c = d[1]; else if ("r" === b && e >= 3) c = d[2]; else if ("m" === b && e >= 4) c = d[3]; else if ("a" === b) {
                var f = parseInt(d[1], 0) || 0, g = parseInt(d[2], 0) || 0;
                c = f + g;
            }
        }
        return c = Liftium.e(c) ? "m" == b ? null : 0 : parseInt(c, 10), Liftium.d("Stats for " + a + " type " + b + " = " + c, 9), 
        c;
    }, Liftium.getUniqueSlotname = function(a) {
        var b = "Liftium_" + a + "_" + Liftium.getPropertyCount(Liftium.slotnames);
        return Liftium.slotnames[b] = a, b;
    }, Liftium.handleNetworkOptions = function(a) {
        switch (a.network_id) {
          case "1":
            for (var b in LiftiumOptions) b.match(/^google_/) && (Liftium.d(b + " set to " + LiftiumOptions[b], 5), 
            window[b] = LiftiumOptions[b]);
            return !0;

          default:
            return !0;
        }
    }, Liftium.hop = function(a) {
        return Liftium.e(a) && (a = Liftium.lastSlot), Liftium.d("Liftium.hop() called for " + a), 
        Liftium.markLastAdAsRejected(a), Liftium._callAd(a);
    }, window.LiftiumHop = Liftium.hop, Liftium.standaloneHop = function() {
        for (var a in Liftium.chain) {
            Liftium.d("Liftium.standaloneHop() called for" + a, 4), Liftium.markLastAdAsRejected(a), 
            Liftium._callAd(a, !0);
            break;
        }
    }, Liftium.iframeHop = function(a) {
        if (Liftium.d("Liftium.iframeHop() called with " + a, 3), Liftium.in_array(a, Liftium.hopRegister)) return Liftium.d("Hop from " + a + " already registered. Bailing out.", 1), 
        Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/last_hopped_2",
            ga_action: "last_hopped_2",
            trackingMethod: "ad"
        }), void Liftium.reportError("Hop from " + a + " already registered.");
        if (Liftium.hopRegister.push(a), LiftiumOptions.standalone && a == window.location.href) return void Liftium.standaloneHop();
        for (var b, c = document.getElementsByTagName("iframe"), d = !1, e = [], f = 0, g = c.length; g > f; f++) {
            var h = Math.random();
            c[f].id ? h = c[f].id : c[f].id = h;
            var i = Liftium._(h);
            if (Liftium.e(i.src)) Liftium.d("myframe.src for #" + f + " (" + h + ") is empty, skipping", 7); else {
                if (a.indexOf(i.src) >= 0) {
                    if (d = !0, Liftium.d("found iframe match, #" + f + " (" + h + ")", 5), b = Liftium.getSlotnameFromElement(i), 
                    Liftium.e(b)) return void Liftium.reportError("Unable to determine slotname from iframe " + a);
                    break;
                }
                e.push(i.src);
            }
        }
        return d ? (Liftium.d("Slotname is " + b + " in iframeHop", 3), Liftium.markLastAdAsRejected(b), 
        void Liftium._callAd(b, !0)) : void Liftium.reportError("Unable to find iframe for " + a + "in : " + e.join(", "));
    }, Liftium.iframeContents = function(a, b) {
        if ("object" != typeof a) return !1;
        if (a.doc || (a.contentDocument ? a.doc = a.contentDocument : a.contentWindow ? a.doc = a.contentWindow.document : a.document && (a.doc = a.document), 
        a.doc.open(), a.doc.close()), "undefined" != typeof b) {
            a.doc.body.style.backgroundColor = "blue";
            var c = a.doc.createElement("div");
            return c.id = "div42", c.innerHTML = b, a.doc.body.appendChild(c), !0;
        }
        return a.doc.getElementById("div42").innerHTML;
    }, Liftium.in_array = function(a, b, c) {
        for (var d in b) {
            if (b[d] == a) return !0;
            if (c && b[d].toString().toLowerCase() == a.toString().toLowerCase()) return !0;
        }
        return !1;
    }, Liftium.init = function(a) {
        if (window.Wikia && window.Wikia.AbTest && window.Wikia.AbTest.inGroup("LIFTIUM_DR", "LIFTIUM_DISABLED")) return void Liftium.d("(Fake) AB experiment LIFTIUM_DR, group LIFTIUM_DISABLED", 1);
        if (Liftium.e(LiftiumOptions.pubid)) return !1;
        Liftium.wikiaTrack({
            eventName: "liftium.init",
            ga_category: "init/init",
            ga_action: "init",
            ga_label: "liftium",
            trackingMethod: "ad"
        });
        var b = function() {
            "function" == typeof a && a(), window.AdEngine_loadLateAds && (Liftium.d("AdEngine_run_later", 1), 
            window.AdEngine_loadLateAds());
        };
        return Liftium.pullGeo(), LiftiumOptions.loadConfig !== !1 && Liftium.pullConfig(b), 
        LiftiumOptions.enableXDM !== !1 && XDM.listenForMessages(Liftium.crossDomainMessage), 
        "Opera" == BrowserDetect.browser && (Liftium.iframeOnload = function(a) {
            var b = a.target || a;
            try {
                "undefined" == typeof b.readyState && (b.readyState = "complete");
            } catch (c) {}
        }, Liftium.addEventListener(window, "DOMFrameContentLoaded", Liftium.iframeOnload)), 
        Liftium.getRequestVal("liftium_exclude_tag") && (LiftiumOptions.exclude_tags = [ Liftium.getRequestVal("liftium_exclude_tag") ]), 
        Liftium.trackQcseg(), !0;
    }, Liftium.iframesLoaded = function() {
        function a() {
            return Liftium.loadDelay < 1e3 * Liftium.getPropertyCount(Liftium.slotnames) ? !1 : !0;
        }
        if (Liftium.isCalledAfterOnload && Liftium.hasMoreCalls) return !1;
        if (!document.readyState) return a();
        var b = document.getElementsByTagName("iframe"), c = b.length;
        if (0 === c) return !0;
        for (var d = 0; c > d; d++) try {
            if (!b[d].contentDocument || !b[d].contentDocument.readyState) return a();
            if ("complete" != b[d].contentDocument.readyState) return !1;
        } catch (e) {
            break;
        }
        return "complete" == document.readyState;
    }, Liftium.isValidBrowser = function(a) {
        var b = BrowserDetect.OS + " " + BrowserDetect.browser + " " + BrowserDetect.version, c = new RegExp(a, "i");
        return b.match(c) ? !0 : !1;
    }, Liftium.isNetworkInChain = function(a, b) {
        for (var c = !1, d = 0; d < Liftium.chain[b].length; d++) if (Liftium.chain[b][d].network_name == a) {
            c = !0;
            break;
        }
        return c;
    }, Liftium.isHighValueCountry = window.AdLogicHighValueCountry && AdLogicHighValueCountry(window).isHighValueCountry || function() {}, 
    Liftium.isValidCountry = function(a) {
        var b = Liftium.getCountry();
        return Liftium.d("Checking if '" + b + "' is in:", 8, a), Liftium.in_array("row", a, !0) && !Liftium.isHighValueCountry(b) ? (Liftium.d("ROW targetted, and country not high-value", 8), 
        !0) : Liftium.in_array(b, a, !0) ? !0 : !1;
    }, Liftium.isValidCriteria = function(a, b) {
        var c = "Ad #" + a.tag_id + " from " + a.network_name + " invalid for " + b + ": ";
        if (!Liftium.e(a.inChain) && !Liftium.e(a.freq_cap)) return Liftium.d(c + "it has a freq cap and is already in another chain", 3), 
        !1;
        if (!Liftium.e(LiftiumOptions.exclude_tags) && Liftium.in_array(a.tag_id, LiftiumOptions.exclude_tags)) return Liftium.d(c + "in LiftiumOptions excluded tags list", 2), 
        !1;
        if (!Liftium.e(a.freq_cap)) {
            var d = Liftium.getTagStat(a.tag_id, "a");
            if (d >= parseInt(a.freq_cap, 10)) return Liftium.d(c + d + "attempts is >= freq_cap of " + a.freq_cap, 5), 
            !1;
        }
        if (!Liftium.e(a.rej_time)) {
            var e = Liftium.getMinutesSinceReject(a.tag_id);
            if (null !== e && (Liftium.d(" rej_time = " + a.rej_time + " elapsed = " + e, 8), 
            e < parseInt(a.rej_time, 10))) return Liftium.d(c + "tag was rejected sooner than rej_time of " + a.rej_time, 5), 
            !1;
        }
        if (!Liftium.e(a.criteria)) for (var f in a.criteria) switch (f) {
          case "country":
            if (!Liftium.isValidCountry(a.criteria.country)) return Liftium.d(c + "Invalid country", 6), 
            !1;
            break;

          case "browser":
            if (!Liftium.isValidBrowser(a.criteria.browser[0])) return Liftium.d(c + "Invalid browser", 6), 
            !1;
            break;

          case "domain":
            if (LiftiumOptions.domain = LiftiumOptions.domain || document.domain, a.criteria.domain[0] != LiftiumOptions.domain) return Liftium.d(c + "Invalid domain", 6), 
            !1;
            break;

          case "placement":
            if (!Liftium.in_array(Liftium.slotPlacements[b], a.criteria.placement)) return Liftium.d(c + "Invalid placement (" + Liftium.slotPlacements[b] + ")", 6, a.criteria.placement), 
            !1;
            break;

          default:
            if (f.match(/^kv_/) && !Liftium.in_array(LiftiumOptions[f], a.criteria[f])) return Liftium.d(c + "key value " + f + " does not match: " + a.criteria[f], 6), 
            !1;
        }
        if (!Liftium.e(a.pacing) && !Liftium.isValidPacing(a)) return Liftium.d(c + " - pacing criteria not met (" + a.pacing + ")", 5), 
        !1;
        var g = /(LiftiumDART|AdConfig|AdEngine)/.exec(a.tag);
        return g && Liftium.getRequestVal("liftium_skip_wikia") ? (Liftium.d(c + " - wikia-specific code(" + g[0] + ")", 5), 
        !1) : (Liftium.d("Targeting criteria passed for tag #" + a.tag_id, 6), !0);
    }, Liftium.isValidPacing = function(a) {
        return 100 * Math.random() < a.pacing;
    }, Liftium.loadScript = function(a, b, c) {
        if (Liftium.d("Loading script from " + a + " (not blocking: " + (Liftium.e(b) ? "false" : "true") + ", with callback: " + (Liftium.e(c) ? "false" : "true") + ")", 5), 
        "undefined" == typeof b) return Liftium.d("Using document.write", 5), document.write('<script type="text/javascript" src="' + a + '"></script>'), 
        !0;
        if ("undefined" != typeof jQuery && c) return Liftium.d("Using $.getScript", 5), 
        $.getScript(a, c), !0;
        Liftium.d("Using document.createElement(script)", 5);
        var d = document.getElementsByTagName("head").item(0), e = document.createElement("script");
        return e.src = a, d.appendChild(e), e;
    }, Liftium.markChain = function(a) {
        if (Liftium.d("Marking chain for " + a, 5), Liftium.e(Liftium.chain[a])) return Liftium.debug("Skipping marking chain for " + a + ", chain was empty"), 
        !1;
        for (var b = 0, c = Liftium.chain[a].length; c > b; b++) if (b < Liftium.currents[a] && Liftium.chain[a][b].started) Liftium.chain[a][b].rejected = !0; else if (b == Liftium.currents[a]) {
            Liftium.chain[a][b].loaded = !0;
            break;
        }
        return b;
    }, Liftium.markLastAdAsRejected = function(a) {
        var b = Liftium.currents[a];
        if ("undefined" == typeof b) return Liftium.d("No chain for " + a + " found. Bailing out.", 1), 
        void Liftium.wikiaTrack({
            eventName: "liftium.errors",
            ga_category: "errors/no_chain",
            ga_action: a,
            trackingMethod: "ad"
        });
        var c = Liftium.chain[a][b].tag_id;
        Liftium.d("Marking last ad as rejected for " + a + " (#" + c + ")", 3), Liftium.chain[a][b].rejected = !0, 
        Liftium.setTagStat(c, "r");
        var d = Liftium.debugTime() - Liftium.slotTimer2[a + "-" + c];
        Liftium.d("slotTimer2 end for #" + c + " in " + a + " after " + d + " ms", 3);
        var e = Liftium.chain[a][b].network_id;
        Liftium.wikiaTrack({
            eventName: "liftium.hop",
            ga_category: "hop/net " + e,
            ga_action: "tag " + c,
            ga_label: Liftium.formatTrackTime(d, 5),
            trackingMethod: "ad"
        });
    }, Liftium.normalizeColor = function(a) {
        if (a = a || "", "transparent" == a) return "";
        if (a.match(/^#[A-F0-9a-f]{6}/)) return a.toUpperCase().replace(/^#/, "");
        if (a.match(/^#[A-F0-9a-f]{3}$/)) {
            var b = a.substring(1, 1), c = a.substring(2, 1), d = a.substring(3, 1), e = b + b + c + c + d + d;
            return e.toUpperCase();
        }
        if (a.match(/^rgb/)) {
            var f = a.replace(/[^0-9,]/g, ""), g = f.split(",");
            return Liftium.dec2hex(g[0]) + Liftium.dec2hex(g[1]) + Liftium.dec2hex(g[2]);
        }
        return a.replace(/"/g, "");
    }, Liftium.onLoadHandler = function() {
        if (window.Wikia && window.Wikia.AbTest && window.Wikia.AbTest.inGroup("LIFTIUM_DR", "LIFTIUM_DISABLED")) return void Liftium.d("(Fake) AB experiment LIFTIUM_DR, group LIFTIUM_DISABLED", 1);
        if (Liftium.pageLoaded = !0, !Liftium.e(Liftium.config) && Liftium.iframesLoaded()) Liftium.sendBeacon(); else if (Liftium.loadDelay < Liftium.maxLoadDelay) Liftium.loadDelay += Liftium.loadDelay, 
        window.setTimeout(Liftium.onLoadHandler, Liftium.loadDelay); else {
            var a = Liftium.e(Liftium.config) ? "no config" : "config loaded";
            Liftium.d("Gave up waiting for ads to load (" + a + "), sending beacon now", 1), 
            Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/gave_up_waiting_for_ads",
                ga_action: a,
                trackingMethod: "ad"
            }), Liftium.sendBeacon();
        }
    }, Liftium.parseQueryString = function(a) {
        var b = [];
        if ("string" != typeof a || "" === a) return b;
        "?" === a.charAt(0) && (a = a.substr(1)), a = a.replace(/\;/g, "&", a), a = a.replace(/\+/g, "%20", a);
        for (var c, d = a.split("&"), e = 0; e < d.length; e++) if (0 !== d[e].length) {
            var f = "", g = "";
            if (-1 != (c = d[e].indexOf("="))) try {
                f = decodeURIComponent(d[e].substr(0, c)), g = decodeURIComponent(d[e].substr(c + 1));
            } catch (h) {
                f = unescape(d[e].substr(0, c)), g = unescape(d[e].substr(c + 1));
            } else f = d[e], g = !0;
            b[f] = g;
        }
        return b;
    }, Liftium.pullConfig = function(a) {
        if (!Liftium.config) {
            if (LiftiumOptions.config) return void (Liftium.config = LiftiumOptions.config);
            var b = {
                pubid: LiftiumOptions.pubid,
                v: 1.2,
                country: Liftium.getCountry()
            };
            Liftium.e(LiftiumOptions.config_delay) || (b.config_delay = LiftiumOptions.config_delay, 
            b.cb = Math.random()), window.location.hostname.indexOf(".dev.liftium.com") > -1 && (Liftium.baseUrl = "/");
            var c = Liftium.baseUrl + "config?" + Liftium.buildQueryString(b);
            Liftium.d("Loading config from " + c, 2), a ? Liftium.loadScript(c, !0, a) : Liftium.loadScript(c);
        }
    }, Liftium.pullGeo = function() {
        if (!Liftium.geo) {
            Liftium.d("Loading geo data from cookie", 3);
            var a = decodeURIComponent(Liftium.cookie("Geo"));
            if (!Liftium.e(a)) {
                try {
                    Liftium.geo = JSON.parse(a) || {};
                } catch (b) {
                    Liftium.geo = {};
                }
                return void Liftium.d("Geo data loaded:", 7, Liftium.geo);
            }
            Liftium.d("Loading geo data from " + Liftium.geoUrl, 3), Liftium.loadScript(Liftium.geoUrl);
        }
    }, Liftium.print_r = function(a) {
        return "string" == typeof a ? a : window.JSON && JSON.stringify(a) || "";
    }, Liftium.recordEvents = function(a) {
        for (var b = "", c = 0, d = Liftium.chain[a].length; d > c; c++) {
            var e = Liftium.chain[a][c];
            if (!Liftium.e(e.started)) {
                var f = Liftium.getTagStat(e.tag_id, "l");
                if (Liftium.e(Liftium.chain[a][c].loaded)) {
                    if (!Liftium.e(e.rejected)) {
                        b += ",r" + e.tag_id + "pl" + f, Liftium.d("Recording Reject for " + e.network_name + ", #" + e.tag_id + " in " + a, 5);
                        continue;
                    }
                } else Liftium.d("Recording Load for " + e.network_name + ", #" + e.tag_id + " in " + a, 4), 
                Liftium.setTagStat(e.tag_id, "l"), b += ",l" + e.tag_id + "pl" + f;
            }
        }
        return b.replace(/^,/, "");
    }, Liftium.reportError = function(a, b) {
        try {
            if (Liftium.d("Liftium ERROR: " + a), "undefined" != typeof Liftium.errorCount ? Liftium.errorCount++ : Liftium.errorCount = 1, 
            Liftium.errorCount > 5) return;
            for (var c = [ "Error loading script", "Script error.", "GA_googleFillSlot is not defined", "translate.google", "COMSCORE", "quantserve", "urchin", "greasemonkey", "Permission denied", "Unexpected token ILLEGAL", "Access is denied" ], d = 0; d < c.length; d++) if (a.indexOf(c[d]) >= 0) return;
            if ("onerror" == b) Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/js",
                ga_action: a,
                trackingMethod: "ad"
            }); else {
                var e = {
                    msg: a.substr(0, 512),
                    type: b || "general",
                    pubid: LiftiumOptions.pubid,
                    lang: "en"
                };
                "tag" == b && (e.tag_id = Liftium.lastTag.tag_id), Liftium.beaconCall(Liftium.baseUrl + "error?" + Liftium.buildQueryString(e));
            }
        } catch (f) {
            Liftium.d("Yikes. Liftium.reportError has an error"), Liftium.wikiaTrack({
                eventName: "liftium.errors",
                ga_category: "errors/reportError",
                ga_action: "reportError",
                trackingMethod: "ad"
            });
        }
    }, Liftium.errorMessage = function(a) {
        return "object" == typeof a ? Liftium.print_r(a) : a;
    }, Liftium.sendBeacon = function() {
        if (!Liftium.e(Liftium.beacon)) return !0;
        var a;
        if (Liftium.e(Liftium.config) || void 0 === a || null === a ? (Liftium.d("No throttle defined, using 1.0", 5), 
        a = 1) : a = Liftium.config.throttle, Math.random() > a) return Liftium.d("Beacon throttled at " + a), 
        !0;
        var b = "", c = 0;
        for (var d in Liftium.chain) "function" != typeof Liftium.chain[d] && (c++, Liftium.markChain(d), 
        b += "," + Liftium.recordEvents(d));
        b = b.replace(/^,/, ""), Liftium.storeTagStats();
        var e = {};
        e.numSlots = c, e.events = b, e.country = Liftium.getCountry(), Liftium.slotTimeouts > 0 && (e.slotTimeouts = Liftium.slotTimeouts), 
        Liftium.d("Beacon: ", 7, e);
        var f;
        return f = window.JSON ? {
            beacon: window.JSON.stringify(e)
        } : {
            events: e.events
        }, Liftium.beacon = f, Liftium.beaconCall(Liftium.baseUrl + "beacon?" + Liftium.buildQueryString(f)), 
        Liftium.d("Liftium done, beacon sent"), Liftium.wikiaTrack({
            eventName: "liftium.init",
            ga_category: "init/beacon",
            ga_action: "beacon",
            trackingMethod: "ad"
        }), window.LiftiumTest && "function" == typeof window.LiftiumTest.afterBeacon && window.LiftiumTest.afterBeacon(), 
        !0;
    }, Liftium.setAdjustedValues = function(a) {
        for (var b, c, d = .05, e = 0; e < a.length; e++) if (!a[e].adjusted_value) {
            c = a[e].value, "CPC" == a[e].pay_type && (d += .2), parseFloat(a[e].floor, 10) && (c = 1.01 * c), 
            "CPC" != a[e].pay_type || Liftium.e(Liftium.getReferringKeywords()) || (c = 1.25 * c, 
            d = 0), b = Liftium.getTagStat(a[e].tag_id, "a");
            for (var f = 0; b > f; f++) c -= c * d;
            a[e].adjusted_value = c < .15 * a[e].value ? .15 * a[e].value : c;
        }
        return a;
    }, Liftium.setPageVar = function(a, b) {
        LiftiumOptions["kv_" + a] = b;
    }, Liftium.setTagStat = function(a, b) {
        Liftium.d("Setting a " + b + " stat for " + a, 6);
        var c = Liftium.tagStats.split(",");
        c.length > Liftium.statMax && c.shift();
        var d = Liftium.getTagStat(a, "l"), e = Liftium.getTagStat(a, "r"), f = 0;
        "l" === b ? (d++, f = Liftium.getTagStat(a, "m") || 0) : "r" === b && (e++, f = Liftium.getMinutesSinceMidnight());
        var g = Liftium.now.getDay() + "_" + a + "l" + d;
        e > 0 && (g = g + "r" + e, g = g + "m" + f);
        var h = Liftium.tagStats.replace(Liftium.getStatRegExp(a), g);
        Liftium.tagStats = h === Liftium.tagStats ? Liftium.tagStats + "," + g : h, Liftium.tagStats = Liftium.tagStats.replace(/^,/, ""), 
        Liftium.d("Tag Stats After Set = " + Liftium.tagStats, 6), Liftium.storeTagStats();
    }, Liftium.storeTagStats = function() {
        Liftium.d("Stored Tag Stats = " + Liftium.tagStats, 6), Liftium.cookie("LTS", Liftium.tagStats, {
            domain: Liftium.getCookieDomain(),
            path: "/",
            expires: 864e5
        });
    }, Liftium.trackEvent = function(a, b) {
        "object" == typeof a && (a = a.join("/")), Liftium.d("Track event: " + a, 1);
        var c = window.navigator;
        Liftium.sessionid = Liftium.sessionid || Math.round(2147483647 * Math.random()), 
        a = "/" + LiftiumOptions.pubid + "/" + a;
        var d = "__utma=" + Liftium.cookie("__utma") + ";+__utmz=" + Liftium.cookie("__utmz") + ";", e = {
            utmwv: "4.6.5",
            utmn: Math.round(2147483647 * Math.random()),
            utmhn: "liftium.wikia.com",
            utmcs: "UTF-8",
            utmsr: "1024x768",
            utmsc: "24-bit",
            utmul: (c.language || c.systemLanguage || c.browserLanguage || c.userLanguage || "").toLowerCase(),
            utmje: "1",
            utmfl: "10.0 r32",
            utmdt: document.title,
            utmhid: Liftium.sessionid,
            utmr: "0",
            utmp: a,
            utmcc: d
        };
        "undefined" != typeof b ? (e.utmac = b, Liftium.d("Tracking is using custom profile: " + b, 7)) : e.utmac = "UA-17475676-10";
        var f = "https:" == window.location.protocol ? "https://ssl." : "http://www.";
        f += "google-analytics.com/__utm.gif?" + Liftium.buildQueryString(e), Liftium.beaconCall(f, !1), 
        Liftium.eventsTracked++;
    }, Liftium.buildTrackUrl = function(a) {
        return a.join("/") + "/" + [ Liftium.getPageVar("Hub", "unknown"), Liftium.langForTracking(Liftium.getPageVar("cont_lang", "unknown")), Liftium.dbnameForTracking(Liftium.getPageVar("wgDBname", "unknown")), Liftium.geoForTracking(Liftium.getCountry()) ].join("/");
    }, Liftium.langForTracking = function(a) {
        return Liftium.in_array(a, [ "en", "es", "de", "fr" ]) || (Liftium.d("Wiki lang " + a + " changed to 'other' for tracking", 7), 
        a = "other"), a;
    }, Liftium.dbnameForTracking = function(a) {
        return window.wgWikiFactoryTagIds && !Liftium.e(window.wgWikiFactoryTagIds) && window.wgWikiFactoryTagIds.length > 4 ? a : (Liftium.d("Wiki dbname " + a + " changed to 'other' for tracking", 7), 
        "other");
    }, Liftium.geoForTracking = function(a) {
        return Liftium.in_array(a, [ "unknown", "us", "uk", "ca" ]) || (Liftium.d("Country " + a + " changed to 'other' for tracking", 7), 
        a = "other"), a;
    }, Liftium.trackQcseg = function() {
        var a = Liftium.cookie("qcseg");
        if (Liftium.d("Quantcast cookie: " + a, 5), !Liftium.e(a) && (-1 == a.search(/"[DT]"/) || -1 != a.search(/"[0-9]{4}"/))) try {
            var b = JSON.parse(a);
            if (Liftium.d("Quantcast cookie parsed:", 7, b), Liftium.e(b.segments)) return;
            var c = !0;
            for (var d in b.segments) "object" == typeof b.segments[d] && (Liftium.e(b.segments[d]) || Liftium.e(b.segments[d].id) || (Liftium.d("Quantcast segment: " + b.segments[d].id, 5), 
            c = !1));
            if (c) return;
        } catch (e) {
            return void Liftium.d("Quantcast cookie parse error:", 7, e);
        }
    }, Liftium.throwError = function() {
        return window.LiftiumthrowError.UndefinedVar;
    };
    var BrowserDetect = {
        init: function() {
            this.browser = this.searchString(this.dataBrowser) || "", this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "", 
            this.OS = this.searchString(this.dataOS) || "";
        },
        searchString: function(a) {
            for (var b = 0, c = a.length; c > b; b++) {
                var d = a[b].string, e = a[b].prop;
                if (this.versionSearchString = a[b].versionSearch || a[b].identity, d) {
                    if (-1 != d.indexOf(a[b].subString)) return a[b].identity;
                } else if (e) return a[b].identity;
            }
            return null;
        },
        searchVersion: function(a) {
            var b = a.indexOf(this.versionSearchString);
            return -1 == b ? null : parseFloat(a.substring(b + this.versionSearchString.length + 1));
        },
        dataBrowser: [ {
            string: navigator.userAgent,
            subString: "Chrome",
            identity: "Chrome"
        }, {
            string: navigator.userAgent,
            subString: "OmniWeb",
            versionSearch: "OmniWeb/",
            identity: "OmniWeb"
        }, {
            string: navigator.vendor,
            subString: "Apple",
            identity: "Safari",
            versionSearch: "Version"
        }, {
            prop: window.opera,
            identity: "Opera"
        }, {
            string: navigator.vendor,
            subString: "iCab",
            identity: "iCab"
        }, {
            string: navigator.vendor,
            subString: "KDE",
            identity: "Konqueror"
        }, {
            string: navigator.userAgent,
            subString: "Firefox",
            identity: "Firefox"
        }, {
            string: navigator.vendor,
            subString: "Camino",
            identity: "Camino"
        }, {
            string: navigator.userAgent,
            subString: "Netscape",
            identity: "Netscape"
        }, {
            string: navigator.userAgent,
            subString: "MSIE",
            identity: "Explorer",
            versionSearch: "MSIE"
        }, {
            string: navigator.userAgent,
            subString: "Gecko",
            identity: "Mozilla",
            versionSearch: "rv"
        }, {
            string: navigator.userAgent,
            subString: "Mozilla",
            identity: "Netscape",
            versionSearch: "Mozilla"
        } ],
        dataOS: [ {
            string: navigator.platform,
            subString: "Win",
            identity: "Windows"
        }, {
            string: navigator.platform,
            subString: "Mac",
            identity: "Mac"
        }, {
            string: navigator.userAgent,
            subString: "iPhone",
            identity: "iPhone/iPod"
        }, {
            string: navigator.platform,
            subString: "Linux",
            identity: "Linux"
        } ]
    };
    BrowserDetect.init(), Liftium.loadInspector = function() {
        var a = Liftium._("LiftiumInspectorScript");
        if (Liftium.e(a)) {
            var b = Liftium.loadScript(Liftium.baseUrl + "js/Inspector.js?r=" + Math.random().toString().substring(2, 8), !0);
            b.id = "LiftiumInspectorScript";
        }
    };
    var XDM = {
        allowedMethods: [],
        debugOn: !1
    };
    XDM.send = function(a, b, c) {
        return XDM.debug("XDM.send called from " + document.location.hostname), "string" != typeof b ? (XDM.debug("Bad argument for XDM.send, 'method' is not a string, (" + typeof b + ")"), 
        !1) : ("undefined" == typeof c && (c = []), XDM._postMessage(a, b, c));
    }, XDM.getDestinationDomain = function(a) {
        if (a == top) {
            if ("" !== document.referrer.toString()) {
                var b = document.referrer.toString().match(/https*:\/\/([^\/]+)/);
                return XDM.debug("Hostname for destWin set to " + b[1] + " using referrer"), b[1];
            }
            return !1;
        }
        return a.location.hostname;
    }, XDM._postMessage = function(a, b, c) {
        XDM.debug("Sending message using postMessage()");
        var d = "*", e = XDM.serializeMessage(b, c);
        if (a.postMessage) return a.postMessage(e, d);
        if (a.document.postMessage) return a.document.postMessage(e, d);
        throw "No supported way of using postMessage";
    }, XDM.serializeMessage = function(a, b) {
        for (var c, d = "method=" + escape(a.toString()), e = 0; e < b.length; e++) c = e + 1, 
        d += ";arg" + c + "=" + escape(b[e]);
        return XDM.debug("Serialized message: " + d), d;
    }, XDM.debug = function(a) {
        XDM.debugOn && "undefined" != typeof console && "undefined" != typeof console.log && console.log("XDM debug: " + a);
    }, XDM.listenForMessages = function(a) {
        return window.addEventListener ? window.addEventListener("message", a, !1) : window.attachEvent ? window.attachEvent("onmessage", a) : void 0;
    }, XDM.isAllowedMethod = function(a) {
        if (!a) return !1;
        for (var b = !1, c = 0; c < XDM.allowedMethods.length; c++) if (a.toString() === XDM.allowedMethods[c]) {
            b = !0;
            break;
        }
        return b;
    }, XDM.executeMessage = function(serializedMessage) {
        var nvpairs = XDM.parseQueryString(serializedMessage);
        if (XDM.isAllowedMethod(nvpairs.method)) {
            var functionArgs = [], code = nvpairs.method;
            for (var prop in nvpairs) "arg" == prop.substring(0, 3) && functionArgs.push(nvpairs[prop].replace(/"/g, '\\"'));
            return code += functionArgs.length > 0 ? '("' + functionArgs.join('","') + '");' : "();", 
            XDM.debug("Evaluating " + code), eval(code);
        }
        return XDM.debug("Invalid method from XDM: " + nvpairs.method), !1;
    }, XDM.parseQueryString = function(a) {
        var b = [];
        if ("string" != typeof a) return b;
        "?" === a.charAt(0) && (a = a.substr(1)), a = a.replace(/\;/g, "&", a);
        for (var c, d = a.split("&"), e = 0; e < d.length; e++) if (0 !== d[e].length) {
            var f = "", g = "";
            -1 != (c = d[e].indexOf("=")) ? (f = decodeURIComponent(d[e].substr(0, c)), g = decodeURIComponent(d[e].substr(c + 1))) : (f = d[e], 
            g = !0), b[f] = g;
        }
        return b;
    }, Liftium.now = new Date(), window.wgNow && (Liftium.now = window.wgNow, Liftium.d("Using monaco time:", 7, window.wgNow)), 
    Liftium.startTime = Liftium.now.getTime(), Liftium.debugLevel = Liftium.getRequestVal("liftium_debug", 0) || Liftium.cookie("liftium_debug"), 
    Liftium.maxHopTime = Liftium.getRequestVal("liftium_timeout", 0) || Liftium.cookie("liftium_timeout") || 18e5, 
    LiftiumOptions.error_beacon = !Liftium.debugLevel && !Liftium.getRequestVal("liftium_onerror", 0) && !Liftium.cookie("liftium_onerror"), 
    LiftiumOptions.error_beacon !== !1 && !function() {
        var a = window.onerror;
        window.onerror = function(b, c, d) {
            return a && a(b, c, d), Liftium.catchError(b, c, d);
        };
    }();
}

Liftium.wikiaTrack = function() {
    window.Wikia && window.Wikia.Tracker && Wikia.Tracker.track.apply(arguments);
}, window.wgAdDriverStartLiftiumOnLoad ? Liftium.addEventListener(window, "load", Liftium.init) : Liftium.empty(LiftiumOptions.offline) && Liftium.init(), 
Liftium.addEventListener(window, "load", Liftium.onLoadHandler);

var LiftiumDART = {
    random: Math.round(23456787654 * Math.random()),
    sites: {
        Auto: "wka.auto",
        Creative: "wka.crea",
        Education: "wka.edu",
        Entertainment: "wka.ent",
        Finance: "wka.fin",
        Gaming: "wka.gaming",
        Green: "wka.green",
        Humor: "wka.humor",
        Lifestyle: "wka.life",
        Music: "wka.music",
        Philosophy: "wka.phil",
        Politics: "wka.poli",
        Science: "wka.sci",
        Sports: "wka.sports",
        Technology: "wka.tech",
        "Test Site": "wka.test",
        Toys: "wka.toys",
        Travel: "wka.travel"
    },
    slotconfig: {
        TOP_RIGHT_BOXAD: {
            tile: 1,
            loc: "top"
        },
        TOP_LEADERBOARD: {
            tile: 2,
            loc: "top",
            dcopt: "ist"
        },
        DOCKED_LEADERBOARD: {
            tile: 8,
            loc: "bottom"
        },
        LEFT_SKYSCRAPER_1: {
            tile: 3,
            loc: "top"
        },
        LEFT_SKYSCRAPER_2: {
            tile: 3,
            loc: "middle"
        },
        LEFT_SKYSCRAPER_3: {
            tile: 6,
            loc: "middle"
        },
        FOOTER_BOXAD: {
            tile: 5,
            loc: "footer"
        },
        PREFOOTER_LEFT_BOXAD: {
            tile: 5,
            loc: "footer"
        },
        PREFOOTER_RIGHT_BOXAD: {
            tile: 5,
            loc: "footer"
        },
        PREFOOTER_BIG: {
            tile: 5,
            loc: "footer"
        },
        HOME_TOP_RIGHT_BOXAD: {
            tile: 1,
            loc: "top"
        },
        HOME_TOP_LEADERBOARD: {
            tile: 2,
            loc: "top",
            dcopt: "ist"
        },
        HOME_LEFT_SKYSCRAPER_1: {
            tile: 3,
            loc: "top"
        },
        HOME_LEFT_SKYSCRAPER_2: {
            tile: 3,
            loc: "middle"
        },
        INCONTENT_BOXAD_1: {
            tile: 4,
            loc: "middle"
        },
        INCONTENT_BOXAD_2: {
            tile: 5,
            loc: "middle"
        },
        INCONTENT_BOXAD_3: {
            tile: 6,
            loc: "middle"
        },
        INCONTENT_BOXAD_4: {
            tile: 7,
            loc: "middle"
        },
        INCONTENT_BOXAD_5: {
            tile: 8,
            loc: "middle"
        },
        INCONTENT_LEADERBOARD_1: {
            tile: 4,
            loc: "middle"
        },
        INCONTENT_LEADERBOARD_2: {
            tile: 5,
            loc: "middle"
        },
        INCONTENT_LEADERBOARD_3: {
            tile: 6,
            loc: "middle"
        },
        INCONTENT_LEADERBOARD_4: {
            tile: 7,
            loc: "middle"
        },
        INCONTENT_LEADERBOARD_5: {
            tile: 8,
            loc: "middle"
        },
        EXIT_STITIAL_INVISIBLE: {
            tile: 1,
            loc: "exit",
            dcopt: "ist"
        },
        EXIT_STITIAL_BOXAD_1: {
            tile: 2,
            loc: "exit"
        },
        EXIT_STITIAL_BOXAD_2: {
            tile: 3,
            loc: "exit"
        },
        INVISIBLE_1: {
            tile: 10,
            loc: "invisible"
        },
        INVISIBLE_2: {
            tile: 11,
            loc: "invisible"
        },
        HOME_INVISIBLE_TOP: {
            tile: 12,
            loc: "invisible"
        },
        INVISIBLE_TOP: {
            tile: 13,
            loc: "invisible"
        },
        TEST_TOP_RIGHT_BOXAD: {
            tile: 1,
            loc: "top"
        },
        TEST_HOME_TOP_RIGHT_BOXAD: {
            tile: 1,
            loc: "top"
        }
    },
    sizeconfig: {
        "300x250": "300x250",
        "600x250": "600x250,300x250",
        "728x90": "728x90,468x60",
        "160x600": "160x600,120x600",
        "0x0": "1x1"
    }
};

LiftiumDART.callAd = function(a, b, c) {
    Liftium.e(LiftiumDART.slotconfig[a]) && Liftium.d("Notice: LiftiumDART not configured for " + a);
    var d = LiftiumDART.getUrl(a, b, c, !1);
    return '<script type="text/javascript" src="' + d + '"></script>';
}, LiftiumDART.getUrl = function(a, b, c, d) {
    if (window.AdConfig) return window.AdConfig.DART.getUrl(a, b, !0, "Liftium");
    LiftiumDART.sizeconfig[b] && (b = LiftiumDART.sizeconfig[b]);
    var e = "http://ad.doubleclick.net/" + LiftiumDART.getAdType(d) + "/" + LiftiumDART.getDARTSite(Liftium.getPageVar("Hub")) + "/" + LiftiumDART.getZone1(Liftium.getPageVar("wgDBname")) + "/" + LiftiumDART.getZone2() + ";" + LiftiumDART.getAllDartKeyvalues(a) + LiftiumDART.getTitle() + LiftiumDART.getDcoptKV(a) + "sz=" + b + ";" + LiftiumDART.getTileKV(a) + "mtfIFPath=/extensions/wikia/AdEngine/;ord=" + LiftiumDART.random;
    return Liftium.d("Dart URL = " + e, 4), e;
}, LiftiumDART.getSubdomain = function() {
    var a = "ad";
    if (!Liftium.e(Liftium.geo.continent)) switch (Liftium.geo.continent) {
      case "AF":
      case "EU":
        a = "ad-emea";
        break;

      case "AS":
        switch (Liftium.d("country: " + Liftium.getCountry().toUpperCase(), 4), Liftium.getCountry().toUpperCase()) {
          case "AE":
          case "CY":
          case "BH":
          case "IL":
          case "IQ":
          case "IR":
          case "JO":
          case "KW":
          case "LB":
          case "OM":
          case "PS":
          case "QA":
          case "SA":
          case "SY":
          case "TR":
          case "YE":
            a = "ad-emea";
            break;

          default:
            a = "ad-apac";
        }
        break;

      case "OC":
        a = "ad-apac";
        break;

      case "NA":
        break;

      case "SA":
        break;

      default:
        a = "ad";
    }
    return a;
}, LiftiumDART.getAdType = function(a) {
    return a ? "adi" : "adj";
}, LiftiumDART.getDARTSite = function(a) {
    return "undefined" != typeof LiftiumDART.sites[a] ? LiftiumDART.sites[a] : "wka.wikia";
}, LiftiumDART.getZone1 = function(a) {
    return Liftium.e(a) ? "_wikia" : "_" + a.replace("/[^0-9A-Z_a-z]/", "_");
}, LiftiumDART.getZone2 = function() {
    return Liftium.e(Liftium.getPageVar("page_type")) ? "article" : Liftium.getPageVar("page_type");
}, LiftiumDART.getTileKV = function(a) {
    return !Liftium.e(LiftiumDART.slotconfig[a]) && LiftiumDART.slotconfig[a].tile ? "tile=" + LiftiumDART.slotconfig[a].tile + ";" : "";
}, LiftiumDART.getDcoptKV = function(a) {
    return !Liftium.e(LiftiumDART.slotconfig[a]) && LiftiumDART.slotconfig[a].dcopt ? "dcopt=" + LiftiumDART.slotconfig[a].dcopt + ";" : "";
}, LiftiumDART.getLocKv = function(a) {
    return !Liftium.e(LiftiumDART.slotconfig[a]) && LiftiumDART.slotconfig[a].loc ? "loc=" + LiftiumDART.slotconfig[a].loc + ";" : "";
}, LiftiumDART.getArticleKV = function() {
    return Liftium.e(Liftium.getPageVar("article_id")) ? "" : "artid=" + Liftium.getPageVar("article_id") + ";";
}, LiftiumDART.getTitle = function() {
    return window.wgPageName ? "wpage=" + window.wgPageName + ";" : "";
}, LiftiumDART.getDomainKV = function(a) {
    var b, c, d, e = "";
    return b = a.toLowerCase(), c = b.split("."), d = c.length, e = "co" == c[d - 2] ? c[d - 3] + "." + c[d - 2] + "." + c[d - 1] : c[d - 2] + "." + c[d - 1], 
    "" !== e ? "dmn=" + e.replace(/\./g, "") + ";" : "";
}, LiftiumDART.getQuantcastSegmentKV = function() {
    var COOKIE_NAME = "qcseg", kv = "";
    if (window.wgIntegrateQuantcastSegments || !window.wgIntegrateQuantcastSegments) return kv;
    if (!Liftium.e(Liftium.cookie(COOKIE_NAME))) try {
        var qc = eval("(" + Liftium.cookie(COOKIE_NAME) + ")");
        if (!Liftium.e(qc) && !Liftium.e(qc.segments)) for (var i in qc.segments) kv += "qcseg=" + qc.segments[i].id + ";";
    } catch (e) {}
    return kv;
}, LiftiumDART.getImpressionCount = function(slotname) {
    if (Liftium.e(Liftium.adDriverNumCall)) {
        Liftium.d("Loading AdDriver data from cookie");
        var cookie = Liftium.cookie("adDriverNumAllCall");
        Liftium.e(cookie) || (Liftium.adDriverNumCall = eval("(" + cookie + ")"), Liftium.d("AdDriver data loaded:", 7, Liftium.AdDriverNumCall));
    }
    if (!Liftium.e(Liftium.adDriverNumCall)) for (var i = 0; i < Liftium.adDriverNumCall.length; i++) if (Liftium.adDriverNumCall[i].slotname == slotname && parseInt(Liftium.adDriverNumCall[i].ts, 10) + 36e5 * window.wgAdDriverCookieLifetime > Liftium.now.getTime()) {
        var num = parseInt(Liftium.adDriverNumCall[i].num, 10);
        return "impct=" + num + ";";
    }
    return "";
}, LiftiumDART.getResolution = function() {
    return (Liftium.e(LiftiumDART.width) || Liftium.e(LiftiumDART.height)) && (LiftiumDART.width = document.documentElement.clientWidth || document.body.clientWidth, 
    LiftiumDART.height = document.documentElement.clientHeight || document.body.clientHeight, 
    Liftium.d("resolution: " + LiftiumDART.width + "x" + LiftiumDART.height, 7)), LiftiumDART.width > 1024 ? "dis=large;" : "";
}, LiftiumDART.getMinuteTargeting = function() {
    return new Date().getMinutes() % 15;
}, LiftiumDART.getAllDartKeyvalues = function(a) {
    var b = "s0=" + LiftiumDART.getDARTSite(Liftium.getPageVar("Hub")).replace(/wka\./, "") + ";s1=" + LiftiumDART.getZone1(Liftium.getPageVar("wgDBname")) + ";s2=" + LiftiumDART.getZone2() + ";@@WIKIA_PROVIDER_VALUES@@" + LiftiumDART.getLocKv(a) + LiftiumDART.getArticleKV() + LiftiumDART.getDomainKV(Liftium.getPageVar("domain")) + "pos=" + a + ";";
    b = b.replace(/@@WIKIA_AQ@@/, LiftiumDART.getMinuteTargeting());
    var c = Liftium.getPageVar("dart", "");
    return Liftium.e(c) || (b = b.replace(/@@WIKIA_PROVIDER_VALUES@@/, c + ";")), b;
};
