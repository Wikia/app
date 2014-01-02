(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['operation'] = template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, stack2, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1, stack2;
  buffer += "\n                <h4>Implementation Notes</h4>\n                <p>";
  stack2 = ((stack1 = depth0.notes),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "</p>\n                ";
  return buffer;
  }

function program3(depth0,data) {
  
  
  return "\n                    <h4>Response Class</h4>\n                    <p><span class=\"model-signature\" /></p>\n                    <br/>\n                    <div class=\"content-type\" />\n                ";
  }

function program5(depth0,data) {
  
  
  return "\n                    <h4>Parameters</h4>\n                    <table class='fullwidth'>\n                        <thead>\n                        <tr>\n                            <th>Parameter</th>\n                            <th>Value</th>\n                            <th>Description</th>\n                            <th>Parameter Type</th>\n                            <th>Data Type</th>\n                        </tr>\n\n                        </thead>\n                        <tbody class=\"operation-params\">\n\n                        </tbody>\n                    </table>\n                    ";
  }

function program7(depth0,data) {
  
  
  return "\n                    <div style='margin:0;padding:0;display:inline'></div>\n                    <h4>Error Status Codes</h4>\n                    <table class='fullwidth'>\n                        <thead>\n                        <tr>\n                            <th>HTTP Status Code</th>\n                            <th>Reason</th>\n                        </tr>\n                        </thead>\n                        <tbody class=\"operation-status\">\n                        \n                        </tbody>\n                    </table>\n                    ";
  }

function program9(depth0,data) {
  
  
  return "\n                    ";
  }

function program11(depth0,data) {
  
  
  return "\n                    <div class='sandbox_header'>\n                        <input class='submit bt_large_blue' name='commit' type='button' value='Try it out!' />\n                        <a href='#' class='response_hider' style='display:none'>Hide Response</a>\n                        <div   alt='Throbber' class='response_throbber'  style='display:none' />\n                    </div>\n                    ";
  }

  buffer += "\n    <ul class='operations' >\n      <li class='"
    + escapeExpression(((stack1 = depth0.httpMethod),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + " operation' id='"
    + escapeExpression(((stack1 = depth0.resourceName),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.nickname),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.httpMethod),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.number),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "'>\n            <a href='#!/"
    + escapeExpression(((stack1 = depth0.resourceName),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "/"
    + escapeExpression(((stack1 = depth0.nickname),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.httpMethod),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.number),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "' class=\"heading toggleOperation\">\n                <h3>\n                  <span class='http_method'>\n                    HTTP "
    + escapeExpression(((stack1 = depth0.httpMethod),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\n                  </span>\n                  <span class=\"collapse-expand-button\"></span>\n                  <span class=\"summary\">\n                      ";
  stack2 = ((stack1 = depth0.summary),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                  </span>\n                  <span class='path'>\n                      <b>URL:</b> ";
  stack2 = ((stack1 = depth0.path),typeof stack1 === functionType ? stack1.apply(depth0) : stack1);
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                  </span>\n                </h3>\n            </a>\n            <div class='content' id='"
    + escapeExpression(((stack1 = depth0.resourceName),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.nickname),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.httpMethod),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_"
    + escapeExpression(((stack1 = depth0.number),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "_content'>\n                ";
  stack2 = helpers['if'].call(depth0, depth0.notes, {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                ";
  stack2 = helpers['if'].call(depth0, depth0.responseClass, {hash:{},inverse:self.noop,fn:self.program(3, program3, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                <form accept-charset='UTF-8' class='sandbox'>\n                    <div style='margin:0;padding:0;display:inline'></div>\n                    ";
  stack2 = helpers['if'].call(depth0, depth0.parameters, {hash:{},inverse:self.noop,fn:self.program(5, program5, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                    ";
  stack2 = helpers['if'].call(depth0, depth0.errorResponses, {hash:{},inverse:self.noop,fn:self.program(7, program7, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                    ";
  stack2 = helpers['if'].call(depth0, depth0.isReadOnly, {hash:{},inverse:self.program(11, program11, data),fn:self.program(9, program9, data),data:data});
  if(stack2 || stack2 === 0) { buffer += stack2; }
  buffer += "\n                </form>\n                <div class='response' style='display:none'>\n                    <div class=\"response_top\">\n                        <div class='container_left'>\n                            <h4>Request URL</h4>\n                            <div class='block request_url'><input readonly=\"readonly\" class='copy_in'/></div>\n                        </div>\n                        <div class='container_right'>\n                            <h4>Response Code</h4>\n                            <div class='block response_code'></div>\n                        </div>\n                    </div>\n                    <input class='copy bt_medium_blue'  type='button' value='Select URL' />\n                    <h4>Response Body</h4>\n                    <div class='block response_body'></div>\n                    <h4>Response Headers</h4>\n                    <div class='block response_headers'></div>\n                </div>\n            </div>\n        </li>\n    </ul>\n";
  return buffer;
  });
})();