/**
 * SF_collapsible.js
 *
 * Allows for collapsible fieldsets.
 *
 * Based on the 'coolfieldset' jQuery plugin:
 * http://w3shaman.com/article/jquery-plugin-collapsible-fieldset
 */

function sfHideFieldsetContent(obj, options){
	obj.find('div').slideUp(options.speed);
	obj.removeClass("sfExpandedFieldset");
	obj.addClass("sfCollapsedFieldset");
}

function sfShowFieldsetContent(obj, options){
	obj.find('div').slideDown(options.speed);
	obj.removeClass("sfCollapsedFieldset");
	obj.addClass("sfExpandedFieldset");
}

jQuery.fn.sfMakeCollapsible = function(options){
	var setting = { collapsed: true, speed: 'medium' };
	jQuery.extend(setting, options);

	this.each(function(){
		var fieldset = jQuery(this);
		var legend = fieldset.children('legend');
		if ( setting.collapsed == true ) {
			legend.toggle(
				function(){
					sfShowFieldsetContent(fieldset, setting);
				},
				function(){
					sfHideFieldsetContent(fieldset, setting);
				}
			)

			sfHideFieldsetContent(fieldset, {animation:false});
		} else {
			legend.toggle(
				function(){
					sfHideFieldsetContent(fieldset, setting);
				},
				function(){
					sfShowFieldsetContent(fieldset, setting);
				}
			)
		}
	});
}

jQuery(document).ready(function() {
	jQuery('.sfCollapsibleFieldset').sfMakeCollapsible();
});
