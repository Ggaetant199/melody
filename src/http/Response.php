<?php
namespace melody\http;

class Response
{
    protected   $status = 200;
    public      $headers;

    public function send (string $data) {
        echo $data;
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