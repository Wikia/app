var MediaTool = MediaTool || (function () {

	/** @private **/
	var cart = null;
	var itemsCollection = null;
	var renderer = null;
	var resourceLoaderCache = null;
	var dialogWrapper = null;
	var currentView = "find"; // [ find, edit ]

	/* templates */
	var templateDialog = null;
	var templateCart = null;
	var templateItemsList = null;

	function loadResources() {
		return resourceLoaderCache = resourceLoaderCache ||
			$.Deferred(function (dfd) {
				$.when(
					$.getResources([
						wgExtensionsPath + '/wikia/MediaTool/js/Cart.js',
						wgExtensionsPath + '/wikia/MediaTool/js/Item.js',
						wgExtensionsPath + '/wikia/MediaTool/js/Renderer.js',
						wgExtensionsPath + '/wikia/MediaTool/js/ItemsCollection.js'
					]),
					$.loadMustache(),
					$.loadJQueryUI(),
					callBackend('getTemplates', function (resp) {
						templateDialog = resp['dialog'];
						templateCart = resp['cart'];
						templateItemsList = resp['itemsList'];
					})

				).done(dfd.resolve);
			}).promise();
	}
    var initModalComplete = false;

    function initModal() {
        if (!initModalComplete) {
            // loading resources, constructing dialog
            renderer = new MediaTool.Renderer();
            itemsCollection = new MediaTool.ItemsCollection('mediatool-thumbnail-browser', 'mediaToolItemList', 'mediaToolBasket');
            itemsCollection.template = templateItemsList;
            cart = new MediaTool.Cart('mediaToolBasket', 'mediaToolItemList');
            cart.template = templateCart;
            this.bind('Cart::itemsChanged', onCartContentChange);
            this.bind('showModal', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'open', wgCityId);});
            this.bind('editDone', function() {trackMUT(WikiaTracker.ACTIONS.CLICK, 'complete', wgCityId);});
            initModalComplete = true;
        }
    }

    function trackMUT(action, label, value) {
        /*
         tracking using new werehouse
         */
        WikiaTracker.trackEvent(null, {
            ga_category: 'mut',
            ga_action: action,
            ga_label: label || '',
            ga_value: value || 0
        }, 'internal');
    }

	function showModal(event) {
		var self = this;
		loadResources().done(function () {
            self.initModal();
			var processedhtml = $.mustache(templateDialog, {
					'cart':templateCart,
					'itemslist':$.mustache(templateItemsList, {
						'title':'Media recently added to wiki',
						'items':itemsCollection.items
					})
				}
			);
			dialogWrapper = $.showModal('MUT', processedhtml, { width:970, className:"MediaToolModal" });
			self.fire('showModal');

			appendUIActions.call(self);
			changeCurrentView( "find" );
		});
	}

	function onCartContentChange() {
		if(cart.isEmpty()) {
			$('.tabs li[data-tab=edit-media]').addClass('disabled');
			$('.MediaTool-buttons button[name=continue]').attr('disabled','disabled');
		} else {
			$('.tabs li[data-tab=edit-media]').removeClass('disabled');
			$('.MediaTool-buttons button[name=continue]').removeAttr('disabled');
		}
	}

	function closeModal() {
		//TODO: check state and add confirm
		$(dialogWrapper).closeModal();
	}

	function canEnterEditTab() {
		return cart.isEmpty() ? false : true;
	}

	function finalizeDialog() {
		this.fire('editDone', cart);
		this.closeModal();
	}

	function changeCurrentView(newView, fromTab) {

		if (newView == "edit") {

			if (canEnterEditTab()) {

				currentView = "edit";
				if (!fromTab) {
					$("ul.tabs li[data-tab='edit-media'] a", dialogWrapper).trigger("click");
				}
				$("button[name='done']", dialogWrapper).show();
				$("button[name='continue']", dialogWrapper).hide();
			}
		}

		if (newView == "find") {

			currentView = "find";
			$("button[name='done']", dialogWrapper).hide();
			$("button[name='continue']", dialogWrapper).show();
		}
	}

	function appendUIActions() {
		var self = this;
		$("button[name='cancel']", dialogWrapper).on("click", function (e) {
			closeModal();
		});
		$("button[name='continue']", dialogWrapper).on("click", function (e) {
			changeCurrentView("edit");
		});
		$("button[name='done']", dialogWrapper).on("click", function (e) {
			self.finalizeDialog();
		});

		$("ul.tabs li[data-tab='edit-media'] a", dialogWrapper).on("click", function (e) {
			changeCurrentView("edit", true);
		});
		$("ul.tabs li[data-tab='find-media'] a", dialogWrapper).on("click", function (e) {
			changeCurrentView("find", true);
		});
	}

	function callBackend(method, params, callback) {
		return $.nirvana.getJson(
			'MediaTool',
			method,
			params,
			callback
		);
	}

	/** @public **/
	var MediaToolClass = $.createClass(Observable, {

		constructor:function () {
			MediaToolClass.superclass.constructor.call(this);
			//this.debugEvents();
		},
        initModal: initModal,
		showModal: showModal,
		closeModal: closeModal,
		finalizeDialog: finalizeDialog,
		callBackend: callBackend,
		getCart: function () {
			return cart;
		},
		getItemsCollection: function () {
			return itemsCollection;
		},
		getRenderer: function() {
			return renderer;
		}
	});

	return new MediaToolClass;
})();