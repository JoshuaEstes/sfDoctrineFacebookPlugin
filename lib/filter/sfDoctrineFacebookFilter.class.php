<?php

/**
 * sfDoctrineFacebookFilter checks to make sure the user is either authenticated
 * with facebook or is authenticed with the app.
 *
 * facebook:
 *  class: sfFacebookFilter
 * security:  ~
 * 
 */
class sfDoctrineFacebookFilter extends sfFilter
{

  /**
   * Executes the filter
   *
   * @param sfFilterChain $filter
   */
  public function execute(sfFilterChain $filter)
  {
    // disable security on login and secure actions
    if (
      (sfConfig::get('sf_login_module') == $this->context->getModuleName()) && (sfConfig::get('sf_login_action') == $this->context->getActionName())
      ||
      (sfConfig::get('sf_secure_module') == $this->context->getModuleName()) && (sfConfig::get('sf_secure_action') == $this->context->getActionName())
      ||
      (sfConfig::get('app_sf_facebook_plugin_login_module') == $this->context->getModuleName()) && (sfConfig::get('app_sf_facebook_plugin_login_action') == $this->context->getActionName())
    )
    {
      $filter->execute();

      return;
    }

    // chceck cookie
    // @todo need to complete this section
    $cookieName = sfConfig::get('app_sf_facebook_plugin_remember_cookie_name', 'sfFacebookRememberMe');
    if (
      $this->isFirstCall()
      &&
      $this->context->getUser()->isAnonymous()
      &&
      $cookie = $this->context->getRequest()->getCookie($cookieName)
    )
    {
      $q = Doctrine_Core::getTable('sfGuardRememberKey')->createQuery('r')
            ->innerJoin('r.User u')
            ->where('r.remember_key = ?', $cookie);

      if ($q->count())
      {
        $this->context->getUser()->signIn($q->fetchOne()->User);
      }
    }

    // no cookie found
    if (!$session = $this->getContext()->getFacebook()->getSession())
    {
      if (sfConfig::get('sf_logging_enabled'))
      {
        $this->context->getEventDispatcher()->notify(new sfEvent($this, 'application.log', array(sprintf('Action "%s/%s" requires authentication, forwarding to "%s/%s"', $this->context->getModuleName(), $this->context->getActionName(), sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action')))));
      }

      $this->forwardToLoginAction();
    }

    // check to see if user is in the database
    if (!$facebook = Doctrine::getTable('sfGuardFacebookUser')->findOneBy('uuid', $this->getContext()->getFacebook()->getUser()))
    {
      $details = $this->getContext()->getFacebook()->api('/me');
      $facebook = new sfGuardFacebookUser();
      $facebook->uuid = $this->getContext()->getFacebook()->getUser();
      $facebook->first_name = $details['first_name'];
      $facebook->last_name = $details['last_name'];
      $facebook->timezone = $details['timezone'];
      $facebook->locale = $details['locale'];
      $facebook->save();
    }
    $this->getContext()->getUser()->setAttribute('uuid', $facebook->uuid);

    $this->getContext()->getUser()->setAuthenticated(true);

    $filter->execute();
    
    return;
  }

  /**
   * Forwards the current request to the secure action.
   *
   * @throws sfStopException
   */
  protected function forwardToLoginAction()
  {
    $this->context->getController()->forward(sfConfig::get('app_sf_facebook_plugin_login_module'), sfConfig::get('app_sf_facebook_plugin_login_action'));

    throw new sfStopException();
  }

}