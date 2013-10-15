/*global define */
/**
 * textView handling in WikiaMobileEditor
 *
 * @author Bartłomiej Kowalczyk
 */

define( 'editor', ['wikia.nirvana'], function( nirvana ){

    //textBox object from DOM
    var textBox = document.getElementById( 'wpTextbox1' ),

        suggestionBox = document.getElementById( 'suggestionBox' ),

    //group of indicators of textBox state
        watcher = {
            //indicates sniffing for possible snippet input
            snippet : false,

            //indicates sniffing for possible tag to close
            tBlength : false,

            //indicates sniffing for possible API suggestions to come
            suggestions : false
        },

        patterns = {
            //indicator of desirable caret position
            caret : /_\$/,

            //characters breaking snippet sniffing
            snippetBreakers : /[^a-zA-Z0-9\.\:]/,

            //character indicating the beginning and the end of a snippet
            snippetChar : '!',

            //characters breaking a suggestion
            suggestionBreakers : /[\[\]\t\n]/,

            //char separating extensions of a snippet
            extChar : ':'
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
        else{

            caretShift = phrase.length;
        }

        caretShift += textBox.selectionStart;

        textBox.value = textBox.value.substring( 0, textBox.selectionStart ) +
            phrase + textBox.value.substring( textBox.selectionStart, textBox.value.length );

        textBox.selectionStart = textBox.selectionEnd = caretShift;
        textBox.focus();
    }


    //controlling possible events related to user keyboard input
    function watch( handleSnippets ){

        textBox.addEventListener( 'keyup', function(){

            handleSnippets( textBox, patterns, insert );

            handleSuggestions();

            closeTags();

            watcher.tBlength = textBox.value.length;
        } );
    }

    // automatic closing -> if <tag> then it appends </tag> and sets caret in between
    function closeTags(){

        //check if a tag might've been closed
        if( textBox.value[textBox.selectionStart-1] != '>' || textBox.value.length < watcher.tBlength) return;

        var startPos = textBox.value.substring( 0, textBox.selectionStart - 1).lastIndexOf( '<' ),
            endPos = textBox.selectionStart - 1;

        if( startPos != -1 && startPos > textBox.value.substring( 0, endPos ).lastIndexOf( '>' )
            && !textBox.value.substring( startPos+1, endPos-1 ).match( patterns.snippetBreakers ) ){

            var tag = textBox.value.substring( startPos+1, endPos );
            var parityCheck = '_$' + textBox.value.substring( textBox.selectionStart,
                textBox.selectionStart + tag.length + 3);
            var closure = '_$</' + tag + '>';
            if( tag && closure != parityCheck ) insert( '_$</' + tag + '>' )
        }
    }

    function initSuggestionBox(){

        suggestionBox.addEventListener( 'click', function( evt ){

           if( evt.target.classList.contains( 'suggestion' ) ){

               var phrase = evt.target.innerText,
                   beginning = textBox.value.substring( textBox.value.substring( 0,
                       textBox.selectionEnd-1 ).lastIndexOf( '[' ) + 1, textBox.selectionEnd );

               textBox.value = textBox.value.substring(0, textBox.selectionEnd - beginning.length) +
                   textBox.value.substring(textBox.selectionEnd, textBox.value.length);

               textBox.selectionEnd = textBox.selectionStart = textBox.selectionStart -= beginning.length;

               var ending = ( textBox.value.substring( textBox.selectionStart, textBox.selectionStart + 2 )
                   === "]]" ) ? "" : "]]";

               if( !ending ) {

                   watcher.suggestions = false;
                   hideSuggestions();
               }
               insert( phrase + ending + '_$' );
           }
           hideSuggestions();
        });
    }

    //check if user opened internal link with [[ and trigger API search
    function handleSuggestions(){

        //check if you can activate link suggestions ('[[' as start of the internal link)
        if( !watcher.suggestions ){
            if( textBox.value.substring( textBox.selectionStart - 3, textBox.selectionStart - 1) === '[[' ){

                // start suggestion attempts on next char
                watcher.suggestions = true;
            }
            return;
        }

        //if any of (whitespaces, link ender, chars forbidden for url) appears, kill the suggestions
        if( textBox.value[textBox.selectionEnd - 1].match( patterns.suggestionBreakers ) ){
            watcher.suggestions = false;
            hideSuggestions();
            return;
        }

        var text = textBox.value.substring( 0, textBox.selectionEnd );
        var phrase = text.substring( text.lastIndexOf( '[' ) + 1, textBox.selectionEnd );
        if( phrase ){

            //update suggestionBox position even if no new results
            suggestionBox.style.top = getTextHeight() + 'px';
            getSuggestions( phrase );
        }
    }

    //wrapper for SearchSuggestionsAPI returning array of first link records
    function getSuggestions( query ){

        hideSuggestions();
        var data = {};
        data.query = query;

        nirvana.getJson('SearchSuggestionsApi', 'getList', data).done(function(data){

            if(typeof data !== 'error'){

                // parsing data from json to array of suggestions with a limit of 3 (optimal for mobile screens)
                var suggs = [];
                //var limit = (data.items.length < 3) ? data.items.length : 3;
                for(var i = 0; i < data.items.length; i++){

                    suggs[i] = data.items[i].title;
                }

                if( suggs ) showSuggestions( suggs );
            }
        });
    }

    //shows suggestionBox if there are suggestions to display
    function showSuggestions( suggs ){

        suggestionBox.innerHTML = '';
        for( var i = 0; i < suggs.length; i++ ){
            suggestionBox.innerHTML += '<li class="suggestion">' + suggs[i] + '</li>';
        }
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
        textBoxClone.id = 'tempClone';
        textBoxClone.style = textBox.style;

        //setting clone to be 1px (fully scrollable) and not affecting layout of the page
        textBoxClone.style.height = '1px';
        textBoxClone.style.position = 'absolute';
        textBoxClone.style.visibility = 'hidden';
        if( !( textBox.scrollHeight > textBox.offsetHeight ) ) textBoxClone.classList.add('hiddenScrollbar');

        //appending clone to DOM to measure height
        textBox.parentElement.appendChild(textBoxClone);
        var height = textBoxClone.scrollHeight;
        textBox.parentElement.removeChild(textBoxClone);

        //adjustment if user scrolled textarea manually
        height -= textBox.scrollTop;

        //setting the distance from the top of the document
        height += textBox.getBoundingClientRect().top + window.scrollY;

        return height;
    }

    //module initializer
    function init( handleSnippets ){

        textBox.scrollIntoView();

        initSuggestionBox();

        //init of user interaction watcher
        watch( handleSnippets );
    }

    return {

        textBox : textBox,

        init : init,

        insert : insert,

        patterns: patterns
    }

} );