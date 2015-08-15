<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Mail;

use Blar\Common\Collections\Collection;
use Exception;

/**
 * Class AddressCollection
 *
 * @package Blar\Mail
 */
class AddressCollection extends Collection {

    /**
     * @param mixed $addressCollection
     *
     * @return AddressCollection
     */
    public static function factory($addressCollection) {
        if(is_string($addressCollection)) {
            $addressCollection = static::parse($addressCollection);
        }
        return $addressCollection;
    }

    /**
     * @return AddressCollection
     */
    public static function parse($addressCollection) {
        $result = imap_rfc822_parse_adrlist($addressCollection, getHostname());
        $addressCollection = new static($result);
        return $addressCollection->map(function ($user) {
            if(!$user->host) {
                throw new Exception('Missing or invalid host name');
            }
            if($user->host == '.SYNTAX-ERROR.') {
                throw new Exception('Missing or invalid host name');
            }
            $mailAddress = new MailAddress();
            if(property_exists($user, 'personal')) {
                $mailAddress->setUserName($user->personal);
            }
            $mailAddress->setMailbox($user->mailbox);
            $mailAddress->setHostname($user->host);
            return $mailAddress;
        });
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->join(', ');
    }

    /**
     * @return array
     */
    public function getEmails() {
        return $this->map(function ($address) {
            return $address->getEmail();
        });
    }
}
