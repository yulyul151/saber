<?php

namespace Blue\Saber;

/*
* Created by frandy
*/
use ErrorException;
use Blue\Saber\Compiles\SaberCompiler;

class Factory
{
    protected $root;
    
    protected $extend;
    
    protected $type;
    
    protected $output = [];
    
    protected $data = [];
    
    protected $extension = [
            '.saber.php',
            '.php',
            '.html',
            '.phtml'
        ];
    
    public function setRoot($root)
    {
        $this->root = $root;
    }
    
    public function view($file,$vars = [])
    {
        extract($vars);
        $this->data = $vars;
        $prepare = $this->prepareFile($file);
        $saberCompiler = new SaberCompiler($this->root);
        $view = $saberCompiler->addCompile($prepare);
        eval(' ?>'.$view.'<?php ');
        if(isset($this->extend)){
            eval(' ?>'.$saberCompiler->addCompile($this->extend).'<?php ');
        }
        
    }
    
    public function isinclude($path)
    {
        extract($this->data);
        $prepare = $this->prepareFile($path);
        $compiler = new SaberCompiler($this->root);
        eval(' ?>'.$compiler->addCompile($prepare).'<?php ');
    }
    
    public function content($type)
    {
        return $this->output[$type];
    }
    
    public function block($type,$value = null)
    {
        $this->type = $type;
        if(isset($value)){
            $this->output[$type] = $value;
        }
        ob_start();
    }
    
    public function endblock()
    {
        $this->output[$this->type] = ob_get_clean();
    }
    
    public function layout($file)
    {
        $file = $this->prepareFile($file);
        $this->extend = str_replace(['/','\\'],DIRECTORY_SEPARATOR,$file);
    }
    
    public function prepareFile($file)
    {
        $file = str_replace('.',DIRECTORY_SEPARATOR,$file);
        $extension = $this->prepareExtension($file,$this->extension);
        return $file.$extension;
    }
    
    public function prepareExtension($file,$extn)
    {
        if(file_exists($this->root.$file.$extn[1])){
            return $extn[1];
        }elseif(file_exists($this->root.$file.$extn[2])){
            return $extn[2];
        }elseif(file_exists($this->root.$file.$extn[0])){
            return $extn[0];
        }else{
            throw new ErrorException('View ['.$file.'] Does Not Exists');
        }
        
        
    }
}