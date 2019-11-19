<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:47
 */

class HttpResponseModel
{
    private $_code = 0;
    private $_header = "";
    private $_message = null;
    private $_HttpResponse = null;

    public function __construct($code, $header, $message)
    {
        $this->_header = $header;
        $this->_code = $code;
        $this->_message = $message;
    }

    /**
     * @param mixed $HttpResponse
     */
    private function setHttpResponse()
    {
        $this->_HttpResponse['code'] = $this->_code;
        $this->_HttpResponse['header'] = $this->_header;
        $this->_HttpResponse['message'] = $this->_message;
    }
    /**
     * @return mixed
     */
    public function getHttpResponse()
    {
        $this->setHttpResponse();
        return $this->_HttpResponse;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->_code = $code;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->_header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->_header = $header;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->_message = $message;
    }


}