<?php

namespace App\Http\Patterns;

use App\Models\EnvironmentVariable;

class SendEmail
{
    public static function send($headers, $subject, $html, $to)
    {
        $ev = EnvironmentVariable::where('name', 'EMAIL_BACKUP')->first();
        $to_emails = explode(",", $to);
        $list_email = "";
        if (count($to_emails) > 1) {
            if (isset($ev) && $ev->value == 1) {
                foreach ($to_emails as $to_email) {
                    if ($list_email == "")
                        $list_email .= $to_email;
                    else
                        $list_email .= "," . $to_email;
                }
            } else {
                $list_email = $to_emails[0];
            }
        } else {
            $list_email = $to_emails[0];
        }

        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        if (!mail($list_email, $subject, $html, $headers))
            return false;
        else
            return true;
    }
}