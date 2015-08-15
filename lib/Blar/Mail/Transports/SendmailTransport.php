<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail\Transports;

use Blar\Mail\Mail;

/**
 * Class SendmailTransport
 *
 * @package Blar\Mail\Transports
 */
class SendmailTransport implements Transport {

    /**
     * @param Mail $mail Mail.
     *
     * @return $this
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
