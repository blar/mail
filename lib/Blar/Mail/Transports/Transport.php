<?php

namespace Blar\Mail\Transports;

use Blar\Mail\Mail;

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */
interface Transport {

    /**
     * @param Blar\Mail\Mail $mail Mail.
     * @return self
     */
    public function sendMail(Mail $mail);

}
