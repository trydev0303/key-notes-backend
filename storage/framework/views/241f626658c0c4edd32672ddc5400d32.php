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
                                <table class="col-800" width="800" height="200" border="0" border-radius: "15px" ;
                                    align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-size:37px; font-weight: bold;  padding: 30px 0px; position: relative;">
                                                <img style="max-height: 100px"
                                                    src="<?php echo e(config('app.url')); ?>/admin/src/sidebar-logo.svg"
                                                    class="img-flued" alt="" height="100">
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
                                                    <span> Hi </span> <?php echo e($userName ?? "Dear"); ?>,
                                                </p>
                                            </td>
                                        </tr>

                                        <td align="center"
                                            style="font-family: 'Raleway', sans-serif; font-size:30px; color:#171717; font-weight: 700;">
                                            <p
                                                style="font-family: 'Raleway', sans-serif; font-size:17px; color:#171717; font-weight: 700; ">
                                                Your Account Verify OTP! </p>
                                        </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="font-family: 'Raleway', sans-serif; font-size:17px; color:#171717; font-weight: 700;">
                                <p
                                    style="font-family: 'Raleway', sans-serif; font-size:17px; color:#171717; font-weight: 700;">
                                    We recieved a request to verify your account. Please use the following one-time
                                    password to verify yourself</p>
                            </td>
                        </tr>

                        <tr>
                            <td align="left"
                                style="font-family: 'Raleway', sans-serif; font-size:16px; color:#000000; font-weight: 700;">
                                <p
                                    style="font-family: 'Raleway', sans-serif; font-size:17px; color:#171717; font-weight: 700; ">
                                    Your verification OTP <span
                                        style="font-weight: 800; font-family: poppins;"><?php echo e($otp); ?></span>
                                </p>
                            </td>

                        <tr>
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
<?php /**PATH D:\Work\Real_Project\key-notes-backend\resources\views/templates/emails/welcome.blade.php ENDPATH**/ ?>