<?php

namespace Blar\Mail\Transports;

use Blar\Mail\Mail,
    Blar\Curl\Curl;

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */
class CurlTransport implements Transport {

    /**
     * @var Blar\Curl
     */
    protected $curl;

    public function __construct($hostname = '127.0.0.1', $port = NULL, $secure = false) {
        $url = $this->createConnectionUrl($hostname, $port, $secure);
        $this->setCurl(new Curl($url));
    }

    /**
     * @param string $hostName HostName.
     * @param integer $port Port.
     * @param boolean $secure Secure.
     */
    protected function createConnectionUrl($hostName, $port, $secure) {
        $url = '';
        if($secure) {
            $url .= 'smtps://';
        }
        else {
            $url .= 'smtp://';
        }
        $url .= $hostName;
        if($port) {
            $url .= ':'.$port;
        }
        return $url;
    }

    /**
     * @param Blar\Curl $curl Curl
     * @return self
     */
    public function setCurl(Curl $curl) {
        $this->curl = $curl;
        return $this;
    }

    /**
     * @return Blar\Curl
     */
    public function getCurl() {
        return $this->curl;
    }

    /**
     * @param string $userName Username.
     * @param string $password Password.
     * @return self
     */
    public function setCredentials($username, $password) {
        $this->getCurl()->setOption(CURLOPT_USERPWD, $username.':'.$password);
        return $this;
    }

    /**
     * @param Blar\Mail\Mail $mail Mail.
     * @return self
     */
    public function sendMail(Mail $mail) {
        $handle = fopen('php://temp', 'w');
        fwrite($handle, $mail);
        rewind($handle);
        
        $this->getCurl()->setOption(CURLOPT_VERBOSE, true);
        $this->getCurl()->setOption(CURLOPT_PUT, true);
        $this->getCurl()->setOption(CURLOPT_MAIL_FROM, $mail->getFrom());
        $this->getCurl()->setOption(CURLOPT_MAIL_RCPT, array($mail->getTo()));
        $this->getCurl()->setOption(CURLOPT_INFILE, $handle);
        $this->getCurl()->execute();
        
        fclose($handle);
        return $this;
    }

}
