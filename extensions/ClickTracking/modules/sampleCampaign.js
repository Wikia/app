/**
 * Sample campaign for ClickTracking
 */

// Check
if ( !mw.activeCampaigns ) {
	mw.activeCampaigns = {};
}

// Define new active campaign
mw.activeCampaigns.ArticleSave = {
	// Treatment name
	name: "ArticleSave",

	// Treatment version. Increment this when altering rates
	version: 2,

	// Rates are calculated out of the total sum, so
	// rates of x:10000, y:3, and z:1 mean users have a
	// chance of being in bucket x at 10000/10004,
	// y at 3/10004 and z at 1/10004
	// The algorithm is faster if these are ordered in descending order,
	// particularly if there are orders of magnitude differences in the
	// bucket sizes
	// "none" is reserved for control
	rates: {
		none: 10000,
		Bold: 3,
		Italics: 1
	},

	// Individual changes, function names corresponding
	// to what is in "rates" object
	// (note: "none" function not needed or used)
	Bold: function(){
		// Change edit button to bold
		jQuery( '#wpSave' ).css( 'font-weight', 'bolder' );
	},
	Italics: function(){
		// Change edit button to italics
		jQuery( '#wpSave' ).css( { 'font-weight': 'normal', 'font-style': 'italic' });
	},

	// "allActive" is reserved.
	// If this function exists, it will be apply to every user not in the "none" bucket
	allActive: function(){
		// FIXME: Calling trackAction() from a click handler of a button that submits a form DOES NOT WORK cross-browser
		// Add click tracking to save
		jQuery( '#wpSave' ).click(function(){ jQuery.trackAction( 'save' ); });
		// Add click tracking to preview
		jQuery( '#wpPreview' ).click(function(){ jQuery.trackAction( 'preview' ); });
		jQuery( '#editpage-copywarn' ).click(function(){ jQuery.trackAction( 'copywarn' ); });
	}

};
