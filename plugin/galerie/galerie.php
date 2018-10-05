<?php
defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation
function galerieInstall(){
	if(!file_exists(DATA_PLUGIN.'galerie/galerie.json')){
		@mkdir(UPLOAD.'galerie/');
		$data = array();
		util::writeJsonFile(DATA_PLUGIN.'galerie/galerie.json', $data);
	}
}

## Code relatif au plugin

class galerie{
	
	private $items;
	private $size;
	
	public function __construct(){
		$data = array();
		if(file_exists(DATA_PLUGIN.'galerie/galerie.json')){
			$temp = util::readJsonFile(DATA_PLUGIN.'galerie/galerie.json');
			if(pluginsManager::getPluginConfVal('galerie', 'order') == 'byDate') $temp = util::sort2DimArray($temp, 'date', 'desc');
			elseif(pluginsManager::getPluginConfVal('galerie', 'order') == 'byName') $temp = util::sort2DimArray($temp, 'title', 'asc');
			elseif(pluginsManager::getPluginConfVal('galerie', 'order') == 'natural') $temp = util::sort2DimArray($temp, 'id', 'asc');
			foreach($temp as $k=>$v){
				$data[] = new galerieItem($v);
			}
		}
		$this->items = $data;
		$this->size = pluginsManager::getPluginConfVal('galerie', 'size');
	}
	
	public function getItems(){
		return $this->items;
	}
	
	public function createItem($id){
		foreach($this->items as $obj){
			if($obj->getId() == $id) return $obj;
		}
		return false;
	}
	
	public function saveItem($obj){
		$id = $obj->getId();
		if($id == ''){
			$obj->setId(uniqid());
			$upload = util::uploadFile('file', UPLOAD.'galerie/', $obj->getId(), array('jpg'));
			if($upload == 'success'){
				$obj->setImg($obj->getId().'.jpg');
				galerieResize($this->size, $this->size, UPLOAD.'galerie/', $obj->getId().'.jpg', UPLOAD.'galerie/', $obj->getId().'.jpg');
			}
			$this->items[] = $obj;
		}
		else{
			foreach($this->items as $k=>$v){
				if($id == $v->getId()){
					$upload = util::uploadFile('file', UPLOAD.'galerie/', $obj->getId(), array('jpg'));
					if($upload == 'success'){
						$obj->setImg($obj->getId().'.jpg');
						galerieResize($this->size, $this->size, UPLOAD.'galerie/', $obj->getId().'.jpg', UPLOAD.'galerie/', $obj->getId().'.jpg');
					}
					$this->items[$k] = $obj;
				}
			}
		}
		return $this->saveItems();
	}
	
	public function delItem($obj){
		foreach($this->items as $k=>$v){
			if($obj->getId() == $v->getId()){
				unset($this->items[$k]);
			}
		}
		return $this->saveItems();
	}
	
	public function listCategories($hiddenItems = true){
		$data = array();
		foreach($this->items as $k=>$v) if($v->getCategory() != null && $v->getCategory() != ''){
			if($hiddenItems || (!$hiddenItems && !$v->getHidden())) $data[] = $v->getCategory();
		}
		asort($data);
		return array_unique($data);
	}
	
	public function useCategories(){
		if(count($this->listCategories()) > 0) return true;
		else return false;
	}
	
	public function getLastId(){
		$ids = array();
		foreach($this->items as $k=>$v){
			$ids[] = $v->getId();
		}
		return max($ids);
	}
	
	private function saveItems(){
		$data = array();
		foreach($this->items as $k=>$v){
			$data[] = array(
				'id' => $v->getId(),
				'title' => $v->getTitle(),
				'content' => $v->getContent(),
				'date' => $v->getDate(),
				'img' => $v->getImg(),
				'category' => $v->getCategory(),
				'hidden' => $v->getHidden(),
			);
		}
		if(util::writeJsonFile(DATA_PLUGIN.'galerie/galerie.json', $data)){
			return true;
		}
		return false;
	}
	
}

class galerieItem{
	
	private $id;
	private $title;
	private $date;
	private $content;
	private $img;
	private $category;
	private $hidden;
	
	public function __construct($data = array()){
		if(count($data) > 0){
			$this->id = $data['id'];
			$this->title = $data['title'];
			$this->content = $data['content'];
			$this->date = $data['date'];
			$this->img = $data['img'];
			$this->category = $data['category'];
			$this->hidden = (isset($data['hidden'])) ? $data['hidden'] : 0;
		}
	}
	
	public function setId($val){
		$this->id = $val;
	}
	
	public function setTitle($val){
		$val = trim($val);
		if($val == '') $val = $core->lang("News unnamed");
		$this->title = $val;
	}
	
	public function setContent($val){
		$this->content = trim($val);
	}
	
	public function setDate($val){
		$val = trim($val);
		if($val == '') $val = date('Y-m-d H:i:s');
		$this->date = $val;
	}
	
