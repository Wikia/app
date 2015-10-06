$(function () {
    // Attach the dynatree widget to an existing <div id="tree"> element
    // and pass the tree options as an argument to the dynatree() function:
    var nodeSelection = $("div[id*=treeinput]");
    nodeSelection.each (function (index) {
        var node = nodeSelection.eq(index);
        var selectMode = 2;
        var checkboxClass = {checkbox: "dynatree-checkbox"};
        if (node.find(":input:radio").length) {
            selectMode = 1;
            checkboxClass = {checkbox: "dynatree-radio"};
        }

        node.dynatree({
            checkbox: true,
            minExpandLevel: 1,
            classNames: checkboxClass,
            selectMode: selectMode,
            onClick: function (node, event) {
                var targetType = node.getEventTargetType(event);
                if ( targetType == "expander" ) {
                    node.toggleExpand();
                } else if ( targetType == "checkbox" ||
                       targetType == "title" ) {
                    node.toggleSelect();
                }

                return false;
            },
            //Un/check real checkboxes recursively after selection
            onSelect: function (select, dtnode) {
                var inputkey = "chb-" + dtnode.data.key;
                $("[id='" + inputkey + "']").attr("checked", select);
            },
            //Prevent reappearing of checkbox when node is collapse
            onExpand: function (select, dtnode) {
                $("#chb-" + dtnode.data.key).attr("checked",
                    dtnode.isSelected()).addClass("hidden");
            }
        });
        //Update real checkboxes according to selections
        $.map(node.dynatree("getTree").getSelectedNodes(),
            function (dtnode) {
                $("#chb-" + dtnode.data.key).attr("checked", true);
                dtnode.activate();
            });
        var activeNode = node.dynatree("getTree").getActiveNode();
        if (activeNode !== null) {
            activeNode.deactivate();
        }
    });
});
