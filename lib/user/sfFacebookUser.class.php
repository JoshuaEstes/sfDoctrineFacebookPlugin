<?php
class sfFacebookUser extends sfGuardSecurityUser
{
  private $facebookUser = null;

  /**
   * Grabs the facebook user record out of the table
   *
   * @return sfGuardFacebookUser
   */
  public function getFacebookUser()
  {
    if (!$this->facebookUser && $uuid = $this->getAttribute('uuid', null))
    {
      $this->facebookUser = Doctrine_Core::getTable('sfGuardFacebookUser')->findOneBy('uuid',$uuid);

      if (!$this->facebookUser)
      {
        // the user does not exist anymore in the database
        $this->signOut();

        throw new sfException('The user does not exist anymore in the database.');
      }
    }
    return $this->facebookUser;
  }
}