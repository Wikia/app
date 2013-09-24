/*global define */
/**
 * listing & transmitting tags between modules handler
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'config', ['menu', 'editor', 'wikia.mustache', 'wikia.loader'], function(menu, editor, mustache, loader){

    'use strict';

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
                    short: "m",
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

    //toast message shower
    function alarm( type, data ){

        switch(type){

            case 'tag-add-success' :
                toast.show( 'You just added ' + ( ( data.short ) ? data.short + ' ' : '' ) + 'tag to the menu'
                    + '\n' + 'Menu fulfillment: ' + menu.tags.length + ' / ' + menu.maxItems ); break;

            case 'tag-add-error' :
                toast.show( 'Error adding ' + ( ( data.short ) ? data.short + ' ' : '' ) + 'tag to the menu'
                    + '\n' + 'Menu fulfillment: ' + menu.tags.length + ' / ' + menu.maxItems ); break;

            case 'tag-remove' :
                toast.show( 'You just removed ' + ( ( data.short ) ? data.short + ' ' : '' ) + 'tag to the menu'
                    + '\n' + 'Menu fulfillment: ' + menu.tags.length + ' / ' + menu.maxItems ); break;

            case 'no-tag' :
                toast.show( 'Tag ' + ( ( data.short ) ? data.short + ' ' : '' ) + ' is not in the menu' ); break;

            case 'start-message' :
                toast.show( 'Use checkboxes in tag lists below to add items to the animated menu. You can ' +
                    'also define custom tags.' ); break;

            default: break;
        }
    }

    //adds tag to the animated menu
    function add( tag ){

        if( menu.tags[tag.short] ){
            menu.tags[tag.short] = tag;
            return true;
        }
        return false;
    }

    //removes tag from the animated menu
    function remove( tag ){

    }

    //marks tags that are in the menu at webpage start
    function markInitialTags(){

        if( !menu.tags ) return;
        for( var tag in tags ){

            //marks the cell with current tag in taglists
            mark( findItem( tags[tag] ) );
        }
    }

    //finds a list item containing given tag
    function findItem( tag ){

        var el = document.getElementById(tag.short).parentElement;
        return( el.type === 'LI' ) ? el : false;
    }

    //marks / unmarks a list item
    function mark( item ){

        if( item && !item.classList.contains( 'marked' ) ){

            item.classList.add( 'marked' );
        }
    }

    //clears previously given mark
    function clear( item ){

        if( item && item.classList.contains( 'marked' ) ){

            item.classList.remove( 'marked' );
        }
    }

    //adds custom tag to the tags dictionary & saves it to localStorage if
    function addCustom( tag ){
        var cTags = JSON.parse( localStorage.getItem( 'cTags' ) );

    }

    //module initializer
    function init(){

        //menu.init();

        loader({

            type: loader.MULTI,
            resources: {
                mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_tagList.mustache'
            }
        }).done(function(resp){

                console.log(mustache.render(resp.mustache[0], taglist))
            });

        markInitialTags();

    }

    return {

        init: init
    }

} );