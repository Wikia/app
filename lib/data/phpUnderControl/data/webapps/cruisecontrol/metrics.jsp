<%--********************************************************************************
 * This file is part of phpUnderControl.
 *
 * Copyright (c) 2007-2010, Manuel Pichler <mapi@phpundercontrol.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 ********************************************************************************--%>
<%@page import="net.sourceforge.cruisecontrol.*, net.sourceforge.cruisecontrol.chart.*"%>
<%@ taglib uri="/WEB-INF/cruisecontrol-jsp11.tld" prefix="cruisecontrol"%>
<%@ page import="java.io.File" %>
<%@ page import="java.io.FilenameFilter" %>
<%@ page import="java.util.Arrays" %>

<cruisecontrol:buildInfo />
<% 
File   graphDir = null;
String graphUrl = null;
%>

<cruisecontrol:artifactsLink>
<% 
String log = new File(application.getInitParameter("logDir")).getAbsolutePath();
String ts  = artifacts_url.substring(artifacts_url.lastIndexOf('/') + 1);

graphUrl = artifacts_url + "/graph/";
graphDir = new File( log + "/" + project + "/" + ts + "/graph" );

if (!graphDir.exists()) {
    graphDir = new File(log + "/../artifacts/" + project + "/" + ts + "/graph" );
}
%>
</cruisecontrol:artifactsLink>

<% 
if (graphDir.exists()) {
    FilenameFilter filter = new FilenameFilter() {
        public boolean accept(File dir, String name) {
            return name.substring(name.length() - 4).equals(".svg");
        }
    };
    
    String[] files = graphDir.list(filter);
    Arrays.sort(files);
    
    for (int i = 0; i < files.length; i++) {
%>
<iframe class="chart" src="<%=request.getContextPath() %>/<%=graphUrl + files[i] %>" style="overflow: hidden;">
</iframe>

<% 
    }
} else { 
%>
<%@ include file="metrics.cewolf.jsp" %>
<% } %>