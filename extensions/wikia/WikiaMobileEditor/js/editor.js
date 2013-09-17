define('editor', ['pubsub', 'wikia.nirvana'], function(pubsub, nirvana){
    var editArea = document.getElementById('wpTextbox1'),
        pattern = /_\$/,
        length = editArea.value.length,
        suggestionBox = document.getElementById('suggestionBox'),
        snippets = {
            active: false,
            tagsActive: false
        },
        suggestions = {
            active: false
        },
        caret = 0;

    function watchForTags(){
        pubsub.subscribe('insert', function(tag){
            insertTags(tag);
        });
    }

    function insertTags(phrase){ //distFromEnd - number of chars from end to center of the phrase
        var startPos, endPos, cursorPos, halvesOfText = [], inText='', distFromEnd= 0;
        if(phrase.match(pattern)){ //extracts _$ if present to know the cursor position
            halvesOfText = phrase.split('_$');
            distFromEnd = halvesOfText[1].length;
            if(editArea.selectionStart != editArea.selectionEnd){
                inText = editArea.value.substring(editArea.selectionStart, editArea.selectionEnd);
            }
            phrase = halvesOfText[0] + inText + halvesOfText[1];
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
        cursorPos = (halvesOfText[1] && inText) ? endPos+phrase.length - distFromEnd - inText.length + halvesOfText[1].length
            : endPos+phrase.length - distFromEnd;
        editArea.focus();
        editArea.setSelectionRange(cursorPos, cursorPos);
    }

    function checkSnippet(evt){
        pubsub.publish('checkSnippet', evt);
    }

    function endTags(){
        var char = editArea.value[editArea.selectionStart-1];
        if(char != '<' && char != '>') return;
        if(!snippets.tagsActive && editArea.value[editArea.selectionStart-1] === '<'){
            snippets.tagsActive = true;
            return;
        }
        var posEnd = editArea.selectionStart-1,
            posStart = posEnd,
            abbr = '';
        while(posStart){
            if(editArea[posStart] == " " || editArea[posStart] == "\n") return;
            if(editArea[posStart] === '<') break;
            abbr = editArea.value[posStart] + abbr;
            posStart--;
        }
        if(abbr){
            editArea.setSelectionRange(posEnd+1, posEnd+1);
            insertTags('</'+abbr+'>');
            snippets.tagsActive = false;
        }
    }

    function watchForSnippets(){
        editArea.addEventListener('keyup', function(evt){
            checkIfToSuggest();
            checkSnippet(evt);
            if(editArea.value.length > length){
                length = editArea.value.length;
                endTags();
            }
        });
    }

    function checkIfToSuggest(){
        if(!suggestions.active){
            if(editArea.value.substring(editArea.selectionStart-3, editArea.selectionStart-1) === '[['){
                suggestions.active = true;
            }
            return;
        }
        if(editArea.value[editArea.selectionEnd-1] === ']'){
            suggestions.active = false;
        }
        var text = editArea.value.substring(0, editArea.selectionEnd);
        var phrase = text.substring(text.lastIndexOf('[')+1, editArea.selectionEnd);
        if(phrase.length > 3){
            getSuggestions(phrase);
        }
    }

    function getTextHeight(){
        var text = editArea.value;
        editArea.value = text.substring( 0, editArea.selectionEnd );
        editArea.style.height = '1px';
        var height = editArea.scrollHeight;
        editArea.style.height = '';
        editArea.value = text;
        return height;
    }

    function getSuggestions(query){
        data = {};
        data.query = query;
        nirvana.getJson('SearchApi', 'getList', data).done(function(data){/*, function(data){*/
            if(typeof data !== 'error'){
                var suggs = [];
                var limit = (data.items.length < 3) ? data.items.length : 3;
                for(var i = 0; i < limit; i++){
                    suggs[i] = data.items[i].title;
                }
                showSuggestions(suggs);
            }

        });/*, function(error){

        });*/
    }

    function initSuggestions(){
        document.addEventListener('click', function(){
            if(event.target.classList.contains('suggestion')){
                editArea.focus();
                var text = editArea.value.substring(0, caret-1);
                var text2 = editArea.value.substring(caret, editArea.value.length);
                debugger;
                text = text.substring(0, text.lastIndexOf('[')+1);
                editArea.value = text + text2;
                editArea.selectionStart = editArea.selectionEnd = caret;
                insertTags(event.target.innerHTML + ']]');
            }
            hideSuggestions();
        });
    }

    function showSuggestions(suggs){
        caret = editArea.selectionEnd;
        suggestionBox.innerHTML = '';
        for(var i = 0; i < suggs.length; i++){
            suggestionBox.innerHTML += '<li class="suggestion">' + suggs[i] + '</li>';
        }
        suggestionBox.style.top = (getTextHeight() + editArea.getBoundingClientRect().top) + 'px';

        if(suggestionBox.classList.contains('off'))suggestionBox.classList.remove('off');
    }

    function hideSuggestions(){
        if(!suggestionBox.classList.contains('off'))suggestionBox.classList.add('off');
        suggestionBox.innerHTML = '';
    }

    function init(){
        initSuggestions();
        watchForTags();
        watchForSnippets();
    }

    return{
        init: init,
        editArea: editArea,
        insertTags: insertTags,
        snippets: snippets,
    };
});
