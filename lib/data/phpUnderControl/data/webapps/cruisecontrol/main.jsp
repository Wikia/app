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
<%@page contentType="text/html; charset=utf-8"%>
<%@page errorPage="/error.jsp"%>
<%@page import="java.io.File" %>
<%@taglib uri="/WEB-INF/cruisecontrol-jsp11.tld" prefix="cruisecontrol"%>
<%
    String ccname  = System.getProperty("ccname", "");
    String project = request.getPathInfo().substring(1);

    boolean apidoc   = false;
    boolean browser  = false;
    boolean coverage = false;
%>
<cruisecontrol:artifactsLink>
<% 
    String log = new File(application.getInitParameter("logDir")).getAbsolutePath();
    String ts  = artifacts_url.substring(artifacts_url.lastIndexOf('/') + 1);

    File artifacts = new File(log + "/../artifacts/" + project + "/" + ts);

    if (!artifacts.exists()) {
        artifacts = new File(log + "/" + project + "/" + ts);
    }

    apidoc   = new File(artifacts.getAbsolutePath() + "/api").exists();
    browser  = new File(artifacts.getAbsolutePath() + "/php-code-browser").exists();
    coverage = new File(artifacts.getAbsolutePath() + "/coverage").exists();
%>
</cruisecontrol:artifactsLink>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title><%= ccname%> phpUnderControl 0.6.1beta1 - Build Results</title>
    <link type="text/css" rel="stylesheet" href="<%=request.getContextPath() %>/css/SyntaxHighlighter.css"/>
    <link type="text/css" rel="stylesheet" href="<%=request.getContextPath() %>/css/php-under-control.css?v=3"/>
    <link rel="icon" href="<%=request.getContextPath() %>/favicon.ico" type="image/x-icon" />
    <link type="application/rss+xml" rel="alternate" href="<%= request.getContextPath() %>/rss/<%= project %>" title="RSS"/>
  </head>
  <body>
    <div id="container">
      <%@ include file="header.jsp" %>
      <cruisecontrol:tabsheet>
        <tr>
          <td>
          
            <%-- phpUnderControl 1 --%>
          
            <cruisecontrol:tab name="buildResults" label="Overview" >
              <%@ include file="buildresults.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 2 --%>
            
            <cruisecontrol:tab name="testResults" label="Tests" >
              <%@ include file="phpunit.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 3 --%>

            <cruisecontrol:tab name="metrics" label="Metrics" >
              <%@ include file="metrics.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 4 --%>
              
            <% if (coverage) { %>
            <cruisecontrol:tab name="coverage" label="Coverage">
              <cruisecontrol:artifactsLink>
                <iframe src="<%=request.getContextPath() %>/<%= artifacts_url %>/coverage/index.html" class="tab-content">
                </iframe>
              </cruisecontrol:artifactsLink>
            </cruisecontrol:tab>
            <% } %>

            <%-- phpUnderControl 5 --%>

            <% if (browser) { %>
            <cruisecontrol:tab name="codeBrowser" label="Code Browser">
              <cruisecontrol:artifactsLink>
                <iframe src="<%=request.getContextPath() %>/<%= artifacts_url %>/php-code-browser/index.html" class="tab-content">
                </iframe>
              </cruisecontrol:artifactsLink>
            </cruisecontrol:tab>
            <% } %>
            
            <%-- phpUnderControl 6 --%>
              
            <% if (apidoc) { %>
            <cruisecontrol:tab name="documentation" label="Documentation">
              <cruisecontrol:artifactsLink>
                <iframe src="<%=request.getContextPath() %>/<%= artifacts_url %>/api/index.html" class="tab-content">
                </iframe>
              </cruisecontrol:artifactsLink>
            </cruisecontrol:tab>
            <% } %>
            
            <%-- phpUnderControl 7 --%>

            <cruisecontrol:tab name="phpcs" label="CodeSniffer">
              <%@ include file="phpcs.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 8 --%>
              
            <cruisecontrol:tab name="pmd" label="PHPMD">
              <%@ include file="phpunit-pmd.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 9 --%>
            <cruisecontrol:tab name="cpd" label="PHP-CPD">
              <%@ include file="phpunit-cpd.jsp" %>
            </cruisecontrol:tab>
            
            <%-- phpUnderControl 10 --%>
            <cruisecontrol:tab name="changeset" label="Changeset">
              <%@ include file="changeset.jsp" %>
            </cruisecontrol:tab>

            <%-- phpUnderControl 11 --%>

          </td>
        </tr>
      </cruisecontrol:tabsheet>
    </div>
    <%@ include file="footer.jsp" %>
    <script type="text/javascript" src="<%=request.getContextPath() %>/js/prototype.js?v=1"></script>
    <script type="text/javascript" src="<%=request.getContextPath() %>/js/php-under-control.js?v=3"></script>
  </body>
</html>
