<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" encoding="UTF-8"/>
	<!--
    generate key for device id
  -->
	<xsl:key name="device_id" match="device" use="@id"/>
	<xsl:template match="/">
		<xsl:message>
			<xsl:text>
	      *******************************************************************
	      start checking WURFL:
	      - id attribute present
	      - user_agent attribute present
	      - user_agent is unique
	      - id attribute unique
	      - fall_back attribute available
	      *******************************************************************
			</xsl:text>
    </xsl:message><!--
      send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
    --><xsl:variable name="errors"><xsl:apply-templates select="/wurfl/devices/device"/></xsl:variable>

    *******************************************************************
    Result of checking WURFL:
    *******************************************************************
    <xsl:choose><xsl:when test="normalize-space($errors) != ''">
	errors detected:
	<xsl:value-of select="$errors"/>
      </xsl:when><xsl:otherwise>
	no errors
      </xsl:otherwise></xsl:choose>
    *******************************************************************
  </xsl:template>
	<xsl:template match="device">
		<xsl:message> check id: <xsl:value-of select="@id"/> </xsl:message>
		<xsl:choose>
			<!--
	check if device id is available
      -->
			<xsl:when test="@id != ''">
				<xsl:choose>
					<!--
	    check for user_agent attribute
	  -->
					<xsl:when test="@user_agent">
						<xsl:choose>
							<!--
		check for unique device id
	      -->
							<xsl:when test="count(key('device_id',current()/@id)/@id) != 1">
								<xsl:message terminate="yes">
									Device: <xsl:value-of select="@id"/>/<xsl:value-of select="@user_agent"/>/<xsl:value-of select="@fall_back"/>
									UserID is not unique!
								</xsl:message>
	      			</xsl:when>
							<xsl:otherwise>
								<xsl:choose>
									<!--
		    check if fall_back attribute is available and is not root (generic device)
		  -->
									<xsl:when test="@fall_back = 'root' or count(key('device_id',current()/@fall_back)/@id) &gt;= 1">
										<xsl:call-template name="check_id">
											<xsl:with-param name="id" select="@id"/>
										</xsl:call-template>
									</xsl:when>
									<xsl:otherwise>
										<xsl:message terminate="yes">
									    Device: <xsl:value-of select="@id"/>/<xsl:value-of select="@user_agent"/>/<xsl:value-of select="@fall_back"/>
									    Fall_back is not available!
										</xsl:message>
	  							</xsl:otherwise>
								</xsl:choose>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:when>
					<xsl:otherwise>
						<xsl:message terminate="yes">
					    Device: <xsl:value-of select="@id"/>/<xsl:value-of select="@user_agent"/>/<xsl:value-of select="@fall_back"/>
					    UserAgent attribute is missing
						</xsl:message>
  				</xsl:otherwise>
				</xsl:choose>
			</xsl:when>
			<xsl:otherwise>
				<xsl:message terminate="yes">
					Device: <xsl:value-of select="@id"/>/<xsl:value-of select="@user_agent"/>/<xsl:value-of select="@fall_back"/>
					No UserID set!
				</xsl:message>
      </xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="check_id">
		<xsl:param name="id"/>
		<xsl:if test="not(key('device_id',$id)/@fall_back = 'root')">
			<xsl:call-template name="check_id">
				<xsl:with-param name="id" select="key('device_id',$id)/@fall_back"/>
			</xsl:call-template>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
