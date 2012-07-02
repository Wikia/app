/**
 * JavasSript for the Google translation functionality in the Live Translate extension.
 * @see http://www.mediawiki.org/wiki/Extension:Live_Translate
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

google.load("language", "1");
google.setOnLoadCallback(function(){google.language.getBranding("googlebranding");});

(function( $, lt ){ window.translationService = function() {
	
	var self = this;
	
	this.done = function(){};
	
	this.runningJobs = 0;
	
	// This is to enable a hack to decode quotes.
	this.textAreaElement = document.createElement( 'textarea' );
	
	/**
	 * Determines a chunk to translate of an DOM elements contents and calls the Google Translate API.
	 * Then calls itself if there is any remaining work to be done.
	 * 
	 * @param {array} untranslatedsentences
	 * @param {array} chunks
	 * @param {integer} currentMaxSize
	 * @param {string} sourceLang
	 * @param {string} targetLang
	 * @param {DOM element} element
	 */
	this.translateChunk = function( untranslatedsentences, chunks, currentMaxSize, sourceLang, targetLang, element ) {
		lt.debug( 'Google: Translating chunk' );
		var remainingPart = false;
		var partToUse = false;
		var sentenceCount = 0;
		var currentLength = 0;
		
		// Find the scentances that can be put in the current chunk.
		for ( i in untranslatedsentences ) {
			sentenceCount++;
			
			if ( currentLength + untranslatedsentences[i].length < currentMaxSize ) {
				currentLength += untranslatedsentences[i].length;
			}
			else if ( untranslatedsentences[i].length > 0 ) {
				if ( currentLength == 0 ) {
					// If the first scentance is longer then the max chunk legth, split it.
					partToUse = untranslatedsentences[i].substr( 0, currentMaxSize - currentLength );
					remainingPart = untranslatedsentences[i].substr( currentMaxSize - currentLength );
				}
				
				break;
			}
		}
		
		var chunk = '';
		
		// Build the chunck.
		for ( i = 0; i < sentenceCount; i++ ) {
			var part = untranslatedsentences.shift();
			
			if ( i != sentenceCount - 1 || partToUse === false ) {
				chunk += part; 
			}
		}
		
		// If there is a remaining part, re-add it to the scentances to translate list.
		if ( remainingPart !== false ) {
			untranslatedsentences.unshift( remainingPart );
		}
		
		// If there is a partial scentance, add it to the chunk.
		if ( partToUse !== false ) {
			chunk += partToUse;
		}
		
		// If the lenght is 0, the element has been translated.
		if ( chunk.length == 0 ) {
			this.handleTranslationCompletion();
			return;
		}

		// Keep track of leading and tailing spaces, as they often get modified by the GT API.
		var leadingSpace = chunk.substr( 0, 1 ) == ' ' ? ' ' : '';
		var tailingSpace = ( chunk.length > 1 && chunk.substr( chunk.length - 1, 1 ) == ' ' ) ? ' ' : '';
		
		google.language.translate(
			jQuery.trim( chunk ), // Trim, so the result does not contain preceding or tailing spaces.
			sourceLang,
			targetLang,
			function(result) {
				lt.debug( 'Google: Translated chunk' );
				
				if ( result.translation ) {
					chunks.push( leadingSpace + result.translation + tailingSpace );
				}
				else {
					// If the translation failed, keep the original text.
					chunks.push( chunk );
				}
				
				if ( untranslatedsentences.length == 0 ) {
					// If the current chunk was smaller then the max size, node translation is complete, so update text.
					self.textAreaElement.innerHTML = chunks.join( '' ); // This is a hack to decode quotes.
					element.replaceData( 0, element.length, self.textAreaElement.value );
					self.handleTranslationCompletion();
				}
				else {
					// If there is more work to do, move on to the next chunk.
					self.translateChunk( untranslatedsentences, chunks, currentMaxSize, sourceLang, targetLang, element );
				}
			}
		);	
	};
	
	/**
	 * Translates a single DOM element using Google Translate.
	 * Loops through child elements and recursively calls itself to translate these.
	 * 
	 * @param {jQuery} element
	 * @param {string} sourceLang
	 * @param {string} targetLang
	 */
	this.translateElement = function( element, sourceLang, targetLang ) {
		lt.debug( 'Google: Translating element' );
		this.runningJobs++;
		
		var maxChunkLength = 500;

		element.contents().each( function() {
			lt.debug( 'Google: Element conent item' );
			
			// If it's a text node, then translate it.
			if ( this.nodeType == 3 && typeof this.data === 'string' && $.trim( this.data ).length > 0 ) {
				lt.debug( 'Google: Found content node' );
				
				self.runningJobs++;
				self.translateChunk(
					this.data.split( new RegExp( "([.!?])(?=\\s+|$)", "gi" ) ), // "(\\S.+?[.!?])(?=\\s+|$)"
					[],
					maxChunkLength,
					sourceLang,
					targetLang,
					this
				);
			}
			// If it's an html element, check to see if it should be ignored, and if not, apply function again.
			else if ( this.nodeType != 3
				&& $.inArray( $( this ).attr( 'id' ), [ 'siteSub', 'jump-to-nav' ] ) == -1
				&& !$( this ).hasClass( 'notranslate' ) && !$( this ).hasClass( 'printfooter' )
				&& $( this ).text().length > 0 ) {
				
				lt.debug( 'Google: Found child node' );
				self.translateElement( $( this ), sourceLang, targetLang );
			}
			else {
				lt.debug( 'Google: Found ignore node' );
			}
		} );
		
		this.handleTranslationCompletion();
	};
	
	/**
	 * Should be called every time a DOM element has been translated.
	 * By use of the runningJobs var, completion of the translation process is detected,
	 * and further handled by this function.
	 */
	this.handleTranslationCompletion = function() {
		if ( !--this.runningJobs ) {
			lt.debug( 'Google: translation process done' );
			this.done();
		}
	}
	
}; })( jQuery, window.liveTranslate );