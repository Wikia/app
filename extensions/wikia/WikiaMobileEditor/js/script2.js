define('editor', function(){
    var editArea = document.getElementById('editArea'),
        pattern = /_\$/;

    this.insertTags = function(phrase){ //distFromEnd - number of chars from end to center of the phrase
        var startPos, endPos, cursorPos, halvesOfText, distFromEnd= 0;

        if(phrase.match(pattern)){ //extracts _$ if present to know the cursor position
            halvesOfText = phrase.split('_$');
            distFromEnd = halvesOfText[1].length;
            phrase = halvesOfText[0].concat(halvesOfText[1]);
        }

        if (editArea.selectionStart || editArea.selectionStart == '0') {
            startPos = editArea.selectionStart;
            endPos = editArea.selectionEnd;

            editArea.value = editArea.value.substring(0, startPos)
                + phrase
                + editArea.value.substring(endPos, editArea.value.length);
        }

        //if no selection add the phrase at the end of textarea text
        else {
            editArea.value += phrase;
            startPos = endPos = editArea.value.length;
        }
        cursorPos = endPos+phrase.length - distFromEnd;
        editArea.focus();
        editArea.setSelectionRange(cursorPos, cursorPos);
    };

    return{
        insertTags: insertTags
    };
});

define ('config', function(){
    this.active = function(chbArray){ //returns elements with checkboxes in 'active' state
        activeTags = [];
        for(var i = 0; i < chbArray.length; i++){
            if(chbArray[i].checked){
                activeTags.push(chbArray[i].dataset.tag);
            }
        }
        return activeTags;
    };
});

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
                        updateButton(menuRight.primary.elements[i - prmLft - scdLft], tags[i]);
                    }
                    else{
                        updateButton(menuRight.secondary.elements[i - prmLft - scdLft - prmRgt], tags[i]);
                    }
                }
            }
        }
    }

    function expand(elements){
        var classNumber;
        for(var i = 0; i < elements.length; i++){
            classNumber = i+1;
            elements[i].classList.add('onCircle' + classNumber);
            elements[i].classList.remove('fold');
        }
        elements[0].parentElement.expanded = 'expanded';
    }

    function fold(elements){
        var classNumber;
        for(var i = 0; i < elements.length; i++){
            classNumber = i+1;
            elements[i].classList.remove('onCircle' + classNumber);
            elements[i].classList.add('fold');
        }
        elements[0].parentElement.expanded = 'fold';
    }

    function switchButtons(primary, secondary){
        if(primary.expanded == 'fold' && secondary.expanded == 'fold'){
            expand(primary.elements);
            return;
        }
        else if(primary.expanded){
            fold(primary.elements);
            expand(secondary.elements);
            return;
        }
        fold(secondary.elements);
        expand(primary.elements);
        //expand primary if everything fold
        //expand secondary if primary expanded
        //expand primary if secondary expanded
    }

    function getRange(x) {return ~~((x + 30) / 30)}

    function findArea(menu, Pheight, Pwidth){
        var x = lastTouchX - Pwidth,
            y = Pheight - lastTouchY,
            angle = 0;

        if(x > 0 && y > 0){
            angle = Math.atan(y / x);
        }
        else{
            if(x < 0){
                x = -x;
                angle = Math.atan(x / y) + 90;
            }
            else{
                if(y < 0){
                    y = -y;
                    angle = Math.atan(-y / x);
                }
                else{
                    //do whatever (means swiped towards right-bottom corner of the screen
                    return 0;
                }
            }
        }
        return getRange(angle);
    }

    function findDistance(element){
        //jeśli nieprzewinięte okno, to dist = page offsetY - odl. od dolu
    }

    function swipeCheck(menu){
        var radius = menu.offsetWidth / 2;
        menu.addEventListener('touchmove', function(event){
            event.preventDefault();
            var width = event.changedTouches[0].pageX - lastTouchX,
                height = event.changedTouches[0].pageY - lastTouchY,
                diagonal = Math.sqrt(width*width + height*height);
            if(diagonal > radius){
                afterSwipe(this, width, height);
            }
        });
        menu.addEventListener('touchend', function(){
            event.preventDefault();
            if(menu.primary.expanded == 'expanded'){
                fold(menu.primary.elements);
            }
            else{
                fold(menu.secondary.elements);
            }
        });
        setTimeout(function(){
            switchButtons(menu.primary, menu.secondary);
        }, 300);
    }

    function afterSwipe(menu, width, height){
        //just check the coords and find the appropriate button
        var expElements;
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
        if(width > -150 && width < -70 && height > 15 && height < 40){
            editor.insertTags(expElements[4].getAttribute('data-tag'));
        }
        if(width > -150 && width < -70 && height > -40 && height < 15 ){
            editor.insertTags(expElements[3].getAttribute('data-tag'));
        }
        if(width > -70 && width < -35 && height > -120 && height < -40 ){
            editor.insertTags(expElements[2].getAttribute('data-tag'));
        }
        if(width > -35 && width < 0 && height > -140 && height < -60 ){
            editor.insertTags(expElements[1].getAttribute('data-tag'));
        }
        if(width > 0 && width < 40 && height > -140 && height < -60 ){
            editor.insertTags(expElements[0].getAttribute('data-tag'));
        }
        menu.removeEventListener('touchmove');
        fold(menu.primary.elements);
        fold(menu.secondary.elements);
    }

    function afterTouchStart(menu, changedTouches){
        //wait for touchend, if it comes faster than 100ms (assumption) don't show the menu
        //check if the second menu expanded - if yes, switch it
        if(menu === menuLeft){
            if(menuRight.primary.expanded == 'expanded' || menuRight.secondary.expanded == 'expanded'){
                switchButtons(menuRight.primary, menuRight.secondary);
            }
            else{
                swipeCheck(menu);
                lastTouchX = changedTouches[0].pageX;
                lastTouchY = changedTouches[0].pageY;
            }
        }
        else{
            if(menuLeft.primary.expanded == 'expanded' || menuLeft.secondary.expanded == 'expanded'){
                switchButtons(menuLeft.primary, menuLeft.secondary);
            }
            else{
                swipeCheck(menu);
                lastTouchX = changedTouches[0].pageX;
                lastTouchY = changedTouches[0].pageY;
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

document.addEventListener('DOMContentLoaded', function(){
    require(['menu'], function(menu){
        menu.init();
    });
});