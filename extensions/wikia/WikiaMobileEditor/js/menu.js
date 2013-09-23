define('menu', ['pubsub', 'editor', 'device', 'config'], function(pubsub, editor, device, config){

    var menuLeft,
        menuRight,
        rMin = 60,
        rMax = 110,
        minMove = 20,
        draggable = false,
        dragFlag = false,
        wrapper = document.getElementsByClassName('wrapper')[0],
        shadow = wrapper.getElementsByClassName('shadow')[0],
        userTags = {},
        defaultTags = {
            'b' : {
                tag : "''_$''",
                abbr : 'b',
                display : "'' ''"
            },
            'i' : {
                tag : "'''_$'''",
                abbr : 'i',
                display : "''' '''"
            },
            'sm' : {
                tag : "<small>_$</small>",
                abbr : 'sm',
                display : '&lt;small&gt;&lt;/small&gt;'
            },
            'sup' : {
                tag : "<sup>_$</sup>",
                abbr : 'sup',
                display : '&lt;sup&gt;&lt;/sup&gt;'
            },
            'sub' : {
                tag : "<sub>_$</sub>",
                abbr : 'sub',
                display : '&lt;sub&gt;&lt;/sub&gt;'
            },
            'h2' : {
                tag : "==_$==",
                abbr : 'h2',
                display : 'Level 2 Headline'
            },
            'qte' : {
                tag : "<blockquote>_$</blockquote>",
                abbr : 'qte',
                display : 'Blockquote'
            },
            'int' : {
                tag : "[[_$]]",
                abbr : 'int',
                display : '[[]]'
            },
            'ext' : {
                tag : "[http://_$ title]",
                abbr : 'ext',
                display : '[http:// title]'
            },
            'file' : {
                tag : "[[File:_$]]",
                abbr : 'file',
                display : '[[File:]]'
            },
            'med' : {
                tag : "[Media:_$]",
                abbr : 'med',
                display : '[Media:]'
            },
            'math' : {
                tag : "<math>_$</math>",
                abbr : 'math',
                display : '&lt;math&gt;_$&lt;/math&gt;'
            },
            'ign' : {
                tag : "<nowiki>_$</nowiki>",
                abbr : 'ign',
                display : '&lt;nowiki&gt;&lt;/nowiki&gt;'
            },
            'usr' : {
                tag : "~~~~",
                abbr : 'usr',
                display : 'Username and time'
            },
            'hrzl' : {
                tag : "----",
                abbr : 'hrzl',
                display : '----'
            },
            'str' : {
                tag : "<strike>_$</strike>",
                abbr : 'str',
                display : '&lt;strike&gt;_$&lt;/strike&gt;'
            },
            'hdn' : {
                tag : "<!-- _$ -->",
                abbr : 'hdn',
                display : '&lt;!-- _$ --&gt;'
            },
            'cat' : {
                tag : "[[Category:_$]]",
                abbr : 'cat',
                display : '[[Category:]]'
            },
            'red' : {
                tag : "#REDIRECT[[_$]]",
                abbr : 'red',
                display : 'REDIRECT[[]]'
            },
            'ref' : {
                tag : "<ref>_$</ref>",
                abbr : 'ref',
                display : '&lt;ref&gt;&lt;/ref&gt;'
            }
        }

    function menuObj(wrapperId){ //constructor for menu object, parameter = div wrapper for menu
        var myWrapper = document.getElementById(wrapperId);
        this.wrapper = myWrapper;
        this.master = myWrapper.getElementsByClassName('master')[0];
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

    function waitForTouch(){
            document.addEventListener('touchstart', function(evt){
                if(evt.target.classList.contains('master')){
                    var curMenu = evt.target.parentElement.classList.contains('left') ? menuLeft : menuRight;
                    onTouchStart(evt, curMenu);
                }
            });
    }

    function onDrag(event){
        distance = event.touches[0].pageY;
        if(distance > 50 && distance < (window.innerHeight - 50))
        menuLeft.wrapper.style.webkitTransform
            = menuRight.wrapper.style.webkitTransform
            = 'translate(0,' + (distance - getMasterPosition(menuLeft).y) + 'px)';
    }

    function onDragEnd(event){
        this.removeEventListener('touchmove', onDrag);
        this.removeEventListener('touchend', onDragEnd);
        draggable = false;
        dragFlag = false;
    }

    function touchEndBeforeDrag(){
        draggable = false;
        this.removeEventListener('touchend', touchEndBeforeDrag);
    }

    function onTouchStart(event, menu){
        event.preventDefault();
        if(menu.other.primary.expanded || menu.other.secondary.expanded){
            switchMenu(menu.other);
            draggable = true;
            menu.wrapper.addEventListener('touchend', touchEndBeforeDrag);
            setTimeout(function(){
                if(draggable){
                    menu.wrapper.removeEventListener('touchend', touchEndBeforeDrag);
                    menu.other.wrapper.removeEventListener('touchmove', onTouchMove);
                    menu.other.wrapper.removeEventListener('touchend', onTouchEnd);
                    if(!menu.other.primary.ul.classList.contains('minified')) menu.other.primary.ul.classList.add('minified');
                    if(!menu.other.secondary.ul.classList.contains('minified')) menu.other.secondary.ul.classList.add('minified');
                    menu.other.primary.expanded = menu.other.secondary.expanded = false;
                    menu.master.addEventListener('touchmove', onDrag);
                    menu.master.addEventListener('touchend', onDragEnd);
                }
            }, 1000)
        }
        else{
            switchMenu(menu);
            menu.other.master.innerHTML = '<span class="turnLeft">⇧</span>';
            menu.master.innerHTML = '<span>x</span>';
            menu.master.classList.add('reversed');
            addListeners(menu);
        }
    }

    function addListeners(menu){
        menu.wrapper.addEventListener('touchmove', onTouchMove);
        menu.wrapper.addEventListener('touchend', onTouchEnd);
    }

    function onTouchMove(event){
        var menu = (event.srcElement === menuLeft.master) ? menuLeft : menuRight;
        //moveShadow(event);
        var x = event.changedTouches[0].clientX - getMasterPosition(menu).x,
            y = getMasterPosition(menu).y - event.changedTouches[0].clientY;
        event.preventDefault();
        if(Math.sqrt(x*x + y*y) > minMove){
            onMoveOut(menu, event.changedTouches[0]);
        }
    }

    function onTouchEnd(event){
        event.preventDefault();
        debugger;
        var menu = (event.srcElement === menuLeft.master) ? menuLeft : menuRight;
        var x = event.changedTouches[0].clientX - getMasterPosition(menu).x,
            y = getMasterPosition(menu).y - event.changedTouches[0].clientY,
            r = Math.sqrt(x*x+y*y);
        if(r > rMin && r < rMax){
            var activeElement = getActiveElement(menu, event.changedTouches[0].clientX, event.changedTouches[0].clientY);
            if(activeElement)action(activeElement);
        }
        reset(menu);
        menu.other.master.innerHTML = '<span>+</span>';
        menu.master.innerHTML = '<span>+</span>'
        menu.master.classList.remove('reversed');
        shadow.classList.remove('shadowOn');
        this.removeEventListener('touchend', onTouchEnd);
        this.removeEventListener('touchmove', onTouchMove);
    }

    function action(li){
        editor.insertTags(li.getAttribute('data-tag')); //TODO -> tag preparation!
    }

    function onMoveOut(menu, changedTouch){
        var activeElement = getActiveElement(menu, changedTouch.clientX, changedTouch.clientY);
        if(activeElement != menu.activeElement){
            if(activeElement) onActive(activeElement);
            if(menu.activeElement) onActiveOut(menu.activeElement);
            menu.activeElement = activeElement;
        }
    }

    function onScreenChange(evt){
        var inView = true,
            bound = editor.editArea.getBoundingClientRect();
        if(!(window.innerHeight - bound.top > 80 && bound.bottom > 10)){
            inView = false;
        }
        if(evt && evt.type == 'scroll') {
            menuRight.wrapper.style.bottom += window.scrollY + 'px';
            menuLeft.wrapper.style.bottom += window.scrollY + 'px';
        }
        if((window.innerHeight < 150 || !inView) && !wrapper.classList.contains('off'))wrapper.classList.add('off');
        if(window.innerHeight > 150 && inView && wrapper.classList.contains('off'))wrapper.classList.remove('off');
        //menuLeft.wrapper.style.top = menuRight.wrapper.style.top = (window.innerHeight - 120) + 'px';
    }

    function watchForScreenChange(){
        onScreenChange();
        window.addEventListener('scroll', onScreenChange);
        window.addEventListener('deviceorientation', onScreenChange);
        window.addEventListener('viewportsize', onScreenChange);
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
        shadow.style.webkitTransform = 'translate(' + (evt.touches[0].pageX-25) + 'px, ' + (evt.touches[0].pageY-25) + 'px)';
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

    pubsub.subscribe('addTag', function(tag){
        userTags[tag.abbr] = tag;
        localStorage.setItem('tags', JSON.stringify(userTags));
        attachTags();
    });

    pubsub.subscribe('removeTag', function(abbr){
        delete userTags[abbr];
        attachTags();
    });

    function updateButton (li, tag){
        li.setAttribute('data-tag', tag.tag);
        li.getElementsByTagName('a')[0].innerHTML = tag.abbr.toUpperCase();
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

    function attachTags(){
        var i = 0, currentLi;
        for(var userTag in userTags){
            if(userTags[userTag] && userTags.hasOwnProperty(userTag) && i < config.maxItems){
                currentLi = getLi(i);
                updateButton(currentLi, userTags[userTag]);
                i++;
            }
        }
        for(var defTag in defaultTags)
            if(defaultTags.hasOwnProperty(defTag) && i < config.maxItems && !userTags[defTag]){
                currentLi = getLi(i);
                updateButton(currentLi, defaultTags[defTag]);
                i++;
            }
    }

    function activateStaticMenu(){
        var menus = {left: menuLeft, right: menuRight};
        for(menu in menus){
            if(menus.hasOwnProperty(menu)){
                menus[menu].master.addEventListener('click', function(evt){
                    myMenu = this.parentElement.classList.contains('left')? menuLeft : menuRight;
                    if(myMenu.other.primary.expanded || myMenu.other.secondary.expanded)return;
                    if(myMenu.primary.expanded){
                        myMenu.primary.ul.classList.add('minified');
                        myMenu.primary.expanded = false;
                        myMenu.secondary.ul.classList.remove('minified');
                        myMenu.master.innerHTML = '<span>x</span>';
                        myMenu.secondary.expanded = true;
                        return;
                    }
                    if(myMenu.secondary.expanded){
                        myMenu.secondary.ul.classList.add('minified');
                        myMenu.master.innerHTML = '<span class>+</span>';
                        myMenu.secondary.expanded = false;
                        return;
                    }
                    myMenu.primary.ul.classList.remove('minified');
                    myMenu.master.innerHTML = '<span>⇧</span>';
                    myMenu.primary.expanded = true;
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

    function getStoredTags(){
        var tags = JSON.parse(localStorage.getItem('tags')),
            i = 0;
        if(tags){
            for(var key in tags){
                if(tags.hasOwnProperty(key)){
                    defaultTags[key] = tags[key];
                    i++;
                }
            }
            for(var uKey in defaultTags){
                if(userTags.hasOwnProperty('uKey') && i){
                    delete userTags[uKey];
                    i--;
                }
            }
        }
        attachTags();
    }

    function init(){
        build('menuLeft', 'menuRight');
        watchForScreenChange();
        getStoredTags();
        if(!device.handlesAnimatedMenu()){
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
