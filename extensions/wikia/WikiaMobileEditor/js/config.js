define('config', ['pubsub'], function(pubsub){

    var configObj,
        activeTags = {},
        maxItems = 16;

    ConfigObj = function(wrapSection){
        this.wrapper = wrapSection;
        this.sections = {};
        this.warning = wrapSection.getElementsByClassName('warning')[0];
        this.submit = wrapSection.getElementsByClassName('save')[0];
        this.checkboxes = wrapSection.getElementsByClassName('tagChb');
        var sectionsList = wrapSection.getElementsByTagName('section'),
            tagType;
        for(var i = 0; i < sectionsList.length; i++){
            tagType = sectionsList[i].getAttribute('data-tagType');
            this.sections[tagType] = {
                section : sectionsList[i],
                toggle : sectionsList[i].getElementsByClassName('toggle')[0],
                ul : sectionsList[i].getElementsByTagName('ul')[0],
            };
            this.sections[tagType].ul.elements = this.sections[tagType].ul.getElementsByTagName('li');
        }
    }

    var tags = {
        'Text Modifiers' : {
            'Bold' : {
                tag : "''_$''",
                abbr : 'B',
                display : "'' ''"
            },
            'Italic' : {
                tag : "'''_$'''",
                abbr : 'I',
                display : "''' '''"
            },
            'Small' : {
                tag : "<small>_$</small>",
                abbr : 'Sm',
                display : '&lt;small&gt; &lt;/small&gt;'
            },
            'Superscript' : {
                tag : "<sup>_$</sup>",
                abbr : 'Sup',
                display : 'Superscript'
            },
            'Subscript' : {
                tag : "<sub>_$</sub>",
                abbr : 'Sub',
                display : 'Subscript'
            },
            'Level 2 Headline' : {
                tag : "==_$==",
                abbr : 'H2',
                display : 'Level 2 Headline'
            },
            'Blockquote' : {
                tag : "<blockquote>_$</blockquote>",
                abbr : 'Qte',
                display : 'Blockquote'
            },
        },
        'Wiki Markup' : {
            'Internal Link' : {
                tag : "[[_$]]",
                abbr : 'Int',
                display : 'Internal Link'
            },
            'External Link' : {
                tag : "[http://_$ title]",
                abbr : 'Ext',
                display : 'External Link'
            },
            'Embedded File' : {
                tag : "[[File:_$]]",
                abbr : 'Embd',
                display : 'Embedded File'
            },
            'File Link' : {
                tag : "[Media:_$]",
                abbr : 'File',
                display : 'File Link'
            },
            'Math Formula' : {
                tag : "<math>_$</math>",
                abbr : 'Math',
                display : 'Math Formula'
            },
            'Ignore Wiki' : {
                tag : "<nowiki>_$</nowiki>",
                abbr : 'Ignr',
                display : 'Ignore Wiki'
            },
            'Username And Time' : {
                tag : "~~~~",
                abbr : 'Usr',
                display : 'Username and time'
            },
            'Horizontal Line' : {
                tag : "----",
                abbr : 'Usr',
                display : 'Username and time'
            },
            'Strike' : {
                tag : "<strike>_$</strike>",
                abbr : 'Str',
                display : 'Strike'
            },
            'Hidden Comment' : {
                tag : "<!-- _$ -->",
                abbr : 'Hdn',
                display : 'Hidden Comment'
            },
            'Category' : {
                tag : "[[Category:_$]]",
                abbr : 'Hdn',
                display : 'Hidden Comment'
            },
            'Redirect' : {
                tag : "#REDIRECT[[_$]]",
                abbr : 'Hdn',
                display : 'Hidden Comment'
            },
            'Redirect' : {
                tag : "#REDIRECT[[_$]]",
                abbr : 'Hdn',
                display : 'Hidden Comment'
            },
            'Reference' : {
                tag : "<ref>_$</ref>",
                abbr : 'Ref',
                display : 'Reference'
            },
            'Include Only' : {
                tag : "<includeonly>_$</includeonly>",
                abbr : 'Incl',
                display : 'Include Only'
            },
            'No Include' : {
                tag : "<noinclude>_$</noinclude>",
                abbr : 'NIncl',
                display : 'No Include'
            },
        },
        'Special Characters' : {
            'title' : {
                tag : '#hello',
                abbr : 'hel',
                display : 'hello tag'
            },
            'title2' : {
                tag : '#hello2',
                abbr : 'hel2',
                display : 'hello tag2'
            }
        },
        'Features And Media' : {
            'Gallery' : {
                tag : "<gallery>Image:_$|Caption</gallery>",
                abbr : 'Gal',
                display : 'Gallery'
            },
        }
    };

    function findTag(abbr){
        for(var tagGr in tags){
            if(tags.hasOwnProperty(tagGr) && typeof tags[tagGr] === 'object'){
                for(var tag in tags[tagGr]){
                    if(tags[tagGr].hasOwnProperty(tag) && typeof tags[tagGr][tag] === 'object'){
                        if (tags[tagGr][tag].abbr === abbr){
                            return tags[tagGr][tag].tag;
                        }
                    }
                }
            }
        }
        return false;
    }

    function isFirstCharValid(tag){
        return (tagStarts.indexOf(tag.substring(0,1)) != -1);
    }

    function isValid(tag){
        if(tag.length > tags.maxLength && isFirstCharValid(tag)) return true;
        return false;
    }

    function initializeLinks(){
        var links;
        Object.keys(configObj.sections).forEach(function(section){
            if(configObj.sections.hasOwnProperty(section)){
                links = configObj.sections[section].ul.getElementsByTagName('a');
                for(var i = 0; i < links.length; i++){
                    links[i].addEventListener('click', function(evt){
                        evt.preventDefault();
                        pubsub.publish('insert', this.innerText);
                    });
                }
            }
        });
    }

    function buildHTML(){
        var html = '';
        Object.keys(tags).forEach(function(tagGr){ //tu foricz
            if(tags.hasOwnProperty(tagGr) && typeof tags[tagGr] === 'object'){
                html+='<section class ="tagSection" data-tagType="'+tagGr+'">';
                html+='<h1>'+tagGr+'</h1><a href="" class="toggle">expand</a>';
                html+='<ul class="off">';
                Object.keys(tags[tagGr]).forEach(function(tag){ //i tu foricz
                    if(tags[tagGr].hasOwnProperty(tag)){
                        html+='<li>';
                        html+='<input type="checkbox" class="tagChb" name="'+tag+'">';
                        html+='<label for="'+tag+'">'+tag+'</label>';
                        html+='<a href="">'+tags[tagGr][tag].tag+'</a>';
                        html+='</li>';
                    }
                });
                html+='</ul></section>';
            }
        });
        html+='<p class="warning">Warning! You picked wrong number of tags for the animated menu (0 or >20)</p>';
        html+= '<input type="submit" value="Reload animated menu" class="save">';
        return html;
    }

    function expand(section){
        section.ul.classList.add('on');
        section.toggle.innerText = 'fold';
    }

    function fold(section){
        section.ul.classList.add('off');
        section.toggle.innerText = 'expand';
    }

    function activateToggle(){
        var toggles = configObj.wrapper.getElementsByClassName('toggle'),
            ul;
        for(var i = 0; i < toggles.length; i++){
            toggles[i].addEventListener('click', function(evt){
                evt.preventDefault();
                ul = this.parentElement.getElementsByTagName('ul')[0];
                if(ul.classList.contains('on')){
                    this.innerText = 'expand';
                    ul.classList.remove('on');
                }
                else{
                    ul.classList.add('on');
                    this.innerText = 'fold';
                }
            });
        }
    }

    function getActive(){ //returns elements with checkboxes in 'active' state
        var activeChb = [];
        for(var i = 0; i < configObj.checkboxes.length; i++){
            if(configObj.checkboxes[i].checked){
                activeChb.push(configObj.checkboxes[i]);
            }
        }
        return activeChb;
    }

    function setActiveTags(activeChb){
        for(var i = 0; i < activeChb.length; i++){
            curChb = activeChb[i];
            activeTags[curChb.name] = {
                tag : curChb.parentElement.getElementsByTagName('a')[0].innerText,
                abbr : '' //ToDo! -> extracting abbreviation from the tags dictionary
            };
        }
    }

    function onUpdate(){
        var activeChb = getActive();
        setActiveTags(activeChb);
        if(validate(activeTags)){
            if(configObj.warning.classList.contains('on')){
                configObj.warning.classList.remove('off');
            }
            //ask the animated menu to update itself
            pubsub.publish('menuUpdate', activeTags);
        }
        else{
            configObj.warning.classList.add('on');
        }
    }

    function validate(activeTags){
        var checker = 0;
        for(var key in activeTags){
            if(activeTags.hasOwnProperty(key))checker++;
        }
        return !!(checker <= maxItems && checker > 0);
    }

    function watchForSubmit(){
        configObj.submit.addEventListener('click', function(evt){
            evt.preventDefault();
            onUpdate();
        });
    }

    function init(){
        var configHTML = buildHTML(),
            wrapper = document.getElementsByClassName('tagListWrapper')[0];
        wrapper.innerHTML += configHTML;
        configObj = new ConfigObj(wrapper);
        activateToggle();
        initializeLinks();
        watchForSubmit();
    }
    return {
        init : init,
        findTag: findTag
    }
});