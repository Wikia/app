(function( $ ){

	$._modalCreated = false;
	$._position = 1;
	$._timer =  null;
	$._caption = false;

	$.createModal =  function() {
		var modal = '<div id="modalWrapper">\
				<div id="modalTopBar"></div>\
				<div id="modalClose"></div>\
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


		$(document.body).delegate('#modalClose', 'click', function() {
			that.closeModal();
		});

		$(document.body).delegate('#modalWrapper', 'click', function() {
			that._resetTimeout();
		});

		this._modalCreated = true;
	};

	$.openModal =  function(options) {
		if(!this._modalCreated) this.createModal();
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

		$('#navigation, #WikiaPage, #wikiaFooter, #leftPane').hide();
		this._modal.addClass('modalShown');
		this._resetTimeout();
	};

	$._resetTimeout = function() {
		var allToHide = this._allToHide;

		allToHide.removeClass('hidden');

		clearTimeout(this._timer);
		this._timer = setTimeout(function() {
			allToHide.addClass('hidden');
		}, 3500);
	};

	$.closeModal =  function() {
		if(this._modalCreated) {
			this.hideModal();
			this._allToHide.html('');
		}
	};

	$.hideModal = function() {
		if(this._modalCreated) {
			var modal = this._modal;
			modal.removeClass('modalShown');
			this._allToHide.removeClass('hidden');
			$('#navigation, #WikiaPage, #wikiaFooter, #leftPane').show();
			window.scrollTo( 0, this._position );
			this._position = 1;
			clearTimeout(this._timer);
		}
	};

	$.isModalShown = function(){
		return this._modal.hasClass('modalShown');
	};
})(Zepto);