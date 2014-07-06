Transports
==========

Es werden verschiedene Transports bereitgestellt um E-Mails zu versenden.


Sendmail-Transport
******************

.. code-block:: php

   $transport = new SendmailTransport();
   $transport->sendMail($mail);

.. note::

   Der Versand von E-Mails mit dem Sendmail-Transport ist meist einfacher, da
   Sendmail vom Administrator vorkonfiguriert sein sollte und keine Zugangsdaten
   benötigt werden.


Curl-Transport
**************

.. code-block:: php

   $transport = new CurlTransport('smtp.example.com');
   $transport->setCredentials('username', 'password');
   $transport->sendMail($mail);


.. note::

   Der Versand von E-Mails per Curl im selben Script ist deutlich schneller
   (~1.000%), da nicht für jede E-Mail ein neuer Prozess von Sendmail gestartet
   wird, sondern alle E-Mails mit der selben SMTP-Verbindung versendet werden.

