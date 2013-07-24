define('editor', function(){

    var editArea = document.getElementById('editArea');

    this.insertTags = function(phrase){ //distFromEnd - number of chars from end to center of the phrase
        var startPos, endPos, cursorPos, halvesOfText, distFromEnd= 0;

        if(phrase.match('_&')){ //extracts _$ if present to know the cursor position
            halvesOfText = phrase.split('_$');
            distanceFromEnd = halvesOfText[1].length;
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

define('menu', ['config', 'editor'], function(config, editor){

    var self = this;
    this.itemsPerMenu = document.getElementsByClassName('primaryButtons')[0].getElementsByTagName('li').length;

    this.updateButtons = function(){
        var activeTags = editor.active(),
            primaryList = document.getElementsByClassName('primaryButtons'),
            secondaryList = document.getElementsByClassName('secondaryButtons');

        for(var i = 0; i < activeTags.length; i++){
            if(i <= this.itemsPerMenu-1){

            }
        }
    };

    this.expand = function (list) { //takes a <ul> element of children to be written drawn on circle
        //quarter can be top-left, top-right, bottom-left, bottom-right
        var wrapper = list.parentElement;
        var master = wrapper.getElementsByClassName('master')[0];
        if(!wrapper.classList.contains('expanded')){ //expanding the wrapper size in css to make place for the buttons
            wrapper.classList.add('expanded');
        }
        var radius = wrapper.offsetWidth / 2,
            elemArray = list.getElementsByTagName('li'),
            quarter = wrapper.dataset.direction,
            marginTop,
            marginLeft;

        for(var i = 0; i < elemArray.length; i++){
            elemArray[i].classList.remove('rollIn');
            elemArray[i].angle = i * 90 / (elemArray.length - 1); //angle
            marginTop = radius * Math.sin(elemArray[i].angle * Math.PI / 180) - elemArray[i].offsetHeight / 2;
            marginLeft = radius * Math.cos(elemArray[i].angle * Math.PI / 180) - elemArray[i].offsetWidth / 2;

            switch(quarter){
                case 'top-left':
                    marginTop = radius - marginTop - elemArray[i].offsetHeight;
                    marginLeft = radius - marginLeft - elemArray[i].offsetWidth;
                    break;
                case 'top-right':
                    marginTop = radius - marginTop - elemArray[i].offsetHeight;
                    marginLeft += radius;
                    break;
                case 'bottom-left':
                    marginTop += radius;
                    marginLeft = radius - marginLeft - elemArray[i].offsetWidth;
                    break;
                case 'bottom-right':
                    marginTop += radius;
                    marginLeft += radius;
                    break;
            }
            elemArray[i].style.top = marginTop + 'px';
            elemArray[i].style.left = marginLeft + 'px';
        }
        if(master.dataset.expanded == 'false'){
            master.dataset.expanded = 'true';
        }
    };

    this.fold = function(list){ //takes an array of elements and moves them to the center of a parent element
        var wrapper = list.parentElement,
            radius = wrapper.offsetWidth / 2,
        elemArray = list.getElementsByTagName('li');

        //marginTop = radius - elemArray[0].offsetHeight / 2 + 'px';
        //marginLeft = radius - elemArray[0].offsetWidth / 2 + 'px';

        for(var i = 0; i < elemArray.length; i++){
            elemArray[i].classList.add('rollIn');
            elemArray[i].style.top = '40%';
            elemArray[i].style.left = '40%';
        }
    };

    this.switchButtons = function(parent){ //switches between groups of buttons in menu
        var lists = parent.getElementsByTagName('ul');
        var masterButton = parent.getElementsByClassName('master')[0];
        if(masterButton.dataset.expanded = 'false'){
            parent.style.height = '40%';
            parent.style.width = '40%';
        }
        if(parent.getElementsByClassName('master')[0].dataset.expanded == 'true'){
            for(var i = 0; i < lists.length; i++){
                if(lists[i].dataset.position == 'out'){
                    this.fold(lists[i]);
                    lists[i].dataset.position = 'in';
                    this.expand(lists[(i+1)%lists.length], parent.dataset.direction);
                    lists[(i+1)%lists.length].dataset.position = 'out';
                }
            }
        }
        else{
            this.expand(lists[0]);
            masterButton.dataset.expanded = 'true';
        }
    };

    this.hideMenu = function(parent){
        var lists = parent.getElementsByTagName('ul');
        for(var i = 0; i < lists.length; i++){
            this.fold(lists[i]);
            lists[i].dataset.position = 'in';
        }
        parent.getElementsByClassName('master')[0].dataset.expanded = 'false';
    };

    this.hideAll = function(){
        var parents = document.getElementsByClassName('menuWrapper');
        for(var i = 0; i < parents.length; i++){
            this.hideMenu(parents[i]);
        }
    };

    this.changeTransClass = function(element, className){
        if(element.classList.contains(className)){
            element.classList.remove(className);
        }
        else{
            element.classList.add('className');
        }
    };
    this.touchStartProxy = function(target){
        switch(target.className){
            case 'master': //main button touched
                if(target.dataset.expanded == 'false'){ //if second menu is expanded, switch its options (shift)
                    var menuParents = document.getElementsByClassName('menuWrapper'),
                        shift = false;
                    for(var i = 0; i < menuParents.length; i++){
                        if(menuParents[i].id != target.parentElement.id && menuParents[i].getElementsByClassName('master')[0].dataset.expanded == 'true'){
                            this.switchButtons(menuParents[i]);
                            shift = true;
                            break;
                        }
                    }

                    if(!shift){
                        this.switchButtons(target.parentElement);
                    }
                    else{
                        shift = false;
                    }
                }
                break;
            default:
                break;
        }
    };

    this.touchEndProxy = function (target){
        if(target.classList.contains('menuOption')){ //if touch ended on option insert text into textarea
            editor.insertTags(target.dataset.tags);
            this.hideAll();
        }
        else{ //if touch ended on anything else just fold the menu
            var parent = target;
            while(!parent.classList.contains('menuWrapper')){
                parent = parent.parentElement;
            }
            this.hideMenu(parent);
        }
    };

    this.init = function(menuWrappers){ //initalization of events for the menu & menu itself
        for(var i = 0; i < menuWrappers.length; i++){
            menuWrappers[i].addEventListener('touchstart', function(event){
                self.touchStartProxy(event.target);
            });
            menuWrappers[i].addEventListener('touchend', function(event){
                self.touchEndProxy(event.target);
            });
        }
    };

    return{
        init:init,
        touchEndProxy:touchEndProxy,
        touchStartProxy:touchStartProxy,
        changeTransClass:changeTransClass,
        hideAll:hideAll,
        hideMenu:hideMenu,
        switchButtons:switchButtons,
        fold:fold,
        expand:expand,
        updateButtons:updateButtons
    };
});

//------------------------------------------------------------------------------Circle Menu Handlers


/*circleMenu.holdOnToBottom = function(textarea, menuWrapper){
 //bottom of screen or bottom of textarea (which one is higher)
 var windowHeight = window.innerHeight,
 textareaHeight = textarea.offsetHeight;
 if(textareaHeight+marginTop < windowHeight){
 //place the menu at the bottom of textarea
 }
 else{
 //place the menu at the bottom of the screen
 }
 }*/
//------------------------------------------------------------------------------Editor Functions (insertions etc.


/*
 editor.tags = { //_$ = cut the string and place the cursor there
 http = '[http://_$]',
 username = '--~~~~',
 category = '[[Category:_$]]',
 redirect = '#REDIRECT[[_$]]',
 sup = '<sup>_$</sup>',
 sub = '<sub>_$</sub>',
 ref = '<ref>_$</ref>',
 references = '</references>', //?
 includeOnly = '<includeonly>_$</includeonly>',
 noInclude = '<noinclude>_$</noinclude>',
 tilde = '~',
 brvbar = '|',
 amp = '&',
 iexcl = '¡',
 iquest = '¿',
 dagger = '†',
 Dagger = '‡',
 harr = '↔',
 uarr = '↑',
 rarr = '→', //?
 darr = '↓',
 larr = '←', //?
 bull = '•',
 hash = '#', //?
 sect = '§',
 percent = '%',
 mdash = '—',
 ndash = '–',
 hellip = '…',
 deg = '°',
 asymp = '≈',
 plusmn = '±',
 times = '×',
 divide = '÷',
 middot = '·',
 sup1 = '¹',
 sup2 = '²',
 sup3 = '³',
 frac12 = '½',
 frac13 = '⅓',
 frac23 = '⅔',
 frac14 = '¼',
 frac34 = '¾',
 frac18 = '⅛',
 frac38 = '⅜',
 frac58 = '⅝',
 frac78 = '⅞',
 lsquo = '‘',
 rsquo = '’',
 ldquo = '“',
 rdquo = '”',
 cent = '¢',
 dollar = '$',
 euro = '€',
 pound = '£',
 yen = '¥',
 aAcute = 'á'
 aAcuteCap = 'Á'
 cAcute = 'ć',
 cAcuteCap = 'Ć',
 eAcute = 'é',
 eAcuteCap = 'É',
 iAcute = 'í',
 iAcuteCap = 'Í',
 lAcute = 'ĺ',
 lAcuteCap = 'Ĺ',
 nAcute = 'ń',
 nAcuteCap = 'Ń',
 oAcute = 'ó',
 oAcuteCap = 'Ó',
 rAcute = 'ŕ',
 rAcuteCap = 'Ŕ',
 sAcute = 'ś',
 sAcuteCap = 'Ś',
 uAcute = 'ú',
 uAcuteCap = 'Ú',
 yAcute = 'ý',
 yAcuteCap = 'Ý',
 zAcute = 'ź',
 zAcuteCap = 'Ź',
 aGrave = 'à',
 aGraveCap = 'À',
 eGrave = 'è',
 eGraveCap = 'È',
 iGrave = 'ì',
 iGraveCap = 'Ì',
 oGrave = 'ò',
 oGraveCap = 'Ò',
 uGrave = 'ù',
 uGraveCap = 'Ù',
 aDashed = 'â',
 aDashedCap = 'Â',
 cDashed = 'ĉ',
 cDashedCap = 'Ĉ',
 eDashed = 'ê',
 eDashedCap = 'Ê',
 gDashed = 'ĝ',
 gDashedCap = 'Ĝ',
 hDashed = 'ĥ',
 hDashedCap = 'Ĥ',
 iDashed = 'î',
 iDashedCap = 'Î',
 jDashed = 'ĵ',
 jDashedCap = 'Ĵ',
 oDashed = 'ô',
 oDashedCap = 'Ô',
 sDashed = 'ŝ',
 sDashedCap = 'Ŝ',
 uDashed = 'û',
 uDashedCap = 'Û',
 wDashed = 'ŵ',
 wDashedCap = 'Ŵ',
 yDashed = 'ŷ',
 yDashedCap = 'Ŷ',
 aUmlaut = 'ä',
 aUmlautCap = 'Ä',
 eUmlaut = 'ë',
 eUmlautCap = 'Ë',
 iUmlaut = 'ï',
 iUmlautCap = 'Ï',
 oUmlaut = 'ö',
 oUmlautCap = 'Ö',
 uUmlaut = 'ü',
 uUmlautCap = 'Ü',
 yUmlaut = 'ÿ',
 yUmlautCap = 'Ÿ',
 ss = 'ß'
 };*/

//------------------------------------------------------------------------------'Main'
document.addEventListener('DOMContentLoaded', function(){
    require(['menu'], function(menu){
        menu.init(document.getElementsByClassName('menuWrapper'));
    });
});