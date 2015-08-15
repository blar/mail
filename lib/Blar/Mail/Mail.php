<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail;

use Blar\Mime\Mime;
use Blar\Mime\MimeHeaders;

/**
 * Class Mail
 *
 * @package Blar\Mail
 */
class Mail extends Mime {

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @return MimeHeaders
     */
    public function getHeaders() {
        $headers = parent::getHeaders();
        if(count($this) > 1) {
            $headers->set('MIME-Version', '1.0');
            $headers->set('Content-Type', 'multipart/mixed; boundary=' . $this->getBoundary());
        }
        return $headers;
    }

    /**
     * @return string
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from) {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getTo() {
        return $this->to;
    }

    /**
     * @param string $to
     *
     * @return $this
     */
    public function setTo($to) {
        $this->to = $to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        if($this->body) {
            return $this->body;
        }
        return parent::getBody();
    }

    /**
     * @param mixed $body
     *
     * @return $this
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

}
