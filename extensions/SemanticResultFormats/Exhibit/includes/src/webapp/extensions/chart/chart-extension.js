/*==================================================
 *  Simile Exhibit Chart Extension
 *==================================================
 */

Exhibit.ChartExtension = {
    params: {
        bundle: true
    } 
};

(function() {
    var javascriptFiles = [
        "scatter-plot-view.js",
        "pivot-table-view.js",
        "bar-chart-view.js"
    ];
    var cssFiles = [
        "scatter-plot-view.css",
        "pivot-table-view.css",
        "bar-chart-view.css"
    ];
        
    var url = SimileAjax.findScript(document, "/chart-extension.js");
    if (url == null) {
        SimileAjax.Debug.exception(new Error("Failed to derive URL prefix for Simile Exhibit Chart Extension code files"));
        return;
    }
    Exhibit.ChartExtension.urlPrefix = url.substr(0, url.indexOf("chart-extension.js"));
        
    var paramTypes = { bundle: Boolean };
    SimileAjax.parseURLParameters(url, Exhibit.ChartExtension.params, paramTypes);
        
    var scriptURLs = [];
    var cssURLs = [];
    
    if (Exhibit.ChartExtension.params.bundle) {
        scriptURLs.push(Exhibit.ChartExtension.urlPrefix + "chart-extension-bundle.js");
        cssURLs.push(Exhibit.ChartExtension.urlPrefix + "chart-extension-bundle.css");
    } else {
        SimileAjax.prefixURLs(scriptURLs, Exhibit.ChartExtension.urlPrefix + "scripts/", javascriptFiles);
        SimileAjax.prefixURLs(cssURLs, Exhibit.ChartExtension.urlPrefix + "styles/", cssFiles);
    }
    
    for (var i = 0; i < Exhibit.locales.length; i++) {
        scriptURLs.push(Exhibit.ChartExtension.urlPrefix + "locales/" + Exhibit.locales[i] + "/chart-locale.js");
    };
    
    SimileAjax.includeJavascriptFiles(document, "", scriptURLs);
    SimileAjax.includeCssFiles(document, "", cssURLs);
})();
