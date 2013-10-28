/*global define */
/**
 * listing & transmitting tags between modules handler
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'config', ['editor', 'wikia.mustache', 'wikia.loader', 'toast'], function(editor, mustache, loader){

    'use strict';

    var wrapper = document.getElementById( 'tagListWrapper' ),

    //list of all tags
    taglist = {

        tags: [

            {
                name: 'Text Modifiers',
                tags: [
                    {
                        name: 'Bold',
                        short: 'b',
                        tag: '\'\'_$\'\''
                    },

                    {
                        name: 'Italic',
                        short: 'i',
                        tag: '\'\'\'_$\'\'\''
                    },

                    {
                        name: 'Small',
                        short: 'sm',
                        tag: '<small>_$</small>'
                    },

                    {
                        name: 'Superscript',
                        short: 'sup',
                        tag: '<sup>_$</sup>'
                    },

                    {
                        name: 'Subscript',
                        short: 'sub',
                        tag: '<sub>_$</sub>'
                    },

                    {
                        name: 'S',
                        short: 's',
                        tag: '<s>_$</s>'
                    },

                    {
                        name: 'Level 2 Headline',
                        short: 'h2',
                        tag: '==_$=='
                    },

                    {
                        name: 'Bulleted List',
                        short: 'ul',
                        tag: '#',
                        extend: function( limit ){

                            limit = Number( limit );

                            var result = '';
                            if( !isNaN( limit ) && typeof limit === 'number' ){

                                for (var i = 0; i < limit - 1; i++){

                                    result +='\n#';
                                }
                            }
                            return result;
                        }
                    },

                    {
                        name: 'Blockquote',
                        short: 'bq',
                        tag: '<blockquote>_$</blockquote>'
                    }
                ]
            },

            {
                name: 'Wiki Markup',
                tags: [

                    {
                        name: 'Link (external)',
                        short: 'ex',
                        tag: '[http://_$]',
                        extend: function( url, title ){

                                var result = '';
                                if( url ) {result += url.replace( 'http://', '' );}
                                if( title ) {result += ' ' + title;}
                                return result;
                            }
                    },

                    {
                        name: 'Link (internal)',
                        short: 'in',
                        tag: '[[_$]]'
                    },

                    {
                        name: 'File',
                        short: 'f',
                        tag: '[[File:_$]]',
                        extend: function( path ){

                            var result = '';

                            if( path ) {
                                path += '';
                                result += path.replace( 'http://', '' );
                            }
                            return result;
                        }
                    },

                    {
                        name: 'Media',
                        short: 'm',
                        tag: '[[Media:_$]]'
                    },

                    {
                        name: 'Category',
                        short: 'c',
                        tag: '[[Category:_$]]'
                    },

                    {
                        name: 'Redirection',
                        short: 'r',
                        tag: '#Redirect[[_$]]'
                    },

                    {
                        name: 'Math Formula',
                        short: 'mth',
                        tag: '<math>_$</math>'
                    },

                    {
                        name: 'Code',
                        short: 'cod',
                        tag: '<code>_$</code>'
                    },

                    {
                        name: 'Ignore Wiki',
                        short: 'no',
                        tag: '<nowiki>_$</nowiki>'
                    },

                    {
                        name: 'Username + time',
                        short: 'u',
                        tag: '~~~~'
                    },

                    {
                        name: 'Horizontal Line',
                        short: 'l',
                        tag: '--_$--'
                    },

                    {
                        name: 'Strike',
                        short: 'str',
                        tag: '<strike>_$</strike>'
                    },

                    {
                        name: 'Hidden comment',
                        short: 'h',
                        tag: '<!-- _$ -->'
                    },

                    {
                        name: 'Reference',
                        short: 'ref',
                        tag: '<ref>_$</ref>'
                    },

                    {
                        name: 'Include Only',
                        short: 'inc',
                        tag: '<includeonly></includeonly>'
                    },

                    {
                        name: 'No Include',
                        short: 'ninc',
                        tag: '<noinclude>_$</noinclude>'
                    }
                ]
            },

            {
                name: 'Features and Media',
                tags: [

                    {
                        name: 'Gallery',
                        short: 'gal',
                        tag: '<gallery>_$</gallery>'
                    }
                ]
            }

        ]
    };

    //adds custom tag to the tags dictionary & saves it to localStorage ToDo
    function addCustom( tag ){

        var cTags = JSON.parse( localStorage.getItem( 'cTags' ) );
    }

    //finds tag object in the dictionary
    function findTag ( tagShort ){

        for( var i = 0; i < taglist.tags.length; i++ ){

            for( var j = 0; j < taglist.tags[i].tags.length; j++ ){

                if( taglist.tags[i].tags[j].short === tagShort ){

                    return taglist.tags[i].tags[j];
                }
            }
        }
        return false;
    }

    //makes all the links in the tagList insert it's tag
    function initLinks(){

        wrapper.addEventListener( 'click', function(){

            if( event.target.tagName === 'A' && event.target.hasAttribute( 'data-tag' ) ){

                editor.insert( event.target.getAttribute( 'data-tag' ) );
            }
        } );
    }

    //check if user possible wrote snippet <special_char><tag_shortcut><special_char>
    function handleSnippets( textBox, patterns, insert){

        //ignore if anything else than snippet pattern given
        if( textBox.value[textBox.selectionStart-1] !== patterns.snippetChar ) {return;}
        var endPos = textBox.selectionStart - 1;

        //look if there is a snippet opener
        if( !textBox.value.substring( 0, endPos - 1 ).match( patterns.snippetChar ) ) {return;}
        var startPos = textBox.value.substring( 0, endPos).lastIndexOf( patterns.snippetChar );

        var phrase = textBox.value.substring( startPos+1, endPos );
        if( phrase.match( patterns.snippetBreakers ) ) {return;}

        var isExt = false;
        var tag;

        if( phrase.indexOf( patterns.extChar ) !== -1 ){

            tag = findTag( phrase.substring( 0, phrase.indexOf( patterns.extChar ) ) );
            isExt = true;
        }else{

            tag = findTag( phrase );
        }

        if( tag ){

            var ext = '',
                phr = tag.tag,
                phrTab,
                extTab;

            if( isExt && phr.indexOf( patterns.caret ) ){

                phrTab = phr.split( patterns.caret );
                extTab = phrase.split( patterns.extChar );
                extTab.splice( 0, 1 );
                ext = ( tag.extend ) ? tag.extend.apply( tag, extTab ) : ext;
            }

            var sel = textBox.selectionStart;
            textBox.value = textBox.value.substring( 0, startPos ) +
                textBox.value.substring( endPos + 1 );

            textBox.selectionStart = textBox.selectionEnd  = sel - ( endPos + 1 - startPos );
            if( phrTab && isExt) {mw-anon-edit-warning

                var ending = ( phrTab[1] ) ? phrTab[1] : '';
                insert( phrTab[0] + ext + ending );
            }else {

                insert( phr + ext );
            }
        }
    }
    
    //module initializer
    function init(){

        editor.init( handleSnippets );

        loader({

            type: loader.MULTI,
            resources: {
                mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_tagList.mustache'
            }
        }).done(function(resp){

                wrapper.innerHTML = mustache.render(resp.mustache[0], taglist);

                initLinks();

            });

    }

    return {

        init: init
    };

} );

document.addEventListener('DOMContentLoaded', function(){

    require(['config'], function(config){

        config.init();
    });
});