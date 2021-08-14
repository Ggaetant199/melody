<?php
namespace melody\main;

use Closure;
use melody\http\Request;
use melody\http\Response;

/**
 * 
 * class de base permettant d'initialiser une application Melody
 * 
 * @author gomsu gaetant : gg.gomsugaetant@gmail.com
 * @license MIT
 * @version melody 1.0.0
 * 
 */


class Main {
    
    protected $request;
    protected $response;
    protected $middelware       = []; 
    protected $defaultResponse  = null;
    protected $notFoundRequest  = true;
  
    /**
     * @param string|null $varGetUri
     * @param bool $varGetUri_isUri default false
     */
    public function __construct(string $varGetUri = null, bool $varGetUri_isUri = false) {

        $this->request  = new Request($varGetUri, $varGetUri_isUri);
        $this->response = new Response();

    }

    /**
     * @param Closure|array $callBack
     * @return Main
     * 
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function use ($callBack) {
       
        $this->addMiddleware($callBack);

        return $this;
    }

    
    /**
     * @param string|null $uriShema
     * @param Closure|array $callBack 
     * 
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function get (string $uriShema = null, $callBack) {
       
        if ($this->request->getMethod() == 'get') {

            if ( $this->scanUriShema ($uriShema) ) {
                $this->addMiddleware($callBack);
            }

        }

        return $this;
    }

     /**
     * @param string|null $uriShema
     * @param Closure|array $callBack 
     * 
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function post (string $uriShema = null, $callBack) {

        if ($this->request->getMethod() == 'post') {

            if ( $this->scanUriShema ($uriShema) ) {
                $this->addMiddleware($callBack);
            }

        }

        return $this;
    }

     /**
     * @param string|null $uriShema
     * @param Closure|array $callBack 
     * 
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function put (string $uriShema = null, $callBack) {

        if ($this->request->getMethod() == 'put') {
            
            if ( $this->scanUriShema ($uriShema) ) {
                $this->addMiddleware($callBack);
            }

        }

        return $this;
    }

     /**
     * @param string|null $uriShema
     * @param Closure|array $callBack 
     * 
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function delete (string $uriShema = null, $callBack) {

        if ($this->request->getMethod() == 'delete') {
            
            if ( $this->scanUriShema ($uriShema) ) {
                $this->addMiddleware($callBack);
            }

        }

        return $this;
    }

    /**
     * @param Closure|array $callBack
     * si $callBack est un tableau alors le tableau doit être un tableau dont les entrées sont des instances de Closure
     */
    public function default ($callBack) {

        $this->defaultResponse = $callBack;

        return $this;
    }

    /**
     * termine l'application et lance les middelwares
     */
    public function end () {

        // echo $this->request->getUri();exit;

        if ($this->notFoundRequest) {
            $this->addMiddleware($this->defaultResponse, true);
        }

        $count = count($this->middelware);

        for ($i=0; $i < $count; $i++) { 
            $this->middelware [$i] ($this->request, $this->response);
        }

        exit;
    }

    protected function addMiddleware (&$callBack, bool $notFoundRequest = false) {
        
        if ($callBack instanceof Closure) {
            $this->middelware[]     = $callBack;
            $this->notFoundRequest  = $notFoundRequest;
            
            return $this;
        } 
        
        if (is_array($callBack)) {
            foreach ($callBack as $callable) {
                if ($callable instanceof Closure) {
                    $this->middelware[] = $callable;
                }
            }

            $this->notFoundRequest  = $notFoundRequest;
            return $this;
        }

        throw new \Exception("Error Processing Request", 1);

    }

    /**
     * @param string|null $uriShema
     */
    protected function scanUriShema (string $uriShema = null) {

        if ($uriShema == null) {
            return true;
        }
        
        $params     = [];
        $matches1   = [];
        $matches2   = [];
        
        if (preg_match_All('":([a-zA-Z]+)"', $uriShema, $matches)) {
            
            unset($matches[0]);
            
            $matches1 = $matches[1];

            $uriShema = preg_replace('":[a-zA-Z]+"', "(.+)", $uriShema);
        }

        $pattern = ' "^' . $uriShema . '$" ';

        if (preg_match($pattern, $this->request->getUri(), $matches)) {
            
            array_shift($matches);

            $matches2 = $matches;

            if (count($matches1) != count($matches2)) {
                return false;
            }

            foreach ($matches1 as $key => $value) {
                $params[$value] = $matches2[$key];
            }

            $this->request->params = &$params;

            return true;
        }

        return false;
    }

}