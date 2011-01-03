<?php

class sfFacebookRouting
{

  static public function listenToLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();
    $routing->prependRoute('sf_facebook_signin', new sfRoute('/facebook/login', array(
      'module' => 'sfFacebookAuth',
      'action' => 'login',
    )));
    $routing->prependRoute('sf_facebook_deauthorize', new sfRoute('/facebook/deauthorize', array(
      'module' => 'sfFacebookAuth',
      'action' => 'deauthorize',
    )));
  }

}