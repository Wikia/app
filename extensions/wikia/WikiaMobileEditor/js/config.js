define('config', ['pubsub', 'wikia.loader', 'wikia.mustache'], function(pubsub, loader, mustache){

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
                abbr : 'b',
                display : "'' ''"
            },
            'Italic' : {
                tag : "'''_$'''",
                abbr : 'i',
                display : "''' '''"
            },
            'Small' : {
                tag : "<small>_$</small>",
                abbr : 'sm',
                display : '&lt;small&gt;&lt;/small&gt;'
            },
            'Superscript' : {
                tag : "<sup>_$</sup>",
                abbr : 'sup',
                display : '&lt;sup&gt;&lt;/sup&gt;'
            },
            'Subscript' : {
                tag : "<sub>_$</sub>",
                abbr : 'sub',
                display : '&lt;sub&gt;&lt;/sub&gt;'
            },
            'Level 2 Headline' : {
                tag : "==_$==",
                abbr : 'h2',
                display : 'Level 2 Headline'
            },
            'Blockquote' : {
                tag : "<blockquote>_$</blockquote>",
                abbr : 'qte',
                display : 'Blockquote'
            },
        },
        'Wiki Markup' : {
            'Internal Link' : {
                tag : "[[_$]]",
                abbr : 'int',
                display : '[[]]'
            },
            'External Link' : {
                tag : "[http://_$ title]",
                abbr : 'ext',
                display : '[http:// title]'
            },
            'Embedded File' : {
                tag : "[[File:_$]]",
                abbr : 'file',
                display : '[[File:]]'
            },
            'Media File Link' : {
                tag : "[Media:_$]",
                abbr : 'med',
                display : '[Media:]'
            },
            'Math Formula' : {
                tag : "<math>_$</math>",
                abbr : 'math',
                display : '&lt;math&gt;_$&lt;/math&gt;'
            },
            'Ignore Wiki' : {
                tag : "<nowiki>_$</nowiki>",
                abbr : 'ign',
                display : '&lt;nowiki&gt;&lt;/nowiki&gt;'
            },
            'Username And Time' : {
                tag : "~~~~",
                abbr : 'usr',
                display : 'Username and time'
            },
            'Horizontal Line' : {
                tag : "----",
                abbr : 'hrzl',
                display : '----'
            },
            'Strike' : {
                tag : "<strike>_$</strike>",
                abbr : 'str',
                display : '&lt;strike&gt;_$&lt;/strike&gt;'
            },
            'Hidden Comment' : {
                tag : "<!-- _$ -->",
                abbr : 'hdn',
                display : '&lt;!-- _$ --&gt;'
            },
            'Category' : {
                tag : "[[Category:_$]]",
                abbr : 'cat',
                display : '[[Category:]]'
            },
            'Redirect' : {
                tag : "#REDIRECT[[_$]]",
                abbr : 'red',
                display : 'REDIRECT[[]]'
            },
            'Reference' : {
                tag : "<ref>_$</ref>",
                abbr : 'ref',
                display : '&lt;ref&gt;&lt;/ref&gt;'
            },
            'Include Only' : {
                tag : "<includeonly>_$</includeonly>",
                abbr : 'incl',
                display : '&lt;includeonly&gt;&lt;/includeonly&gt;'
            },
            'No Include' : {
                tag : "<noinclude>_$</noinclude>",
                abbr : 'noinc',
                display : '&lt;noinclude&gt;&lt;/noinclude&gt;'
            }
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
                abbr : 'gal',
                display : '&lt;gallery&gt;Image:|Caption&lt;/gallery&gt;'
            }
        }
    };

    function findTag(abbr){
        for(var tagGr in tags){
            if(tags.hasOwnProperty(tagGr) && typeof tags[tagGr] === 'object'){
                for(var tag in tags[tagGr]){
                    if(tags[tagGr].hasOwnProperty(tag) && typeof tags[tagGr][tag] === 'object'){
                        if (tags[tagGr][tag].abbr === abbr){
                            return tags[tagGr][tag];
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
		return (tag.length > tags.maxLength && isFirstCharValid(tag));
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
                        html+='<input type="checkbox" class="tagChb" name="'+tags[tagGr][tag].abbr+'">';
                        html+='<label for="'+tags[tagGr][tag].abbr+'">'+tag+'</label>';
                        html+='<a href="">'+tags[tagGr][tag].display+'</a>';
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
            activeTags[curChb.name] = findTag(curChb.name);
        }
    }

    function storeTags(tags){
        localStorage.setItem('tags', JSON.stringify(tags));
    }

    function getTagsFromStorage(){
        return JSON.parse(localStorage.getItem('tags'));
    }

    function onUpdate(){
        var activeChb = getActive();
        setActiveTags(activeChb);
        if(validate(activeTags)){
            if(configObj.warning.classList.contains('on')){
                configObj.warning.classList.remove('off');
            }
            //ask the animated menu to update itself
            storeTags(activeTags);
            pubsub.publish('menuUpdate', activeTags);
        }
        else{
            configObj.warning.classList.add('on');
        }
        activeTags = {};
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
		loader({
			type: loader.MULTI,
			resources: {
				mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_tagList.mustache'
			}
		}).done(function(resp){
			console.log(mustache.render(resp.mustache[0],{tagSections: {name: 'data'}}))
		});


        var configHTML = buildHTML(),
            wrapper = document.getElementsByClassName('tagListWrapper')[0];
        wrapper.innerHTML += configHTML;
        configObj = new ConfigObj(wrapper);
        if(localStorage['tags']){
            activeTags = getTagsFromStorage();
            onUpdate();
        }
        activateToggle();
        initializeLinks();
        watchForSubmit();
    }
    return {
        init : init,
        findTag: findTag
    }
});