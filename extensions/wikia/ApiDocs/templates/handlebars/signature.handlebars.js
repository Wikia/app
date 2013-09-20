(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['signature'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<div>\n<ul class=\"signature-nav\">\n    <li><a class=\"description-link\" href=\"#\">Model</a></li>\n    <li><a class=\"snippet-link\" href=\"#\">Model Schema</a></li>\n</ul>\n<div>\n\n<div class=\"signature-container\">\n    <div class=\"description\">\n        ";
  stack2 = ((stack1 = depth0.signature),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n    </div>\n\n    <div class=\"snippet\">\n        <pre><code>"
    + escapeExpression(((stack1 = depth0.sampleJSON),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</code></pre>\n        <small class=\"notice\"></small>\n    </div>\n</div>\n\n";
  return buffer;
  });
})();