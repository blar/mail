<?php

use PHPUnit_Framework_TestCase as TestCase,
    Blar\Mail\MailAddress;

class MailAddressTest extends TestCase {

    public function testAddress() {
        $mailAddress = new MailAddress('foobar@example.com');

        $this->assertEquals('', $mailAddress->getUserName());
        $this->assertEquals('foobar', $mailAddress->getMailbox());
        $this->assertEquals('example.com', $mailAddress->getHostName());
        $this->assertEquals('foobar@example.com', $mailAddress->getEmail());
        $this->assertEquals('<foobar@example.com>', (string) $mailAddress);
    }

    public function testAddressWithUserName() {
        $mailAddress = new MailAddress('foobar@example.com', 'foo bar');

        $this->assertEquals('foo bar', $mailAddress->getUserName());
        $this->assertEquals('foobar', $mailAddress->getMailbox());
        $this->assertEquals('example.com', $mailAddress->getHostName());
        $this->assertEquals('foobar@example.com', $mailAddress->getEmail());
        $this->assertEquals('foo bar <foobar@example.com>', (string) $mailAddress);
    }

    public function testAddressWithUserName2() {
        $mailAddress = new MailAddress();
        $mailAddress->setUserName('foo bar');
        $mailAddress->setMailbox('foobar');
        $mailAddress->setHostName('example.com');

        $this->assertEquals('foo bar', $mailAddress->getUserName());
        $this->assertEquals('foobar', $mailAddress->getMailbox());
        $this->assertEquals('example.com', $mailAddress->getHostName());
        $this->assertEquals('foobar@example.com', $mailAddress->getEmail());
        $this->assertEquals('foo bar <foobar@example.com>', (string) $mailAddress);
    }

    public function testAddressWithFluidInterface() {
        $mailAddress = new MailAddress();
        $mailAddress
            ->setUserName('foo bar')
            ->setMailbox('foobar')
            ->setHostName('example.com');

        $this->assertEquals('foo bar', $mailAddress->getUserName());
        $this->assertEquals('foobar', $mailAddress->getMailbox());
        $this->assertEquals('example.com', $mailAddress->getHostName());
        $this->assertEquals('foobar@example.com', $mailAddress->getEmail());
        $this->assertEquals('foo bar <foobar@example.com>', (string) $mailAddress);
    }

}
