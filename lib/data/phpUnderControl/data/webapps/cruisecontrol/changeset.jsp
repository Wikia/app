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
<%@ page import="org.apache.commons.io.*" %>
<%@ page import="java.io.File" %>
<%@ page import="java.io.FilenameFilter" %>
<%@ page import="java.util.Arrays" %>
<%@ page import="java.util.regex.*" %>
<%@ page import="java.util.Collection" %>
<%@ page import="java.util.Iterator" %>

<cruisecontrol:buildInfo />
<% 
File   diffDir = null;
String diffUrl = null;
String log     = null;
String diffPath= null;
String find    = "[^\\w]";
String replace = "";
String[] extensions = {"html"};
%>

<cruisecontrol:artifactsLink>
<% 
log = new File(application.getInitParameter("logDir")).getAbsolutePath();
String ts  = artifacts_url.substring(artifacts_url.lastIndexOf('/') + 1);

diffUrl = artifacts_url + "/diff/";
diffPath= log + "/" + project + "/" + ts + "/diff";
diffDir = new File( diffPath );

if (!diffDir.exists()) {
    diffDir = new File(log + "/../artifacts/" + project + "/" + ts + "/diff" );
}
%>
</cruisecontrol:artifactsLink>

<cruisecontrol:xsl xslFile="/xsl/modifications.xsl"/>
<%--
<% 
if (diffDir.exists()) {
    Collection files = diffDir.listFiles();, extensions, true);
    for (Iterator iterator = files.iterator(); iterator.hasNext();) {
        File file = (File) iterator.next();
%>

<p class="fileinfo">
    <a name="<%=file.getAbsolutePath().substring(diffPath.length(), file.getAbsolutePath().length()-5) %>">
        <%=file.getAbsolutePath().substring(diffPath.length(), file.getAbsolutePath().length()-5) %>
    </a>
</p>
<iframe class="diff" src="<%=request.getContextPath() %>/<%=diffUrl + file.getAbsolutePath().substring(diffPath.length()) %>" style="overflow: hidden;">
</iframe>
<br/>

<% 
    }
}
%>
--%>

