/*==================================================
 *  Exhibit German localization
 *==================================================
 */

if (!("l10n" in Exhibit)) {
    Exhibit.l10n = {};
}

Exhibit.l10n.missingLabel = "fehlend";
Exhibit.l10n.missingSortKey = "(fehlend)";
Exhibit.l10n.notApplicableSortKey = "(k.A.)";
Exhibit.l10n.itemLinkLabel = "Verweis";

Exhibit.l10n.busyIndicatorMessage = "Bitte warten...";
Exhibit.l10n.showDocumentationMessage = "Der relevante Teil der Dokumentation wird nach nach dieser Nachricht angezeigt.";
Exhibit.l10n.showJavascriptValidationMessage = "Dieser Fehler wird detailliert nach dieser Nachricht erkl�rt.";

Exhibit.l10n.showJsonValidationMessage = "Dieser Fehler wird detailliert nach dieser Nachricht erkl�rt.";
Exhibit.l10n.showJsonValidationFormMessage = "Nach dieser Nachricht werden Sie zu einem Webservice weitergeleitet, mit dessen Hilfe Sie ihren Code �berpr�fen k�nnen.";

Exhibit.l10n.badJsonMessage = function(url, e) {
    return "Die JSON Datei\n  " + url + "\nenth�lt Fehler =\n\n" + e;
};
Exhibit.l10n.failedToLoadDataFileMessage = function(url) {
    return "Die Datei\n  " + url + "\nkann nicht gefunden werden. Bitte �berpr�fen Sie den Dateinamen.";
};

/*
 *  Copy button and dialog box
 */
Exhibit.l10n.exportButtonLabel = "Exportieren";
Exhibit.l10n.exportAllButtonLabel = "Alles Exportieren";
Exhibit.l10n.exportDialogBoxCloseButtonLabel =  "Schlie�en";
Exhibit.l10n.exportDialogBoxPrompt =
    "Kopieren Sie diesen Code wie normalen Text in die Zwischenablage. Dr�cken Sie ESC um dieses Dialogfenster zu schliessen.";

/*
 *  Focusdialog box
 */
Exhibit.l10n.focusDialogBoxCloseButtonLabel = "Schlie�en";

/*
 *  Common exporters' labels
 */
Exhibit.l10n.rdfXmlExporterLabel =            "RDF/XML";
Exhibit.l10n.smwExporterLabel =               "Semantic wikitext";
Exhibit.l10n.exhibitJsonExporterLabel =       "Exhibit JSON";
Exhibit.l10n.tsvExporterLabel =               "Tabulator-getrennte Werte";
Exhibit.l10n.htmlExporterLabel =              "Erzeugtes HTML dieser Ansicht";
