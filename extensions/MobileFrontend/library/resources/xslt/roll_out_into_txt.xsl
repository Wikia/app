<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output version="1.0" encoding="UTF-8" indent="no" method="text" omit-xml-declaration="yes" media-type="text/plain"/>
	<!--
      roll out WURFL.xml into TEXT
      send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
  -->
	<!-- 
       ##############################################################
       parameters
       ##############################################################
  -->
	<!-- resolve wurfl fallbacks true/false -->
	<xsl:param name="resolve_fallbacks">true</xsl:param>
	<!-- file with capabilities that should be used -->
	<xsl:param name="file_name">roll_out_capabilities.xml</xsl:param>
	<!-- add field names -->
	<xsl:param name="field_names">true</xsl:param>
	<!-- delimiter for field names-->
	<xsl:param name="delimiter">
		<xsl:text>	</xsl:text>
	</xsl:param>
	<xsl:variable name="caps" select="document($file_name)//cap"/>
	<xsl:key name="device_id" match="device" use="@id"/>

	<xsl:template match="/">
		<xsl:apply-templates select="wurfl/devices"/>
	</xsl:template>

	<xsl:template match="wurfl/devices">
		<xsl:if test="$field_names = 'true'">
			<xsl:for-each select="$caps">
				<xsl:value-of select="."/>
				<xsl:if test="position() != last()">
					<xsl:value-of select="$delimiter"/>
				</xsl:if>
			</xsl:for-each>
			<xsl:text>
</xsl:text>
		</xsl:if>
		<xsl:apply-templates select="device"/>
	</xsl:template>

	<xsl:template match="device">
		<xsl:variable name="device" select="."/>
		<xsl:for-each select="$caps">
			<xsl:choose>
				<!-- select device attributes -->
				<xsl:when test=". = 'id'">
					<xsl:value-of select="$device/@id"/>
				</xsl:when>
				<xsl:when test=". = 'fall_back'">
					<xsl:value-of select="$device/@fall_back"/>
				</xsl:when>
				<xsl:when test=". = 'actual_device_root'">
					<xsl:choose>
						<xsl:when test="$device[@actual_device_root = 'true']">
							<xsl:text>true</xsl:text>
						</xsl:when>
						<xsl:otherwise>
							<xsl:text>false</xsl:text>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:when>
				<xsl:when test=". = 'user_agent'">
					<xsl:value-of select="$device/@user_agent"/>
				</xsl:when>
				<xsl:otherwise>
					<!-- normal capabilities -->
					<xsl:apply-templates select="$device" mode="CapOrNull">
						<xsl:with-param name="cap" select="."/>
					</xsl:apply-templates>
				</xsl:otherwise>
			</xsl:choose>
			<xsl:if test="position() != last()">
				<xsl:value-of select="$delimiter"/>
			</xsl:if>
		</xsl:for-each>
		<xsl:text>
</xsl:text>
	</xsl:template>

	<!-- change context from capability xml to device -->
	<xsl:template match="device" mode="CapOrNull">
		<xsl:param name="cap"/>
		<xsl:call-template name="CapOrNull">
			<xsl:with-param name="capability">
				<xsl:value-of select="$cap"/>
			</xsl:with-param>
		</xsl:call-template>
	</xsl:template>

	<xsl:template name="CapOrNull">
		<xsl:param name="capability"/>
		<xsl:param name="fall_back" select="@fall_back"/>
		<xsl:choose>
			<xsl:when test="group/capability[@name = $capability]">
				<xsl:value-of select="group/capability[@name = $capability]/@value"/>
			</xsl:when>
			<!-- check if resolving fallbacks is enabled, fall_back device is available and current id isn't the generic device -->
			<xsl:when test="$resolve_fallbacks = 'true' and (key('device_id',$fall_back) and @id != 'generic')">
				<xsl:for-each select="key('device_id',$fall_back)[1]">
					<xsl:call-template name="CapOrNull">
						<xsl:with-param name="capability" select="$capability"/>
						<xsl:with-param name="fall_back" select="key('device_id',$fall_back)/@fall_back"/>
					</xsl:call-template>
				</xsl:for-each>
			</xsl:when>
			<!-- this should never reatched, a capability that is not in fallback available -->
			<xsl:otherwise>NULL</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
