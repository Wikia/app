define('menu', ['editor', 'config'], function(editor, config){

    var menuLeft = {},
        menuRight = {};
        menuLeft.wrapper = document.getElementById('menuLeft'),
        menuRight.wrapper = document.getElementById('menuRight'),
        lastTouchX = 0,
        lastTouchY = 0;
        menuLeft.master = menuLeft.wrapper.getElementsByClassName('master')[0];
        menuRight.master = menuRight.wrapper.getElementsByClassName('master')[0];
        menuLeft.primary = menuLeft.wrapper.getElementsByClassName('primary')[0];
        menuRight.primary = menuRight.wrapper.getElementsByClassName('primary')[0];
        menuLeft.secondary = menuLeft.wrapper.getElementsByClassName('secondary')[0];
        menuRight.secondary = menuRight.wrapper.getElementsByClassName('secondary')[0];
        menuLeft.primary.expanded =
        menuLeft.secondary.expanded =
        menuRight.primary.expanded =
        menuRight.secondary.expanded = 'fold';
        menuLeft.primary.elements = menuLeft.primary.getElementsByTagName('li');
        menuLeft.secondary.elements = menuLeft.secondary.getElementsByTagName('li');
        menuRight.primary.elements = menuRight.primary.getElementsByTagName('li');
        menuRight.secondary.elements = menuRight.secondary.getElementsByTagName('li');
        menuLeft.angles =[];
        menuRight.angles =[];
        menuLeft.radius = menuRight.radius = 80;

    config.init(function(activeTags){
        attachTags(activeTags);
    });

    function updateButton (li, tag, tagTitle){
        li.setAttribute('data-tag', tag);
        li.getElementsByTagName('p')[0].innerText = tagTitle;
    }

    function findLi(index){
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
            currentLi = findLi(i);
            if(tags.hasOwnProperty(key) && currentLi){
                updateButton(currentLi, tags[key].tag, key);
                i++;
            }
        }
    }

    function switchButtons(primary, secondary){
        var menu = menuRef(primary.parentElement);
        if(primary.expanded == 'fold' && secondary.expanded == 'fold'){
            drawMenu(primary.elements, menu);
            return;
        }
        else if(primary.expanded){
            foldMenu(primary.elements, menu);
            drawMenu(secondary.elements, menu);
            return;
        }
        foldMenu(secondary.elements, menu);
        drawMenu(primary.elements, menu);
    }

    function getRange(x) {return ~~((x + 30) / 30)}

    function holdMenu(){
        var boundTop;
        window.addEventListener('scroll', function(){
            boundTop = editor.editArea.getBoundingClientRect().top + window.scrollY + editor.editArea.offsetHeight;
            if(window.scrollY > boundTop - document.documentElement.clientHeight/* && menuLeft.classList.contains('fixedPos')*/){
                menuLeft.wrapper.classList.add('absolutePos');
                menuRight.wrapper.classList.add('absolutePos');
                menuLeft.wrapper.classList.remove('fixedPos');
                menuRight.wrapper.classList.remove('fixedPos');
                return;
            }
            if(window.scrollY < boundTop - document.documentElement.clientHeight && menuLeft.wrapper.classList.contains('absolutePos')){
                menuLeft.wrapper.classList.remove('absolutePos');
                menuRight.wrapper.classList.remove('absolutePos');
                menuLeft.wrapper.classList.add('fixedPos');
                menuRight.wrapper.classList.add('fixedPos');
                return;
            }
        });

    }

    function findArea(menu, Pwidth, Pheight){
        var x = Pwidth - lastTouchX,
            y = Pheight - lastTouchY,
            angle = 0;
        if(menu == menuLeft)x = -x;

        if(x >= 0){
            if(y >= 0){
                return 0;
            }
            angle = Math.atan(x / -y) * 180 / Math.PI + 90;
        }
        else{
            if(y < 0){
                angle = Math.atan(y / x) * 180 / Math.PI;
            }
            else{
                angle = - Math.atan(-y / x) * 180 / Math.PI;
            }
        }
        return getRange(angle) + 1;
    }

    function drawMenu(ulElements, menu){
        for(var i = 1; i <= ulElements.length; i++){
            ulElements[i-1].classList.remove('fold');
            if(menu == menuLeft){
                ulElements[i-1].getElementsByTagName('hr')[0].classList.add('rotHrL' + i);
                ulElements[i-1].getElementsByTagName('p')[0].classList.add('rotTagL' + i);
            }
            else{
                ulElements[i-1].getElementsByTagName('hr')[0].classList.add('rotHr' + i);
                ulElements[i-1].getElementsByTagName('p')[0].classList.add('rotTag' + i);
            }
            ulElements[i-1].getElementsByTagName('hr')[0].classList.remove('foldHr');
            ulElements[i-1].getElementsByTagName('p')[0].classList.remove('foldTag');
        }
        ulElements[0].parentElement.expanded = 'expanded';
    }

    function foldMenu(ulElements, menu){
        for(var i = 1; i <= ulElements.length; i++){
            ulElements[i-1].classList.add('fold');
            if(menu == menuLeft){
                ulElements[i-1].getElementsByTagName('hr')[0].classList.remove('rotHrL' + i);
                ulElements[i-1].getElementsByTagName('p')[0].classList.remove('rotTagL' + i);
            }
            else{
                ulElements[i-1].getElementsByTagName('hr')[0].classList.remove('rotHr' + i);
                ulElements[i-1].getElementsByTagName('p')[0].classList.remove('rotTag' + i);
            }
            ulElements[i-1].getElementsByTagName('hr')[0].classList.add('foldHr');
            ulElements[i-1].getElementsByTagName('p')[0].classList.add('foldTag');
        }
        ulElements[0].parentElement.expanded = 'fold';
    }

    function swipeCheck(menu){
        window.addEventListener('touchmove', function(event){
            if(event.srcElement.classList.contains('master')){
                event.preventDefault();
                var width = event.changedTouches[0].pageX - lastTouchX,
                    height = event.changedTouches[0].pageY - lastTouchY,
                    diagonal = Math.sqrt(width*width + height*height);
                if(diagonal > menu.radius){
                    afterSwipe(menuRef(event.srcElement.parentElement), event.changedTouches[0].pageX, event.changedTouches[0].pageY);
                }
            }
        });
        window.addEventListener('touchend', function(){
            if(event.srcElement.classList.contains('master')){
                event.preventDefault();
                menu = menuRef(event.srcElement.parentElement); //wrapper menu
                if(menu.primary.expanded == 'expanded'){
                    foldMenu(menu.primary.elements, menu);
                }
                else{
                    foldMenu(menu.secondary.elements, menu);
                }
            }
        });
        switchButtons(menu.primary, menu.secondary);
    }

    function afterSwipe(menu, width, height){
        //just check the coords and find the appropriate button
        var expElements, touchArea;
        if(menu.primary.expanded == 'expanded'){
            expElements = menu.primary.elements;
        }
        else{
            if(menu.secondary.expanded == 'expanded'){
                expElements = menu.secondary.elements
            }
            else{
                return; //what about quick swipe?
            }
        }

        touchArea = findArea(menu, width, height);

        if(touchArea > 0 && touchArea < 6){
            editor.insertTags(expElements[touchArea-1].getAttribute('data-tag'))
        }

        menu.wrapper.removeEventListener('touchmove');
        foldMenu(menu.primary.elements, menu);
        foldMenu(menu.secondary.elements, menu);
    }

    function expanded(menu){
        if(menu.primary.expanded) return menu.primary;
        if(menu.secondary.expanded) return menu.secondary;
        return false;
    }

    function menuRef(wrapper){
        return wrapper.id == 'menuLeft' ? menuLeft : menuRight;
    }

    function afterTouchStart(menu, changedTouches){
        if(menu === menuLeft){
            if(menuRight.primary.expanded == 'expanded'){
                switchButtons(menuRight.primary, menuRight.secondary);
            }
            else{
                if(menuRight.secondary.expanded == 'expanded'){
                    switchButtons(menuRight.secondary, menuRight.primary);
                }

                else{
                    swipeCheck(menu);
                    lastTouchX = changedTouches[0].pageX;
                    lastTouchY = changedTouches[0].pageY;
                }
            }
        }
        else{
            if(menuLeft.primary.expanded == 'expanded'){
                switchButtons(menuLeft.primary, menuLeft.secondary);
            }
            else{
                if(menuLeft.secondary.expanded == 'expanded'){
                    switchButtons(menuLeft.secondary, menuLeft.primary);
                }

                else{
                    swipeCheck(menu);
                    lastTouchX = changedTouches[0].pageX;
                    lastTouchY = changedTouches[0].pageY;
                }
            }
        }
    }

    function init(){
        holdMenu();
        masters =[menuLeft.master, menuRight.master];
        masters.forEach(function(master){
            master.addEventListener('touchstart', function(event){
                event.preventDefault();
                afterTouchStart(menuRef(master.parentElement), event.changedTouches);
            });
        })
    }

    return{
        init: init
    };
});