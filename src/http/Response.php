<?php
namespace melody\http;

/**
 * représente la réponse du serveur
 */
class Response
{
    protected   $status = 200;
    public      $headers;

    public function send ($data) {
        
        if(is_string($data)) {
            echo $data;
            exit;
        }

        print_r($data);

        exit;
    }

    public function json ($data) {
       
        $this->header('content-type', 'application/json');
        $this->render();

        echo json_encode($data);

        exit;
    }

    public function location (string $location) {
       
        $this->status(303);
        $this->header('location', $location);
        $this->render();

        exit;
    }

    public function status (int $status) {
       
        $this->status = $status;

        return $this;
    }

    public function download($pathFile, $filename = null) {
        if(!file_exists($pathFile)) {
            return false;
        }

        if(is_null($filename)) {
            $filename = basename($pathFile);
        }

        header('pragma: public');
        header('expires: 0');
        header('cache-control: must-revalidate,post-check=0,pre-check=0');
        header('content-type: application/force-download');
        header('content-type: application/octet-stream');
        header('content-type: application/download');
        header('content-disposition: attachement');
        header('content-disposition: filename='.$filename.';');
        header('content-transfer-encoding:binary');
        header('content-length:'.filesize($pathFile));
        readfile($pathFile);
        
        exit;
    }

    public function header (string $key, string $value) {
       
        $this->headers[$key] = $value;
        return $this;
    }

    public function headers (array $headers) {
        
        foreach ($headers as $key => $value) {
            $this->header($key, $value);
        }

        return $this;
    }
 
    protected function render () {
        $this->renderHeader();
        $this->renderStatus();
    }

    protected function renderHeader () {
        foreach ($this->headers as $key => $value) {
            header($key . ':' . ' ' . $value);
        }

        return $this;
    }

    protected function renderStatus () {
        http_response_code($this->status);
        return $this;
    }
}