/*==================================================
 *  Exhibit.BabelBasedImporter
 *==================================================
 */

Exhibit.BabelBasedImporter = {
    mimetypeToReader: {
        "application/rdf+xml" : "rdf-xml",
        "application/n3" : "n3",
        
        "application/msexcel" : "xls",
        "application/x-msexcel" : "xls",
        "application/x-ms-excel" : "xls",
        "application/vnd.ms-excel" : "xls",
        "application/x-excel" : "xls",
        "application/xls" : "xls",
        "application/x-xls" : "xls",
        
        "application/x-bibtex" : "bibtex"
    }
};

Exhibit.importers["application/rdf+xml"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/n3"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/msexcel"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/x-msexcel"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/vnd.ms-excel"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/x-excel"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/xls"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/x-xls"] = Exhibit.BabelBasedImporter;
Exhibit.importers["application/x-bibtex"] = Exhibit.BabelBasedImporter;

Exhibit.BabelBasedImporter.load = function(link, database, cont) {
    var url = (typeof link == "string") ?
        Exhibit.Persistence.resolveURL(link) :
        Exhibit.Persistence.resolveURL(link.href);

    var reader = "rdf-xml";
    var writer = "exhibit-jsonp";
    if (typeof link != "string") {
        var mimetype = link.type;
        if (mimetype in Exhibit.BabelBasedImporter.mimetypeToReader) {
            reader = Exhibit.BabelBasedImporter.mimetypeToReader[mimetype];
        }
    }
    if (reader == "bibtex") {
        writer = "bibtex-exhibit-jsonp";
    }
    
    var babelURL = "http://simile.mit.edu/babel/translator?" + [
        "reader=" + reader,
        "writer=" + writer,
        "url=" + encodeURIComponent(url)
    ].join("&");

    return Exhibit.JSONPImporter.load(babelURL, database, cont);
};
