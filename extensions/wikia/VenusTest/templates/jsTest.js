(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['jsTest'] = template({"1":function(depth0,helpers,partials,data) {
  var stack1, helper, functionType="function", escapeExpression=this.escapeExpression, buffer = "\r\n	<li>"
    + escapeExpression(((helper = helpers.name || (depth0 && depth0.name)),(typeof helper === functionType ? helper.call(depth0, {"name":"name","hash":{},"data":data}) : helper)))
    + "\r\n		<ul>\r\n			<li><strong>Age:</strong> "
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.data)),stack1 == null || stack1 === false ? stack1 : stack1.age)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</li>\r\n			<li><strong>Gender:</strong> "
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.data)),stack1 == null || stack1 === false ? stack1 : stack1.gender)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</li>\r\n			<li><strong>Food:</strong><ul>\r\n					";
  stack1 = helpers.each.call(depth0, ((stack1 = (depth0 && depth0.data)),stack1 == null || stack1 === false ? stack1 : stack1.food), {"name":"each","hash":{},"fn":this.program(2, data),"inverse":this.noop,"data":data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  return buffer + "\r\n				</ul>\r\n			</li>\r\n		</ul>\r\n	</li>\r\n	";
},"2":function(depth0,helpers,partials,data) {
  var functionType="function", escapeExpression=this.escapeExpression;
  return "\r\n					<li>"
    + escapeExpression((typeof depth0 === functionType ? depth0.apply(depth0) : depth0))
    + "</li>\r\n					";
},"compiler":[5,">= 2.0.0"],"main":function(depth0,helpers,partials,data) {
  var stack1, helper, functionType="function", escapeExpression=this.escapeExpression, buffer = "<p>This is handlebars test "
    + escapeExpression(((helper = helpers.i || (depth0 && depth0.i)),(typeof helper === functionType ? helper.call(depth0, {"name":"i","hash":{},"data":data}) : helper)))
    + "</p>\r\n<p>Team: "
    + escapeExpression(((helper = helpers.team || (depth0 && depth0.team)),(typeof helper === functionType ? helper.call(depth0, {"name":"team","hash":{},"data":data}) : helper)))
    + "</p>\r\n<p>Members: <ul>\r\n	";
  stack1 = helpers.each.call(depth0, (depth0 && depth0.members), {"name":"each","hash":{},"fn":this.program(1, data),"inverse":this.noop,"data":data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  return buffer + "\r\n</ul></p>";
},"useData":true});
})();