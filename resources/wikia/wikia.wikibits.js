(function( window, $ ) {

    /**
     * Import JavaScript and Stylesheet articles from any wiki.
     *
     * >> Examples:
     *
     * // Importing a single Stylesheet from the local wiki
     * importArticle({
     *     type: "style",
     *     article: "Mediawiki:MyCustomStyles.css"
     * });
     *
     * // Importing multiple JavaScript files from an external wiki
     * importArticles({
     *     type: "script",
     *     articles: [
     *         "Mediawiki:MyCustomJavaScript.js",
     *         "w:starwars:Mediawiki:External.js"
     *     ]
     * });
     *
     * @param {...Object} Any number of modules to load.
     *
     * @returns {Array} An array of DOM nodes used to inject the
     *                  content into the page.
     *
     * @author Kyle Florence <kflorence@wikia-inc.com>
     * @author Wladyslaw Bodzek
     */
    var importArticle = (function() {
        var baseUri = mw.config.get( 'wgLoadScript' ) + '?=',
            defaults = {
                debug: mw.config.get( 'debug' ),
                lang: mw.config.get( 'wgUserLanguage' ),
                mode: 'articles',
                skin: mw.config.get( 'skin' ),
                missingCallback: 'importArticleMissing'
            },
            loaded = {},
            slice = [].slice;

        function log( text ) {
            return $().log( text, 'importArticle' );
        }

        return function() {
            var i, l, module, uri,
                modules = slice.call(arguments),
                result = [];

            for ( i = 0, l = modules.length; i < l; i++ ) {
                module = $.extend( {}, defaults, modules[ i ] );

                // Resource loader expects "articles" param
                module.articles = module.article || module.articles;
                delete module.article;

                if ( !module.articles || !module.articles.length ) {
                    log( 'Missing required argument: articles' );
                    continue;
                }

                // Resource loader expects pipe separated article names
                if ( $.isArray( module.articles ) ) {
                    module.articles = module.articles.join( '|' );
                }

                // These import methods are in /skins/common/wikibits.js
                var importMethod;
                if ( module.type == 'script' ) {
                    importMethod = window.importScriptURI;

                } else if ( module.type == 'style' ) {
                    importMethod = window.importStylesheetURI;
                }

                if ( !importMethod ) {
                    log( 'Invalid article type: ' + ( module.type || '(none provided)' ) );
                    continue;
                }

                // Resource loader expects "only" param instead of "type"
                module.only = module.type + 's';
                delete module.type;

                // Make sure we don't load the same URI again
                uri = baseUri + $.param( module )
                if ( loaded[ uri ] ) {
                    continue;
                }

                loaded[ uri ] = true;

                // Inject request into DOM
                result.push( importMethod( uri ) );
            }

            return result;
        }
    }());

    var missingText = {
        single: '%1s was not found (requested by user-supplied javascript)',
        multiple: '%1s %2s were not found (requested by user-supplied javascript)'
    };
    var moreText = {
        single: '(and one more article)',
        multiple: '(and %d moe articles)'
    };

    var missingList = [];
    var importArticleMissing = function(names) {
        names = $.isArray(names) ? names : [names];
        missingList = missingList.concat(names);

        // don't show notificaton for regular users
        if ( !$.isArray( window.wgUserGroups )
            || ( window.wgUserGroups.indexOf('staff') === -1
            &&  window.wgUserGroups.indexOf('sysop') === -1
            &&  window.wgUserGroups.indexOf('bureaucrat') === -1 ) ) {
            return;
        }

        // use GlobalNotification to show the error to the user
        if ( window.GlobalNotification ) {
            var message = missingText[missingList.length <= 1 ? 'single' : 'multiple' ];
            var more = moreText[missingList.length-1 <= 1 ? 'single' : 'multiple' ];
            message = message.replace('%1s','"'+missingList[0]+'"')
                .replace('%2s',more.replace('%d',missingList.length-1));
            GlobalNotification.show(message,'error');
        }
    };

    var reportMissing = $.isArray( window.wgUserGroups )
        && ( window.wgUserGroups.indexOf('staff') !== -1
            || window.wgUserGroups.indexOf('sysop') !== -1
            || window.wgUserGroups.indexOf('bureaucrat') !== -1 );

    // Exports
    window.importArticle = window.importArticles = importArticle;
    window.importArticleMissing = importArticleMissing;


})( this, jQuery );