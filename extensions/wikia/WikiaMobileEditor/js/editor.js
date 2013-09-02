define('editor', ['pubsub', 'config'], function(pubsub, config){
    var editArea = document.getElementById('wpTextbox1'),
        pattern = /_\$/,
        snippets = {};

    function Snippets(){
        this.active = false;
    }

    function watchForTags(){
        pubsub.subscribe('insert', function(tag){
            insertTags(tag);
        });
    }

    function insertTags(phrase){ //distFromEnd - number of chars from end to center of the phrase
        var startPos, endPos, cursorPos, halvesOfText, inText='', distFromEnd= 0;
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
        cursorPos = endPos+phrase.length - distFromEnd;
        editArea.scrollIntoView();
        editArea.focus();
        editArea.setSelectionRange(cursorPos, cursorPos);
    }

    function checkSnippet(evt){
        if(editArea.value[editArea.selectionStart-1] != '!') return;
        if(!snippets.active){
            snippets.active = true;
            return;
        }
        evt.preventDefault();
        var abbr = "!",
            ch = "",
            tag,
            pos = editArea.selectionStart - 1,
            text = editArea.value.split("");
        while(pos) {
            ch = text.splice(pos-1,1);
            if(ch == " " || ch == "\n") {
                //resetSnippet();
                return;
            }
            abbr += ch;
            pos -= 1;
            if(ch == "!") {
                break;
            }
        }
        abbr = abbr.split('').splice(1, abbr.length-2).join('');
        tag = config.findTag(abbr.split('').reverse().join('')).tag;
        if(tag){
            var start = text.splice(0, pos);
            var end = text.splice(1, text.length);
            editArea.value = start.join('') + end.join('');
            editArea.setSelectionRange(pos,pos);
            insertTags(tag);
            resetSnippet();
        }

    }

    function resetSnippet(){
        snippets.active = false;
    }

    function watchForSnippets(){
        editArea.addEventListener('keyup', function(evt){
            checkSnippet(evt);
        });
    }

    function init(){
        watchForTags();
        snippets = new Snippets();
        watchForSnippets();
    }

    return{
        init: init,
        editArea: editArea,
        insertTags: insertTags
    };
});
