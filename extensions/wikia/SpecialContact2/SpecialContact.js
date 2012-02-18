var SpecialContact = {
	init: function() {
		$('.specialcontact-seclink-content-issue').trackClick('wiki/SpecialContact/content-issue');
		$('.specialcontact-seclink-user-conflict').trackClick('wiki/SpecialContact/user-conflict');
		$('.specialcontact-seclink-adoption').trackClick('wiki/SpecialContact/adoption');
		$('.specialcontact-seclink-account-issue').trackClick('wiki/SpecialContact/account-issue');
		$('.specialcontact-seclink-close-account').trackClick('wiki/SpecialContact/close-account');
		$('.specialcontact-seclink-rename-account').trackClick('wiki/SpecialContact/rename-account');
		$('.specialcontact-seclink-blocked').trackClick('wiki/SpecialContact/blocked');
		$('.specialcontact-seclink-using-wikia').trackClick('wiki/SpecialContact/using-wikia');
		$('.specialcontact-seclink-feedback').trackClick('wiki/SpecialContact/feedback');
		$('.specialcontact-seclink-bug').trackClick('wiki/SpecialContact/bug');
		$('.specialcontact-seclink-bad-ad').trackClick('wiki/SpecialContact/bad-ad');
		$('.specialcontact-seclink-wiki-name-change').trackClick('wiki/SpecialContact/wiki-name-change');
		$('.specialcontact-seclink-design').trackClick('wiki/SpecialContact/design');
		$('.specialcontact-seclink-features').trackClick('wiki/SpecialContact/features');
		$('.specialcontact-seclink-close-wiki').trackClick('wiki/SpecialContact/close-wiki');
		$('#SpecialContactFooterPicker a').trackClick('wiki/SpecialContact/footer-picker');
		$('#SpecialContactFooterNoForm a').trackClick('wiki/SpecialContact/footer-noform');
		$('#SpecialContactIntroNoForm a').trackClick('wiki/SpecialContact/intro-noform');
		$('#SpecialContactIntroForm a').trackClick('wiki/SpecialContact/intro-form');

		$('input[type=file]').change(function() {
			$(this).closest('p').next().show();
		});
	}
};

$(function() {
	SpecialContact.init();
});