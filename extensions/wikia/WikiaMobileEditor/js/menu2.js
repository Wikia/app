/*global define */
/**
 * quick access menu handling
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'menu', ['editor'], function(){

    var tags = localStorage.getItem( 'wkTags' ) || {
        //default tags
    };

    //active menu-item indicator
    var activeItem = null;

    function Menu( wrapperID ){

        //wrapper element for menu
        this.wrapper = document.getElementById( wrapperID );

        //main button
        this.master = this.wrapper.getElementsByClassName( 'master' )[0];

        //primary menu (ul + li elements + flag indicating if it's visible)
        this.primary = {};
        this.primary.ul = this.wrapper.getElementsByClassName( 'primary' )[0];
        this.primary.li = this.primary.ul.getElementsByTagName( 'li' );
        this.primary.expanded = false;

        //secondary menu (ul + li elements + flag indicating if it's visible)
        this.secondary = {};
        this.secondary.ul = this.wrapper.getElementsByClassName( 'secondary' )[0];
        this.secondary.li = this.secondary.ul.getElementsByTagName( 'li' );
        this.secondary.expanded = false;
    }

    //toggles expanded submenu
    function toggle( menu ){

        if( menu.primary.expanded ){
            menu.primary.expanded = false;
            menu.primary.classList.toggle( 'off' );
            menu.secondary.expanded = true;
            menu.secondary.classList.toggle( 'off' );
            return;
        }

        if( menu.secondary.expanded ){
            menu.secondary.expanded = false;
            menu.secondary.classList.toggle( 'off' );
        }
        menu.primary.expanded = true;
        menu.primary.toggle( 'off' );
        return;
    }

    //returns an element that the finger is pointing at if it's a menu-item
    function getItem( x, y ){

        var item = document.elementFromPoint( x, y );

        //if target === anchor inside li, normalize item to be li
        if( item.parentElement.classList.contains('menuItem') ) item = item.parentElement;
        return ( item.classList.contains( 'menu-item' ) ) ? item : false;
    }

    //inserts the tag from pointed element to the textBox
    function insert( anchor ){

        editor.insert(  anchor.getAttribute( 'data-tag' ) );
    }

    //determines what happens after touchstart on a master button
    function onTouchstart( menu ){

        if( menu.other.primary.expanded || menu.other.secondary.expanded )
            toggle( menu.other );

        else
            activate( menu );

    }

    //expands menu and waits for user interaction with it
    function activate( menu ){

        toggle( menu );
        menu.wrapper.addEventListener( 'touchmove', onTouchmove );
        menu.wrapper.addEventListener( 'touchend', onTouchend );
    }

    function hide( menu ){

        menu.primary.expanded = menu.secondary.expanded = false;
        if( !menu.primary.ul.classList.contains( 'off' ) ) menu.primary.ul.classList.add('off');
        if( !menu.secondary.ul.classList.contains( 'off' ) ) menu.secondary.ul.classList.add('off');
    }

    //if user is pointing at an item, it triggers highliter / animator function and marks it
    function onTouchmove( evt ){

        var item = getItem( evt.changedTouches[0].pageX, evt.changedTouches[0].pageY );
        if( item && ( item.type === 'LI' || item.type ) ){
            activeItem = item;
            animate( item );
        }else{
            activeItem = null;
        }
    }

    //checks if user pointed an item (insertion), folds menu and removes unnecesary listeners
    function onTouchend( evt ){

        var menu = ( this.id === 'menuLeft' ) ? menuLeft : menuRight;
        var item = getItem( evt.changedTouches[0].pageX, evt.changedTouches[0].pageY );
        if( item ){

            insert( item );
        }else{

            activeItem = null;
        }
        this.removeEventListener('touchmove', onTouchmove);
        this.removeEventListener('touchend', onTouchend);
    }

    //initializes 2 menu handler objects with references to each other and triggers interaction
    function init(){

        var menuLeft = new Menu('menuLeft');
        var menuRight = new Menu('menuRight');
        menuLeft.other = menuRight;
        menuRight.other = menuLeft;
        document.addEventListener( 'touchstart', function(){
            if( event.target.classList.contains( 'menu' ) ){

                onTouchstart( ( event.target.id === 'menuLeft' ) ? menuLeft : menuRight );
            }
        } );
    }

    return{

        init : init
    }
} );
