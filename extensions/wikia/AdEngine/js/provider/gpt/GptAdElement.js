/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gptAdElement', [
	'wikia.document',
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.provider.gptAdSizeConverter'
], function (doc, log, adLogicPageParams, adSizeConverter) {

	var logGroup = 'ext.wikia.adEngine.provider.gptAdElement',
		pageLevelParams = adLogicPageParams.getPageLevelParams();

	function AdElement(adDivId) {
		this.id = adDivId;
		this.node = doc.getElementById(adDivId);

		if (!this.node) {
			this.node = doc.createElement('div');
			this.node.id = adDivId;
		}
		log(['AdElement', this], 'debug', logGroup);
	}

	AdElement.prototype.getId = function () {
		return this.id;
	};

	AdElement.prototype.getNode = function () {
		return this.node;
	};

	AdElement.prototype.setPageLevelParams = function (pubads) {
		var name,
			value;

		for (name in pageLevelParams) {
			if (pageLevelParams.hasOwnProperty(name)) {
				value = pageLevelParams[name];
				if (value) {
					log(['setPageLevelParams', 'pubads.setTargeting', name, value], 'debug', logGroup);
					pubads.setTargeting(name, value);
				}
			}
		}

		log(['setPageLevelParams', pageLevelParams], 'debug', logGroup);
		this.node.setAttribute('data-gpt-page-params', JSON.stringify(pageLevelParams));
	};

	AdElement.prototype.setSizes = function (slotName, sizes) {
		this.sizes = adSizeConverter.convert(slotName, sizes);
		this.node.setAttribute('data-gpt-slot-sizes', JSON.stringify(this.sizes));

		log(['setSizes', this.sizes], 'debug', logGroup);
	};

	AdElement.prototype.getSizes = function () {
		return this.sizes;
	};

	AdElement.prototype.setSlotLevelParams = function (slot, slotTargeting) {
		var name,
			value;

		delete slotTargeting.size;
		for (name in slotTargeting) {
			if (slotTargeting.hasOwnProperty(name)) {
				value = slotTargeting[name];
				if (value) {
					log(['setSlotLevelParams', 'slot.setTargeting', name, value], 'debug', logGroup);
					slot.setTargeting(name, value);
				}
			}
		}

		log(['setSlotLevelParams', slotTargeting], 'debug', logGroup);
		this.node.setAttribute('data-gpt-slot-params', JSON.stringify(slotTargeting));
	};

	AdElement.prototype.setResponseLevelParams = function (event) {
		this.node.setAttribute('data-gpt-line-item-id', JSON.stringify(event.lineItemId));
		this.node.setAttribute('data-gpt-creative-id', JSON.stringify(event.creativeId));
		this.node.setAttribute('data-gpt-creative-size', JSON.stringify(event.size));
	};

	return AdElement;
});
