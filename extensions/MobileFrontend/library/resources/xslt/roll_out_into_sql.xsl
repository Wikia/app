<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output version="1.0" encoding="UTF-8" indent="no" method="text" omit-xml-declaration="yes" media-type="text/plain"/>
	<!--
      roll out WURFL.xml into SQL
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
	<!-- sql target table name -->
	<xsl:param name="table_name">wurfl_devices</xsl:param>
	<!-- add create statement -->
	<xsl:param name="create_statement">true</xsl:param>

	<xsl:variable name="caps" select="document($file_name)//cap"/>
	<xsl:key name="device_id" match="device" use="@id"/>

	<xsl:template match="/">
		<xsl:apply-templates select="wurfl/devices"/>
	</xsl:template>

	<xsl:template match="wurfl/devices">
		<xsl:if test="$create_statement = 'true'">
      <xsl:text>CREATE TABLE `</xsl:text>
			<xsl:value-of select="$table_name"/>
			<xsl:text>` (</xsl:text>
      <xsl:for-each select="$caps">
				<xsl:text>`</xsl:text>
				<xsl:value-of select="."/>
				<xsl:text>` </xsl:text>
				<xsl:choose>
					<xsl:when test="@type">
						<xsl:value-of select="@type"/>
					</xsl:when>
					<xsl:otherwise>varchar(255)</xsl:otherwise>
				</xsl:choose>
				<xsl:text> default NULL,</xsl:text>
			</xsl:for-each>
			<xsl:if test="$caps[text() = 'id']">
				<xsl:text> PRIMARY KEY (`id`)</xsl:text>
			</xsl:if>
			<xsl:text>);</xsl:text>
    </xsl:if>
		<xsl:apply-templates select="device"/>
	</xsl:template>

	<xsl:template match="device">
    <xsl:text>insert into </xsl:text>
		<xsl:value-of select="$table_name"/>
    <xsl:text>(</xsl:text>
		<xsl:for-each select="$caps">
			<xsl:value-of select="."/>
			<xsl:if test="position() != last()">
				<xsl:text>,</xsl:text>
			</xsl:if>
		</xsl:for-each>
		<xsl:text>) values (</xsl:text>
    <xsl:variable name="device" select="."/>
	    <xsl:for-each select="$caps">
				<xsl:choose>
				<!-- select device attributes -->
					<xsl:when test=". = 'id'">
						<xsl:text>'</xsl:text>
						<xsl:value-of select="$device/@id"/>
						<xsl:text>'</xsl:text>
					</xsl:when>
					<xsl:when test=". = 'fall_back'">
				    <xsl:text>'</xsl:text>
						<xsl:value-of select="$device/@fall_back"/>
						<xsl:text>'</xsl:text>
					</xsl:when>
					<xsl:when test=". = 'actual_device_root'">
						<xsl:choose>
							<xsl:when test="$device[@actual_device_root = 'true']">
								<xsl:text>1</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>0</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:when>
					<xsl:when test=". = 'user_agent'">
				    <xsl:text>'</xsl:text>
						<xsl:value-of select="translate($device/@user_agent, &quot;'&quot;, &quot;\\'&quot;)"/>
						<xsl:text>'</xsl:text>
					</xsl:when>
					<xsl:otherwise>
					<!-- normal capabilities -->
					<xsl:apply-templates select="$device" mode="CapOrNull">
						<xsl:with-param name="cap" select="."/>
					</xsl:apply-templates>
				</xsl:otherwise>
			</xsl:choose>
			<xsl:if test="position() != last()">
				<xsl:text>, </xsl:text>
			</xsl:if>
		</xsl:for-each>
		<xsl:text>);</xsl:text>
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

	<!-- change true/false into 1/0 -->
	<xsl:template name="TorF">
		<xsl:param name="value"/>
		<xsl:choose>
			<xsl:when test="$value='true'">
				<xsl:text>1</xsl:text>
			</xsl:when>
			<xsl:when test="$value='false'">
				<xsl:text>0</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>'</xsl:text>
				<xsl:value-of select="$value"/>
				<xsl:text>'</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template name="CapOrNull">
		<xsl:param name="capability"/>
		<xsl:param name="fall_back" select="@fall_back"/>
		<xsl:choose>
			<xsl:when test="group/capability[@name = $capability]">
				<xsl:call-template name="TorF">
					<xsl:with-param name="value" select="translate(group/capability[@name = $capability]/@value, &quot;'&quot;, &quot;\\'&quot;)"/>
				</xsl:call-template>
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
