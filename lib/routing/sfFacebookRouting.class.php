<?php

class sfFacebookRouting
{

  static public function listenToLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();
    $routing->prependRoute('sf_facebook_signin', new sfRoute('/facebook/signin', array(
      'module' => 'sfFacebookAuth',
      'action' => 'signin',
    )));
//    $routing->prependRoute('sf_facebook_connect_ajax_signin', new sfRoute('/fb-connect/ajax-signin', array(
//      'module' => 'sfFacebookConnectAuth',
//      'action' => 'ajaxSignin',
//    )));
  }

}