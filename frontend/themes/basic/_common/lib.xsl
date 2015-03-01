<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:variable name="head_inner">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="{/doc/g/assets}/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="{/doc/g/assets}/css/bootstrap-responsive.css" />
    </xsl:variable>

    <xsl:variable name="body_end">
        <script src="{/doc/g/assets}/js/jquery-1.11.2.js" />
        <script src="{/doc/g/assets}/js/bootstrap.js"/>
    </xsl:variable>

    <xsl:variable name="header">
        <h1>Header</h1>
    </xsl:variable>

    <xsl:variable name="footer">
        <p>Footer copyright @2015</p>
    </xsl:variable>

</xsl:stylesheet>