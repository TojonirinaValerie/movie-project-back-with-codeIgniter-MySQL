<?php
class Filter 
{

    public $limit;
    public $page;
    public $title;
    public $genre;

    public function __construct($limit, $page, $title, $genre)
    {

        $this->limit = $limit;
        $this->page = $page;
        $this->title = $title;
        $this->genre = $genre;

    }

}