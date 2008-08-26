var head = document.getElementsByTagName('head')[0];

var link = document.createElement('link');
link.setAttribute('rel', 'stylesheet');
link.setAttribute('type', 'text/css');
link.setAttribute('href', 'http://demo.wikiwyg.net/wikiwyg/css/wikiwyg.css');
head.appendChild(link);

var myConfig = {
    imagesLocation: 'http://demo.wikiwyg.net/wikiwyg/images/',
    doubleClickToEdit: true
}
var myWikiwyg = new Wikiwyg();

var wiki = document.getElementById('wiki');
myWikiwyg.createWikiwygArea(wiki, myConfig);
