<?php
class GenresManager extends CI_Model
{

    private $tableGenre = 'genres';
    public $table = 'movies';
    public $tableRelation = 'relation_movies_genres';

    public $designation;

    public function set($designation)
    {

        $this->designation = $designation;

    }

    public function add_genre($genre)
    {

        return $this->db->set('designation', $genre->designation)->insert($this->tableGenre);

    }
    
    public function getGenreById($id)
    {
        
        $result = $this->db->select('*')
                        ->from($this->tableGenre)
                        ->where('id', (int) $id)
                        ->get()
                        ->result();

        if(sizeof($result)!=1) return false;
        
        return $result[0];
        
    }

    public function getMovieGenreByMovieId($id)
    {

        return $this->db->select("{$this->tableGenre}.id")
            ->from($this->tableGenre)
            ->join($this->tableRelation, "{$this->tableRelation}.idGenre = {$this->tableGenre}.id", "center")
            ->where("{$this->tableRelation}.idMovie = {$id}")
            ->get()
            ->result();

    }

}