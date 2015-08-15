<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail\Transports;

use Blar\Mail\Mail;

/**
 * Interface Transport
 *
 * @package Blar\Mail\Transports
 */
interface Transport {

    /**
     * @param Mail $mail Mail.
     *
     * @return $this
     */
    public function sendMail(Mail $mail);

}
