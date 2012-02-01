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
	private $list, $dirList, $fileList;

	public function __construct($path){
		$this->setPath($path);
	}

	public function __get($name){
		return $this->$name;
	}

	public function setPath($path){
		if (!is_dir($path))
			return;
		$this->path = $path;
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

			$this->list = array();
			foreach ($this->dirList as $dir)
				$this->list[] = $dir;
			foreach ($this->fileList as $file)
				$this->list[] = $file;
		}
		catch(Exception $e){

		}
	}
}

$system = System::getInstance();