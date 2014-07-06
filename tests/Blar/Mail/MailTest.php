<?php

use PHPUnit_Framework_TestCase as TestCase,
    Blar\Mail\Mail,
    Blar\Mail\MailAddress,
    Blar\Mail\Transports\SendmailTransport,
    Blar\Mail\Transports\CurlTransport,
    Blar\Mime\Mime;

class MailTest extends TestCase {

    public function testSendmailTransport() {
        $this->markTestSkipped('How to use Sendmail with Mailtrap?');

        $mail = new Mail();
        $mail->setFrom('foo@example.com');
        $mail->setTo(new MailAddress('bar@example.com', 'Bar 42'));
        $mail->setHeader('Subject', 'Test');
        $mail->setHeader('X-Foo', 23);
        $mail->setHeader('X-Bar', 42);
        $mail->setHeader('X-Foo-Bar', 1337);
        $mail->setBody('Hello World');
        
        $transport = new SendmailTransport();
        $transport->sendMail($mail);
    }

    public function testSimple() {
        $mail = new Mail();
        $mail->setTo('foo@example.com');
        
        $headers = $mail->getHeaders();
        $headers->set('From', 'foobar@example.com');
        $headers->set('To', 'foo@example.com');
        $headers->set('Subject', 'Testnachricht');
        $mail->push('Hello World');
    }

    public function testHeaders() {
        $mail = new Mail();
        $mail->setTo('foo@example.com');
        
        $headers = $mail->getHeaders();
        $headers->set('From', 'foobar@example.com');
        $headers->set('To', 'foo@example.com');
        $headers->set('Subject', 'Testnachricht');
        $headers->set('X-Foo', '23');
        $headers->set('X-Bar', '42');
        $headers->set('X-Foo-Foo', '1337');
        $mail->push('Hello World');
    }

    public function testBoundary() {
        $mail = new Mail();
        $this->assertEquals($mail->getBoundary(), $mail->getBoundary());
        $this->assertEquals($mail->setBoundary('foo')->getBoundary(), $mail->getBoundary());
        $this->assertEquals('foo', $mail->getBoundary());
        $this->assertNotEquals($mail->getBoundary(), $mail->setBoundary('bar')->getBoundary());
    }

    public function testMimeParts() {
        $mail = new Mail();
        $mail->setBoundary('4cda2d9a46f80b7b49b97e0417fdcc86095967bf');
        $mail->setFrom('foo@example.com');
        $mail->setTo('bar@example.com');
        
        $headers = $mail->getHeaders();
        $headers->set('From', 'foo@example.com');
        $headers->set('To', 'bar@example.com');
        $headers->set('Subject', 'Hello World');
        $mail->push("Content-Type: text/plain\r\n\r\nFoo");
        $mail->push("Content-Type: text/plain\r\n\r\nBar");

        $this->assertStringEqualsFile(__DIR__.'/MailTest_MimeParts.eml', str_replace("\r", "", $mail));
    }

    public function testCurlTransport() {
        $mail = new Mail();
        $mail->setTo('foo@example.com');
        
        $headers = $mail->getHeaders();
        $headers->set('From', 'bar@example.com');
        $headers->set('To', 'foo@example.com');
        $headers->set('Subject', 'Testnachricht');
        $headers->set('X-Foo', 23);
        $headers->set('X-Bar', 42);
        $headers->set('X-Foo-Bar', 1337);
        $mail->push("Content-Type: text/plain\r\n\r\nFoo");
        
        $mime = new Mime();
        $headers = $mime->getHeaders();
        $headers->set('Content-Type', 'text/html');
        $mime->push('<p>Hello World</p>');
        $mail->push($mime);
        
        $credentials = getEnv('MAILTRAP_SMTP_CREDENTIALS');
        if(!$credentials) {
            $this->markTestSkipped('Credentials for Mailtrap not found!');
        }
        $credentials = explode(':', $credentials, 2);
        $transport = new CurlTransport('mailtrap.io');
        $transport->setCredentials($credentials[0], $credentials[1]);
        $transport->sendMail($mail);
        
        $this->markTestIncomplete('Check sent mail via Mailtrap is not implemented');
    }

}
