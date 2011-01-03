<?php

/**
 * Base actions for the sfDoctrineFacebookPlugin sfFacebookAuth module.
 * 
 * @package     sfDoctrineFacebookPlugin
 * @subpackage  sfFacebookAuth
 * @author      Joshua Estes
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasesfFacebookAuthActions extends sfActions
{
  public function executeLogin(sfWebRequest $request)
  {

  }

  public function executeDeauthorize(sfWebRequest $request)
  {
    return sfView::NONE;
  }
}
