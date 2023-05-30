<?php
class ApiResponse 
{

    public $succes;
    public $data;

    public function __construct()
    {
    }

    public function set_success($value)
    {

        $this->succes = $value;

    }

    public function set_data($data)
    {
        
        $this->data = $data;

    }

}