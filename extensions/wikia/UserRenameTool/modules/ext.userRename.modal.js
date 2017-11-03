(function ($, mw) {
	var confirmationModal = {
		init: function () {
			this.$form = $('#renameuser');
			this.$isConfirmed = this.$form.find('input[name=isConfirmed]');

			if (this.$form.data('showConfirm')) {
				this.bindEvents();
				this.disableInputs();
				this.$form.trigger('submit');
			}
		},

		bindEvents: function () {
			this.$form.on('submit', this.onSubmit.bind(this));
		},

		onOk: function () {
			this.$isConfirmed.val('true');
			this.$form.trigger('submit');
		},

		isConfirmed: function () {
			return this.$isConfirmed.val() === 'true';
		},

		disableInputs: function () {
			this.$form.find('input').not(':input[type=submit]').attr('readonly', true);
		},

		onSubmit: function (event) {
			if (this.isConfirmed()) {
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
