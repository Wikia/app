(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['param_list'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, self=this, functionType="function", escapeExpression=this.escapeExpression;

function program1(depth0,data) {
  
  
  return "\n        ";
  }

function program3(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n            ";
  stack1 = helpers['if'].call(depth0, depth0.defaultValue, {hash:{},inverse:self.program(6, program6, data),fn:self.program(4, program4, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n        ";
  return buffer;
  }
function program4(depth0,data) {
  
  
  return "\n            ";
  }

function program6(depth0,data) {
  
  
  return "\n                <option selected=\"\" value=''></option>\n            ";
  }

function program8(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n            ";
  stack1 = helpers['if'].call(depth0, depth0.isDefault, {hash:{},inverse:self.program(11, program11, data),fn:self.program(9, program9, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n        ";
  return buffer;
  }
function program9(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n                <option value='"
    + escapeExpression(((stack1 = depth0.value),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>"
    + escapeExpression(((stack1 = depth0.value),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + " (default)</option>\n            ";
  return buffer;
  }

function program11(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n                <option value='"
    + escapeExpression(((stack1 = depth0.value),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>"
    + escapeExpression(((stack1 = depth0.value),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</option>\n            ";
  return buffer;
  }

  buffer += "<td class='code'>"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</td>\n<td>\n    <select class='parameter' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>\n        ";
  stack2 = helpers['if'].call(depth0, depth0.required, {hash:{},inverse:self.program(3, program3, data),fn:self.program(1, program1, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n        ";
  stack2 = helpers.each.call(depth0, ((stack1 = depth0.allowableValues),stack1 == null || stack1 === false ? stack1 : stack1.descriptiveValues), {hash:{},inverse:self.noop,fn:self.program(8, program8, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n    </select>\n</td>\n<td>";
  stack2 = ((stack1 = depth0.description),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</td>\n<td>";
  stack2 = ((stack1 = depth0.paramType),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</td>\n<td><span class=\"model-signature\"></span></td>\n";
  return buffer;
  });
})();