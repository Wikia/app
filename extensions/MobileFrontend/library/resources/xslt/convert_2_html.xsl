<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="UTF-8" indent="yes"/>

	<!--
    xslt for transform into a html page.
    useful if your friends are asking if their brand new device is supported by WURFL
    send comments, questions to roland guelle <roldriguez@users.sourceforge.net>
  -->
	<xsl:template match="/">
		<html>
			<head>
				<title>
					<xsl:value-of select="/wurfl/version/ver"/>
				</title>
			</head>
			<body>
				<div>
					<h1>
						<xsl:value-of select="/wurfl/version/ver"/>
					</h1>
					<xsl:apply-templates select="/wurfl/version"/>
					<xsl:apply-templates select="/wurfl/devices/device"/>
				</div>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="device">
		<div>
			<h5>
				<xsl:value-of select="@id"/>
			</h5>
			<ul>
				<li>
					<xsl:for-each select="@*">
						<xsl:value-of select="name()"/>
						<xsl:text>="</xsl:text>
						<xsl:value-of select="."/>
						<xsl:text>" </xsl:text>
					</xsl:for-each>
					<!-- group -->
					<xsl:for-each select="*">
						<ul>
							<li>
								<xsl:for-each select="@*">
									<xsl:value-of select="name()"/>
									<xsl:text>="</xsl:text>
									<xsl:value-of select="."/>
									<xsl:text>"</xsl:text>
									<br/>
								</xsl:for-each>
								<!-- caps -->
								<xsl:for-each select="*">
									<ul>
										<li>
											<xsl:value-of select="@name"/>
											<xsl:text>="</xsl:text>
											<xsl:value-of select="@value"/>
											<xsl:text>"</xsl:text>
											<br/>
										</li>
									</ul>
								</xsl:for-each>
							</li>
						</ul>
					</xsl:for-each>
				</li>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="version">
		<hr/>
		<h4>
			<a href="{official_url}">
				<xsl:value-of select="ver"/>
			</a>
		</h4>
		<h4>
			<xsl:value-of select="last_updated"/>
		</h4>
		<p>
			<xsl:value-of select="statement"/>
		</p>
		<p>
			<h5>Maintainer</h5>
			<ul>
				<xsl:for-each select="maintainers/maintainer">
					<li><xsl:value-of select="@name"/>/ <a href="{@home_page}">www</a></li>
				</xsl:for-each>
			</ul>
		</p>
	</xsl:template>
</xsl:stylesheet>
