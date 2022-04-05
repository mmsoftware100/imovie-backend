<?php

/**
 *
 */
class Form
{
    private $_postData = [];
    private $_fileData = [];

    private $_currentData = null;
    private $_currentfileData = null;

    private $_val = [];


    private $_error = [];

    public function __construct()
    {
        $this->_val = new Validate();
    }

    public function post($field)
    {
        $this->_postData[$field] = $_POST[$field];
        $this->_currentData      = $field;
        return $this;
    }

    public function file($field)
    {
        $this->_fileData[$field] = $_FILES[$field];
        $this->_currentfileData      = $field;
        return $this;
    }

    public function fetch($field = null)
    {
        if ($field != null) {
            if (isset($this->_postData[$field])) {
                return $this->_postData[$field];
            } else {
                return false;
            }
        } else {
            return $this->_postData;
        }

    }

    public function fetchfile($field = null)
    {
        if ($field != null) {
            if (isset($this->_fileData[$field])) {
                return $this->_fileData[$field];
            } else {
                return false;
            }
        } else {
            return $this->_fileData;
        }

    }

    public function val($typeofval, $arg = null)
    {
        if ($arg == null) {
            $check = $this->_val->{$typeofval}($this->_postData[$this->_currentData]);
        } else {
            $check = $this->_val->{$typeofval}($this->_postData[$this->_currentData], $arg);
        }

        if ($check) {
            $this->_error[$this->_currentData] = $check;
        }

        return $this;
    }



    public function filter($typeofval, $arg = null)
    {
        $filterData = $this->_postData[$this->_currentData];
        if ($arg == null) {
            $this->_postData[$this->_currentData] = $this->_val->{$typeofval}($filterData);
        } else {
            $this->_postData[$this->_currentData] = $this->_val->{$typeofval}($filterData, $arg);
        }

        return $this;
    }


    public function fileval($typeofval, $arg = null)
    {
        if ($arg == null) {
            $check = $this->_val->{$typeofval}($this->_fileData[$this->_currentfileData]);
        } else {
            $check = $this->_val->{$typeofval}($this->_fileData[$this->_currentfileData], $arg);
        }

        if ($check) {
            $this->_error[$this->_currentfileData] = $check;
        }

        return $this;
    }

    public function submit()
    {
        if (empty($this->_error)) {
            return true;
        } else {
            return $this->_error;
        }
    }

}


