<?php
class sfFacebookUser extends sfGuardSecurityUser
{
  public function getFacebookuser()
  {
    return sfContext::getInstance()->getFacebook();
  }
}