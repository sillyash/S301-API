<?php

class Mail {
    protected string $to;
    protected string $subject;
    protected string $message;
    protected array $headers;

    public function __construct(
        string $to,
        string $subject,
        string $message,
        array $headers = EMAIL_HEADERS) {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    /**
     * Handle account validation emails sending
     * @return void
     */
    public static function handleAccountValidation() : void {
        Router::addRoute('POST', '/mail/accountValidation', function() {
            $data = json_decode(file_get_contents("php://input"), true);
            $to = $data['to'] ?? null;
            $subject = $data['subject'] ?? null;
            $url = $data['url'] ?? null;
            $headers = $data['headers'] ?? EMAIL_HEADERS;

            if ($to === null || $url === null) {
                fieldsIncomplete($data);
                return;
            }

            if ($subject) static::sendAccountValidation($to, $url, $subject, $headers);
            else static::sendAccountValidation($to, $url);
        });
    }

    /**
     * Handle invite emails sending
     * @return void
     */
    public static function handleInvites() : void {
        Router::addRoute('POST', '/mail/invites', function() {
            $data = json_decode(file_get_contents("php://input"), true);
            $to = $data['to'] ?? null;
            $subject = $data['subject'] ?? null;
            $url = $data['url'] ?? null;
            $headers = $data['headers'] ?? EMAIL_HEADERS;

            if ($to === null || $url === null) {
                fieldsIncomplete($data);
                return;
            }

            if ($subject) static::sendInvites($to, $url, $subject, $headers);
            else static::sendInvites($to, $url);
        });
    }

    /**
     * Handle notifications emails sending
     * @return void
     */
    public static function handleNotifications() : void {
        Router::addRoute('POST', '/mail/notifications', function() {
            $data = json_decode(file_get_contents("php://input"), true);
            $to = $data['to'] ?? null;
            $subject = $data['subject'] ?? null;
            $notification = $data['notification'] ?? null;
            $headers = $data['headers'] ?? EMAIL_HEADERS;

            if ($to === null || $notification === null) {
                fieldsIncomplete($data);
                return;
            }

            if ($subject) static::sendNotifications($to, $notification, $subject, $headers);
            else static::sendNotifications($to, $notification);
        });
    }

    /**
     * Handle email notifications sending
     * @param array $to list of recipients
     * @param string $subject subject of the email
     * @param string $url url to validate the account
     * @param array $headers headers of the email (optional)
     * @return void
     */
    public static function sendAccountValidation(
        array $to,
        string $url,
        string $subject = 'DemocHub account validation',
        array $headers = EMAIL_HEADERS) : void {
        $message = "<html><body>";
        $message .= "<h1>Hello,</h1>";
        $message .= "<p>You need to validate your DemocHub account by clicking";
        $message .= " <a href='$url'>here</a> or by pasting the following URL in your browser :</p>";
        $message .= "<p>$url</p>";
        $message .= "<p>Best regards,<br>The DemocHub team</p>";
        $message .= "</body></html>";

        static::sendMails($to, $subject, $message, $headers);
    }


    /**
     * Handle email invitations sending
     * @param array $to list of recipients
     * @param string $subject subject of the email
     * @param string $url url to join the group
     * @param array $headers headers of the email (optional)
     * @return void
     */
    public static function sendInvites(
        array $to,
        string $url,
        string $subject = 'DemocHub group invitation',
        array $headers = EMAIL_HEADERS) : void {
        $message = "<html><body>";
        $message .= "<h1>Hello,</h1>";
        $message .= "<p>You have been invited to join a DemocHub group. Join the group by clicking";
        $message .= " <a href='$url'>here</a> or by pasting the following URL in your browser :</p>";
        $message .= "<p>$url</p>";
        $message .= "<p>Best regards,<br>The DemocHub team</p>";
        $message .= "</body></html>";

        static::sendMails($to, $subject, $message, $headers);
    }


    /**
     * Handle email notifications sending
     * @param array $to list of recipients
     * @param string $subject subject of the email
     * @param string $notification notification to send
     * @param array $headers headers of the email (optional)
     * @return void
     */
    public static function sendNotifications(
        array $to,
        string $notification,
        string $subject = 'DemocHub notification',
        array $headers = EMAIL_HEADERS) : void {
        $message = "<html><body>";
        $message .= "<h1>Hello,</h1>";
        $message .= "<p>You have received a notification from DemocHub :</p>";
        $message .= "<p>" . nl2br($notification) . "</p>";
        $message .= "<p>Best regards,<br>The DemocHub team</p>";
        $message .= "</body></html>";

        static::sendMails($to, $subject, $message, $headers);
    }

    
    /**
     * Send emails to multiple recipients
     * @param array $to list of recipients
     * @param string $subject subject of the email
     * @param string $message message of the email
     * @param array $headers headers of the email (optional)
     * @return void
     */
    public static function sendMails(
        array $to,
        string $subject,
        string $message,
        array $headers = EMAIL_HEADERS) : void {
        foreach ($to as $recipient) {
            try {
                $mail = new Mail($recipient, $subject, $message, $headers);
                $mailOK = $mail->send();
                if (!$mailOK) {
                    throw new Exception('Mail failed to send');
                }
            } catch (Exception $e) {
                $dump = array(
                    'message' => 'Error sending email',
                    'error' => $e->getMessage(),
                    'mail' => $mail->dumpVars()
                );
                header("HTTP/1.1 500 Internal Server Error");
                echo json_encode($dump);
            }
        }
        creationSuccess($to);
    }


    /**
     * Send the email
     * @return bool true if the email was sent, false otherwise
     */
    public function send() : bool {
        return mail($this->to, $this->subject, $this->message, $this->headers);
    }


    /**
     * Set a property of the email
     * @param string $key property to set
     * @param mixed $value value to set
     * @return void
     */
    public function set(string $key, mixed $value) {
        $this->$key = $value;
    }


    /**
     * Get the info of the email
     * @return array info of the email
     */
    public function dumpVars() : array {
        return array(
            'to' => $this->to,
            'subject' => $this->subject,
            'message' => $this->message,
            'headers' => $this->headers
        );
    }
}

?>
