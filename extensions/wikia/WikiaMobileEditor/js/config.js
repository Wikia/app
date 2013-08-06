define ('config', ['editor'], function(editor){
    'use strict';

    var wrapper = document.getElementsByClassName('tagListWrapper')[0],
        submitter,
        chbArray = wrapper.getElementsByTagName('input'),
        maxItems = 20,
        warning = wrapper.getElementsByClassName('warning')[0],
        onChange,
        activeTags = [];

    var tags = {
        bold : "''_$''",
        italic : "''_$''",
        internalLink : "[[_$]]",
        externalLink : "[http://_$ title]",
        level2Headline : "==_$==",
        embeddedFile : "[[File:_$]]",
        fileLink : "[[Media:_$]]",
        mathFormula : "<math></math>",
        ignoreWiki : "<nowiki></nowiki>",
        gallery : "<gallery>Image:_$|Caption</gallery>",
        blockquote : "<blockquote>_$</blockquote>",
        /*table : "{| class="wikitable"
            |-
            ! header 1
            ! header 2
            ! header 3
            |-
            | row 1, cell 1
            | row 1, cell 2
            | row 1, cell 3
            |-
            | row 2, cell 1
            | row 2, cell 2
            | row 2, cell 3
        |}",*/
        usernameAndTime : "--~~~~",
        horizontalLine : "----",
        category : "[[Category:_$]]",
        redirect : "#REDIRECT[[_$]]",
        strike : "----",
        lineBreak : "<br />",
        small : "<small></small>",
        hiddenComment : "<!-- _$ -->",
        superScript : "<sup>_$</sup>",
        subScript : "<sub>_$</sub>",
        ref : "<ref>_$</ref>",
        references : "</references>", //?
        includeOnly : "<includeonly>_$</includeonly>",
        noInclude : "<noinclude>_$</noinclude>",
        tilde : "~",
        brvbar : "|",
        amp : "&",
        iexcl : "¡",
        iquest : "¿",
        dagger : "†",
        Dagger : "‡",
        harr : "↔",
        uarr : "↑",
        rarr : "→", //?
        darr : "↓",
        larr : "←", //?
        bull : "•",
        hash : "#", //?
        sect : "§",
        percent : "%",
        mdash : "—",
        ndash : "–",
        hellip : "…",
        deg : "°",
        asymp : "≈",
        plusmn : "±",
        times : "×",
        divide : "÷",
        middot : "·",
        sup1 : "¹",
        sup2 : "²",
        sup3 : "³",
        frac12 : "½",
        frac13 : "⅓",
        frac23 : "⅔",
        frac14 : "¼",
        frac34 : "¾",
        frac18 : "⅛",
        frac38 : "⅜",
        frac58 : "⅝",
        frac78 : "⅞",
        lsquo : "‘",
        rsquo : "’",
        ldquo : "“",
        rdquo : "”",
        cent : "¢",
        dollar : "$",
        euro : "€",
        pound : "£",
        yen : "¥",
        aAcute : "á",
        aAcuteCap : "Á",
        cAcute : "ć",
        cAcuteCap : "Ć",
        eAcute : "é",
        eAcuteCap : "É",
        iAcute : "í",
        iAcuteCap : "Í",
        lAcute : "ĺ",
        lAcuteCap : "Ĺ",
        nAcute : "ń",
        nAcuteCap : "Ń",
        oAcute : "ó",
        oAcuteCap : "Ó",
        rAcute : "ŕ",
        rAcuteCap : "Ŕ",
        sAcute : "ś",
        sAcuteCap : "Ś",
        uAcute : "ú",
        uAcuteCap : "Ú",
        yAcute : "ý",
        yAcuteCap : "Ý",
        zAcute : "ź",
        zAcuteCap : "Ź",
        aGrave : "à",
        aGraveCap : "À",
        eGrave : "è",
        eGraveCap : "È",
        iGrave : "ì",
        iGraveCap : "Ì",
        oGrave : "ò",
        oGraveCap : "Ò",
        uGrave : "ù",
        uGraveCap : "Ù",
        aDashed : "â",
        aDashedCap : "Â",
        cDashed : "ĉ",
        cDashedCap : "Ĉ",
        eDashed : "ê",
        eDashedCap : "Ê",
        gDashed : "ĝ",
        gDashedCap : "Ĝ",
        hDashed : "ĥ",
        hDashedCap : "Ĥ",
        iDashed : "î",
        iDashedCap : "Î",
        jDashed : "ĵ",
        jDashedCap : "Ĵ",
        oDashed : "ô",
        oDashedCap : "Ô",
        sDashed : "ŝ",
        sDashedCap : "Ŝ",
        uDashed : "û",
        uDashedCap : "Û",
        wDashed : "ŵ",
        wDashedCap : "Ŵ",
        yDashed : "ŷ",
        yDashedCap : "Ŷ",
        aUmlaut : "ä",
        aUmlautCap : "Ä",
        eUmlaut : "ë",
        eUmlautCap : "Ë",
        iUmlaut : "ï",
        iUmlautCap : "Ï",
        oUmlaut : "ö",
        oUmlautCap : "Ö",
        uUmlaut : "ü",
        uUmlautCap : "Ü",
        yUmlaut : "ÿ",
        yUmlautCap : "Ÿ",
        ss : "ß"
    };

    function initializeLinks(){
        var links = wrapper.getElementsByTagName('a');
        var tag;
        for(var i = 0; i < links.length; i++){
            links[i].addEventListener('click', function(){
                tag = this.parentElement.getElementsByTagName('input')[0].getAttribute('value');
                editor.insertTags(tag);
            });
        }
    }

    function findSubmitter(){
        var inputs = wrapper.getElementsByTagName('input');
        for(var i = 0; i < inputs.length; i++){
            if(inputs[i].getAttribute('type') == 'submit'){
                return inputs[i];
            }
        }
    }

    function validate(activeTags){
        return !!(activeTags.length < maxItems && activeTags.length > 0);
    }

    function active(){ //returns elements with checkboxes in 'active' state
        var activeTags = {},
            key,
            value,
            tagField,
            titleField;
        for(var i = 0; i < chbArray.length; i++){
            if(chbArray[i].checked){
                if(chbArray[i].parentElement.getElementsByClassName('tagField')[0]){
                    tagField = chbArray[i].parentElement.getElementsByClassName('tagField')[0];
                    titleField = chbArray[i].parentElement.getElementsByClassName('tagTitleField')[0];
                    if(tagField.value && titleField.value){
                        key = titleField.value;
                        activeTags[key] = tagField.value;
                    }
                }
                else{
                    key = chbArray[i].parentElement.getElementsByTagName('label')[0].innerText;
                    key = key.substring(0, key.length-2);
                    activeTags[key] = chbArray[i].getAttribute('value');
                }
            }
        }
        return activeTags;
    }

    function validate(activeTags){
        var checker = 0;
        for(var key in activeTags){
            if(activeTags.hasOwnProperty(key))checker++;
        }
        return !!(checker <= maxItems && checker > 0);
    }

    function updateMenu(){
        activeTags = active();
        if(validate(activeTags)){
            if(warning.classList.contains('warningOn')){
                warning.classList.remove('warningOn');
            }
            //ask the animated menu to update itself
            onChange(activeTags);
        }
        else{
            warning.classList.add('warningOn');
        }
    }

    function init(callback){
        initializeLinks();
        onChange = callback;
        submitter = findSubmitter();
        submitter.addEventListener('click', function(event){
            event.preventDefault();
            updateMenu();
        });
    }

    return{
        active: active,
        init: init,
    }
});