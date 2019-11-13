<?php
/**
 * Created by PhpStorm.
 * User: Liliaze
 * Date: 12/11/2019
 * Time: 14:47
 */

namespace Model;


class HttpResponse
{
    private $_code;
    private $_header;
    private $_body;
    private $_response;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse()
    {
        $this->_response['success'] = $this->_success;
        $this->_response['code'] = $this->_code;
        $this->_response['data'] = $this->_data;
        $this->_response['message'] = $this->_message;
    }
    public function setCompleteResponse($success, $code, $data, $message)
    {
        $this->_response['success'] = $success;
        $this->_response['code'] = $code;
        $this->_response['data'] = $data;
        $this->_response['message'] = $message;
    }
    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->_success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->_success = $success;
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
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->_data = $data;
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