<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:import href="../_common/lib.xsl"/>
    <xsl:template match="/">
        <html>
            <head>
                <xsl:copy-of select="$head_inner"/>
            </head>
            <body>
                <xsl:copy-of select="$header"/>
                <h3>
                    <xsl:value-of select="doc/model/page"/>
                </h3>
                <xsl:apply-templates select="doc/model/login_form"/>
                <xsl:copy-of select="$footer"/>
                <xsl:copy-of select="$body_end"/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="/doc/model/login_form">
        <form id="{form_id}" action="{submission/action}" method="{submission/method}">
            <input type="hidden" name="{submission/csrf/param}" value="{submission/csrf/token}"/>
            <div class="row">
                <div class="span1">
                    <xsl:value-of select="username/label"/>
                </div>
                <div class="span6">
                    <input type="text" name="{username/id}" value="{username/value}"/>
                </div>
            </div>
            <div class="row">
                <div class="span1">
                    <xsl:value-of select="password/label"/>
                </div>
                <div class="span6">
                    <input type="password" name="{password/id}" value="{password/value}"/>
                </div>
            </div>
            <div class="row">
                <div class="span1">
                    <xsl:value-of select="captcha/label"/>
                </div>
                <div class="span3">
                    <input type="text" name="{captcha/id}" value="{capthca/value}"/>
                </div>
                <div class="span3">
                    <img src="{captcha/url}"/>
                </div>
            </div>
            <div class="row">
                <div class="span3 offset2">
                    <input type="submit" value="OK"/>
                </div>
            </div>
        </form>
    </xsl:template>
</xsl:stylesheet>