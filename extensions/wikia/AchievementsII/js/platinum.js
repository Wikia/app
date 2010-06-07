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
	},

	// turn view mode into edit mode
	edit : function(o) {
		$(o).closest(".customize-platinum-badge").toggleClass("readonly editable").find("[disabled]").removeAttr("disabled").end().find(".button-edit, .button-save").toggle();
	},

	addSubmit : function(form) {
		var badge = $(form).find(".customize-platinum-badge");

		//error checking
		var errors = 0;

		if(badge.find("legend input[type='text']").val() == '') {
			errors++;
		}

		badge.find("textarea").each(function() {
			if ($(this).val() == "") {
				errors++;
			}
		});

		if(badge.find("div.column input[type='file']").val() == "") {
			errors++;
		}

		if(errors) {
			alert("Please fill in all the fields and select an image for the badge.");
		} else {
			$.AIM.submit(form, {onComplete: SpecialCustomizePlatinum.onAdded});
			
			//unbind original html element handler to avoid loops
			form.onsubmit = null;
			
			$(form).submit();
			//block user input
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

		//error checking
		var errors = 0;

		if(badge.find("legend input[type='text']").val() == "") {
			errors++;
		}

		badge.find("textarea").each(function() {
			if($(this).val() == "") {
				errors++;
			}
		});

		if(errors) {
			alert("Please fill in the badge's name, \"Awarded for\" and \"How to earn\" fields.");
		} else {
			$.AIM.submit(form, {onComplete: SpecialCustomizePlatinum.onEdited});
			
			//unbind original html element handler to avoid loops
			form.onsubmit = null;
			
			$(form).submit();
			//block user input
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
	}
};

$(function() {
	SpecialCustomizePlatinum.init();
});
