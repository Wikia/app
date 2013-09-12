(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['resource'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<div class='heading'>\n    <h2>\n        <a href='#!/"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "' onclick=\"Docs.toggleEndpointListForResource('"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "');\">/"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</a>\n    </h2>\n    <ul class='options'>\n        <li>\n            <a href='#!/"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "' id='endpointListTogger_"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'\n               onclick=\"Docs.toggleEndpointListForResource('"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "');\">Show/Hide</a>\n        </li>\n        <li>\n            <a href='#' onclick=\"Docs.collapseOperationsForResource('"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'); return false;\">\n                List Operations\n            </a>\n        </li>\n        <li>\n            <a href='#' onclick=\"Docs.expandOperationsForResource('"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'); return false;\">\n                Expand Operations\n            </a>\n        </li>\n        <li>\n            <a href='"
    + escapeExpression(((stack1 = depth0.url),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>Raw</a>\n        </li>\n    </ul>\n</div>\n<ul class='endpoints' id='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_endpoint_list' style='display:none'>\n\n</ul>\n";
  return buffer;
  });
})();