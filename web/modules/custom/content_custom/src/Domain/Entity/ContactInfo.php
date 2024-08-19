<?php

namespace Drupal\content_custom\Domain\Entity;

class ContactInfo
{
  private $date;
  private $firstName;
  private $lastName;
  private $phoneNumber;
  private $email;

  public function __construct($date, $firstName, $lastName, $phoneNumber, $email)
  {
    $this->date = $date;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->phoneNumber = $phoneNumber;
    $this->email = $email;
  }

  public function getDate() { return $this->date; }
  public function setDate($date) { $this->date = $date; }
  public function getFirstName() { return $this->firstName; }
  public function setFirstName($firstName) { $this->firstName = $firstName; }
  public function getLastName() { return $this->lastName; }
  public function setLastName($lastName) { $this->lastName = $lastName; }
  public function getPhoneNumber() { return $this->phoneNumber; }
  public function setPhoneNumber($phoneNumber) { $this->phoneNumber = $phoneNumber; }
  public function getEmail() { return $this->email; }
  public function setEmail($email) { $this->email = $email; }
}
