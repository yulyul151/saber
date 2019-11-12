<?php

namespace  Blue\Saber;

/*
* Created by frandy
*/

use Blue\Saber\Factory;

class View
{
    const DS = DIRECTORY_SEPARATOR;
    
    protected $root;
    
    public function __construct($rootPath = null)
    {
        if(is_null($rootPath)){
            throw new ErrorException('Please Add The Directory Path');
        }
        
        $this->root = getcwd().self::DS.str_replace(['/','\\'],self::DS,$rootPath).self::DS;
        
    }
    
    public function getPath()
    {
        return $this->root;
    }
    
    public function make($file,$vars = [])
    {
        $this->factory($file,$vars);
    }
    
    public function factory($file,$vars = [])
    {
        $factory = new Factory();
        $factory->setRoot($this->getPath());
        $factory->view($file,$vars);
    }
    
}