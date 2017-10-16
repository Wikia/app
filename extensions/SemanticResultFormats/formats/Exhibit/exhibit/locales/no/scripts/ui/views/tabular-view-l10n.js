/*==================================================
 *  Exhibit.TabularView Norwegian localization
 *==================================================
 */
if (!("l10n" in Exhibit.TabularView)) {
    Exhibit.TabularView.l10n = {};
}

Exhibit.TabularView.l10n.viewLabel = "Tabell";
Exhibit.TabularView.l10n.viewTooltip = "Vis i en tabell";

Exhibit.TabularView.l10n.columnHeaderSortTooltip = "Klikk her for � sortere etter denne kolonna";
Exhibit.TabularView.l10n.columnHeaderReSortTooltip = "Klikk her for � sortere i omvendt rekkef�lge";
Exhibit.TabularView.l10n.makeSortActionTitle = function(label, ascending) {
    return (ascending ? "sortert i stigende rekkef�lge etter " : "sortert i synkende rekkef�lge etter ") + label;
};
