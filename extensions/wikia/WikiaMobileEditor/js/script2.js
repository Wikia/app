define('menu', ['editor', 'config'], function(editor, config){

    var menuLeft = document.getElementById('menuLeft'),
        menuRight = document.getElementById('menuRight'),
        lastTouchX = 0,
        lastTouchY = 0,
        touchMap ={

        };

        menuLeft.master = menuLeft.getElementsByClassName('master')[0];
        menuRight.master = menuRight.getElementsByClassName('master')[0];
        menuLeft.primary = menuLeft.getElementsByClassName('primary')[0];
        menuRight.primary = menuRight.getElementsByClassName('primary')[0];
        menuLeft.secondary = menuLeft.getElementsByClassName('secondary')[0];
        menuRight.secondary = menuRight.getElementsByClassName('secondary')[0];
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


    function updateButton (li, tag){
        li.setAttribute('data-tag', tag);
    }

    function attachTags(){
        var tags = config.activeTags(),
            prmLft = menuLeft.primary.elements.length,
            prmRgt = menuRight.primary.elements.length,
            scdLft = menuLeft.secondary.elements.length,
            scdRgt = menuRight.secondary.elements.length;
        for(var i = 0; i < tags.length; i++){
            if(i < prmLft){
                updateButton(menuLeft.primary.elements[i], tags[i]);
            }
            else{
                if(i - prmLft < scdLft){
                    updateButton(menuRight.primary.elements[i - prmLft], tags[i]);
                }
                else{
                    if(i - prmLft - scdLft < prmRgt){
                        updateButton(menuLeft.secondary.elements[i - prmLft - scdLft], tags[i]);
                    }
                    else{
                        updateButton(menuRight.secondary.elements[i - prmLft - scdLft - prmRgt], tags[i]);
                    }
                }
            }
        }
    }

    function switchButtons(primary, secondary){
        if(primary.expanded == 'fold' && secondary.expanded == 'fold'){
            drawMenu(primary.elements);
            return;
        }
        else if(primary.expanded){
            foldMenu(primary.elements);
            drawMenu(secondary.elements);
            return;
        }
        foldMenu(secondary.elements);
        drawMenu(primary.elements);
    }

    function getRange(x) {return ~~((x + 15) / 30)}

    function findArea(menu, Pheight, Pwidth){
        var x = Pwidth - lastTouchX,
            y = Pheight - lastTouchY,
            angle = 0;

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

    function drawMenu(ulElements){
        for(var i = 1; i <= ulElements.length; i++){
            ulElements[i-1].classList.remove('fold');
            ulElements[i-1].getElementsByTagName('hr')[0].classList.add('rotHr' + i);
            ulElements[i-1].getElementsByTagName('p')[0].classList.add('rotTag' + i);
            ulElements[i-1].getElementsByTagName('hr')[0].classList.remove('foldHr');
            ulElements[i-1].getElementsByTagName('p')[0].classList.remove('foldTag');
        }
        ulElements[0].parentElement.expanded = 'expanded';
    }

    function foldMenu(ulElements){
        for(var i = 1; i <= ulElements.length; i++){
            ulElements[i-1].classList.add('fold');
            ulElements[i-1].getElementsByTagName('hr')[0].classList.remove('rotHr' + i);
            ulElements[i-1].getElementsByTagName('p')[0].classList.remove('rotTag' + i);
            ulElements[i-1].getElementsByTagName('hr')[0].classList.add('foldHr');
            ulElements[i-1].getElementsByTagName('p')[0].classList.add('foldTag');
        }
        ulElements[0].parentElement.expanded = 'fold';
    }

    function swipeCheck(menu){
        var radius = menu.offsetWidth / 2;
        menu.addEventListener('touchmove', function(event){
            event.preventDefault();
            var width = event.changedTouches[0].pageX - lastTouchX,
                height = event.changedTouches[0].pageY - lastTouchY,
                diagonal = Math.sqrt(width*width + height*height);
            if(diagonal > radius){
                afterSwipe(this, event.changedTouches[0].pageX, event.changedTouches[0].pageY);
            }
        });
        menu.addEventListener('touchend', function(){
            event.preventDefault();
            if(menu.primary.expanded == 'expanded'){
                foldMenu(menu.primary.elements);
            }
            else{
                foldMenu(menu.secondary.elements);
            }
        });
        setTimeout(function(){
            switchButtons(menu.primary, menu.secondary);
        }, 300);
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

        menu.removeEventListener('touchmove');
        foldMenu(menu.primary.elements);
        foldMenu(menu.secondary.elements);
    }

    function afterTouchStart(menu, changedTouches){
        //wait for touchend, if it comes faster than 100ms (assumption) don't show the menu
        //check if the second menu expanded - if yes, switch it
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
        masters =[menuLeft.master, menuRight.master];
        masters.forEach(function(master){
            master.addEventListener('touchstart', function(event){
                event.preventDefault();
                afterTouchStart(master.parentElement, event.changedTouches);
            });
        })
    }

    return{
        init: init
    };
});