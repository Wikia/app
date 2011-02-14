/*======================================================================
 *  Exhibit auto-create
 *  Code to automatically create the database, load the data links in
 *  <head>, and then to create an exhibit if there's no ex:ondataload
 *  handler on the body element.
 *
 *  You can avoid running this code by adding the URL parameter
 *  autoCreate=false when you include exhibit-api.js.
 *======================================================================
 */
SimileAjax.jQuery(document).ready(function() {
    var fDone = function() {
        window.exhibit = Exhibit.create();
        window.exhibit.configureFromDOM();
    };

    try {
        var s = Exhibit.getAttribute(document.body, "ondataload");
        if (s != null && typeof s == "string" && s.length > 0) {
            fDone = function() {
                var f = eval(s);
                if (typeof f == "function") {
                    f.call();
                }
            }
        }
    } catch (e) {
        // silent
    }

    var fLoadSubmissions = function() {
        window.database.loadSubmissionLinks(fDone);
    };

    Exhibit.Authentication.authenticate();
    window.database = Exhibit.Database.create();
    window.database.loadDataLinks(fLoadSubmissions);
});

