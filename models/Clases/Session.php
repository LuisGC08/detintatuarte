<?php
class Session{
    private $sessionName = 'user';
    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }
    public function set_current_user($user){
        $_SESSION[$this->sessionName] = $user;
    }
    public function get_current_user($user){
        return $_SESSION[$this->sessionName];
    }
    public function closeSession(){
        session_unset();
        session_destroy();
    }
    public function exists(){
        return isset($_SESSION[$this->sessionName]);
    }
}