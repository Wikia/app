/**
 * From https://en.wikipedia.org/wiki/User:Nageh/mathJax.js
 */

if ( typeof(mathJax) === "undefined" ) mathJax = {};

mathJax.version = "0.2";

mathJax.loaded = false;

mathJax.Config = function() {
  MathJax.Hub.Config({
    root: mediaWiki.config.get('wgExtensionAssetsPath') + '/Math/modules/MathJax/',
    config: "TeX-AMS-texvc_HTML.js",
    "v1.0-compatible": false,
    styles: { ".mtext": { "font-family": "sans-serif ! important", "font-size": "80%" } },
    displayAlign: "left",
    menuSettings: { zoom: "click" },
    "HTML-CSS": { imageFont: null, availableFonts: ["TeX"] }
  });
  MathJax.Message.styles["#MathJax_Message"].right = MathJax.Message.styles["#MathJax_Message"].left;
  delete MathJax.Message.styles["#MathJax_Message"].left;
  if ( typeof(mathJax.userConfig) !== "undefined" ) MathJax.Hub.Config( mathJax.userConfig );
  if ( typeof(mathJax.fontDir) !== "undefined" ) MathJax.OutputJax.fontDir = mathJax.fontDir; else MathJax.Hub.Config({ NativeMML: {webFont: null} });
  MathJax.Hub.Register.StartupHook("End Extensions", function() {
    var TEX = MathJax.InputJax.TeX;
    var MACROS = TEX.config.Macros;
    for (var id in MACROS) {
      if (typeof(MACROS[id]) === "string") TEX.Macro(id, MACROS[id]);
      else TEX.Macro(id, MACROS[id][0], MACROS[id][1]);
    }
/*    TEX.Parse.Augment({
      Cr: function(name) {
        this.GetBrackets(name);
        this.Push(TEX.Stack.Item.cell().With({isCR: true, name: name}));
      }
    });*/
  });
  MathJax.Hub.Startup.onload();
}

mathJax.Load = function(element) {
  if (this.loaded)
    return true;

  var span = element.getElementsByTagName("span"), i;
  for (i = span.length-1; i >= 0; i--) {
    if (span[i].className === "tex") {
//      this.span = span;
//      this.spanIndex = i;

      // create configuration element
      var config = 'mathJax.Config();';
      var script = document.createElement( 'script' );
      script.setAttribute( 'type', 'text/x-mathjax-config' );
      if ( window.opera ) script.innerHTML = config; else script.text = config;
      document.getElementsByTagName('head')[0].appendChild( script );

      // create startup element
	  mediaWiki.loader.load('ext.math.mathjax');

      this.loaded = true;
      break;
    }
  }
  return false;
}

mathJax.Init = function() {
  this.Load( document.getElementById("bodyContent") || document.body );

  // compatibility with wikEd
  if ( typeof(wikEd) == "undefined" ) { wikEd = {}; }
  if ( typeof(wikEd.config) == "undefined" ) { wikEd.config = {}; }
  if ( typeof(wikEd.config.previewHook) == "undefined" ) { wikEd.config.previewHook = []; }
  wikEd.config.previewHook.push( function(){ if (window.mathJax.Load(document.getElementById("wikEdPreviewBox") || document.body)) MathJax.Hub.Queue(["Typeset", MathJax.Hub, "wikEdPreviewBox"]) } );

  // compatibility with ajaxPreview
  this.oldAjaxPreviewExec = window.ajaxPreviewExec;
  window.ajaxPreviewExec = function(previewArea) {
    if ( typeof(mathJax.oldAjaxPreviewExec) !== "undefined" ) mathJax.oldAjaxPreviewExec(previewArea);
    if ( mathJax.Load(previewArea) ) MathJax.Hub.Queue( ["Typeset", MathJax.Hub, previewArea] );
  }
}

mathJax.Init();
