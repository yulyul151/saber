<?php

namespace Blue\Saber\Compiles;

/*
* Created by frandy
*/

class SaberCompiler
{
    protected $root;
    
    protected $file;
    
    public function __construct($root)
    {
        $this->root = $root;
    }
    
    public function addCompile($file)
    {
        $file = file_get_contents($this->root.$file);
        $file = $this->echos($file);
        $file = $this->block($file);
        $file = $this->isif($file);
        return $file;
    }
    
    private function isif($replace)
    {
        $replace = preg_replace_callback('/\@if\(.*\)/isU',function($if){
            $if[0] = trim($if[0],'@');
            return '<?php '.$if[0].': ?>';
        },$replace);
        
        $replace = preg_replace_callback('/@else/isU',function($else){
            return '<?php else: ?>';
        },$replace);
        
        $replace = preg_replace_callback('/@endif/',function($end){
            return '<?php endif; ?>';
        },$replace);
        
        $replace = preg_replace_callback('/\@elseif\(.*\)/',function($if){
            $if[0] = trim($if[0],'@');
            return '<?php '.$if[0].': ?>';
        },$replace);
        
        return $replace;
    }
    
    private function block($replace)
    {
                
        $replace = preg_replace_callback('/\@endblock/isU',function($matches){
            $matches[0] = trim($matches[0],'@');
            return '<?php $this->endblock(); ?>';
            
        },$replace);
        
        $replace = preg_replace_callback('/\@block\(.*\)/isU',function($matches){
            $matches[0] = trim($matches[0],'@');
            return '<?php $this->'.$matches[0].'; ?>';
        },$replace);
        
        $replace = preg_replace_callback('/\@foreach\(.*\)/isU',function($matches){
            $matches[0] = trim($matches[0],'@');
            return '<?php $num = 0; '.$matches[0].': ?>';
        },$replace);
        
        $replace = preg_replace_callback('/@endforeach/isU',function($matches){
            return '<?php $num++; endforeach; ?>';
        },$replace);
        
        $replace = preg_replace_callback('/\@extends\(.*\)/isU',function($matches){
            return '<?php '.str_replace('@extends','$this->layout',$matches[0]).'; ?>';
        },$replace);
        
        $replace = preg_replace_callback('/\@content\(.*\)/isU',function($matches){
            $matches[0] = trim($matches[0],'@');
            return '<?= $this->'.$matches[0].'; ?>';
        },$replace);
        
        $replace = preg_replace_callback('/\@include\(.*\)/isU',function($matches){
            $matches[0] = str_replace('@','$this->is',$matches[0]);
            return '<?php '.$matches[0].'; ?>';
        },$replace);
        
        return $replace;
    }
    
    private function echos($replace)
    {
        $replace = preg_replace_callback('/{{(.*)}}/isU',function($matches){
            $matches[1] = trim($matches[1]);
            if(preg_match('/!(.*)!/',$matches[1])){
                return '<?= '.trim($matches[1],'!').'; ?>';
            }
            
            return '<?= htmlspecialchars('.$matches[1].'); ?>';
            
        },$replace);
        
        return $replace;
    }
    
    
    
    
}