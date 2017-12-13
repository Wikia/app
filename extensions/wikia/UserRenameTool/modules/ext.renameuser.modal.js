(function ($, mw) {
	var confirmationModal = {
		init: function () {
			this.onSubmit = this.onSubmit.bind(this);
			this.onChange = this.onChange.bind(this);
			this.onOk = this.onOk.bind(this);

			this.config = mw.config.get('renameUser') || {};
			this.$form = $('#renameuser');
			this.$isConfirmed = this.$form.find('input[name=isConfirmed]');

			if (this.config.showConfirm) {
				this.bindEvents();
				this.$form.trigger('submit');
			}
		},

		bindEvents: function () {
			this.$form.on('submit', this.onSubmit);
			this.$form.on('change', this.onChange);
		},

		onOk: function () {
			this.$isConfirmed.val('true');
			this.$form.trigger('submit');
		},

		onChange: function () {
			this.$form.off('submit', this.onSubmit);
		},

		isConfirmed: function () {
			return this.$isConfirmed.val() === 'true';
		},

		onSubmit: function (event) {
			if (this.isConfirmed()) {
				return;
			}

			event.preventDefault();
			$.confirm({
				onOk: this.onOk,
				title: mw.message('renameuser').escaped(),
				content: mw.message(
					'userrenametool-confirm-intro',
					this.config.oldUsername,
					this.config.newUsername
				).plain(),
				okMsg: mw.message('userrenametool-confirm').escaped(),
				cancelMsg: mw.message('userrenametool-confirm-no').escaped()
			});
		}
	};

	$(document).ready(function () {
		confirmationModal.init();
	});
})($, mediaWiki);
