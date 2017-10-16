

/* database-l10n.js */
if(!("l10n" in Exhibit.Database)){Exhibit.Database.l10n={};
}Exhibit.Database.l10n.itemType={label:"Objekter",pluralLabel:"Objekter",uri:"http://simile.mit.edu/2006/11/exhibit#Item"};
Exhibit.Database.l10n.labelProperty={label:"label",pluralLabel:"labels",reverseLabel:"label of",reversePluralLabel:"labels of"};
Exhibit.Database.l10n.typeProperty={label:"type",pluralLabel:"types",reverseLabel:"type of",reversePluralLabel:"types of"};
Exhibit.Database.l10n.uriProperty={label:"URI",pluralLabel:"URIs",reverseLabel:"URI of",reversePluralLabel:"URIs of"};
Exhibit.Database.l10n.sortLabels={"text":{ascending:"a - å",descending:"å - a"},"number":{ascending:"minste først",descending:"største først"},"date":{ascending:"tidligste først",descending:"yngste først"},"boolean":{ascending:"false first",descending:"true first"},"item":{ascending:"a - z",descending:"z - a"}};
Exhibit.Database.l10n.labelItemsOfType=function(F,C,G,B){var A=F==1?Exhibit.Database.l10n.itemType.label:Exhibit.Database.l10n.itemType.pluralLabel;
var E=G.getType(C);
if(E){A=E.getLabel();
if(F!=1){var H=E.getProperty("pluralLabel");
if(H){A=H;
}}}var D=document.createElement("span");
D.innerHTML="<span class='"+B+"'>"+F+"</span> "+A;
return D;
};


/* exhibit-l10n.js */
if(!("l10n" in Exhibit)){Exhibit.l10n={};
}Exhibit.l10n.missingLabel="mangler";
Exhibit.l10n.missingSortKey="(mangler)";
Exhibit.l10n.notApplicableSortKey="(n/a)";
Exhibit.l10n.itemLinkLabel="lenke";
Exhibit.l10n.busyIndicatorMessage="Søker...";
Exhibit.l10n.showDocumentationMessage="Vi vil vise relevant dokumentasjon etter denne meldinga...";
Exhibit.l10n.showJavascriptValidationMessage="Vi vil forklare denne feilen etter denne denne meldinga.";
Exhibit.l10n.showJsonValidationMessage="Vi vil forklare feilen etter denne meldinga.";
Exhibit.l10n.showJsonValidationFormMessage="Vi vil lete etter en webservice der du kan laste opp koden etter denne meldinga.";
Exhibit.l10n.badJsonMessage=function(A,B){return"JSON data fila\n  "+A+"\nhar feil =\n\n"+B;
};
Exhibit.l10n.failedToLoadDataFileMessage=function(A){return"Vi kan ikke finne fila i\n  "+A+"\nse om filnavnet er riktig.";
};
Exhibit.l10n.exportButtonLabel="Eksporter";
Exhibit.l10n.exportAllButtonLabel="Eksporter alle";
Exhibit.l10n.exportDialogBoxCloseButtonLabel="Lukk";
Exhibit.l10n.exportDialogBoxPrompt="Kopier denne koden til utklippstavla. Trykk ESC for å fjerne denne dialogboksen.";
Exhibit.l10n.focusDialogBoxCloseButtonLabel="Lukk";
Exhibit.l10n.rdfXmlExporterLabel="RDF/XML";
Exhibit.l10n.smwExporterLabel="Semantisk wikitext";
Exhibit.l10n.exhibitJsonExporterLabel="Exhibit JSON";
Exhibit.l10n.tsvExporterLabel="Tab-separert tekst";
Exhibit.l10n.htmlExporterLabel="HTML generet fra denne visninga";


