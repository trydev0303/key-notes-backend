<?php

use Carbon\Carbon;

/**

 * Write code on Method

 *

 * @return response()

 */

if (!function_exists('sendEmail')) {

    function sendEmail($to, $subject, $template)
    {
        $sendGridApiKey = config('services.sendgrid.api_key');

        $sendGrid = new SendGrid($sendGridApiKey);

        $email = new SendGrid\Mail\Mail();
        $email->setFrom("app@tapnote.tech", "Key-Notes");
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent('text/html', $template);

        try {
            $response = $sendGrid->send($email);
            return $response->statusCode() === 202;
        } catch (\Exception $e) {
            \Log::error('SendGrid Email Error: ' . $e->getMessage());
            return false;
        }
    }

}



/**

 * Write code on Method

 *

 * @return response()

 */

if (! function_exists('errorHandle')) {

    function errorHandle($validator)
    {
        $message = $validator->errors()->first();
        return response()->json([
            'statusCode' => 400,
            'success'    => false,
            'message'    => $message
        ], 400);
    }

}


if (!function_exists('successRes')) {
    function successRes($statusCode = null, $message = null, $data = null)
    {
        return response()->json([
            'success'    => true,
            'statusCode' => $statusCode,
            'message'    => $message,
            'data'       => $data
        ], $statusCode);
    }
}

if (!function_exists('errorRes')) {
    function errorRes($statusCode = null, $message = null, $data = null)
    {
        return response()->json([
            'success'    => false,
            'statusCode' => $statusCode,
            'message'    => $message,
            'data'       => $data
        ], 200);
    }
}
