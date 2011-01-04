<?php

/**
 * sfDoctrineFacebookPlugin configuration.
 * 
 * @package     sfDoctrineFacebookPlugin
 * @subpackage  config
 * @author      Joshua Estes
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class sfDoctrineFacebookPluginConfiguration extends sfPluginConfiguration
{

  private $_facebook = null;

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('context.method_not_found', array($this, 'listenToContextMethodNotFoundEvent'));

    if (sfConfig::get('app_sf_facebook_load_routing', true))
    {
      $this->dispatcher->connect('routing.load_configuration', array('sfFacebookRouting', 'listenToLoadConfigurationEvent'));
    }

    if (sfConfig::get('app_sf_facebook_plugin_debug',false))
    {
      $this->dispatcher->connect('debug.web.load_panels', array($this, 'listenToLoadDebugWebPanelEvent'));
    }
  }

  public function listenToContextMethodNotFoundEvent(sfEvent $event)
  {
    $parameters = $event->getParameters();
    if ('getFacebook' != $parameters['method'])
      return false;

    if ($this->_facebook instanceof sfFacebook)
    {
      $event->setReturnValue($this->_facebook);
      return true;
    }

    require_once sfConfig::get('sf_lib_dir').'/vendor/facebook/src/facebook.php';
    $this->_facebook = new sfFacebook($this->dispatcher);
    $event->setReturnValue($this->_facebook);
    $this->dispatcher->notify(new sfEvent($this, 'facebook.configure'));
    return true;
  }

  public function listenToLoadDebugWebPanelEvent(sfEvent $event)
  {
    $event->getSubject()->setPanel('facebook',new sfWebDebugPanelFacebook($event->getSubject()));
  }

}
