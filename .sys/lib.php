<?php

class System{
	private static $instance;
	private $documentRoot, $serverAddr;

	private function __construct(){
		$this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
		$this->serverAddr = $_SERVER['SERVER_ADDR'];
	}

	public static function getInstance(){
		if (is_null(self::$instance))
			self::$instance = new System();
		return self::$instance;
	}

	public function __get($name){
		return $this->$name;
	}
}

class Dir{
	private $path, $backPath, $relPath, $webPath;
	private $list, $dirList, $fileList, $exclude;

	public function __construct($path, $exclude){
		$this->setPath($path, $exclude);
	}

	public function __get($name){
		return $this->$name;
	}

	public function setPath($path, $exclude = array()){
		if (!is_dir($path))
			return;
		$this->path = $path;
		$this->exclude = $exclude;
		$this->backPath = false;
		$system = System::getInstance();
		$this->relPath = str_replace($system->documentRoot, '', $this->path);
		if (strlen($this->relPath) > 0){
			$splitPath = explode('/', $this->path);
			$lastSplit = $splitPath[count($splitPath) - 2].'/';
			$this->backPath = str_replace($lastSplit, '', $this->path);
		}
		$this->webPath = 'http://'.$system->serverAddr.'/'.$this->relPath;
		$this->readDir();
	}

	private function readDir(){
		try{
			$this->list = scandir($this->path);
			$this->list = array_diff($this->list, array('..', '.'));
			$this->dirList = $this->fileList = array();

			foreach ($this->list as $name){
				if (!in_array($name, $this->exclude)){
					$documentPath = $this->path.$name;
					$webPath = $this->webPath.$name;
					if (is_dir($documentPath)){
						$this->dirList[] = array(
							'name' => $name,
							'type' => 'dir',
							'documentPath' => $documentPath.'/',
							'webPath' => $webPath.'/'
						);
					}
					if (is_file($documentPath)){
						$this->fileList[] = array(
							'name' => $name,
							'type' => 'file',
							'documentPath' => $documentPath,
							'webPath' => $webPath
						);
					}
				}
			}

			$this->list = array();
			$this->list = array_merge($this->dirList, $this->fileList);
		}
		catch(Exception $e){

		}
	}
}

$system = System::getInstance();