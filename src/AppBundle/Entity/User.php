<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */

class User implements UserInterface, \Serializable
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="email", type="string", length=255, unique=true)
   * @Assert\NotBlank()
   * @Assert\Email()
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=255, unique=true)
   * @Assert\NotBlank()
   */
  private $username;

  /**
   * @Assert\NotBlank()
   * @Assert\Length(max=4096)
   */
  private $plainPassword;

  /**
   * @ORM\Column(type="string", length=64)
   */
  private $password;

  /**
   * @ORM\Column(name="is_active", type="boolean")
   */
  private $isActive;

  public function __construct()
  {
    $this->isActive = true;
    // may not be needed, see section on salt below
    // $this->salt = md5(uniqid('', true));
  }

  public function getId()
  {
    return $this->id;
  }


  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
      $this->email = $email;
  }

  public function getSalt()
  {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
  }

  public function getPlainPassword()
  {
    return $this->plainPassword;
  }

  public function setPlainPassword($password)
  {
    $this->plainPassword = $password;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getRoles()
  {
    return array('ROLE_USER');
  }

  public function eraseCredentials()
  {
  }

  /** @see \Serializable::serialize() */
  public function serialize()
  {
    return serialize(array(
      $this->id,
      $this->username,
      $this->password,
      // see section on salt below
      // $this->salt,
    ));
  }

  /** @see \Serializable::unserialize() */
  public function unserialize($serialized)
  {
    list (
      $this->id,
      $this->username,
      $this->password,
      // see section on salt below
      // $this->salt
      ) = unserialize($serialized);
  }
}