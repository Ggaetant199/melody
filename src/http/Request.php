<?php
namespace melody\http;

/**
 * représente la requête du client
 */

class Request
{
    protected   $uri;
    protected   $varGetUri;
    protected   $method;
    protected   $varGetUri_isUri;
    public      $headers;
    public      $query;
    public      $params;
    public      $body;
    public      $files;

    public function __construct(string $varGetUri = null, bool $varGetUri_isUri = false) {
      
        $this->varGetUri        = $varGetUri;
        $this->varGetUri_isUri  = $varGetUri_isUri;

        $this->init();
    }

    protected function init () {
        $this->initUri();
        $this->initMethod();
        $this->initHeader();
        $this->initQuery();
        $this->initBody();
        $this->initFiles();
    }

    public function getMethod () {
        return $this->method;
    }

    public function getUri () {
        return $this->uri;
    }

    public function upload () {

    }

    protected function initUri () {

        if ($this->varGetUri != null) {

            if ($this->varGetUri_isUri) {
                $this->uri = $this->varGetUri;
                return $this;
            }

            if (isset($_GET[$this->varGetUri])) {
                $this->uri = $_GET[$this->varGetUri];
                return $this;
            }
            
            $this->uri = '';

            return $this;
        }

        $this->uri = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );

        return $this;
    }

    protected function initMethod () {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        return $this;
    }

    protected function initHeader () {
        $this->headers = getallheaders();
        return $this;
    }
    
    protected function initQuery () {
        $this->query = &$_GET;
    }

    protected function initBody () {
        $this->body = &$_POST;
    }

    protected function initFiles () {
        $this->files = &$_FILES;
    }

}