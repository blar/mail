<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail;

/**
 * Class MailAddress
 *
 * @package Blar\Mail
 */
class MailAddress {

    /**
     * @var string
     */
    private $mailbox;

    /**
     * @var string
     */
    private $hostName;

    /**
     * @var string
     */
    private $userName;

    /**
     * @param string $email E-Mail.
     * @param string $userName Username.
     */
    public function __construct($email = NULL, $userName = NULL) {
        $this->setEmail($email);
        $this->setUserName($userName);
    }

    /**
     * @return string
     */
    public function __toString() {
        $result = '<' . $this->getEmail() . '>';
        if($this->getUserName()) {
            $result = $this->getUserName() . ' ' . $result;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->getMailbox() . '@' . $this->getHostName();
    }


    /**
     * @param string $email E-Mail.
     *
     * @return $this
     */
    public function setEmail($email) {
        $parts = explode('@', $email, 2);
        if(array_key_exists(0, $parts)) {
            $this->setMailbox($parts[0]);
        }
        if(array_key_exists(1, $parts)) {
            $this->setHostName($parts[1]);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getMailbox() {
        return $this->mailbox;
    }

    /**
     * @param string $mailbox Mailbox.
     *
     * @return $this
     */
    public function setMailbox($mailbox) {
        $this->mailbox = $mailbox;
        return $this;
    }

    /**
     * @return string
     */
    public function getHostName() {
        return $this->hostName;
    }

    /**
     * @param string $hostName Hostname.
     *
     * @return $this
     */
    public function setHostName($hostName) {
        $this->hostName = $hostName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName() {
        return $this->userName;
    }

    /**
     * @param string $userName Username.
     *
     * @return $this
     */
    public function setUserName($userName) {
        $this->userName = $userName;
        return $this;
    }

}
