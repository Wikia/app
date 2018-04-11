/**
 * From https://en.wikipedia.org/wiki/User:Nageh/mathJax.js
 */
/*global mathJax:true, MathJax */
( function ( mw, $ ) {
  if ( typeof mathJax === 'undefined' ) {
    mathJax = {};
  }

  mathJax.version = '0.2';

  mathJax.loaded = false;

  mathJax.config = $.extend( true, {
    root: mw.config.get('wgExtensionAssetsPath') + '/Math/modules/MathJax',
    config: ['TeX-AMS-texvc_HTML.js'],
    'v1.0-compatible': false,
    styles: {
      '.mtext': {
        'font-family': 'sans-serif ! important',
        'font-size': '80%'
      }
    },
    displayAlign: 'left',
    menuSettings: {
      zoom: 'Click'
    },
    'HTML-CSS': {
      imageFont: null,
      availableFonts: ['TeX']
    }
  }, mathJax.config );

  mathJax.Config = function () {
    MathJax.Hub.Config( mathJax.config );
    MathJax.OutputJax.fontDir = mw.config.get('wgExtensionAssetsPath') + '/Math/modules/MathJax/fonts';
  };

  /**
   * Renders all Math TeX inside the given elements.
   * @param {function} callback to be executed after text elements have rendered [optional]
   */
  $.fn.renderTex = function ( callback ) {
    var elem = this.find( '.tex' ).parent().toArray();

    if ( !$.isFunction( callback ) ) {
      callback = $.noop;
    }

    function render () {
      MathJax.Hub.Queue( ['Typeset', MathJax.Hub, elem, callback] );
    }

    mw.loader.using( 'ext.math.mathjax', function () {
      if ( MathJax.isReady ) {
        render();
      } else {
        MathJax.Hub.Startup.signal.MessageHook( 'End', render );
      }
    });
    return this;
  };

  mathJax.Load = function () {
    var config, script;
    if (this.loaded) {
      return true;
    }

    // create configuration element
    config = 'mathJax.Config();';
    script = document.createElement( 'script' );
    script.setAttribute( 'type', 'text/x-mathjax-config' );
    if ( window.opera ) {
      script.innerHTML = config;
    } else {
      script.text = config;
    }
    document.getElementsByTagName('head')[0].appendChild( script );

    // create startup element
    mw.loader.load('ext.math.mathjax');

    this.loaded = true;

    return false;
  };

  $( document ).ready( function () {
    mathJax.Load();
  } );

}( mediaWiki, jQuery ) );
