/**
 * Defines the applyDynatree() function, which turns an HTML "tree" of
 * checkboxes or radiobuttons into a dynamic and collapsible tree of options
 * using the Dynatree JS library.
 *
 * @author Mathias Lidal
 * @author Yaron Koren
 */

( function( $, mw, sf ) {
	'use strict';

	// Attach the Dynatree widget to an existing <div id="tree"> element
	// and pass the tree options as an argument to the dynatree() function.
	jQuery.fn.applyDynatree = function() {
		var node = this;
		var selectMode = 2;
		var checkboxClass = "dynatree-checkbox";
		if (node.find(":input:radio").length) {
			selectMode = 1;
			checkboxClass = "dynatree-radio";
		}

		// @HACK - normally, the "classNames" parameter for the
		// dynatree() call only requires *changes* to the default set
		// of class names. However, for trees contained in multiple-
		// instance templates, the default classNames array is just
		// blank. So we need to add the "selected" value in here,
		// because that gets used later on. Ideally, the underlying
		// bug causing the big blank value would be fixed instead.
		var newClassNames = {
			checkbox: checkboxClass,
			selected: "dynatree-selected"
		};

		node.dynatree({
			checkbox: true,
			minExpandLevel: 1,
			classNames: newClassNames,
			selectMode: selectMode,
			onClick: function (dtNode, event) {
				var targetType = dtNode.getEventTargetType(event);
				if ( targetType === "expander" ) {
					dtNode.toggleExpand();
				} else if ( targetType === "checkbox" ||
					   targetType === "title" ) {
					dtNode.toggleSelect();
				}

				return false;
			},

			// Un/check checkboxes/radiobuttons recursively after
			// selection.
			onSelect: function (select, dtNode) {
				var inputkey = "chb-" + dtNode.data.key;
				node.find("[id='" + inputkey + "']").attr("checked", select);
			},
			// Prevent reappearing of checkbox when node is
			// collapsed.
			onExpand: function (select, dtNode) {
				$("#chb-" + dtNode.data.key).attr("checked",
					dtNode.isSelected()).addClass("hidden");
			}
		});

		// Update real checkboxes according to selections.
		$.map(node.dynatree("getTree").getSelectedNodes(),
			function (dtNode) {
				$("#chb-" + dtNode.data.key).attr("checked", true);
				dtNode.activate();
			});
		var activeNode = node.dynatree("getTree").getActiveNode();
		if (activeNode !== null) {
			activeNode.deactivate();
		}

	};

}( jQuery, mediaWiki, sf ) );
