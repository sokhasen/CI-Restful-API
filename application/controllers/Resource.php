<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Resource extends CI_Controller
{ 
    /**
     * HTTP response code with message.
     *
     * @var array
     */
    protected const _RESPONSE_MESSAGES = array(
            200 => "OK",
            201 => "Created",
            301 => "Moved Permanently",
            302 => "Not Modified",
            307 => "Temporary Redirect",
            308 => "Permanent Redirect",
            400 => "Bad Request",
            401 => "Unauthorized",
            403 => "Method Not Allowed",
            404 => "Not Found",
            406 => "Not Acceptable",
            408 => "Request Timeout",
            409 => "Length Required", 
            502 => "Bad Gateway",
            503 => "Service Unavailable",
            504 => "Gateway Timeout"
        );

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get body from GET method.
     *
     *@param resource $key
     *@param boolean $xss_clean
     * @return string $resquest_user_params
     */
    public function get($key, $xss_clean = TRUE)
    {
        if ($this->isMethod("GET")) {
            return $this->input->get($key, $xss_clean);
        }
        $this->_methodNotAllowError();
    }

    /**
     * get body from POST method.
     *
     *@param resource $key
     *@param boolean $xss_clean
     * @return string $resquest_user_params
     */
    public function post($key, $xss_clean = TRUE)
    {
        if ($this->isMethod("POST")) {
            return $this->input->post($key, $xss_clean);
        }
        $this->_methodNotAllowError();
    }

    /**
     * get body from PUT method.
     *
     *@param resource $key
     *@param boolean $xss_clean
     * @return string $resquest_user_params
     */
    public function put($key, $xss_clean = TRUE)
    {
        if ($this->isMethod("PUT")) {
            return $this->input->input_stream($key, $xss_clean);
        }
        $this->_methodNotAllowError();
    }

    /**
     * get body from DELETE method.
     *
     *@param resource $key
     *@param boolean $xss_clean
     * @return string $resquest_user_params
     */
    public function delete($key, $xss_clean = TRUE)
    {
        if ($this->isMethod("DELETE")) {
            return $this->input->input_stream($key, $xss_clean);
        }
        $this->_methodNotAllowError();
    }

    /**
     * check specific request method.
     *
     *@param string $method
     * @return boolean
     */
    protected function isMethod($method = "GET") {
        $requestMethod = $this->input->method(FALSE);
        $requestMethodParam = strtolower($method);
        if ($requestMethod === $requestMethodParam) {
            return TRUE;
        }
        return  FALSE;
    }

    /**
     * mapping array to json for responding data.
     *
     *@param array $data
     *@param int $code
     *@param string $content
     * @return json $data
     */
    protected function response( $data = [], $code = 200, $content = "application/json") {
        header($_SERVER["SERVER_PROTOCOL"]." ".$code." ".@self::_RESPONSE_MESSAGES[$code]);
        header('Content-Type: '.$content);
        print json_encode($data);
    }

     /**
     * handling error when request method was occured.
     *
     *@param void 
     */
    private function _methodNotAllowError() {
        trigger_error($this->input->method(TRUE)." is method not allowed", E_USER_ERROR);
        exit(0);
    }


}