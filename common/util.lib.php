<?php

/*
** fonctions utilitaires
*/

/*
** annule magic_quotes_gpc()
*/
function setMagicQuotesOff(){
	if(get_magic_quotes_gpc()){
	    function stripslashes_gpc(&$value){
		$value = stripslashes($value);
	    }
	    array_walk_recursive($_GET, 'stripslashes_gpc');
	    array_walk_recursive($_POST, 'stripslashes_gpc');
	    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
	    array_walk_recursive($_REQUEST, 'stripslashes_gpc');
	}
}

/*
** Tri un tableau a 2 dimenssions
** @param : $data (array), $key (tri), $mode (mode tri)
*/
function utilSort2DimArray($data, $key, $mode){
	if($mode == 'desc'){ $mode = SORT_DESC; }
	elseif($mode == 'asc'){ $mode = SORT_ASC; }
	elseif($mode == 'num'){ $mode = SORT_NUMERIC; }
	$temp = array();
	foreach($data as $k=>$v){
		$temp[$k] = $v[$key];
	}
	array_multisort($temp, $mode, $data);
	return $data;
}

/*
** URL rewriting
** @param : $url (string)
** @return : string
*/
function utilStrToUrl($str){
	$str = str_replace('&', 'et', $str);
	if($str !== mb_convert_encoding(mb_convert_encoding($str,'UTF-32','UTF-8'),'UTF-8','UTF-32')) $str = mb_convert_encoding($str,'UTF-8');
	$str = htmlentities($str, ENT_NOQUOTES ,'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i','$1',$str);
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'),'-',$str);
	return strtolower(trim($str,'-'));
}

/*
** Check une adresse email
** @param : $email (string)
** @return : true / false
**/
function utilIsEmail($email){
	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $email)) return true;
	return false;
}

/*
** Envoie un email
** @param : $from (adrese expéditeur), $reply (adresse de réponse), $subjet (sujet), $msg (message)
*/
function utilSendEmail($from, $reply, $to, $subject, $msg){
	$headers = "From: ".$from."\r\n";
	$headers.= "Reply-To: ".$reply."\r\n";
	//$headers.= "Return-Path: ".$this->emailReturn."\r\n";
	$headers.= "X-Mailer: PHP/".phpversion()."\r\n";
	$headers.= 'Content-Type: text/plain; charset="utf-8"'."\r\n";
	$headers.= 'Content-Transfer-Encoding: 8bit';
	if(@mail($to, $subject, $msg, $headers)) return true;
	return false;
}

/*
** Retourne l'extension d'un fichier
** @param : $file (string)
** @return : string
*/
function utilGetFileExtension($file){
  return substr(strtolower(strrchr(basename($file), ".")), 1);
}

/*
** Liste un répertoire
** @param : $folder (chemin), $not (fichiers a exclure)
** @return : array
*/
function utilScanDir($folder, $not = array()){
	$data['dir'] = array();
	$data['file'] = array();
	foreach(scandir($folder) as $file) if($file[0] != '.' && !in_array($file, $not)){
		if(utilGetFileExtension($file)) $data['file'][] = $file;
		else $data['dir'][] = $file;
	}
	return $data;
}

/*
** Retourne la version de PHP
** @return : string
*/
function utilPhpVersion(){
	return substr(phpversion(), 0, 5);
}
?>