	public function setImg($val){
		$this->img = trim($val);
	}
	
	public function setCategory($val){
		$this->category = trim($val);
	}
	
	public function setHidden($val){
		$this->hidden = trim($val);
	}

	public function getId(){
		return $this->id;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function getDate($short = false){
		if($short){
			return substr($this->date, 0, 10);
		}
		return $this->date;
	}
	
	public function getImg(){
		return $this->img;
	}
	
	public function getCategory(){
		return $this->category;
	}
	
	public function getHidden(){
		return $this->hidden;
	}
	
}

## Fonction redim

function galerieResize($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src){
  // ------------------------------------------------------------------
 $condition = 0;
  // Si certains paramètres ont pour valeur '' :
   if ($rep_Dst == '') { $rep_Dst = $rep_Src; }  // (meme repertoire)
   if ($img_Dst == '') { $img_Dst = $img_Src; }  // (meme nom)
   if ($Wmax == '') { $Wmax = 0; }
   if ($Hmax == '') { $Hmax = 0; }
  // ------------------------------------------------------------------
  // si le fichier existe dans le répertoire, on continue...
 if (file_exists($rep_Src.$img_Src) && ($Wmax!=0 || $Hmax!=0)) { 
    // ----------------------------------------------------------------
    // extensions acceptées : 
   $ExtfichierOK = '" jpg jpeg png"';  // (l espace avant jpg est important)
    // extension
   $tabimage = explode('.',$img_Src);
   $extension = $tabimage[sizeof($tabimage)-1];  // dernier element
   $extension = strtolower($extension);  // on met en minuscule
    // ----------------------------------------------------------------
    // extension OK ? on continue ...
   if (strpos($ExtfichierOK,$extension) != '') {
       // -------------------------------------------------------------
       // récupération des dimensions de l image Src
      $size = getimagesize($rep_Src.$img_Src);
      $W_Src = $size[0];  // largeur
      $H_Src = $size[1];  // hauteur
       // -------------------------------------------------------------
       // condition de redimensionnement et dimensions de l image finale
       // -------------------------------------------------------------
       // A- LARGEUR ET HAUTEUR maxi fixes
      if ($Wmax != 0 && $Hmax != 0) {
         $ratiox = $W_Src / $Wmax;  // ratio en largeur
         $ratioy = $H_Src / $Hmax;  // ratio en hauteur
         $ratio = max($ratiox,$ratioy);  // le plus grand
         $W = $W_Src/$ratio;
         $H = $H_Src/$ratio;   
         $condition = ($W_Src>$W) || ($W_Src>$H);  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // B- LARGEUR maxi fixe
      if ($Hmax != 0 && $Wmax == 0) {
         $H = $Hmax;
         $W = $H * ($W_Src / $H_Src);
         $condition = $H_Src > $Hmax;  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // C- HAUTEUR maxi fixe
      if ($Wmax != 0 && $Hmax == 0) {
         $W = $Wmax;
         $H = $W * ($H_Src / $W_Src);         
         $condition = $W_Src > $Wmax;  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // on REDIMENSIONNE si la condition est vraie
       // -------------------------------------------------------------
      if ($condition == 1) {
          // création de la ressource-image"Src" en fonction de l extension
          // et on crée une ressource-image"Dst" vide aux dimensions finales
         switch($extension) {
         case 'jpg':
         case 'jpeg':
           $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
           $Ress_Dst = ImageCreateTrueColor($W,$H);
           break;
         case 'png':
           $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
           $Ress_Dst = ImageCreateTrueColor($W,$H);
            // fond transparent (pour les png avec transparence)
           imagesavealpha($Ress_Dst, true);
           $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
           imagefill($Ress_Dst, 0, 0, $trans_color);
           break;
         }
          // ----------------------------------------------------------
          // REDIMENSIONNEMENT (copie, redimensionne, ré-echantillonne)
         ImageCopyResampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
          // ----------------------------------------------------------
          // ENREGISTREMENT dans le répertoire (avec la fonction appropriée)
         switch ($extension) { 
         case 'jpg':
         case 'jpeg':
           ImageJpeg ($Ress_Dst, $rep_Dst.$img_Dst, 100);
           break;
         case 'png':
           imagepng ($Ress_Dst, $rep_Dst.$img_Dst, 0);
           break;
         }
          // ----------------------------------------------------------
          // libération des ressources-image
         imagedestroy ($Ress_Src);
         imagedestroy ($Ress_Dst);
      }
       // -------------------------------------------------------------
   }
 }
// --------------------------------------------------------------------------------------------------
  // retourne : 1 (vrai) si le redimensionnement et l enregistrement ont bien eu lieu, sinon rien (false)
  // si le fichier a bien été créé
 if ($condition == 1 && file_exists($rep_Dst.$img_Dst)) { return true; }
 else { return false; }
}
?>