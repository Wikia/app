(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['param_required'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n		";
  stack1 = helpers['if'].call(depth0, depth0.isFile, {hash:{},inverse:self.program(4, program4, data),fn:self.program(2, program2, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n	";
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n			<input type=\"file\" name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'/>\n		";
  return buffer;
  }

function program4(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n			";
  stack1 = helpers['if'].call(depth0, depth0.defaultValue, {hash:{},inverse:self.program(7, program7, data),fn:self.program(5, program5, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n		";
  return buffer;
  }
function program5(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n				<textarea class='body-textarea' placeholder='(required)' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>"
    + escapeExpression(((stack1 = depth0.defaultValue),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</textarea>\n			";
  return buffer;
  }

function program7(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n				<textarea class='body-textarea' placeholder='(required)' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'></textarea>\n				<br />\n				<div class=\"content-type\" />\n			";
  return buffer;
  }

function program9(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n		";
  stack1 = helpers['if'].call(depth0, depth0.isFile, {hash:{},inverse:self.program(12, program12, data),fn:self.program(10, program10, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n	";
  return buffer;
  }
function program10(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n			<input class='parameter' class='required' type='file' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'/>\n		";
  return buffer;
  }

function program12(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n			";
  stack1 = helpers['if'].call(depth0, depth0.defaultValue, {hash:{},inverse:self.program(15, program15, data),fn:self.program(13, program13, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n		";
  return buffer;
  }
function program13(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n				<input class='parameter required' minlength='1' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "' placeholder='(required)' type='text' value='"
    + escapeExpression(((stack1 = depth0.defaultValue),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'/>\n			";
  return buffer;
  }

function program15(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n				<input class='parameter required' minlength='1' name='"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "' placeholder='(required)' type='text' value=''/>\n			";
  return buffer;
  }

  buffer += "<td class='code required'>"
    + escapeExpression(((stack1 = depth0.name),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</td>\n<td>\n	";
  stack2 = helpers['if'].call(depth0, depth0.isBody, {hash:{},inverse:self.program(9, program9, data),fn:self.program(1, program1, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n</td>\n<td>\n	<strong>";
  stack2 = ((stack1 = depth0.description),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</strong>\n</td>\n<td>";
  stack2 = ((stack1 = depth0.paramType),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</td>\n<td><span class=\"model-signature\"></span></td>\n";
  return buffer;
  });
})();