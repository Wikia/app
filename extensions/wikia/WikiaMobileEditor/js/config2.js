/*global define */
/**
 * listing & transmitting tags between modules handler
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'config', ['menu', 'editor', 'wikia.mustache', 'wikia.loader'], function(menu, editor, mustache, loader){

    tags = [

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

    //list of wikitext tags & special chars, extendable
    var tags = {
        'Text Modifiers' : {
            'Bold' : {
                tag : "''_$''",
                short : 'b',
            },
            'Italic' : {
                tag : "'''_$'''",
                short : 'i',
            },
            'Small' : {
                tag : "<small>_$</small>",
                short : 'sm',
            },
            'Superscript' : {
                tag : "<sup>_$</sup>",
                short : 'sup',
            },
            'Subscript' : {
                tag : "<sub>_$</sub>",
                short : 'sub',
            },
            'Level 2 Headline' : {
                tag : "==_$==",
                short : 'h2',
            },
            'Blockquote' : {
                tag : "<blockquote>_$</blockquote>",
                short : 'qte',
            },
        },
        'Wiki Markup' : {
            'Internal Link' : {
                tag : "[[_$]]",
                short : 'int',
            },
            'External Link' : {
                tag : "[http://_$ title]",
                short : 'ext',
            },
            'Embedded File' : {
                tag : "[[File:_$]]",
                short : 'file',
            },
            'Media File Link' : {
                tag : "[Media:_$]",
                short : 'med',
            },
            'Math Formula' : {
                tag : "<math>_$</math>",
                short : 'math',
            },
            'Ignore Wiki' : {
                tag : "<nowiki>_$</nowiki>",
                short : 'ign',
            },
            'Username And Time' : {
                tag : "~~~~",
                short : 'usr',
                display : 'Username and time'
            },
            'Horizontal Line' : {
                tag : "----",
                short : 'hrzl',
            },
            'Strike' : {
                tag : "<strike>_$</strike>",
                short : 'str',
            },
            'Hidden Comment' : {
                tag : "<!-- _$ -->",
                short : 'hdn',
            },
            'Category' : {
                tag : "[[Category:_$]]",
                short : 'cat',
            },
            'Redirect' : {
                tag : "#REDIRECT[[_$]]",
                short : 'red',
            },
            'Reference' : {
                tag : "<ref>_$</ref>",
                short : 'ref',
            },
            'Include Only' : {
                tag : "<includeonly>_$</includeonly>",
                short : 'incl',
            },
            'No Include' : {
                tag : "<noinclude>_$</noinclude>",
                short : 'noinc',
            }
        },
        'Special Characters' : {
            'title' : {
                tag : '#hello',
                short : 'hel',
            },
            'title2' : {
                tag : '#hello2',
                short : 'hel2',
            }
        },
        'Features And Media' : {
            'Gallery' : {
                tag : "<gallery>Image:_$|Caption</gallery>",
                short : 'gal'
            }
        }
    };


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

        menu.init();

        loader( {
            type: loader.MULTI,
            resources: {
                mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_tagList.mustache'
            }
        } ).done(function( resp ){
                console.log( mustache.render( resp.mustache[0], tags ) );
            } );

        markInitialTags();

        //ToDo -> mustache render here
    }

    return {

        init: init
    }

} );