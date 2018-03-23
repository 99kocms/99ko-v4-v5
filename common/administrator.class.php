<?php
/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 *
 */

defined('ROOT') OR exit('No direct script access allowed');

class administrator{
    private static $instance = null;
    private $email;
    private $pwd;
    private $token;
    
    ## Constructeur
    public function __construct($email = '', $pwd = ''){
        $this->email = ($email != '') ? $email : @$_SESSION['adminEmail'];
        $this->pwd = ($pwd != '') ? $pwd : @$_SESSION['adminPwd'];
        $this->token = (isset($_SESSION['adminToken'])) ? $_SESSION['adminToken'] : sha1(uniqid(mt_rand(), true));
        $_SESSION['adminToken'] = $this->token;
    }
    
    ## Retourne l'instance de l'objet administrator
    public static function getInstance(){
        if(is_null(self::$instance)) self::$instance = new administrator();
        return self::$instance;
    }
    
    ## Retourne le jeton
    public static function getToken(){
        $instance = self::getInstance();
        return $instance->token;
    }
    
    ## Démmare la session
    public function login($email, $pwd){
        if($this->encrypt($pwd) == $this->pwd && $email == $this->email){
            $_SESSION['admin'] = $this->pwd;
            $_SESSION['adminEmail'] = $email;
            $_SESSION['adminPwd'] = $this->pwd;
            return true;
        }
        else return false;
    }
    
    ## Détruit la session
    public function logout(){
        session_destroy();
    }
    
    ## Teste l'état de la session
    public function isLogged(){
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $this->pwd) return false;
        else return true;
    }
    
    ## Teste le statut du jeton
    public function isAuthorized(){
        if(!isset($_REQUEST['token'])) return false;
        if($_REQUEST['token'] != $this->token) return false;
        return true;
    }
    
    ## Fonction de cryptage
    public function encrypt($data){
        return hash_hmac('sha1', $data, KEY);
    }

}
?>