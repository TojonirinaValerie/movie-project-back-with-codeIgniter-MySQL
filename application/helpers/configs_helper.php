<?php
require('class/Genre.php');
require('class/Movie.php');
require('class/PaginationResult.php');
require('class/Filter.php');
require 'class/ApiResponse.php';
function setHeader()
{
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
    header("Access-Control-Allow-Headers: Origin, X-Requested-Width, Content-Type, Accept");
    header("Content-Type: application/json; charset=UTF-8");

}