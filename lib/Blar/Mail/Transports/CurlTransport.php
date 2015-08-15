<?php

/**
 * SMTP Transport with Curl.
 *
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail\Transports;

use Blar\Credentials\BasicCredentials;
use Blar\Curl\Curl;
use Blar\Mail\Mail;

/**
 * Class CurlTransport
 *
 * @package Blar\Mail\Transports
 */
class CurlTransport implements Transport {

    /**
     * @var Curl $curl
     */
    private $curl;

    /**
     * @param string $hostname
     * @param int $port
     * @param bool $secure
     */
    public function __construct($hostname = 'localhost', $port = NULL, $secure = FALSE) {
        $url = $this->createConnectionUrl($hostname, $port, $secure);
        $this->setCurl(new Curl($url));
    }

    /**
     * @param string $hostName HostName.
     * @param int $port Port.
     * @param boolean $secure Secure.
     */
    protected function createConnectionUrl($hostName, $port = NULL, $secure = FALSE) {
        $url = '';
        if($secure) {
            $url .= 'smtps://';
        }
        else {
            $url .= 'smtp://';
        }
        $url .= $hostName;
        if($port) {
            $url .= ':' . $port;
        }
        return $url;
    }

    /**
     * @param BasicCredentials $credentials
     *
     * @return $this
     */
    public function setCredentials(BasicCredentials $credentials) {
        $this->getCurl()->setOption(CURLOPT_USERPWD, $credentials->getUserName() . ':' . $credentials->getPassword());
        return $this;
    }

    /**
     * @return Curl
     */
    public function getCurl() {
        return $this->curl;
    }

    /**
     * @param Curl $curl Curl
     *
     * @return $this
     */
    public function setCurl(Curl $curl) {
        $this->curl = $curl;
        return $this;
    }

    /**
     * @param Mail $mail Mail.
     *
     * @return $this
     */
    public function sendMail(Mail $mail) {
        $this->getCurl()->setOption(CURLOPT_MAIL_FROM, $mail->getFrom());
        $this->getCurl()->setOption(CURLOPT_MAIL_RCPT, [$mail->getTo()]);
        $this->getCurl()->setMethod('PUT');
        $this->getCurl()->setPutString($mail);
        $this->getCurl()->execute();
        return $this;
    }

}
