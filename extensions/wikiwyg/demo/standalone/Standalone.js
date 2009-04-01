proto = new Subclass('Wikiwyg.Standalone', 'Wikiwyg');

proto.saveChanges = function() {
    var self = this;
    this.current_mode.toHtml( function(html) { self.fromHtml(html) });
    this.displayMode();
}
