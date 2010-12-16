/*==================================================
 *  Simile Exhibit Time Extension
 *==================================================
 */

Exhibit.TimeExtension = {
    params: {
        bundle: true
    } 
};

(function() {
    var javascriptFiles = [
        "timeline-view.js"
    ];
    var cssFiles = [
        "timeline-view.css"
    ];
        
    var url = SimileAjax.findScript(document, "/time-extension.js");
    if (url == null) {
        SimileAjax.Debug.exception(new Error("Failed to derive URL prefix for Simile Exhibit Time Extension code files"));
        return;
    }
    Exhibit.TimeExtension.urlPrefix = url.substr(0, url.indexOf("time-extension.js"));
        
    var paramTypes = { bundle: Boolean };
    SimileAjax.parseURLParameters(url, Exhibit.TimeExtension.params, paramTypes);
        
    var scriptURLs = [ "http://static.simile.mit.edu/timeline/api-2.0/timeline-api.js" ];
    var cssURLs = [];
        
    if (Exhibit.TimeExtension.params.bundle) {
        scriptURLs.push(Exhibit.TimeExtension.urlPrefix + "time-extension-bundle.js");
        cssURLs.push(Exhibit.TimeExtension.urlPrefix + "time-extension-bundle.css");
    } else {
        SimileAjax.prefixURLs(scriptURLs, Exhibit.TimeExtension.urlPrefix + "scripts/", javascriptFiles);
        SimileAjax.prefixURLs(cssURLs, Exhibit.TimeExtension.urlPrefix + "styles/", cssFiles);
    }
    
    for (var i = 0; i < Exhibit.locales.length; i++) {
        scriptURLs.push(Exhibit.TimeExtension.urlPrefix + "locales/" + Exhibit.locales[i] + "/time-locale.js");
    };
    
    SimileAjax.includeJavascriptFiles(document, "", scriptURLs);
    SimileAjax.includeCssFiles(document, "", cssURLs);
})();
