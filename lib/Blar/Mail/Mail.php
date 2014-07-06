<?php

namespace Blar\Mail;

use Blar\Mime\Mime;

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */
class Mail extends Mime {

    protected $from;
    protected $to;
    protected $headers = array();
    protected $body;

    public function getHeaders() {
        $headers = parent::getHeaders();
        if(count($this) > 1) {
            $headers->set('MIME-Version', '1.0');
            $headers->set('Content-Type', 'multipart/mixed; boundary='.$this->getBoundary());
        }
        return $headers;
    }

    public function setFrom($from) {
        $this->from = $from;
        return $this;
    }

    public function getFrom() {
        return $this->from;
    }

    public function setTo($to) {
        $this->to = $to;
        return $this;
    }

    public function getTo() {
        return $this->to;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /*
    public function getBody() {
        return $this->body;
    }
    */

}
