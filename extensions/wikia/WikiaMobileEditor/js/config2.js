/*global define */
/**
 * listing & transmitting tags between modules handler
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'config', ['menu', 'editor', 'wikia.mustache', 'wikia.loader'], function(menu, editor, mustache, loader){

    //list of wikitext tags & special chars, extendable
    var tags = {

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

    }

    //marks / unmarks a list item
    function mark( item ){
        
    }

} );