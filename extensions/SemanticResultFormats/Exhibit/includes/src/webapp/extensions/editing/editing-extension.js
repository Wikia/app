/*==================================================
 *  Simile Exhibit Editing Extension
 *==================================================
 */

Exhibit.EditingExtension = {
    params: {
        bundle:     false
    } 
};

(function() {
    var javascriptFiles = [
        "extra.js",
        "ui/lens.js",
        "ui/editing-lens.js",
        "ui/editing-formatter.js",
        "data/editing-backend.js"
    ];
    var cssFiles = [
        "editing.css"
    ];
    
    var url = SimileAjax.findScript(document, "/editing-extension.js");
    if (url == null) {
        SimileAjax.Debug.exception(new Error("Failed to derive URL prefix for Simile Exhibit Editing Extension code files"));
        return;
    }
    Exhibit.EditingExtension.urlPrefix = url.substr(0, url.indexOf("editing-extension.js"));
        
    var paramTypes = { bundle: Boolean };
    SimileAjax.parseURLParameters(url, Exhibit.EditingExtension.params, paramTypes);
        
    var scriptURLs = [];
    var cssURLs = [];
        
    if (Exhibit.EditingExtension.params.bundle) {
        scriptURLs.push(Exhibit.EditingExtension.urlPrefix + "editing-extension-bundle.js");
        cssURLs.push(Exhibit.EditingExtension.urlPrefix + "editing-extension-bundle.css");
    } else {
        SimileAjax.prefixURLs(scriptURLs, Exhibit.EditingExtension.urlPrefix + "scripts/", javascriptFiles);
        SimileAjax.prefixURLs(cssURLs, Exhibit.EditingExtension.urlPrefix + "styles/", cssFiles);
    }
    
    for (var i = 0; i < Exhibit.locales.length; i++) {
        scriptURLs.push(Exhibit.EditingExtension.urlPrefix + "locales/" + Exhibit.locales[i] + "/editing-locale.js");
    };
    
    SimileAjax.includeJavascriptFiles(document, "", scriptURLs);
    SimileAjax.includeCssFiles(document, "", cssURLs);
})();
