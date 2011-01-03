<?php
require_once sfConfig::get('sf_lib_dir').'/vendor/facebook/src/facebook.php';

class sfFacebook extends Facebook
{
  /**
   * @var sfEventDispatcher
   */
  private $dispatcher;

  /**
   * @param sfEventDispatcher $dispatcher
   * @param array $options
   */
  public function __construct(sfEventDispatcher $dispatcher,$options=array())
  {
    $this->dispatcher = $dispatcher;

    parent::__construct(array(
        'appId' => sfConfig::get('app_sf_facebook_plugin_app_id'),
        'secret' => sfConfig::get('app_sf_facebook_plugin_app_secret'),
        'cookie' => true,
        'domain' => sfConfig::get('app_sf_facebook_plugin_cookie_domain',$_SERVER['SERVER_NAME']),
        'fileUpload' => sfConfig::get('app_sf_facebook_plugin_enable_fileuploads',false)
      ));

    $dispatcher->notify(new sfEvent($this, 'facebook.configure'));
  }
}