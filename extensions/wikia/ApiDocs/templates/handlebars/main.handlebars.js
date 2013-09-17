(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['main'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n        , <span style=\"font-variant: small-caps\">api version</span>: "
    + escapeExpression(((stack1 = depth0.apiVersion),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\n        ";
  return buffer;
  }

  buffer += "\n<div class='container' id='resources_container'>\n    <ul id='resources'>\n    </ul>\n\n    <div class=\"footer\">\n        <br>\n        <br>\n        <h4 style=\"color: #999\">[ <span style=\"font-variant: small-caps\">base url</span>: "
    + escapeExpression(((stack1 = depth0.basePath),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\n        ";
  stack2 = helpers['if'].call(depth0, depth0.apiVersion, {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "]</h4>\n    </div>\n</div>\n";
  return buffer;
  });
})();