[![Build Status](https://travis-ci.org/blar/mail.png?branch=master)](https://travis-ci.org/blar/mail)
[![Coverage Status](https://coveralls.io/repos/blar/mail/badge.png?branch=master)](https://coveralls.io/r/blar/mail?branch=master)
[![Dependency Status](https://gemnasium.com/blar/mail.svg)](https://gemnasium.com/blar/mail)

# blar/mail

Mail für PHP.

[Dokumentation von blar/mail auf Read-the-Docs](http://blarmail.readthedocs.org/)

## Mail erstellen

    $mail = new Mail();
    $mail->setFrom('foo@example.com');
    $mail->setTo('bar@example.com');
    $mail->getHeaders()->set('Subject', 'Hello World');
    $mail->setBody('Hello World');

## Mail versenden

    $transport = new SendmailTransport();
    $transport->sendMail($mail);

## Mail über externen SMTP-Server versenden

    $transport = new CurlTransport('smtp.example.com');

    // Zugangsdaten für den SMTP-Server
    $credentials = new BasicCredentials();
    $credentials->setUserName('foo');
    $credentials->setPassword('bar');
    $transport->setCredentials($credentials);

    $transport->sendMail($mail);
