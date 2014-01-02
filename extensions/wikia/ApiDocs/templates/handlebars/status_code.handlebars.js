(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['status_code'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<td width='15%' class='code'>"
    + escapeExpression(((stack1 = depth0.code),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</td>\n<td>";
  stack2 = ((stack1 = depth0.reason),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</td>\n\n";
  return buffer;
  });
})();