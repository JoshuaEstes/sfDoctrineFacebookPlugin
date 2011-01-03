<?php
class sfWebDebugPanelFacebook extends sfWebDebugPanel
{

  /**
   * Gets the text for the link.
   *
   * @return string The link text
   */
  public function getTitle()
  {
    return 'Facebook';
  }

  /**
   * Gets the title of the panel.
   *
   * @return string The panel title
   */
  public function getPanelTitle()
  {
    return 'Facebook Config Data';
  }

  /**
   * Gets the panel HTML content.
   *
   * @return string The panel HTML content
   */
  public function getPanelContent()
  {
    $facebook = sfContext::getInstance()->getFacebook();

    $contents = '<pre>';
    $contents .= 'App ID: '.$facebook->getAppId()."\n";
    $contents .= 'API Secret: '.$facebook->getApiSecret()."\n";
    $contents .= 'Use Cookie Support: '.$facebook->useCookieSupport()."\n";
    $contents .= 'Base Domain: '.$facebook->getBaseDomain()."\n";
    $contents .= 'Use File Upload Support: '.$facebook->useFileUploadSupport()."\n";
    $contents .= 'Signed Request: '.$facebook->getSignedRequest()."\n";
    $contents .= 'User: '.$facebook->getUser()."\n";
    $contents .= 'Access Token: '.$facebook->getAccessToken()."\n";
    $contents .= 'Login URL: '.$facebook->getLoginUrl()."\n";
    $contents .= 'Logout URL: '.$facebook->getLogoutUrl()."\n";
    $contents .= 'Login Status URL: '.$facebook->getLoginStatusUrl()."\n";
    $contents .= '</pre>';

    return $contents;
  }

}