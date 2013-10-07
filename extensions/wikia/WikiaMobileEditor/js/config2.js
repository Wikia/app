/*global define */
/**
 * listing & transmitting tags between modules handler
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'config', ['menu', 'editor', 'wikia.mustache', 'wikia.loader', 'toast'], function(menu, editor, mustache, loader, toast){

    'use strict';

    var wrapper = document.getElementsByClassName( 'tagListWrapper' )[0];

    //list of tags currently in the menu
    var active = [];

    var taglist = {

        tags: [

            {
                name: "Text Modifiers",
                tags: [
                    {
                        name: "Bold",
                        short: "b",
                        tag: "''_$''"
                    },

                    {
                        name: "Italic",
                        short: "i",
                        tag: "'''_$'''"
                    },

                    {
                        name: "Small",
                        short: "sm",
                        tag: "<small>_$</small>"
                    },

                    {
                        name: "Superscript",
                        short: "sup",
                        tag: "<sup>_$</sup>"
                    },

                    {
                        name: "Subscript",
                        short: "sub",
                        tag: "<sub>_$</sub>"
                    },

                    {
                        name: "Level 2 Headline",
                        short: "h2",
                        tag: "==_$=="
                    },

                    {
                        name: "Blockquote",
                        short: "bq",
                        tag: "<blockquote>_$</blockquote>"
                    }
                ]
            },

            {
                name: "Wiki Markup",
                tags: [

                    {
                        name: "Link (external)",
                        short: "ex",
                        tag: "[http://_$]"
                    },

                    {
                        name: "Link (internal)",
                        short: "in",
                        tag: "[[_$]]"
                    },

                    {
                        name: "File",
                        short: "f",
                        tag: "[[File:_$]]"
                    },

                    {
                        name: "Media",
                        short: "m",
                        tag: "[[Media:_$]]"
                    },

                    {
                        name: "Category",
                        short: "c",
                        tag: "[[Category:_$]]"
                    },

                    {
                        name: "Redirection",
                        short: "r",
                        tag: "#Redirect[[_$]]"
                    },

                    {
                        name: "Math Formula",
                        short: "mth",
                        tag: "<math>_$</math>"
                    },

                    {
                        name: "Ignore Wiki",
                        short: "no",
                        tag: "<nowiki>_$</nowiki>"
                    },

                    {
                        name: "Username + time",
                        short: "u",
                        tag: "~~~~"
                    },

                    {
                        name: "Horizontal Line",
                        short: "l",
                        tag: "--_$--"
                    },

                    {
                        name: "Strike",
                        short: "str",
                        tag: "<strike>_$</strike>"
                    },

                    {
                        name: "Hidden comment",
                        short: "h",
                        tag: "<!-- _$ -->"
                    },

                    {
                        name: "Reference",
                        short: "ref",
                        tag: "<ref>_$</ref>"
                    },

                    {
                        name: "Include Only",
                        short: "inc",
                        tag: "<includeonly></includeonly>"
                    },

                    {
                        name: "No Include",
                        short: "ninc",
                        tag: "<noinclude>_$</noinclude>"
                    }
                ]
            },

            {
                name: "Features and Media",
                tags: [

                    {
                        name: "Gallery",
                        short: "gal",
                        tag: "<gallery>_$</gallery>"
                    }
                ]
            }

        ]
    }

    //toast message handler
    function alarm( type, data ){

        switch(type){

            case 'tag-add-success' :
                toast.show( 'You just added "' + ( ( data.short ) ? data.short + '" ' : '' ) + 'tag to the menu.'
                    + '\n' + 'Menu fulfillment: ' + active.length + ' / ' + menu.limit ); break;

            case 'tag-add-error' :
                toast.show( 'Error adding "' + ( ( data.short ) ? data.short + '" ' : '' ) + 'tag to the menu.'
                    + '\n' + 'Menu fulfillment: ' + active.length + ' / ' + menu.limit ); break;

            case 'tag-remove' :
                toast.show( 'You just removed "' + ( ( data.short ) ? data.short + '" ' : '' ) + 'tag from the menu.'
                    + '\n' + 'Menu fulfillment: ' + active.length + ' / ' + menu.limit ); break;

            case 'no-tag' :
                toast.show( 'Tag "' + ( ( data.short ) ? data.short + '" ' : '' ) + ' is not in the menu.' ); break;

            case 'start-message' :
                toast.show( 'Use checkboxes in tag lists below to add items to the animated menu. You can ' +
                    'also define custom tags.' ); break;

            default: break;
        }
    }

    //adds tag to the animated menu
    function addToMenu( tag ){

        if( active.length < menu.limit ){

            for( var i = 0; i < active.length; i++ ){

                if( active[i].short === tag.short ) return false;
            }
            active.push( tag );
            menu.update( active );
            return true;
        }
        return false;
    }

    //removes tag from the animated menu
    function remove( short ){

        for( var i = 0; i < active.length; i++ ){

            if( active[i].short === short ){

                active.splice(i, 1);
                menu.update( active );
                return true;
            }
        }
        return false;
    }

    //marks a group of chosen tags in the taglist
    function markTags( tagArr ){

        for( var i = 0; i < tagArr.length; i++ ){

            mark( findItem( tagArr[i] ) );
        }
    }

    //finds a list item containing given tag
    function findItem( tag ){

        var el = document.getElementById(tag.short).parentElement;
        return( el.tagName === 'LI' ) ? el : false;
    }

    //marks a list item
    function mark( item ){

        if( item && !item.classList.contains( 'marked' ) ){

            var chb = item.getElementsByTagName( 'input' )[0];

            chb.checked = true;

            item.classList.add( 'marked' );
        }
    }

    //clears previously given mark
    function clear( item ){

        if( item && item.classList.contains( 'marked' ) ){

            var chb = item.getElementsByTagName( 'input' )[0];

            chb.checked = false;

            item.classList.remove( 'marked' );
        }
    }

    //handles checkbox changes

    function onCheck ( chb ){

        if( chb.checked ){

            if( !addToMenu( findTag( chb.id ) ) ){

                alarm( "tag-add-error", {short: chb.id});
                chb.checked = false;
            }else{

                alarm( "tag-add-success", {short: chb.id});
                mark( chb.parentElement );
            }

        }else{

            if( !remove( chb.id ) ){

                chb.checked = false;
            }else{
                alarm( "tag-remove", {short: chb.id});
                clear( chb.parentElement );
            }
        }
    }

    //adds custom tag to the tags dictionary & saves it to localStorage ToDo
    function addCustom( tag ){

        var cTags = JSON.parse( localStorage.getItem( 'cTags' ) );
    }

    //finds tag object in the dictionary
    function findTag ( short ){

        for( var i = 0; i < taglist.tags.length; i++ ){

            for( var j = 0; j < taglist.tags[i].tags.length; j++ ){

                if( taglist.tags[i].tags[j].short === short ){

                    return taglist.tags[i].tags[j];
                }
            }
        }
        return false;
    }

    //makes all the links in the tagList insert it's tag
    function initLinks(){

        wrapper.addEventListener( 'click', function( evt ){

            if( evt.target.tagName === 'A' && evt.target.hasAttribute( 'data-tag' ) ){

                editor.insert( evt.target.getAttribute( 'data-tag' ) );
            }
        } );
    }

    //check if user possible wrote snippet <special_char><tag_shortcut><special_char>
    function handleSnippets( textBox, patterns, insert ){

        //ignore if anything else than snippet pattern given
        if( textBox.value[textBox.selectionStart-1] != patterns.snippetChar ) return;
        var endPos = textBox.selectionStart - 1;

        //if there is no special snippet char within 6 last items (max snippet length = 5)
        if( !textBox.value.substring( endPos - 5, endPos - 1 ).match( patterns.snippetChar ) ) return;
        var startPos = textBox.value.substring( 0, endPos).lastIndexOf( patterns.snippetChar );

        var phrase = textBox.value.substring( startPos+1, endPos );
        if( phrase.match( patterns.snippetBreakers ) ) return;

        var tag = findTag( phrase);

        if( tag ){

            var sel = textBox.selectionStart;
            textBox.value = textBox.value.substring( 0, startPos ) +
                textBox.value.substring( endPos + 1 );

            textBox.selectionStart = textBox.selectionEnd  = sel - ( endPos + 1 - startPos );

            insert( tag.tag );
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

                var markup = mustache.render(resp.mustache[0], taglist);
                wrapper.innerHTML = markup;
                debugger;
                //menu initializing tags from lS or default ones
                active = [
                        taglist.tags[1].tags[13],
                        taglist.tags[0].tags[1],
                        taglist.tags[0].tags[2],
                        taglist.tags[0].tags[3],
                        taglist.tags[0].tags[4],
                        taglist.tags[0].tags[5],
                        taglist.tags[0].tags[6],
                        taglist.tags[1].tags[0],
                        taglist.tags[1].tags[1],
                        taglist.tags[1].tags[2],
                        taglist.tags[1].tags[3],
                        taglist.tags[1].tags[4],
                        taglist.tags[1].tags[5],
                        taglist.tags[1].tags[6],
                        taglist.tags[1].tags[7],
                        taglist.tags[1].tags[8],
                        taglist.tags[1].tags[9],
                        taglist.tags[1].tags[10],
                        taglist.tags[1].tags[11],
                        taglist.tags[1].tags[12],
                ]

                markTags( active );

                initLinks();

                menu.init();

                menu.update( active );

                alarm( 'start-message' );

                document.addEventListener( 'click', function( evt ){

                    if( evt.srcElement.tagName === 'INPUT' && evt.target.id ){

                        onCheck( evt.srcElement );
                    };
                } );
            });

    }

    return {

        init: init
    }

} );