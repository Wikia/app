define('menu', ['pubsub', 'editor', 'device'], function(pubsub, editor, device){

    var menuLeft,
        menuRight,
        rMin = 50,
        rMax = 100,
        minMove = 20,
        wrapper = document.getElementsByClassName('wrapper')[0],
        shadow = wrapper.getElementsByClassName('shadow')[0],
        tags = JSON.parse(localStorage.getItem('tags')) || {};

    function menuObj(wrapperId){ //constructor for menu object, parameter = div wrapper for menu
        var myWrapper = document.getElementById(wrapperId);
        this.wrapper = myWrapper;
        this.master = myWrapper.getElementsByClassName('master')[0]
        this.primary = {
            ul : myWrapper.getElementsByTagName('ul')[0],
            elements : myWrapper.getElementsByTagName('ul')[0].getElementsByTagName('li'),
            expanded : false
        };
        this.secondary = {
            ul : myWrapper.getElementsByTagName('ul')[1],
            elements : myWrapper.getElementsByTagName('ul')[1].getElementsByTagName('li'),
            expanded : false
        };
        this.activeElement = false;
    }

    function build(menuIdL, menuIdR){ //constructs 2 menu objects and adds references to each other
        menuLeft = new menuObj(menuIdL);
        menuRight = new menuObj(menuIdR);
        menuLeft.other = menuRight;
        menuRight.other = menuLeft;
    }

    function waitForTouch(menus){
            document.addEventListener('touchstart', function(evt){
                if(evt.target.classList.contains('master')){
                    var curMenu = evt.target.parentElement.classList.contains('left') ? menuLeft : menuRight;
                    onTouchStart(evt, curMenu);
                }
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
            moveShadow(event);
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

    function hold(){
        var bound = editor.editArea.getBoundingClientRect();
        if(window.innerHeight - bound.top > 80
            && bound.bottom > 10){
                //if(!wrapper.classList.contains('on'))wrapper.classList.add('on');
                if(wrapper.classList.contains('off'))wrapper.classList.remove('off');
        }
        else{
            if(!wrapper.classList.contains('off')){
                wrapper.classList.add('off');
            }
        }
    }

    function watchForScroll(){
        hold();
        window.addEventListener('scroll', function(){
            hold();
        });
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
        angle = 180-angle;
        if(menu === menuRight) angle+=99;
        if(angle < 0) angle +=360;
        return ~~((angle-47)/36);
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

    function moveShadow(evt){
        if(!shadow.classList.contains('shadowOn'))shadow.classList.add('shadowOn');
        shadow.style.webkitTransform = 'translate(' + (evt.targetTouches[0].pageX-25) + 'px, ' + (evt.targetTouches[0].pageY-25) + 'px)';
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
    }

    function fold(ul){
        ul.ul.classList.add('minified');
        ul.expanded = false;
    }

    pubsub.subscribe('menuUpdate', function(activeTags){
        attachTags(activeTags);
    });

    function updateButton (li, tag){
        li.setAttribute('data-tag', tag.tag);
        li.getElementsByTagName('a')[0].innerText = tag.abbr;
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

    function activateStaticMenu(){
        var menus = {left: menuLeft, right: menuRight};
        for(menu in menus){
            if(menus.hasOwnProperty(menu)){
                menus[menu].master.addEventListener('click', function(evt){
                    myMenu = this.parentElement.classList.contains('left')? 'left' : 'right';
                    evt.preventDefault();
                    if(menus[myMenu].other.primary.expanded){
                        menus[myMenu].other.primary.expanded = false;
                        menus[myMenu].other.primary.ul.classList.add('minified');
                        return;
                    }
                    else {
                        if(menus[myMenu].other.secondary.expanded){
                            menus[myMenu].other.secondary.expanded = false;
                            menus[myMenu].other.secondary.ul.classList.add('minified');
                            return;
                        }
                    }
                    if(menus[myMenu].primary.expanded){
                        menus[myMenu].primary.expanded = false;
                        menus[myMenu].primary.ul.classList.add('minified');
                        menus[myMenu].secondary.expanded = true;
                        menus[myMenu].secondary.ul.classList.remove('minified');
                        return;
                    }
                    if(menus[myMenu].secondary.expanded){
                        menus[myMenu].secondary.expanded = false;
                        menus[myMenu].secondary.ul.classList.add('minified');
                    }
                    menus[myMenu].primary.expanded = true;
                    menus[myMenu].primary.ul.classList.remove('minified');
                    return;
                });
                var lis = menus[menu].wrapper.getElementsByTagName('li');
                for(var i = 0; i < lis.length; i++){
                        lis[i].addEventListener('click', function(evt){
                            myMenu = this.parentElement.classList.contains('left')? 'left' : 'right';
                            evt.preventDefault();
                            editor.insertTags(this.getAttribute('data-tag'));
                            this.parentElement.classList.add('minified');
                            if(this.parentElement.classList.contains('primary')){
                                menus[myMenu]['primary'].expanded = false;
                            }
                            else{
                                menus[myMenu]['secondary'].expanded = false;
                            }
                        });
                }
            }
        }
    }

    function init(){
        build('menuLeft', 'menuRight');
        attachTags(tags);
        watchForScroll();
        if(device.handlesAnimatedMenu()){
            wrapper.classList.add('fancy');
            waitForTouch([menuLeft, menuRight]);
        }
        else{
            wrapper.classList.add('static');
            activateStaticMenu();
        }
    }

    return{
        init: init
    }
});
