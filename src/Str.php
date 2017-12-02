<?php

namespace stekel\AutoTest;

class Str {
    
    public static function finish($value, $cap) {
    
        $quoted = preg_quote($cap, '/');
        
        return preg_replace('/(?:'.$quoted.')+$/u', '', $value).$cap;
    }
    
    public static function startsWith($string, $query) {
        
        return substr($string, 0, strlen($query)) === $query;
    }
    
    public static function contains($string, $query) {
        
        return strpos($string, $query) !== false;
    }
}