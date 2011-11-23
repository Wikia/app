(function( $ ){

	$._modalCreated = false;
	$._position = 1;
	$._timer =  null;
	$._caption = false;
	$._hideBarsAfter = 5500;

	$._createModal =  function() {
		var modal = '<div id="modalWrapper">\
				<div id="modalTopBar"></div>\
				<div id="modalClose">&times;</div>\
				<div id="modalContent"></div>\
				<div id="modalFooter"></div>\
			</div>',
		that = this;

		$('body').append(modal);

		this._modal = $('#modalWrapper');
		this._modalClose = $('#modalClose');
		this._modalTopBar = $('#modalTopBar');
		this._modalContent = $('#modalContent');
		this._modalFooter = $('#modalFooter');
		this._allToHide = this._modalTopBar.add(this._modalClose).add(this._modalFooter);
		this._thePage = $('#navigation, #WikiaPage, #wikiaFooter');


		$(document.body).delegate('#modalClose', 'click', function() {
			that.closeModal();
		});

		$(document.body).delegate('#modalWrapper', 'click', function() {
			that._resetTimeout();
		});

		this._modalCreated = true;
	};

	$.openModal =  function(options) {
		if(!this._modalCreated) this._createModal();
		options = options || {};

		if(options.html) {
			this._modalContent.html(options.html);
		} else {
			this._modalContent.html('No Content provided');
		}

		if(options.caption) {
			this._modalFooter.show();
			this._modalFooter.html(options.caption);
			this._caption = true;
		} else {
			this._caption = false;
			this._modalFooter.hide();
		}

		this._position = pageYOffset;

		this._thePage.hide();
		this._modal.addClass('modalShown');
		this._resetTimeout();
	};

	$._resetTimeout = function() {
		var allToHide = this._allToHide;

		allToHide.removeClass('hidden');

		clearTimeout(this._timer);
		this._timer = setTimeout(function() {
			allToHide.addClass('hidden');
		}, this._hideBarsAfter);
	};

	$.closeModal =  function() {
		if(this._modalCreated) {
			this.hideModal();
			this._modalContent.html('');
			this._modalFooter.html('');
		}
	};

	$.hideModal = function() {
		if(this._modalCreated) {
			var modal = this._modal;
			modal.removeClass('modalShown');
			this._allToHide.removeClass('hidden');
			this._thePage.show();
			window.scrollTo(0, this._position);
			this._position = 1;
			clearTimeout(this._timer);
		}
	};

	$.isModalShown = function(){
		return this._modal.hasClass('modalShown');
	};
})(Zepto);