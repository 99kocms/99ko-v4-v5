<?php

define('FAQ_DATAPATH', ROOT.'data/plugin/faq/');

class faq{
	private $entries;

	public function __construct(){
		$this->entries = $this->listAll();
	}

	public function getEntries(){
		return $this->entries;
	}
	public function getEntry($id){
		foreach($this->entries as $entry){
			if($entry->getId() == $id) return $entry;
		}
	}
	public function addEntry($obj){
		if($id = $this->saveEntry($obj)){
			$obj->setId($id);
			$this->entries[] = $obj;
			return true;
		}
		return false;
	}
	public function delEntry($id){
		foreach($this->entries as $k=>$obj){
			if($obj->getId() == $id && $this->_delEntry($obj)){
				unset($this->entries[$k]);
			}
		}
	}
	public function countEntries(){
		return count($this->entries);
	}

	private function listAll(){
		$orderMode[1] = array('question', 'asc');
		$orderMode[2] = array('id', 'desc');
		$orderModeSelected = pluginsManager::getPluginConfVal('faq', 'orderMode');
		$data = array();
		$dataNotSorted = array();
		foreach(scandir(FAQ_DATAPATH) as $k=>$file) if($file != 'config.json' && $file[0] != '.'){
			$dataNotSorted[] = json_decode(file_get_contents(FAQ_DATAPATH.$file), true);
		}
		if(count($dataNotSorted) > 0){
			$dataSorted = util::sort2DimArray($dataNotSorted, $orderMode[$orderModeSelected][0], $orderMode[$orderModeSelected][1]);
			foreach($dataSorted as $val){
				$data[] = new faqEntry($val);
			}
		}
		return $data;
	}
	private function saveEntry($obj){
		$id = intval($obj->getId());
		if($id < 1) $id = $this->makeId();
		$data = array(
			'id' => $id,
			'question' => $obj->getQuestion(),
			'answer' => $obj->getAnswer(),
		);
		if(@file_put_contents(FAQ_DATAPATH.$id.'.txt', json_encode($data), 0666)) return $id;
		return false;
	}
	private function makeId(){
		$ids = array();
		foreach($this->entries as $obj){
			$ids[] = $obj->getId();
		}
		return @max($ids)+1;
	}
	private function _delEntry($obj){
		if(@unlink(FAQ_DATAPATH.$obj->getId().'.txt')) return true;
		return false;
	}
}

class faqEntry{
	private $id;
	private $question;
	private $answer;

	public function __construct($val = array()){
		if(count($val) > 0){
			$this->id = $val['id'];
			$this->question = $val['question'];
			$this->answer = $val['answer'];
		}
	}

	public function setId($val){
		$this->id = trim($val);
	}
	public function setQuestion($val){
		$val = trim($val);
		if($val == '') $val = "Question non définie";
		$this->question = $val;
	}
	public function setAnswer($val){
		$this->answer = trim($val);
	}

	public function getId(){
		return $this->id;
	}
	public function getQuestion(){
		return $this->question;
	}
	public function getAnswer(){
		return $this->answer;
	}
}
?>
