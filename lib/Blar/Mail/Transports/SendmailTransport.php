<?php

namespace Blar\Mail\Transports;

use Blar\Mail\Mail;

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */
class SendmailTransport implements Transport {

    /**
     * @param Blar\Mail\Mail $mail Mail.
     * @return self
     */
    public function sendMail(Mail $mail) {
        $mail = clone $mail;
        $subject = $mail->getHeader('Subject');
        $mail->removeHeader('Subject');

        $status = mail(
            $mail->getTo(),
            $subject,
            $mail->getBody(),
            $mail->getHeadersString()
        );
        return $this;
    }

}