/* formatter-l10n.js */
if(!("l10n" in Exhibit.Formatter)){Exhibit.Formatter.l10n={};
}Exhibit.Formatter.l10n.listSeparator=", ";
Exhibit.Formatter.l10n.listLastSeparator=", og ";
Exhibit.Formatter.l10n.listPairSeparator=" og ";
Exhibit.Formatter.l10n.textEllipsis="...";
Exhibit.Formatter.l10n.booleanTrue="sann";
Exhibit.Formatter.l10n.booleanFalse="usann";
Exhibit.Formatter.l10n.currencySymbol="$";
Exhibit.Formatter.l10n.currencySymbolPlacement="første";
Exhibit.Formatter.l10n.currencyShowSign=true;
Exhibit.Formatter.l10n.currencyShowRed=false;
Exhibit.Formatter.l10n.currencyShowParentheses=false;
Exhibit.Formatter.l10n.dateTimeDefaultFormat="EEE, MMM d, yyyy, hh:mm a";
Exhibit.Formatter.l10n.dateShortFormat="dd/MM/yy";
Exhibit.Formatter.l10n.timeShortFormat="hh:mm a";
Exhibit.Formatter.l10n.dateTimeShortFormat="dd/MM/yy hh:mm a";
Exhibit.Formatter.l10n.dateMediumFormat="EEE, MMM d, yyyy";
Exhibit.Formatter.l10n.timeMediumFormat="hh:mm a";
Exhibit.Formatter.l10n.dateTimeMediumFormat="EEE, MMM d, yyyy, hh:mm a";
Exhibit.Formatter.l10n.dateLongFormat="EEEE, MMMM d, yyyy";
Exhibit.Formatter.l10n.timeLongFormat="HH:mm:ss z";
Exhibit.Formatter.l10n.dateTimeLongFormat="EEEE, MMMM d, yyyy, HH:mm:ss z";
Exhibit.Formatter.l10n.dateFullFormat="EEEE, MMMM d, yyyy";
Exhibit.Formatter.l10n.timeFullFormat="HH:mm:ss.S z";
Exhibit.Formatter.l10n.dateTimeFullFormat="EEEE, MMMM d, yyyy G, HH:mm:ss.S z";
Exhibit.Formatter.l10n.shortDaysOfWeek=["Søn","Man","Tir","Ons","Tor","Fre","Lør"];
Exhibit.Formatter.l10n.daysOfWeek=["Søndag","Mandag","Tirsdag","Onsdag","Torsdag","Fredag","Lørdag"];
Exhibit.Formatter.l10n.shortMonths=["Jan","Feb","Mar","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Des"];
Exhibit.Formatter.l10n.months=["Januar","Februar","Mars","April","Mai","Juni","Juli","August","September","Oktober","November","Desember"];
Exhibit.Formatter.l10n.commonEra="CE";
Exhibit.Formatter.l10n.beforeCommonEra="Fvt.";
Exhibit.Formatter.l10n.beforeNoon="am";
Exhibit.Formatter.l10n.afterNoon="pm";
Exhibit.Formatter.l10n.BeforeNoon="AM";
Exhibit.Formatter.l10n.AfterNoon="PM";


/* lens-l10n.js */
if(!("l10n" in Exhibit.Lens)){Exhibit.Lens.l10n={};
}

/* ui-context-l10n.js */
if(!("l10n" in Exhibit.UIContext)){Exhibit.UIContext.l10n={};
}Exhibit.UIContext.l10n.initialSettings={"bubbleWidth":400,"bubbleHeight":300};


/* ordered-view-frame-l10n.js */
if(!("l10n" in Exhibit.OrderedViewFrame)){Exhibit.OrderedViewFrame.l10n={};
}Exhibit.OrderedViewFrame.l10n.removeOrderLabel="fjern sorteringsrekkefølgen";
Exhibit.OrderedViewFrame.l10n.sortingControlsTemplate="sortert etter: <span id='ordersSpan'></span>; <a id='thenSortByAction' href='javascript:void' class='exhibit-action' title='sorter videre etter'>så etter...</a>";
Exhibit.OrderedViewFrame.l10n.formatSortActionTitle=function(B,A){return"Sortert etter "+B+" ("+A+")";
};
Exhibit.OrderedViewFrame.l10n.formatRemoveOrderActionTitle=function(B,A){return"Fjernet rekkefølgen "+B+" ("+A+")";
};
Exhibit.OrderedViewFrame.l10n.groupedAsSortedOptionLabel="gruppert etter sorteringsrekkefølge";
Exhibit.OrderedViewFrame.l10n.groupAsSortedActionTitle="grupper som sortert";
Exhibit.OrderedViewFrame.l10n.ungroupAsSortedActionTitle="avgrupper som sortert";
Exhibit.OrderedViewFrame.l10n.showAllActionTitle="vis alle treff";
Exhibit.OrderedViewFrame.l10n.dontShowAllActionTitle="vis de første resultatene";
Exhibit.OrderedViewFrame.l10n.formatDontShowAll=function(A){return"Vis bare de første "+A+" ";
};
Exhibit.OrderedViewFrame.l10n.formatShowAll=function(A){return"Vis alle "+A+" ";
};


/* tabular-view-l10n.js */
if(!("l10n" in Exhibit.TabularView)){Exhibit.TabularView.l10n={};
}Exhibit.TabularView.l10n.viewLabel="Tabell";
Exhibit.TabularView.l10n.viewTooltip="Vis objektene i en tabell";
Exhibit.TabularView.l10n.columnHeaderSortTooltip="Klikk for å sortere denne kolonna";
Exhibit.TabularView.l10n.columnHeaderReSortTooltip="Klikk for å sortere i omvendt rekkefølge";
Exhibit.TabularView.l10n.makeSortActionTitle=function(A,B){return(B?"sortert i stigende rekkefølge ":"sortert i synkende rekkefølge etter ")+A;
};


