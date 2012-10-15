<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
		xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
		xmlns:common="http://exslt.org/common">

  <xsl:output method="xml"
	      encoding="UTF-8"
	      indent="yes"/>
  
  <!--
    	get all capabilities for one device
      send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
  -->

  <xsl:param name="ua"></xsl:param>
  <xsl:param name="id"></xsl:param>
  
  <xsl:template match="/wurfl/devices">
		<xsl:variable name="dID">
			<xsl:choose>
				<xsl:when test="$id != ''">
					<xsl:value-of select="device[@id=$id]/@id"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="device[@user_agent=$ua]/@id"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>	

    <xsl:choose>
      <xsl:when test="device[@id=$dID]/@id = false()">
				<error>
				  UserAgent='<xsl:value-of select="$ua"/>' or ID='<xsl:value-of select="$id"/>' not found
				</error>
      </xsl:when>
      <xsl:otherwise>

				<!--
				  get all capabilities
				-->
				<xsl:variable name="duid">
				  <xsl:copy-of select="device[@id=$dID]/group/capability"/>
				  <xsl:call-template name="tid">
				    <xsl:with-param name="fall_back" select="device[@id=$dID]/@fall_back"/>
				  </xsl:call-template>
				</xsl:variable>
	
				<xsl:variable name="duid_nodes" select="common:node-set($duid)"/>

				<device>
				  <xsl:copy-of select="device[@id=$dID]/@*"/>

				  <xsl:for-each select="$duid_nodes/capability">
				    <xsl:sort select="@name"/>
				    <xsl:if test="not(@name = preceding-sibling::capability/@name)">
				      <xsl:copy-of select="."/>
				    </xsl:if>
				  </xsl:for-each>
				</device>
      </xsl:otherwise>
    </xsl:choose>
    
  </xsl:template>

  <xsl:template name="tid">
    <xsl:param name="fall_back"/>
    <xsl:if test="$fall_back != ''">
      <xsl:copy-of select="device[@id = $fall_back]/group/capability"/>
      <xsl:call-template name="tid">
				<xsl:with-param name="fall_back" select="device[@id=$fall_back]/@fall_back"/>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>
  
  <xsl:template match="text()"/>
  
</xsl:stylesheet>