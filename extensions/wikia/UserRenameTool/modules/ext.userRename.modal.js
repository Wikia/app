(function ($, mw) {
	var confirmationModal = {
		init: function () {
			this.accepted = false;
			this.$form = $('#renameuser');
			this.bindEvents();
		},

		bindEvents: function () {
			this.$form.on('submit', this.onSubmit.bind(this));
		},

		onOk: function () {
			this.$form.trigger('submit', {accepted: true});
		},

		onSubmit: function (event, params) {
			if (params && params.accepted) {
				return;
			}

			event.preventDefault();
			$.confirm({
				onOk: this.onOk.bind(this),
				title: mw.message('renameuser').escaped(),
				content: mw.message('userrenametool-confirm-intro').escaped(),
				okMsg: mw.message('userrenametool-confirm-yes').escaped(),
				cancelMsg: mw.message('userrenametool-confirm-no').escaped()
			});
		}
	};

	$(document).ready(function () {
		confirmationModal.init();
	});
})($, mediaWiki);
