/*global define */
/**
 * textView handling in WikiaMobileEditor
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'editor', function(){

    //textBox object from DOM
    var textBox = document.getElementById( 'wpTextbox1' ),

        suggestionBox = document.getElementById( 'suggestionBox' ),

    //group of indicators of textBox state
        watcher = {
            //indicates sniffing for possible snippet input
            snippet : false,

            //indicates sniffing for possible tag to close
            tagEnder : false,

            //indicates sniffing for possible API suggestions to come
            suggestions : false
        },

        patterns = {
            //indicator of desirable caret position
            caret : /_\$/,

            //characters breaking snippet sniffing
            snippetBreakers : /[^a-zA-Z0-9]/,

            //character indicating the beginning and the end of a snippet
            snippetChar : '!',

            //characters breaking a suggestion
            suggestionBreakers : /[^a-zA-Z0-9\.\:]/
        }

    //inserts a phrase into textBox
    function insert( phrase ){

        if( !phrase ) return;

        //will store future shift of the caret if special caret string attached
        var caretShift = 0;

        // if there's no selection / caret position, set it to beginning of the text
        if( !textBox.selectionStart && textBox.selectionEnd != 0 )
            textBox.selectionStart = textBox.selectionEnd = 0;

        //if desired caret position is forced by special caret string
        if( phrase.match( patterns.caret )){
            var splPhrase = phrase.split( patterns.caret );
            phrase = splPhrase.join('');

            //only first special string will be transformed into caret position, rest will be ignored
            caretShift = splPhrase[0].length;
        }

        caretShift += textBox.selectionStart;

        textBox.value = textBox.value.substring( 0, textBox.selectionStart ) +
            phrase + textBox.value.substring( textBox.selectionStart, textBox.value.length );

        textBox.selectionStart = textBox.selectionEnd = caretShift;
        textBox.focus();
    }

    //controlling possible events related to user keyboard input
    function watch(){

        textBox.addEventListener( 'keyup', function(){

            handleSnippets();

            handleSuggestions();

            closeTags();
        } );
    }

    //check if user possible wrote snippet <special_char><tag_shortcut><special_char>
    function handleSnippets(){

        //ignore if anything else than snippet pattern given
        if( textBox.value[textBox.selectionStart-1] != patterns.snippet ) return;
        var endPos = textBox.selectionStart - 1;

        //if there is no special snippet char within 6 last items (max snippet length = 5)
        if( !textBox.value.substring( endPos - 5, endPos - 1 ).match( patterns.snippet ) ) return;
        var startPos = textBox.value.substring( 0, endPos).lastIndexOf( patterns.snippet );
        if( textBox.value.substring( startPos+1, endPos ).match( patterns.snippetBreakers ) ) return;

        textBox.value = textBox.value.substring( 0, startPos ) +
            textBox.value.substring( endPos + 1 );
        textBox.selectionStart = textBox.selectionEnd  -= (endPos - startPos);
    }

    function closeTags(){

        //check if a tag might've been closed
        if( textBox.value[textBox.selectionStart-1] != '>' ) return;

        var startPos = textBox.value.substring( 0, textBox.selectionStart - 1).lastIndexOf( '<' ),
            endPos = textBox.selectionStart - 1;

        if( startPos != -1 && startPos > textBox.value.substring( 0, endPos ).lastIndexOf( '>' )
            && !textBox.value.substring( startPos+1, endPos-1 ).match( patterns.snippetBreakers ) ){

            var tag = textBox.value.substring( startPos+1, endPos );
            var parityCheck = '_$' + textBox.value.substring( textBox.selectionStart,
                textBox.selectionStart + tag.length + 3);
            var closure = '_$</' + tag + '>';
            if( tag && closure != parityCheck )insert( '_$</' + tag + '>' )
        }
    }

    function initSuggestionBox(){

        suggestionBox.addEventListener('click', function(evt){
           if( evt.target.classList.contains( 'suggestion' ) ){
               var phrase = evt.target.innerText,
                   beginning = textBox.value.substring( textBox.value.lastIndexOf( '[' ), textBox.selectionEnd - 1 );

               //remove beginning (which was already written by the user), add closure ']]' and insert
               insert( phrase.replace( beginning, '' ) + ']]');
               hideSuggestions();
           }
        });
    }

    //check if user opened internal link with [[ and trigger API search
    function handleSuggestions(){

        //check if you can activate link suggestions ('[[' as start of the internal link)
        if( !suggestions.active ){
            if( editArea.value.substring( editArea.selectionStart - 3, editArea.selectionStart - 1) === '[[' ){

                // start suggestion attempts on next char
                suggestions.active = true;
            }
            return;
        }

        //if any of (whitespaces, link ender, chars forbidden for url) appears, kill the suggestions
        if( editArea.value[editArea.selectionEnd - 1].match( patterns.suggestionBreakers ) ){
            suggestions.active = false;
            hideSuggestions();
            return;
        }

        var text = editArea.value.substring( 0, editArea.selectionEnd );
        var phrase = text.substring( text.lastIndexOf( '[' ) + 1, editArea.selectionEnd );
        if( phrase ){
            getSuggestions( phrase );
        }
    }

    //wrapper for SearchSuggestionsAPI returning array of first link records
    function getSuggestions( query ){

        var data = {};
        data.query = query;

        nirvana.getJson('SearchSuggestionsApi', 'getList', data).done(function(data){
            if(typeof data !== 'error'){

                // parsing data from json to array of suggestions with a limit of 3 (optimal for mobile screens)
                var suggs = [];
                var limit = (data.items.length < 3) ? data.items.length : 3;
                for(var i = 0; i < limit; i++){
                    suggs[i] = data.items[i].title;
                }

                if(suggs)showSuggestions(suggs);
            }
        });
    }

    //shows suggestionBox if there are suggestions to display
    function showSuggestions( suggs ){

        for( var i = 0; i < suggs.length; i++ ){
            suggestionBox.innerHTML += '<li class="suggestion">' + suggs[i] + '</li>';
        }
        suggestionBox.style.top = getTextHeight() + 'px';
        if(suggestionBox.classList.contains('off'))suggestionBox.classList.remove('off');
    }

    //hides suggestionBox
    function hideSuggestions(){

        if( !suggestionBox.classList.contains( 'off' ))suggestionBox.classList.add( 'off' );
        suggestionBox.innerHTML = '';
    }

    //gets height of text in textBox
    function getTextHeight(){
        //cloning textBox into hidden element of 1px;
        var textBoxClone = textBox.cloneNode(true);
        textBoxClone.value = textBox.value.substring(0, textBox.selectionStart);

        //setting clone to be 1px (fully scrollable) and not affecting layout of the page
        textBoxClone.style.height = '1px';
        textBoxClone.style.position = 'absolute';
        textBoxClone.style.visibility = 'hidden';

        //appending clone to DOM to measure height
        textBox.parentElement.appendChild(textBoxClone);
        var height = textBoxClone.scrollHeight;
        textBox.parentElement.removeChild(textBoxClone);

        //adjustment if user scrolled textarea manually
        height -= textBox.scrollY;

        //setting the distance from the top of the document
        height += textBox.getBoundingClientRect().top + window.scrollY;

        return height;
    }

    //module initializer
    function init(){

    }

    return {

        init : init,

        insert : insert
    }

} );