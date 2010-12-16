/*==================================================
 *  Simile Exhibit Map Extension
 *==================================================
 */

Exhibit.MapExtension = {
    params: {
        bundle:     true,
        service:    "google"
    } 
};

(function() {
    var javascriptFiles = [
        "map-view.js",
        "vemap-view.js"
    ];
    var cssFiles = [
        "map-view.css"
    ];
        
    var url = SimileAjax.findScript(document, "/map-extension.js");
    if (url == null) {
        SimileAjax.Debug.exception(new Error("Failed to derive URL prefix for Simile Exhibit Map Extension code files"));
        return;
    }
    Exhibit.MapExtension.urlPrefix = url.substr(0, url.indexOf("map-extension.js"));
        
    var paramTypes = { bundle: Boolean };
    SimileAjax.parseURLParameters(url, Exhibit.MapExtension.params, paramTypes);
        
    var scriptURLs = [];
    var cssURLs = [];
        
    if (Exhibit.MapExtension.params.service == "google") {
        if (Exhibit.params.gmapkey) {
            scriptURLs.push("http://maps.google.com/maps?file=api&v=2&key=" + Exhibit.params.gmapkey);
        } else if (Exhibit.MapExtension.params.gmapkey) {
            scriptURLs.push("http://maps.google.com/maps?file=api&v=2&key=" + Exhibit.MapExtension.params.gmapkey);
        } else if (!("GMap2" in window)) {
            scriptURLs.push("http://maps.google.com/maps?file=api&v=2");
        }
    } else {
        scriptURLs.push("http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=5");
    }
    
    if (Exhibit.MapExtension.params.bundle) {
        scriptURLs.push(Exhibit.MapExtension.urlPrefix + "map-extension-bundle.js");
        cssURLs.push(Exhibit.MapExtension.urlPrefix + "map-extension-bundle.css");
    } else {
        SimileAjax.prefixURLs(scriptURLs, Exhibit.MapExtension.urlPrefix + "scripts/", javascriptFiles);
        SimileAjax.prefixURLs(cssURLs, Exhibit.MapExtension.urlPrefix + "styles/", cssFiles);
    }
    
    for (var i = 0; i < Exhibit.locales.length; i++) {
        scriptURLs.push(Exhibit.MapExtension.urlPrefix + "locales/" + Exhibit.locales[i] + "/map-locale.js");
    };
    
    SimileAjax.includeJavascriptFiles(document, "", scriptURLs);
    SimileAjax.includeCssFiles(document, "", cssURLs);
})();
