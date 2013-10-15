/*global define */
/**
 * quick access menu handling
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'menu', ['editor', 'jquery'], function( editor, $ ){

    //objects storing data for menus
    var menuLeft, menuRight;

    //number of places in the menus overall
    var limit = 20;

    //active menu-item indicator
    var activeItem = null;

    function Menu( wrapperID ){

        //temp DOM menu wrapper
        var wrp = document.getElementById( wrapperID );

        //wrapper element for menu
        this.wrapper = wrp;

        //main button
        this.master = wrp.getElementsByClassName( 'master' )[0];

        //primary menu (ul + li elements + flag indicating if it's visible)
        this.primary = {};
        this.primary.ul = wrp.getElementsByClassName( 'primary' )[0];
        this.primary.li = wrp.getElementsByClassName( 'primary' )[0].getElementsByTagName( 'li' );
        this.primary.expanded = false;

        //secondary menu (ul + li elements + flag indicating if it's visible)
        this.secondary = {};
        this.secondary.ul = wrp.getElementsByClassName( 'secondary' )[0];
        this.secondary.li = wrp.getElementsByClassName( 'secondary' )[0].getElementsByTagName( 'li' );
        this.secondary.expanded = false;
    }

    //toggles expanded submenu
    function toggle( menu ){

        if( menu.primary.expanded ){

            menu.primary.expanded = false;
            menu.primary.ul.classList.toggle( 'minified' );
            menu.secondary.expanded = true;
            menu.secondary.ul.classList.toggle( 'minified' );
            return;
        }

        if( menu.secondary.expanded ){

            menu.secondary.expanded = false;
            menu.secondary.ul.classList.toggle( 'minified' );
        }

        menu.primary.expanded = true;
        menu.primary.ul.classList.toggle( 'minified' );
    }

    //refreshes menu elements and attaches new tags if present
    function update( tags ){

        var counter = 0;
        for( var i = 0; i < menuLeft.primary.li.length; i++ ){

            if( tags[counter] ){

                menuLeft.primary.li[i].setAttribute('data-tag', tags[counter].tag);
                menuLeft.primary.li[i].getElementsByTagName( 'a' )[0].innerText = tags[counter].short;
                counter++;
            }
            else{

                menuLeft.primary.li[i].setAttribute('data-tag', "");
                menuLeft.primary.li[i].getElementsByTagName( 'a' )[0].innerText = "";
                counter++;
            }
        }
        for( var j = 0; j < menuLeft.primary.li.length; j++ ){

            if( tags[counter] ){

                menuLeft.secondary.li[j].setAttribute('data-tag', tags[counter].tag);
                menuLeft.secondary.li[j].getElementsByTagName( 'a' )[0].innerText = tags[counter].short;
                counter++;
            }
            else{

                menuLeft.secondary.li[j].setAttribute('data-tag', "");
                menuLeft.secondary.li[j].getElementsByTagName( 'a' )[0].innerText = "";
                counter++;
            }
        }
        for( var k = 0; k < menuLeft.primary.li.length; k++ ){

            if( tags[counter] ){

                menuRight.primary.li[k].setAttribute('data-tag', tags[counter].tag);
                menuRight.primary.li[k].getElementsByTagName( 'a' )[0].innerText = tags[counter].short;
                counter++;
            }
            else{

                menuRight.primary.li[k].setAttribute('data-tag', "");
                menuRight.primary.li[k].getElementsByTagName( 'a' )[0].innerText = "";
                counter++;
            }
        }
        for( var l = 0; l < menuLeft.primary.li.length; l++ ){

            if( tags[counter] ){

                menuRight.secondary.li[l].setAttribute('data-tag', tags[counter].tag);
                menuRight.secondary.li[l].getElementsByTagName( 'a' )[0].innerText = tags[counter].short;
                counter++;
            }
            else{

                menuRight.secondary.li[l].setAttribute('data-tag', "");
                menuRight.secondary.li[l].getElementsByTagName( 'a' )[0].innerText = "";
                counter++;
            }
        }
    }

    //returns an element that the finger is pointing at if it's a menu-item
    function getItem( x, y ){

        var item = document.elementFromPoint( x, y );

        //if target === anchor inside li, normalize item to be li
        if( item ){

            if( item.parentElement && item.parentElement.classList.contains('menuItem') )
                item = item.parentElement;
            return ( item.classList.contains( 'menuItem' ) ) ? item : false;
        }
        return false;
    }

    //inserts the tag from pointed element to the textBox
    function insert( item ){

        editor.insert(  item.getAttribute( 'data-tag' ) );
    }

    //determines what happens after touchstart on a master button
    function onTouchstart( menu ){

        if( menu.other.primary.expanded || menu.other.secondary.expanded )

            toggle( menu.other );

        else
            activate( menu );
    }

    //handles updating position of menu buttons on the page although textBox focus / blur
    function posChange(){

        //set position of the menus to absolute and
        function setAbs(){

            var top;
            menuLeft.wrapper.style.position = "absolute";
            menuRight.wrapper.style.position = "absolute";
            top = menuLeft.master.getBoundingClientRect().top + window.scrollY;
            menuLeft.wrapper.style.top = "0px";
            menuRight.wrapper.style.top = "0px";
            menuLeft.wrapper.style.webkitTransform = "translate(0, " + ( 60 + window.scrollY) + "px )";
            menuRight.wrapper.style.webkitTransform = "translate(0, " + ( 60 + window.scrollY) + "px )";
            menuLeft.wrapper.style.webkitTransformOrigin = "50% 0";
            menuRight.wrapper.style.webkitTransformOrigin = "50% 0";
            document.addEventListener( 'scroll', onScr);
        }

        function onScr( evt ){

            var diff = 60 + window.scrollY;
            debugger;
            var style = "translate( " + "0, " + diff + "px )";
            menuLeft.wrapper.style.webkitTransform = style;
            menuRight.wrapper.style.webkitTransform = style;
        }

        //clear style objects and return to position: fixed
        function setFix(){

            menuLeft.wrapper.setAttribute("style", "");
            menuRight.wrapper.setAttribute("style", "");
            menuLeft.wrapper.style.webkitTransform = "none";
            menuRight.wrapper.style.webkitTransform = "none";
            document.removeEventListener('scroll', onScr);
        }

        editor.textBox.addEventListener( 'focus', setAbs);
        editor.textBox.addEventListener( 'blur', setFix);
    }

    //expands menu and waits for user interaction with it
    function activate( menu ){

        toggle( menu );
        menu.wrapper.addEventListener( 'touchmove', onTouchmove );
        menu.wrapper.addEventListener( 'touchend', onTouchend );
    }

    function hide( menu ){

        menu.primary.expanded = menu.secondary.expanded = false;
        if( activeItem ){

            lightOff( activeItem );
            activeItem = null;
        }
        if( !menu.primary.ul.classList.contains( 'minified' ) ) menu.primary.ul.classList.add('minified');
        if( !menu.secondary.ul.classList.contains( 'minified' ) ) menu.secondary.ul.classList.add('minified');
    }

    //if user is pointing at an item, it triggers highlighter / animator function and marks it
    function onTouchmove( evt ){

        evt.preventDefault();

        var item = getItem( evt.changedTouches[0].clientX, evt.changedTouches[0].clientY );
        if( item ){

            lightOn( item );
            if( item !== activeItem){

                if(activeItem) lightOff( activeItem );
                activeItem = item;
            }
        }else{

            if(activeItem) lightOff( activeItem );
            activeItem = null;
        }
    }

    //highlight hovered menu item
    function lightOn( item ){

        if( !item.classList.contains( 'lightOn' ) ) item.classList.add( 'lightOn' );
    }

    //hide highlight when hover off
    function lightOff( item ){

        if( item.classList.contains( 'lightOn' ) ) item.classList.remove( 'lightOn' );
    }

    //checks if user pointed an item (insertion), folds menu and removes unnecessary listeners
    function onTouchend( evt ){

        evt.preventDefault();

        //extract object related to touched menu
        var menu = ( this.id === 'menuLeft' ) ? menuLeft : menuRight;

        //find potentially touched menu item
        var item = getItem( evt.changedTouches[0].clientX, evt.changedTouches[0].clientY );
        if( item ) insert( item );
        activeItem = null;
        this.removeEventListener( 'touchmove', onTouchmove );
        this.removeEventListener( 'touchend', onTouchend );
        hide( menu );
    }

    //initializes 2 menu handler objects with references to each other and triggers interaction
    function init(){

        menuLeft = new Menu('menuLeft');
        menuRight = new Menu('menuRight');

        menuLeft.other = menuRight;
        menuRight.other = menuLeft;

        //function switching between custom scroll and position fixed (fix for iOS keyboard-on feature)
        posChange();

        //when one of the master button touched, perform further actions
        document.addEventListener( 'touchstart', function( evt ){

            var master, menu;

            if( evt.srcElement && evt.srcElement.classList.contains( 'master' ) ){

                master = evt.srcElement;
            }else{

                if( evt.srcElement.parentElement && evt.srcElement.parentElement.classList.contains( 'master' ) ){

                    master = srcElement.parentElement;
                }
            }
            if(master){

                evt.preventDefault();
                menu = ( menuLeft.wrapper.getElementsByClassName( 'master' )[0] === master ) ? menuLeft : menuRight;
                onTouchstart( menu );
            }
        } );
    }

    return{

        init : init,
        update: update,
        limit: limit
    }
} );
