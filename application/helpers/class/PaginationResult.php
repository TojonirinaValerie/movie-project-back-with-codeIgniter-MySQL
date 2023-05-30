<?php
class PaginationResult
{
    public $totalResult;
    public $totalPage;
    public $page;
    public $limit;
    public $totalRows;
    public $rows;
    public $message;

    public function __construct()
    {
        
    }

    public function set_totalResult($totalResult)
    {
        $this->totalResult = $totalResult;
    }

    public function set_totalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    public function set_page($page)
    {
        $this->page = $page;
    }

    public function set_limit($limit)
    {
        $this->limit = $limit;
    }

    public function set_totalRows($totalRows)
    {
        $this->totalRows = $totalRows;
    }

    public function set_rows($rows)
    {
        $this->rows = $rows;
    }

    public function set_message($message)
    {
        $this->message = $message;
    }

    public function addRows($row){
        $this->rows[] = $row;
    }

}