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
    + "');\">\n            <span class=\"collapse-button\">collapse</span>\n            <span class=\"expand-button\">expand</span>\n\n            <span class=\"api-name\">/"
    + escapeExpression(((stack1 = depth0.readableName),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n            <span class=\"description\">"
    + escapeExpression(((stack1 = depth0.description),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n        </a>\n    </h2>\n</div>\n<ul class='endpoints' id='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_endpoint_list' style='display:none'>\n\n</ul>\n";
  return buffer;
  });
})();