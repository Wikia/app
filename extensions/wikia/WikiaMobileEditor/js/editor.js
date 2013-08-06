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
        editArea: editArea,
        insertTags: insertTags
    };
});
