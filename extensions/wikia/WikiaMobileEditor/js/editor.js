define('editor', ['pubsub'], function(pubsub){
    var editArea = document.getElementById('editArea'),
        pattern = /_\$/,
        snippets = {};

    function Snippets(){
        this.active = false;
        this.break = false;
        this.isValid = function(string){
            if(string.length > editor.maxTagLength()) return false;
        }
    }

    function watchForTags(){
        pubsub.subscribe('insert', function(tag){
            insertTags(tag);
        });
    }

    function insertTags(phrase){ //distFromEnd - number of chars from end to center of the phrase
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

    function watchForSnippets(){
        editArea.addEventListener('keyup', function(evt){
            if(evt.keyCode === 49){ //49 = charCode('!')
                if(snippets.active && !snippets.break){
                    snippets.getSnippet();
                }
                else{
                    snippets.active = true;
                }
            }
            if(evt.keyCode === 32 && snippets.active){
                snippets.break = true;
            }
        });
    }

    function init(){
        watchForTags();
    }

    return{
        init: init,
        editArea: editArea,
        insertTags: insertTags
    };
});
