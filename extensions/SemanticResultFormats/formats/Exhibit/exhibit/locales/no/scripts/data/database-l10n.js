/*==================================================
 *  Exhibit.Database English localization
 *==================================================
 */

if (!("l10n" in Exhibit.Database)) {
    Exhibit.Database.l10n = {};
}

Exhibit.Database.l10n.itemType = {
    label:          "Objekt",
    pluralLabel:    "Objekter",
    uri:            "http://simile.mit.edu/2006/11/exhibit#Item"
};
Exhibit.Database.l10n.labelProperty = {
    label:                  "navn",
    pluralLabel:            "navn",
    reverseLabel:           "navn p�",
    reversePluralLabel:     "navn p�"
};
Exhibit.Database.l10n.typeProperty = {
    label:                  "type",
    pluralLabel:            "typer",
    reverseLabel:           "type av",
    reversePluralLabel:     "typer av"
};
Exhibit.Database.l10n.uriProperty = {
    label:                  "URI",
    pluralLabel:            "URIer",
    reverseLabel:           "URI av",
    reversePluralLabel:     "URIer av"
};
Exhibit.Database.l10n.sortLabels = {
    "text": {
        ascending:  "a - �",
        descending: "� - a"
    },
    "number": {
        ascending:  "minste f�rst",
        descending: "st�rste f�rst"
    },
    "date": {
        ascending:  "eldste f�rst",
        descending: "yngste f�rst"
    },
    "boolean": {
        ascending:  "usann f�rst",
        descending: "sanne f�rst"
    },
    "item": {
        ascending:  "a - �",
        descending: "� - a"
    }
};

Exhibit.Database.l10n.labelItemsOfType = function(count, typeID, database, countStyleClass) {
    var label = count == 1 ? Exhibit.Database.l10n.itemType.label :
        Exhibit.Database.l10n.itemType.pluralLabel

    var type = database.getType(typeID);
    if (type) {
        label = type.getLabel();
        if (count != 1) {
            var pluralLabel = type.getProperty("pluralLabel");
            if (pluralLabel) {
                label = pluralLabel;
            }
        }
    }

    var span = document.createElement("span");
    span.innerHTML = "<span class='" + countStyleClass + "'>" + count + "</span> " + label;

    return span;
};