/* thumbnail-view-l10n.js */
if(!("l10n" in Exhibit.ThumbnailView)){Exhibit.ThumbnailView.l10n={};
}Exhibit.ThumbnailView.l10n.viewLabel="miniatyrbilder";
Exhibit.ThumbnailView.l10n.viewTooltip="Vis alle som miniatyrbilder";


/* tile-view-l10n.js */
if(!("l10n" in Exhibit.TileView)){Exhibit.TileView.l10n={};
}Exhibit.TileView.l10n.viewLabel="Liste";
Exhibit.TileView.l10n.viewTooltip="Vis alle objektene som liste";


/* view-panel-l10n.js */
if(!("l10n" in Exhibit.ViewPanel)){Exhibit.ViewPanel.l10n={};
}Exhibit.ViewPanel.l10n.createSelectViewActionTitle=function(A){return"velg "+A+" visning";
};
Exhibit.ViewPanel.l10n.missingViewClassMessage="The specification for one of the views is missing the viewClass field.";
Exhibit.ViewPanel.l10n.viewClassNotFunctionMessage=function(A){return"The viewClass attribute value '"+A+"' you have specified\nfor one of the views does not evaluate to a Javascript function.";
};
Exhibit.ViewPanel.l10n.badViewClassMessage=function(A){return"The viewClass attribute value '"+A+"' you have specified\nfor one of the views is not a valid Javascript expression.";
};


/* collection-summary-widget-l10n.js */
if(!("l10n" in Exhibit.CollectionSummaryWidget)){Exhibit.CollectionSummaryWidget.l10n={};
}Exhibit.CollectionSummaryWidget.l10n.resetFiltersLabel="Slå av alle filter";
Exhibit.CollectionSummaryWidget.l10n.resetFiltersTooltip="Fjern alle filter og se opprinnelig utvalg";
Exhibit.CollectionSummaryWidget.l10n.resetActionTitle="Slå av alle søkefilter";
Exhibit.CollectionSummaryWidget.l10n.allResultsTemplate="<span class='%0' id='resultDescription'></span>";
Exhibit.CollectionSummaryWidget.l10n.noResultsTemplate="<span class='%0'><span class='%1'>0</span> treff</span> (<span id='resetActionLink'></span>)";
Exhibit.CollectionSummaryWidget.l10n.filteredResultsTemplate="<span class='%0' id='resultDescription'></span> filtrert fra <span id='originalCountSpan'>0</span> opprinnelig (<span id='resetActionLink'></span>)";


/* coders-l10n.js */
if(!("l10n" in Exhibit.Coders)){Exhibit.Coders.l10n={};
}Exhibit.Coders.l10n.mixedCaseLabel="blandet";
Exhibit.Coders.l10n.missingCaseLabel="mangler";
Exhibit.Coders.l10n.othersCaseLabel="andre";


/* facets-l10n.js */
if(!("l10n" in Exhibit.FacetUtilities)){Exhibit.FacetUtilities.l10n={};
}Exhibit.FacetUtilities.l10n.clearSelectionsTooltip="Fjern disse utvalgene";
Exhibit.FacetUtilities.l10n.facetSelectActionTitle="Velg %0 i fasett %1";
Exhibit.FacetUtilities.l10n.facetUnselectActionTitle="Fjern valg %0 i fasett %1";
Exhibit.FacetUtilities.l10n.facetSelectOnlyActionTitle="Velg bare %0 i fasetten %1";
Exhibit.FacetUtilities.l10n.facetClearSelectionsActionTitle="Fjern valg i fasetten %0";
Exhibit.FacetUtilities.l10n.facetTextSearchActionTitle="Tekstsøk %0";
Exhibit.FacetUtilities.l10n.facetClearTextSearchActionTitle="Fjern søketekst";
Exhibit.FacetUtilities.l10n.missingThisField="(mangler dette feltet)";


/* views-l10n.js */
if(!("l10n" in Exhibit.ViewUtilities)){Exhibit.ViewUtilities.l10n={};
}Exhibit.ViewUtilities.l10n.unplottableMessageFormatter=function(B,A,C){var D=A.length;
return String.substitute("<a class='exhibit-action exhibit-views-unplottableCount' href='javascript:void' id='unplottableCountLink'>%0</a> av <class class='exhibit-views-totalCount'>%1</span> kunne ikke vises på kartet.",[D==1?(D+" treff"):(D+" treff"),B]);
};
