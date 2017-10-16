/*global define*/
define('ext.wikia.adEngine.provider.gpt.adElement', [
	'ext.wikia.adEngine.provider.gpt.adSizeConverter',
	'ext.wikia.adEngine.provider.gpt.adSizeFilter',
	'wikia.document',
	'wikia.log'
], function (adSizeConverter, adSizeFilter, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.adElement';

	function AdElement(slotName, slotPath, slotTargeting) {
		this.id = 'wikia_gpt' + slotPath;
		this.node = doc.getElementById(this.id);
		this.slotPath = slotPath;
		this.slotName = slotName;
		this.slotContainerId = this.id;

		if (!this.node) {
			this.node = doc.createElement('div');
			this.node.id = this.id;
		}
		if (slotTargeting.size) {
			this.sizes = adSizeConverter.toArray(slotTargeting.size);
			this.sizes = adSizeFilter.filter(slotName, this.sizes);
			delete slotTargeting.size;
			this.node.setAttribute('data-gpt-slot-sizes', JSON.stringify(this.sizes));
		} else {
			this.node.setAttribute('data-gpt-slot-type', 'out-of-page');
		}

		this.slotTargeting = slotTargeting;
		log(['AdElement', this], 'debug', logGroup);
	}

	AdElement.prototype.getId = function () {
		return this.id;
	};

	AdElement.prototype.getSlotContainerId = function () {
		return this.slotContainerId;
	};

	AdElement.prototype.setSlotContainerId = function (slotContainerId) {
		this.slotContainerId = slotContainerId;
	};

	AdElement.prototype.getSlotName = function () {
		return this.slotName;
	};

	AdElement.prototype.setSlotName = function (slotName) {
		this.slotName = slotName;
	};

	AdElement.prototype.getNode = function () {
		return this.node;
	};

	AdElement.prototype.getSlotPath = function () {
		return this.slotPath;
	};

	AdElement.prototype.getSizes = function () {
		return this.sizes;
	};

	AdElement.prototype.configureSlot = function (slot) {
		return AdElement.configureSlot(slot, this.slotTargeting, this.node);
	};

	AdElement.prototype.setPageLevelParams = function (pageLevelParams) {
		log(['setPageLevelParams', pageLevelParams], 'debug', logGroup);
		this.node.setAttribute('data-gpt-page-params', JSON.stringify(pageLevelParams));
	};

	AdElement.prototype.updateDataParams = function (event) {
		this.node.setAttribute('data-gpt-line-item-id', JSON.stringify(event.lineItemId));
		this.node.setAttribute('data-gpt-creative-id', JSON.stringify(event.creativeId));
		this.node.setAttribute('data-gpt-creative-size', JSON.stringify(event.size));
	};

	/**
	 * Configures GPT slot targeting
	 * @param {object} slot - GPT slot object
	 * @param {object} targeting - object with targeting properties
	 * @param {Node} [node] - slot's HTML node
	 */
	AdElement.configureSlot = function (slot, targeting, node) {
		var name,
			value;

		for (name in targeting) {
			if (targeting.hasOwnProperty(name)) {
				value = targeting[name];
				if (value) {
					log(['setSlot', 'slot.setTargeting', name, value], 'debug', logGroup);
					slot.setTargeting(name, value);
				}
			}
		}

		if (!node) {
			log(['setSlot', 'HTML node not provided, trying to retrieve from slot', slot], 'debug', logGroup);
			node = doc.getElementById(slot.getSlotElementId());
		}

		log(['setSlot', slot], 'debug', logGroup);
		node.setAttribute('data-gpt-slot-params', JSON.stringify(targeting));
	};

	return AdElement;
});
