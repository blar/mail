<?php

use PHPUnit_Framework_TestCase as TestCase,
    Blar\Mail\AddressCollection,
    Blar\Mail\MailAddress;

class AddressCollectionTest extends TestCase {

    public function testSingleAddress() {
        $addressCollection = AddressCollection::parse('foobar@example.com');
        
        $this->assertEquals(array('foobar@example.com'), $addressCollection->getEmails()->getArrayCopy());
        $this->assertEquals('foobar@example.com', $addressCollection[0]->getEmail());
        $this->assertEquals('', $addressCollection[0]->getUserName());
        $this->assertEquals('foobar', $addressCollection[0]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[0]->getHostName());
        $this->assertEquals('<foobar@example.com>', (string) $addressCollection[0]);
        $this->assertEquals('<foobar@example.com>', (string) $addressCollection);
    }

    public function testSingleAddressWithName() {
        $addressCollection = AddressCollection::parse('Foo Bar <foobar@example.com>');

        $this->assertEquals(array('foobar@example.com'), $addressCollection->getEmails()->getArrayCopy());
        $this->assertEquals('foobar@example.com', $addressCollection[0]->getEmail());
        $this->assertEquals('Foo Bar', $addressCollection[0]->getUserName());
        $this->assertEquals('foobar', $addressCollection[0]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[0]->getHostName());
        $this->assertEquals('Foo Bar <foobar@example.com>', (string) $addressCollection[0]);
        $this->assertEquals('Foo Bar <foobar@example.com>', (string) $addressCollection);
    }

    public function testMultipleAddress() {
        $addressCollection = AddressCollection::parse('foo@example.com, bar@example.com');

        $this->assertEquals(array('foo@example.com', 'bar@example.com'), $addressCollection->getEmails()->getArrayCopy());

        $this->assertEquals('foo@example.com', $addressCollection[0]->getEmail());
        $this->assertEquals('', $addressCollection[0]->getUserName());
        $this->assertEquals('foo', $addressCollection[0]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[0]->getHostName());

        $this->assertEquals('bar@example.com', $addressCollection[1]->getEmail());
        $this->assertEquals('', $addressCollection[1]->getUserName());
        $this->assertEquals('bar', $addressCollection[1]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[1]->getHostName());

        $this->assertEquals('<foo@example.com>, <bar@example.com>', (string) $addressCollection);
    }

    public function testMultipleAddressWithName() {
        $addressCollection = AddressCollection::parse('Foo 23 <foo@example.com>, Bar 42 <bar@example.com>');

        $this->assertEquals(array('foo@example.com', 'bar@example.com'), $addressCollection->getEmails()->getArrayCopy());

        $this->assertEquals('foo@example.com', $addressCollection[0]->getEmail());
        $this->assertEquals('Foo 23', $addressCollection[0]->getUserName());
        $this->assertEquals('foo', $addressCollection[0]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[0]->getHostName());

        $this->assertEquals('bar@example.com', $addressCollection[1]->getEmail());
        $this->assertEquals('Bar 42', $addressCollection[1]->getUserName());
        $this->assertEquals('bar', $addressCollection[1]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[1]->getHostName());

        $this->assertEquals('Foo 23 <foo@example.com>, Bar 42 <bar@example.com>', (string) $addressCollection);
    }

    public function testManualMultipleAddressWithName() {
        $addressCollection = new AddressCollection();
        $addressCollection->push(new MailAddress('foo@example.com', 'Foo 23'));
        $addressCollection->push(new MailAddress('bar@example.com', 'Bar 42'));

        $this->assertEquals(array('foo@example.com', 'bar@example.com'), $addressCollection->getEmails()->getArrayCopy());

        $this->assertEquals('foo@example.com', $addressCollection[0]->getEmail());
        $this->assertEquals('Foo 23', $addressCollection[0]->getUserName());
        $this->assertEquals('foo', $addressCollection[0]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[0]->getHostName());

        $this->assertEquals('bar@example.com', $addressCollection[1]->getEmail());
        $this->assertEquals('Bar 42', $addressCollection[1]->getUserName());
        $this->assertEquals('bar', $addressCollection[1]->getMailbox());
        $this->assertEquals('example.com', $addressCollection[1]->getHostName());

        $this->assertEquals('Foo 23 <foo@example.com>, Bar 42 <bar@example.com>', (string) $addressCollection);
    }

}
