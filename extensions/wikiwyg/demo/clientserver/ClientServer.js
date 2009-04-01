Wikiwyg.uri = function() {
    var uri = 
        location.protocol + '//' + location.host + ':' + 
        location.port + '/server/index.cgi';
    if (! uri.match(/wikiwyg\.net/))
        alert("This demo only works on wikiwyg.net");
    return uri;
}

proto = new Subclass('Wikiwyg.ClientServer', 'Wikiwyg');

proto.saveChanges = function() {
    var self = this;
    this.current_mode.toHtml( function(html) { self.fromHtml(html) });
    this.displayMode();
}

proto.modeClasses = [
    'Wikiwyg.Wysiwyg',
    'Wikiwyg.Wikitext.ClientServer',
    'Wikiwyg.Preview'
];
    
proto = new Subclass('Wikiwyg.Wikitext.ClientServer', 'Wikiwyg.Wikitext');

proto.convertWikitextToHtml = function(wikitext, func) {
    var postdata = 'action=wikiwyg_wikitext_to_html;content=' + 
                   encodeURIComponent(wikitext);
    Wikiwyg.liveUpdate(
        'POST',
        Wikiwyg.uri(),
        postdata,
        func
    );
}
