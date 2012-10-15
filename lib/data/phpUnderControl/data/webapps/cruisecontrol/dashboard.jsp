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
<%@ page errorPage="/error.jsp" contentType="text/html; charset=UTF-8"%>
<%@ taglib uri="/WEB-INF/cruisecontrol-jsp11.tld" prefix="cruisecontrol"%>
<%@ page import="net.sourceforge.cruisecontrol.*" %>
<%@ page import="org.phpundercontrol.dashboard.*" %>
<%@ page import="java.net.URL" %>

<%
final String logDir     = application.getInitParameter("logDir");
final String statusFile = application.getInitParameter("currentBuildStatusFile");
%>
<table style="width:100%;margin: 10px;">
  <tbody>
<%

if (logDir == null) {
%>
    <tr>
      <td>
        You need to provide a value for the context parameter
        <code>&quot;logDir&quot;</code>
      </td>
    </tr>
<% 
} else {
    ProjectInfos projects = new ProjectInfos(logDir, statusFile, request.getLocale());
    if (projects.isValid() == false) {
%>
    <tr>
      <td>
        Context parameter logDir needs to be set to a directory.
        Currently set to &quot;<%=logDir%>&quot;
      </td>
    </tr>
<%
    } else {
        if (projects.isEmpty()) {
%>
    <tr>
      <td>
        no project directories found under &quot;<%=logDir%>&quot;
      </td>
    </tr>
<%
        } else {
            for (ProjectInfo project: projects) {
%>
    <tr onmouseover="over(this);" onmouseout="out(this);">
      <td class="status-<%= project.getStatus().getImportance() %>">
        <div class="<%= (project.failed() ? "broken" : "good") %>">
          <div>
          <table>
            <tbody>
              <tr>
                <td class="play" rowspan="2">
                  <a href="#" 
                     onclick="return callServer('<%=request.getContextPath() %>/forcebuild.jsp?project=<%= project.getProject() %>');"
                     title="Start a new build of project '<%= project.getProject() %>'">
                  </a>
                </td>
                <td class="left">
                  <a href="<%=request.getContextPath() %>/buildresults/<%=project.getProject() %>"
                     title="Open the detail page of project '<%= project.getProject() %>'">
                    <%= project.getProject() %>
                  </a>
                </td>
                <td class="right"><%= project.getLabel()%></td>
              </tr>
              <tr>
                <td class="left status-<%= project.getStatus().getImportance() %>">
                  <%= project.getStatus()%> <em>(<%= project.getStatusSince() %>)</em>
                </td>
                <td class="right"><%= project.getLastSuccessfulBuildTime() %></td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </td>
    </tr>
<%
            }
        }
    }
}
%>
  </tbody>
</table>
