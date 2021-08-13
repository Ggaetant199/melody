<?php
namespace melody\http;

class Request
{
    protected   $uri;
    protected   $nameGetUri;
    protected   $method;
    public      $headers;
    public      $query;
    public      $params;
    public      $body;
    public      $files;

    public function __construct(string $nameGetUri = null) {
        $this->nameGetUri = $nameGetUri;
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

    protected function initUri () {

        if ($this->nameGetUri != null) {

            if (isset($_GET[$this->nameGetUri]))
                $this->uri = $_GET[$this->nameGetUri];
            else 
                $this->uri = '';

        } else {
            $this->uri = urldecode(
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );
        }

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