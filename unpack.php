<?php
/*
 Name: PocketMine Server plugin Pack & Unpack Tools
 Author: xMing (YMind Stidio)
 */
namespace{
    final class Packer{
        
        private $path = __FILE__;
        private $name;
        private $srcPath;
        private $binPATH;
        private $types;
        
        public function __construct($name){
            $this->name=$name;
            $this->types=array("bin","src");
            $this->createWorkPath();
        }
        
        public function setPath($type,$path):bool{
            switch($type){
                case "bin":
                    $this->binPath=$path;
                    break;
                    
                case "src":
                    $this->srcPath=$path;
                    break;
                    
                default:
                    return false;
            }
            return true;
        }
        
        private function createWorkPath(){
            foreach($this->types as $t){
                @mkdir($this->path."/".$t);
            }
        }
        
        public function pack(){
            
        }
        
        public function unpack(){
            $pharPath = "phar://".$this->binPath;
            //echo $pharPath;
            $folderPath = $this->name;
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($pharPath)) as $fInfo){
                $path = $fInfo->getPathname();
                @mkdir(dirname($folderPath . str_replace($pharPath,"", $path)), 0755, true);
                file_put_contents($folderPath . str_replace($pharPath,"", $path), file_get_contents($path));
            }
        }
    }
    define("BR",preg_match('/cli/i',php_sapi_name()) ? "\n" : "<br />");
    echo "Input your Program Name to unpack (without .phar): ";
    $name = trim(fgets(STDIN));
    $pack=new Packer($name);
    if($pack->setPath("bin",$name.".phar")){
        $pack->unPack();
        echo "Did it".BR;
    }
}
