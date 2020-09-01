<?php
defined('ROOT') OR exit('No pagesFileect script access allowed');

## Fonction d'installation

function antispamInstall(){
}

## Hooks

## Code relatif au plugin

class antispam{
    private $operation;
    private $result;
    
    public function __construct(){
        $a = rand(1, 9);
        $b = rand(1, 9);
        //$op = '+';
        $this->result = $a + $b;
        $this->operation = $a." + ".$b." ?";
    }
    
    public function show(){
        $_SESSION['antispam_result'] = sha1($this->result);
        return '<p><label>'.$this->operation.'</label><br><input required="required" type="text" name="antispam" value="" /></p>';
    }
    
    public function isValid(){
        if($_SESSION['antispam_result'] == sha1($_POST['antispam'])) return true;
        return false;
    }
}
?>