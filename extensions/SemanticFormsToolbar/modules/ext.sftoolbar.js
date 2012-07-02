// sftoolbar.js
// Main JavaScript for Semantic Forms Toolbar items.
// Provides a template for toolbar dialogs that use Semantic Forms.
// 
// Simple usage:
// $j('#wpTextbox1').wikiEditor( 'addDialog', {'test-form' : sfToolbar.getDialog('Form:Test' ) } )
// 
// $j('#wpTextbox1').wikiEditor( 'addToToolbar',
// 	{ 'section' : 'main', 'group' : 'insert', 'tools' : {
// 		'test-dialog' : { 'label' : 'Test form', 'type' : 'button',
// 		'icon' : 'insert-reference.png',
// 		'action' : {
// 			'type' : 'dialog', 'module' : 'test-form'
// 		}
// 	} } } );

sfToolbar = {
	'template' : {
		'form' : undefined,
		
		'titleMsg' : 'sftoolbar-dialog-title',

		'id' : 'sftoolbar-dialog',

		'html' : '<form class="sftoolbar-dialog-form sftoolbar-loading"></div>',

		'init' : function() {
		},
		
		'dialog' : {
			'width'  : 500,
			'class'  : 'sftoolbar-dialog',
			'buttons': { /*
				'sftoolbar-insert' : function() {
					var citation = $j('#citetool-dialog-textbox').val();
					var wikitext = '<ref name="'+citation+'">{{Cite|'+citation+'}}</ref>';
					var context = $j(this).data('context');
	
					if ( typeof context == undefined || !context ) {
						return;
					}
	
					$j(this).dialog('close');
					$j('#citetool-dialog-textbox').val('');
					$j('#citetool-dialog-preview').html('');
	
					$j.wikiEditor.modules.toolbar.fn.doAction(
						context, {
							'type' : 'replace',
							'options' : {
								'pre' : wikitext
							}
						}, $j(this) );
				} // sftoolbar-insert
			*/}, // buttons
			
			'open' : function() {
				var context = $(this).data( 'context' );
				
				var selection = context.$textarea.textSelection( 'getSelection' );
				
				// If we have a selection, and it's a template,
				//  reload the form
				selection = selection.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
				if ( selection.substr(0,2) != '{{' ||
					selection.substr( selection.length - 2 ) != '}}' )
				{
					selection = '';
				}
				
				// Request HTML from the API.
				var form = $j(this).find('.sftoolbar-dialog-form').attr('sft_form');
				var dialogBox = $j(this).find('.sftoolbar-dialog-form');
				$j(this).addClass('sftoolbar-loading');
				
				var context = $(this).data( 'context' );
				var request = {
					'action' : 'sftoolbar',
					'form' : form,
					'output' : 'html',
					'input-wikitext' : selection
				};
				$j(this).data('form',form);
				
				var saveAction = function() {
					var formArray = $j('.sftoolbar-dialog-form').formToArray();
					var data = {};
					
					$j.each(formArray, function() {
						data[this.name] = this.value;
					} );
					
					var saveRequest = {
						'action' : 'sftoolbar',
						'form' : form,
						'output' : 'wikitext',
						'input-data' : JSON.stringify(data)
					};
					
					sfToolbar.apiRequest( saveRequest, function(data) {
						var wikitext = data.sftoolbar.wikitext;
						
						wikitext = wikitext.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
						
						$j.wikiEditor.modules.toolbar.fn.doAction(
							context, {
								'type' : 'replace',
								'options' : {
									'pre' : wikitext
								}
							}, $j(this) );
							
						dialogBox.parent().dialog('close');
						
						dialogBox.html('');
					} );
					
					return false;
				};
				
				sfToolbar.apiRequest( request, function(data) {
					var html = $j(data.sftoolbar.html);
					
					html.find('#wpSave').attr('id', 'sftoolbar-save');
					html.find('#wpPreview').remove();
					html.find('#wpDiff').remove();
					html.find('.editHelp').remove();
					
					html.find('#sftoolbar-save').click( saveAction );
					
					$j('.sftoolbar-dialog-form').html(html).removeClass('sftoolbar-loading');
				} );
			}
		} // dialog
	}, // template
	
	'apiRequest' : function( request, callback ) {
		request.format = 'json';

		var path = wgScriptPath+'/api'+wgScriptExtension;
		$j.post( path, request,
			function(data) {
				if ( callback ) {
					callback(data);
				}
			}, 'json' );
	}, // apiRequest
	
	'getDialog' : function(form) {
		var dialog = $j.extend( {}, sfToolbar.template, { 'form' : form } );
		
		dialog.html = $j(dialog.html);
		dialog.html.attr('sft_form', form);
		
		dialog.html = $j('<div/>').append(dialog.html).html();
		
		return dialog;
	}
	
}; //sfToolbar

// Shamelessly stolen from the jQuery form plugin, which is licensed under the GPL.
// http://jquery.malsup.com/form/#download
$.fn.formToArray = function() {
	var a = [];
	if (this.length == 0) return a;

	var form = this[0];
	var els = form.elements;
	if (!els) return a;
	for(var i=0, max=els.length; i < max; i++) {
		var el = els[i];
		var n = el.name;
		if (!n) continue;

		var v = $.fieldValue(el, true);
		if (v && v.constructor == Array) {
			for(var j=0, jmax=v.length; j < jmax; j++)
				a.push({name: n, value: v[j]});
		}
		else if (v !== null && typeof v != 'undefined')
			a.push({name: n, value: v});
	}

	if (form.clk) {
		// input type=='image' are not found in elements array! handle it here
		var $input = $(form.clk), input = $input[0], n = input.name;
		if (n && !input.disabled && input.type == 'image') {
			a.push({name: n, value: $input.val()});
			a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
		}
	}
	return a;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
	var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
	if (typeof successful == 'undefined') successful = true;

	if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
		(t == 'checkbox' || t == 'radio') && !el.checked ||
		(t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
		tag == 'select' && el.selectedIndex == -1))
			return null;

	if (tag == 'select') {
		var index = el.selectedIndex;
		if (index < 0) return null;
		var a = [], ops = el.options;
		var one = (t == 'select-one');
		var max = (one ? index+1 : ops.length);
		for(var i=(one ? index : 0); i < max; i++) {
			var op = ops[i];
			if (op.selected) {
				var v = op.value;
				if (!v) // extra pain for IE...
					v = (op.attributes && op.attributes['value'] &&
						!(op.attributes['value'].specified))
							? op.text : op.value;
				if (one) return v;
				a.push(v);
			}
		}
		return a;
	}
	return el.value;
};
