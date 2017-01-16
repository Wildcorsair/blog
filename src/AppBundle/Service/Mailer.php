<?php

namespace AppBundle\Service;


class Mailer
{
    public $mandrill;
    private $fromEmail;
    private $fromName;

    public function __construct($fromEmail, $fromName)
    {
        $this->mandrill = new \Mandrill('GXj3KjJn5GlaCjj6T4qpdw');
        if (!empty($fromEmail)) {
            $this->fromEmail = $fromEmail;
        }
        if (!empty($fromName)) {
            $this->fromName = $fromName;
        }
    }

    public function sendMail($toEmail, $toName, $subject, $messageText)
    {
        $result = false;
        try {
            $message = array(
                'html' => "<p>{$messageText}</p>",
                'text' => $messageText,
                'subject' => $subject,
                'from_email' => $this->fromEmail,
                'from_name' => $this->fromName,
                'to' => array(
                    array(
                        'email' => $toEmail,
                        'name' => $toName,
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'no-reply@mango.com'),
                'important' => false,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null
            );
            $async = false;
            $ip_pool = '';
            $send_at = date('Y-m-d H:i:s', time() - 1000);
            $result = $this->mandrill->messages->send($message, $async, $ip_pool, $send_at);

        } catch (Mandrill_Error $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            throw $e;
        }
        return $result;
    }
}