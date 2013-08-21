define('menu', ['pubsub'], function(pubsub){

    var menuLeft,
        menuRight,
        rMin = 50,
        rMax = 100,
        minMove = 20;

    function menuObj(wrapperId){ //constructor for menu object, parameter = div wrapper for menu
        var wrapper = document.getElementById(wrapperId);
        this.wrapper = wrapper;
        this.master = wrapper.getElementsByClassName('master')[0]
        this.primary = {
            ul : wrapper.getElementsByTagName('ul')[0],
            elements : wrapper.getElementsByTagName('ul')[0].getElementsByTagName('li'),
            expanded : false
        };
        this.secondary = {
            ul : wrapper.getElementsByTagName('ul')[1],
            elements : wrapper.getElementsByTagName('ul')[1].getElementsByTagName('li'),
            expanded : false
        };
        this.activeElement = false;
    }

    function build(menuIdL, menuIdR){ //constructs 2 menu objects and adds references to each other
        menuLeft = new menuObj(menuIdL),
            menuRight = new menuObj(menuIdR);
        menuLeft.other = menuRight;
        menuRight.other = menuLeft;
    }

    function waitForTouch(menus){
        menus.forEach(function(menu){
            menu.master.addEventListener('touchstart', function aa(evt){
                onTouchStart(evt, menu);
            });
        });
    }

    function onTouchStart(event, menu){
        event.preventDefault();
        if(menu.other.primary.expanded || menu.other.secondary.expanded){
            switchMenu(menu.other);
        }
        else{
            switchMenu(menu);
            addListeners(menu);
        }
    }

    function addListeners(menu){
        menu.wrapper.addEventListener('touchmove', function tm(event){
            var x = event.changedTouches[0].clientX - getMasterPosition(menu).x,
                y = getMasterPosition(menu).y - event.changedTouches[0].clientY;
            event.preventDefault();
            if(Math.sqrt(x*x + y*y) > minMove){
                onMoveOut(menu, event.changedTouches[0]);
            }
        });

        menu.wrapper.addEventListener('touchend', function te(event){
            event.preventDefault();
            onTouchEnd(menu, event.changedTouches[0]);
            this.removeEventListener('touchend', te);
            this.removeEventListener('touchmove');
        });
    }

    function onTouchEnd(menu, changedTouch){
        var x = event.changedTouches[0].clientX - getMasterPosition(menu).x,
            y = getMasterPosition(menu).y - event.changedTouches[0].clientY,
            r = Math.sqrt(x*x+y*y);
        if(r > rMin && r < rMax){
            var activeElement = getActiveElement(menu, changedTouch.clientX, changedTouch.clientY);
            if(activeElement)action(activeElement);
        }
        reset(menu);
    }

    function action(li){
        pubsub.publish('insert', li.getAttribute('data-tag')); //TODO -> tag preparation!
    }

    function onMoveOut(menu, changedTouch){
        var activeElement = getActiveElement(menu, changedTouch.clientX, changedTouch.clientY);
        if(activeElement != menu.activeElement){
            if(activeElement) onActive(activeElement);
            if(menu.activeElement) onActiveOut(menu.activeElement);
            menu.activeElement = activeElement;
        }
    }

    function getActiveElement(menu, offsetLeft, offsetTop){
        var masterPos = getMasterPosition(menu),
            x = offsetLeft - masterPos.x,
            y = masterPos.y - offsetTop,
            angle = getAngle(x, y),
            range = getRange(angle, menu),
            activeElements = menu.secondary.expanded ? menu.secondary.elements : menu.primary.elements;
        if(range === -1) return false;
        return activeElements[range];
    }

    function onActive(li){
        li.classList.add('highlight');
    }

    function onActiveOut(li){
        li.classList.remove('highlight');
    }

    function getRange(angle, menu){
        var k = 0;
        if(menu === menuLeft){
            if(angle < 135 && angle > 99) return 0;
            if(angle < 99 && angle > 63) return 1;
            if(angle < 63 && angle > 27) return 2;
            if(angle < 27 && angle > 0 || angle > 351) return 3;
            if(angle < 351 && angle > 315) return 4;
            return -1;
        }
        if(angle < 225 && angle > 189) return 0;
        if(angle < 189 && angle > 153) return 1;
        if(angle < 153 && angle > 117) return 2;
        if(angle < 117 && angle > 81) return 3;
        if(angle < 81 && angle > 45) return 4;
        return -1;
    }

    function getAngle(x, y){
        var r = Math.sqrt(x*x + y*y);
        if(x > 0){
            if(y > 0) return Math.asin(y / r) * 180 / Math.PI;
            return 360 - Math.asin(- y / r) * 180 / Math.PI;
        }
        if(y > 0){
            return 180 - Math.asin( y / r) * 180 / Math.PI;
        }
        return 180 + Math.asin( - y / r) * 180 / Math.PI;
    }

    function getMasterPosition(menu){
        return{
            x : menu.master.getBoundingClientRect().left + menu.master.offsetWidth / 2,
            y : menu.master.getBoundingClientRect().top + menu.master.offsetHeight / 2
        }
    }

    function switchMenu(menu){
        if(menu.primary.expanded){
            fold(menu.primary);
            expand(menu.secondary);
        }
        else{
            if(menu.secondary.expanded){
                fold(menu.secondary);
            }
            expand(menu.primary);
        }
    }

    function reset(menu){
        if(menu.activeElement){
            onActiveOut(menu.activeElement);
            menu.activeElement = false;
        }
        fold(menu.primary);
        fold(menu.secondary);
        menu.wrapper.removeEventListener('touchend');
        menu.wrapper.removeEventListener('touchmove');
    }

    function expand(ul){
        ul.ul.classList.remove('minified');
        ul.expanded = true;
    };

    function fold(ul){
        ul.ul.classList.add('minified');
        ul.expanded = false;
    };

    pubsub.subscribe('menuUpdate', function(activeTags){
        attachTags(activeTags);
    });

    function updateButton (li, tag){
        li.setAttribute('data-tag', tag.tag);
        li.getElementsByTagName('span')[0].innerText = tag.abbr;
    }

    function getLi(index){
        var prmLeft = menuLeft.primary.elements.length,
            prmRight = menuRight.primary.elements.length,
            secLeft = menuLeft.secondary.elements.length,
            secRight = menuRight.secondary.elements.length;
        if(!(index+1) || index >= prmLeft + prmRight + secLeft + secRight) return false;
        if(index < prmLeft) return menuLeft.primary.elements[index];
        index -= prmLeft;
        if(index < prmRight) return menuRight.primary.elements[index];
        index -= prmRight;
        if(index < secLeft) return menuLeft.secondary.elements[index];
        index -= secLeft;
        return menuRight.secondary.elements[index];
    }

    function attachTags(tags){
        var i = 0, currentLi;
        for(var key in tags){
            currentLi = getLi(i);
            if(tags.hasOwnProperty(key) && currentLi){
                updateButton(currentLi, tags[key]);
                i++;
            }
        }
    }

    function init(){
        build('menuLeft', 'menuRight');
        waitForTouch([menuLeft, menuRight]);
    }

    return{
        init: init
    }
});
