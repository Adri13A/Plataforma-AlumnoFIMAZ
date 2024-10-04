<?php
//controller/authController.php

require_once("../../models/usuario.php");

class authController
{

  private $authModel;
  private $max_attempts = 5;
  private $lockout_time = 15;

  public function __construct($authModel)
  {
    $this->authModel = $authModel;
  }

  public function signup($username, $password)
  {
    try {
      return $this->authModel->createUser($username, $password);
    } catch (Exception $ex) {
      return false;
    }
  }

  public function login($username, $password, $ip_address)
  {
    $attempts = $this->authModel->getAttempts($username, $ip_address, $this->lockout_time);

    if ($attempts['attempt_count'] >= $this->max_attempts) {
      $first_attempt_time = new DateTime($attempts['first_attempt_time']);
      $current_time = new DateTime();
      $interval = $current_time->diff($first_attempt_time);

      if ($interval->i < $this->lockout_time) {
        return 'locked';
      }
    }

    $user = $this->authModel->getUserByUserName($username);

    if ($user && password_verify($password, $user['password'])) {
        $this->authModel->clearAttempts($username, $ip_address);
        return $user;
    } else {
        $this->authModel->logAttempt($username, $ip_address);
        return false;
    }
}
}
?>
