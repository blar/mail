Mail
====

.. toctree::
   :maxdepth: 2

   transports


Beispiel
********

.. code-block:: php

   $mail = new Mail();
   $mail->setFrom('foobar@example.com');
   $mail->setTo('foo@example.com, bar@example.com');

.. note::

   Mail::setTo() setzt den Envelope-To. In dieser Liste sind alle Empfänger
   enthalten. Es werden jedoch nur Empfänger in der E-Mail angezeigt, die in den
   Headern **To** oder **BCC** angegeben sind.


E-Mail-Adressen als Objekte
***************************

.. code-block:: php

   $mail = new Mail();
   $mail->setFrom(new MailAddress('foobar@example.com', 'Foo Bar'));

   $to = new AddressCollection();
   $to->push('foo@example.com');
   $to->push('bar@example.com');
   $mail->setTo($to);


Zusätzliche Header
******************

.. code-block:: php

   $mail = new Mail();
   $mail->setFrom(new MailAddress('foobar@example.com', 'Foo Bar'));

   $to = new AddressCollection();
   $to->push('foo@example.com');
   $to->push('bar@example.com');
   $mail->setTo($to);

   $headers = $mail->getHeaders();
   $headers->set('Content-Type', 'text/html');
   $headers->set('Subject', 'Hello World');

   $mail->push('<p>Hello World</p>');


Fluid Interface
***************

.. code-block:: php

   $to = new AddressCollection();
   $to
       ->push('foo@example.com')
       ->push('bar@example.com');

   $mail = new Mail();

   $mail
       ->setFrom(new MailAddress('foobar@example.com', 'Foo Bar'))
       ->setTo($to);

   $mail
        ->getHeaders()
        ->set('Content-Type', 'text/html')
        ->set('Subject', 'Hello World')
        ->push('<p>Hello World</p>');


.. _mail: http://www.php.net/manual/function.mail.php
