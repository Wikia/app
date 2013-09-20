<?xml version="1.0"?>
<!--********************************************************************************
 * CruiseControl, a Continuous Integration Toolkit
 * Copyright (c) 2001, ThoughtWorks, Inc.
 * 651 W Washington Ave. Suite 500
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
 ********************************************************************************-->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:import href="maven.xsl"/>
    <xsl:import href="phpunit-pmd.xsl"/>
    <xsl:import href="errors.xsl"/>
    <xsl:import href="phpdoc.xsl"/>
    <xsl:import href="phpcs.xsl"/>
    <xsl:import href="phpunit.xsl"/>
    <xsl:import href="fittests.xsl"/>
    <xsl:import href="modifications.xsl"/>
    <xsl:import href="cvstagdiff.xsl"/>
    <xsl:import href="distributables.xsl"/>

    <xsl:output method="html" />

    <xsl:variable name="cruisecontrol.list" select="."/>

    <xsl:template match="/">
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="errors"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="unittests"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="maven"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="modifications"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="cvstagdiff"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="distributables"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="pmd"/></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="checkstyle" /></p>
        <p><xsl:apply-templates select="$cruisecontrol.list" mode="phpdoc" /></p>
    </xsl:template>
</xsl:stylesheet>
