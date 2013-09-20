<%--********************************************************************************
 * CruiseControl, a Continuous Integration Toolkit
 * Copyright (c) 2001, ThoughtWorks, Inc.
 * 200 E. Randolph, 25th Floor
 * Chicago, IL 60601 USA
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     + Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *
 *     + Redistributions in binary form must reproduce the above
 *       copyright notice, this list of conditions and the following
 *       disclaimer in the documentation and/or other materials provided
 *       with the distribution.
 *
 *     + Neither the name of ThoughtWorks, Inc., CruiseControl, nor the
 *       names of its contributors may be used to endorse or promote
 *       products derived from this software without specific prior
 *       written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE REGENTS OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ********************************************************************************--%>
<%@page isErrorPage="true"%>
<%@page import="java.io.CharArrayWriter,
            java.io.PrintWriter,
            javax.servlet.http.HttpUtils"%>
<%
    String name = System.getProperty("ccname", "");
    String host = request.getServerName();

    String message = exception.getMessage();
    if (message == null) {
        message = "(null)";
    }
    CharArrayWriter stackTraceWriter = new CharArrayWriter();
    exception.printStackTrace(new PrintWriter(stackTraceWriter, true));
    String stackTrace = stackTraceWriter.toString();
    application.log(HttpUtils.getRequestURL(request) + ": " + message, exception);
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title><%= name%> phpUnderControl 0.6.1beta1 at <%= host %> - Error</title>
    <link type="application/rss+xml" rel="alternate" href="<%= request.getContextPath() %>/rss" title="RSS" />
    <link type="text/css" rel="stylesheet" href="<%= request.getContextPath() %>/css/php-under-control.css?v=3" />
    <link rel="icon" href="<%= request.getContextPath() %>/favicon.ico" type="image/x-icon" />
  </head>
  <body>
    <div id="serverData" style="display:none;"></div>
    <div id="container">
      <h1>
        <a href="<%=request.getContextPath() %>/index">phpUnderControl</a>
      </h1>
      <h1 class="white" align="center">
        <%= name%> phpUnderControl at <%= host %> - Error [
        <em id="servertime"><%@ include file="servertime.jsp" %></em>
        ]
      </h1>
      
      <h2><%=message %></h2>
      <pre><%= stackTrace %></pre>
    </div>
    <%@ include file="footer.jsp" %>
    <script type="text/javascript" src="<%= request.getContextPath() %>/js/prototype.js"></script>
    <script type="text/javascript" src="<%= request.getContextPath() %>/js/php-under-control.js?v=3"></script>
  </body>
</html>
