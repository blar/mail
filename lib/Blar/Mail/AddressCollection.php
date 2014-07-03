<?php

namespace Blar\Mail;

use Blar\Common\Collections\Collection;

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */
class AddressCollection extends Collection {

    public static function factory($addressCollection) {
        if(is_string($addressCollection)) {
            $addressCollection = static::parse($addressCollection);
        }
        return $addressCollection;
    }

    /**
     * @return Blar\Mail\AddressCollection
     */
    public static function parse($addressCollection) {
        $result = imap_rfc822_parse_adrlist($addressCollection, getHostname());
        $addressCollection = new static($result);
        return $addressCollection->map(function($user) {
            if(!$user->host) {
                continue;
            }
            if($user->host == '.SYNTAX-ERROR.') {
                continue;
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
        return $this->map(function($address) {
            return $address->getEmail();
        });
    }
}
