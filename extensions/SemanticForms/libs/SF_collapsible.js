/**
 * SF_collapsible.js
 *
 * Allows for collapsible fieldsets.
 *
 * This code was originally based heavily on the 'coolfieldset' jQuery plugin:
 * http://w3shaman.com/article/jquery-plugin-collapsible-fieldset
 *
 * Now it's less so, because that code used a .toggle() function that was
 * removed in jQuery 1.9.
 */

function sfHideFieldsetContent(obj){
	obj.find('div').slideUp( 'medium' );
	obj.removeClass("sfExpandedFieldset");
	obj.addClass("sfCollapsedFieldset");
}

function sfShowFieldsetContent(obj){
	obj.find('div').slideDown( 'medium' );
	obj.removeClass("sfCollapsedFieldset");
	obj.addClass("sfExpandedFieldset");
}

jQuery.fn.sfMakeCollapsible = function(){
	this.each(function(){
		var fieldset = jQuery(this);

		fieldset.children('legend').click( function() {
			if (fieldset.hasClass('sfCollapsedFieldset')) {
				sfShowFieldsetContent(fieldset);
			} else {
				sfHideFieldsetContent(fieldset);
			}
		});
		sfHideFieldsetContent(fieldset);
	});
};

jQuery(document).ready(function() {
	jQuery('.sfCollapsibleFieldset').sfMakeCollapsible();
});
