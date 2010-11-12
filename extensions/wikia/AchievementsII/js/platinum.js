var SpecialCustomizePlatinum = {

	init : function() {
		// enable awarding to multiple users - a new field is created when one is typed into,
		// need to use live to work with replaced forms after update
		// TODO: use delegate instead of live
		$(".customize-platinum-badge .award-to input").live("keypress", function() {
			var elm = $(this);

			//check if already binded to avoid bulk cloning
			if(elm.data('keypress_binded') != true) {
				elm.parent().clone(true).appendTo($(this).closest("ul"));
				elm.unbind("keypress");
				elm.data('keypress_binded', true);
			}
		});
		
		$('.sponsored-fields input[name="is_sponsored"]').live(($.browser.webkit) ? 'change' : 'click', SpecialCustomizePlatinum.switchSponsored);
	},

	// turn view mode into edit mode
	edit : function(o) {
		$(o).closest(".customize-platinum-badge").toggleClass("readonly editable").find("[disabled]").removeAttr("disabled").end().find(".button-edit, .button-cancel, .button-save").toggle();
	},

	// turn edit mode into view mode
	cancel : function(o) {
		var badge = $(o).closest('form');
		
		badge.find('textarea, input').attr('disabled', 'disabled');
		$("#body").addClass("ajax");

		$.get(
			'/index.php',
			{
				'action': 'ajax',
				'rs': 'AchAjax',
				'method': 'resetPlatinumBadge',
				'type_id': badge.find("input[name='type_id']").val()
			},
			function(response){
				var badgeForm = $("input[name='type_id'][value='" + response.typeId + "']").closest('form');
				badgeForm.replaceWith(response.output);

				//need to refresh the selection
				//$("input[name='type_id'][value='" + response.typeId + "']").closest('form').find('.sponsored-fields input[name="is_sponsored"]').click(SpecialCustomizePlatinum.switchSponsored);

				$("#body").removeClass("ajax");
			},
			'json'
		)
	},

	switchSponsored: function(){
		var source = $(this);;
		var inputSet = source.closest('.sponsored-fields').find('.sponsored-fields-2, .sponsored-fields-3');
		var descrSet = source.closest(".customize-platinum-badge").find('.description-fields');

		if(source.attr('checked')){
			inputSet.show();
			descrSet.hide();
		}
		else{
			inputSet.hide();
			descrSet.show();
		}
	},

	addSubmit : function(form) {
		var badge = $(form).find(".customize-platinum-badge");
		var msg = SpecialCustomizePlatinum.validateInput(badge);

		if(msg != '') alert(msg);
		else {
			$.AIM.submit(form, {onComplete: SpecialCustomizePlatinum.onAdded});
			
			//unbind original html element handler to avoid loops
			form.onsubmit = null;
			
			$(form).submit();
			//block user input
			if(!$.browser.webkit)
				badge.find('textarea, input').attr('disabled', 'disabled');
			
			$("#body").addClass("ajax");
		}
		return false;
	},

	onAdded : function(response) {
		//append the new form to the list
		$(".CustomizePlatinum h2").after(response.output);

		//clear form status
		var badgeForm = $('#createPlatinumForm');
		badgeForm.find('textarea, input').removeAttr('disabled');

		if(response.errors != null) {
			alert(response.errors.join('\n'));
		} else {
			badgeForm[0].reset();
		}
		
		//rebind original html element handler previously unbinded
		badgeForm[0].onsubmit =  function(){return SpecialCustomizePlatinum.addSubmit(this);};
		$("#body").removeClass("ajax");
	},

	editSubmit : function(form) {
		var badge = $(form).children().first();
		var msg = SpecialCustomizePlatinum.validateInput(badge);
		
		if(msg != '') alert(msg);
		else {
			$.AIM.submit(form, {onComplete: SpecialCustomizePlatinum.onEdited});
			
			//unbind original html element handler to avoid loops
			form.onsubmit = null;
			
			$(form).submit();
			//block user input
			if(!$.browser.webkit)
				badge.find('textarea, input, checkbox').attr('disabled', 'disabled');
			
			$("#body").addClass("ajax");
		}
		
		return false;
	},

	onEdited : function(response) {
		//append the new form to the list
		var badgeForm = $("input[name='type_id'][value='" + response.typeId + "']").closest('form');
		
		if(response.errors != null) {
			//errros found, restore the form status and give feedback
			badgeForm.find('textarea, input, checkbox').removeAttr('disabled');
			badgeForm.attr('onsubmit', 'SpecialCustomizePlatinum.editSubmit(this)')
			
			//rebind original html element handler previously unbinded
			badgeForm[0].onsubmit =  function(){return SpecialCustomizePlatinum.editSubmit(this);};
			
			alert('Please fix the following issues:\n\n- '+response.errors.join('\n- '));
		} else {
			badgeForm.replaceWith(response.output);
		}
		
		$("#body").removeClass("ajax");
	},

	validateInput: function(badge){
		//error checking
		var errors = 0;
		var urlErrors = 0;
		var isSponsored = badge.find("input[name='is_sponsored']").attr('checked');
		var msg = '';

		if(badge.find("legend input[type='text']").val() == "") {
			msg += "\n\n- fill in the badge's name field";
		}

		if(badge.find("textarea[name='awarded_for']").val() == "" && !isSponsored) {
			msg += "\n\n- fill in the \"Awarded for\" field";
		}

		if(badge.find("textarea[name='how_to']").val() == "" && !isSponsored) {
			msg += "\n\n- fill in the \"How to earn\" field";
		}

		if(badge.hasClass('new') && badge.find("div.column input[type='file']").val() == "") {
			msg += "\n\n- supply a badge image";
		}

		if(isSponsored){
			if(badge.find('.sponsored-hover img').length == 0 && badge.find(".sponsored-fields-3 input[type='file']").val() == ""){
				msg += "\n\n- supply an image file for the \"Hover picture\" field";
			}
		}

		if(msg != '') msg = "Please fix the following issues:" + msg;

		return msg;
	}
};

$(function() {
	SpecialCustomizePlatinum.init();
});
