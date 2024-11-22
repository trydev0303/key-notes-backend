<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#fff">

    <!-- START HEADER/BANNER -->
    <tbody>
        <tr>

            <td align="center">
                <table width="600" border="0" align="center" cellpadding="50" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" bgcolor="#ffffff"
                                style="border-radius: 15px; position: relative;">
                                <table class="col-600" width="600" height="200" border="0"
                                    border-radius: "15px" ; align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-size:37px; font-weight: bold; margin-bottom: 20px;  position: relative;">
                                                <img style="max-height: 100px" src="https://dev.bosselt.com/key-notes-backend/public/admin/src/sidebar-logo.svg"
                                                class="img-flued"alt="" height="100">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="50"></td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-family: 'Raleway', sans-serif; font-size:25px; color:#000000; font-weight: 700;">
                                                <p
                                                    style="font-family: 'Raleway', sans-serif; font-size:25px; color:#000000; font-weight: 700;">
                                                    <span> Hi </span> {{ $userName ?? "Dear" }},
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-family: 'Raleway', sans-serif; font-size:16px; color:#000000; font-weight: 700; line-height: 25px;">
                                                <p class="">Reset your account password  </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"
                                                style="font-family: 'Raleway', sans-serif; font-size:16px; color:#000000; font-weight: 700; ">
                                                <p
                                                    style="font-family: 'Raleway', sans-serif; font-size:16px; color:#000000; font-weight: 700; margin-bottom:0px">
                                                    We recieved a request to reset your Key-Notes account password. Please use the following one-time password to verify yourself
                                                </p>
                                                <p
                                                    style="font-family: 'Raleway', sans-serif; font-size:24px; color:#000000; font-weight: 700; margin-top: 10px;">
                                                    {{ $otp }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-family: 'Raleway', sans-serif;font-size:16px; color:#5c5a5a; font-weight: 700;">
                                                If you didn't request this, you can safely ignore this email.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
