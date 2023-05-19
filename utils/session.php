<?php

require_once(__DIR__ . '/../utils/security.php');
require_once(__DIR__ . '/../database/connection.db.php');

  class Session {
    private array $messages;

    public function __construct() {
      session_set_cookie_params(0, '/', 'localhost', true, true);
      session_start();
      if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = generate_random_token();
      }
      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? intval($_SESSION['id']) : null;    
    }

    

    public function logout() {
      session_destroy();
    }


    public function getUsername() : ?string {
      return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setName(string $username) {
      $_SESSION['username'] = $username;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  

  

  }
?>