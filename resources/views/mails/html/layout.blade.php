<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!-- trx_0008 -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content=width=device-width, initial-scale=1">
    <title>Bienvenido a Mi Fovipol</title>

    <!--[if!mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700"
          rel="stylesheet">
    <!--<![endif]-->

</head>
<body>
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%"
           width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <span style="color:#FFFFFF; display:none; font-size:0px; height:0px; visibility:hidden; width:0px;">Bienvenido a APP FOVIPOL.</span>
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" bgcolor="#009687" valign="top"
                            id="templateHeader"
                            style="background-color:#009687; padding-right:30px; padding-left:30px;">
                            <table align="center" border="0" cellpadding="0"
                                   cellspacing="0" width="100%" style="max-width:400px;"
                                   class="emailContainer">

                                {{ $header ?? '' }}

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" bgcolor="#009687" valign="top"
                            id="headerContainer"
                            style="background-color:#009687; padding-right:30px; padding-left:30px;">
                            <table align="center" border="0" cellpadding="0"
                                   cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top">
                                        <table align="center" border="0" cellpadding="0"
                                               cellspacing="0" width="100%"
                                               style="max-width:640px;"
                                               class="emailContainer">
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table align="center"
                                                           bgcolor="#FFFFFF" border="0"
                                                           cellpadding="0" cellspacing="0"
                                                           width="100%" id="headerTable"
                                                           style="background-color:#FFFFFF; border-collapse:separate; border-top-left-radius:4px; border-top-right-radius:4px;">
                                                        <tr>
                                                            <td align="center"
                                                                valign="top" width="100%"
                                                                style="padding-top:40px; padding-bottom:0;">
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" id="templateBody">
                            <table align="center" border="0" cellpadding="0"
                                   cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" valign="top">
                                        <table align="center" border="0" cellpadding="0"
                                               cellspacing="0" width="100%"
                                               style="max-width:700px;"
                                               class="emailContainer">
                                            <tr>
                                                <td align="right" valign="top" width="30"
                                                    class="mobileHide">
                                                    <img alt=" " src="https://mi.fovipol.gob.pe/images/logo-app.png" width="30" role="presentation" style="display:block;"/>
                                                </td>
                                                <td valign="top" width="100%" style="padding-right:70px; padding-left:40px;" id="bodyContainer">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">

                                                        {{ $content ?? '' }}

                                                        {{ $subcopy ?? '' }}

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" id="templateFooter" style="padding-right:30px; padding-left:30px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;" class="emailContainer">
                                {{ $footer ?? '' }}
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>
