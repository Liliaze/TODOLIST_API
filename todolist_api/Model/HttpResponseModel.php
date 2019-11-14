<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:47
 */

class HttpResponseModel
{
    private $_code;
    private $_header;
    private $_message;
    private $_HttpResponse;

    /**
     * @return mixed
     */
    public function getHttpResponse()
    {
        $this->setHttpResponse();
        return $this->_HttpResponse;
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

    public function setParams($code, $header, $message)
    {
        $this->_header = $header;
        $this->_code = $code;
        $this->_message = $message;
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