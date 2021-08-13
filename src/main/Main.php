<?php
namespace melody\main;

use Closure;
use melody\http\Request;
use melody\http\Response;

class Main {
    
    protected $request;
    protected $response;
    protected $middelware = []; 
    protected $defaultResponse = null;
    protected $noFound = true;

    public function __construct(string $nameGetUri = null) {

        $this->request  = new Request($nameGetUri);
        $this->response = new Response();

    }

    public function all (Closure $callBack) {
       
        $this->middelware[] = $callBack;

        return $this;
    }

    public function get ($uriShema = null, Closure $callBack) {
       
        if ($this->request->getMethod() == 'get') {

            if ( $this->scanUriShema ($uriShema) ) {
                $this->middelware[] = $callBack;
            }

        }

        return $this;
    }

    public function post ($uriShema = null, Closure $callBack) {

        if ($this->request->getMethod() == 'post') {
            $this->middelware[] = $callBack;
        }

        return $this;
    }

    public function put ($uriShema = null, Closure $callBack) {

        if ($this->request->getMethod() == 'put') {
            $this->middelware[] = $callBack;
        }

        return $this;
    }

    public function delete ($uriShema = null, Closure $callBack) {

        if ($this->request->getMethod() == 'delete') {
            $this->middelware[] = $callBack;
        }

        return $this;
    }

    public function default (Closure $callBack) {

        $this->defaultResponse = $callBack;

        return $this;
    }

    public function end () {

        $count = count($this->middelware);

        if ($count <= 0) {
            $this->middelware [] = $this->defaultResponse;
            $count = 1;
        }

        for ($i=0; $i < $count; $i++) { 
            $this->middelware [$i] ($this->request, $this->response);
        }

        exit;
    }

    protected function scanUriShema (string $uriShema = null) {

        // echo $uriShema.'<br>';
        // echo $this->request->getUri();
        // echo $this->request->query['q'];exit;

        if ($uriShema == null) {
            return true;
        }

        if ($uriShema == $this->request->getUri()) {
            return true;
        }

        return false;
    }

}