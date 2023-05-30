<?php
class MoviesManager extends CI_Model
{
    public $tableMovies = 'movies';
    public $tableRelation = 'relation_movies_genres';
    public $tableGenres = 'genres';

    public function set($srcFolder, $videoSource, $imageSource, $title, $sinopsys, $formatFile, $mimeType, $fileSize, $playtimeString, $dateRelease)
    {

        $this->srcFolder = $srcFolder;
        $this->videoSource = $videoSource;
        $this->imageSource =$imageSource;
        $this->title = $title;
        $this->sinopsys = $sinopsys;
        $this->formatFile = $formatFile;
        $this->mimeType = $mimeType;
        $this->fileSize = $fileSize;
        $this->playtimeString = $playtimeString;
        $this->dateRelease = $dateRelease;

    }

    

    /**
     * ajouter une ligne dans la base de donnees
     */
    public function add_movie($movie)
    {

        return $this->db->set('srcFolder', $movie->srcFolder)
                        ->set('videoSource', $movie->videoSource)
                        ->set('imageSource', $movie->imageSource)
                        ->set('title', $movie->title)
                        ->set('sinopsys', $movie->sinopsys)
                        ->set('formatFile', $movie->formatFile)
                        ->set('mimeType', $movie->mimeType)
                        ->set('fileSize', $movie->fileSize)
                        ->set('playtimeString', $movie->playtimeString)
                        ->set('dateRelease', $movie->dateRelease)
                        ->set('numPC', $movie->numPC)
                        ->set('numDisc', $movie->numDisc)
                        ->insert($this->tableMovies);

    }


    /**
     * recuperer l'id d'un film
     */
    public function get_id($movie)
	{
        
		$result = $this->db->select('id')
				->from($this->tableMovies)
                ->where(array('srcFolder' => $movie->srcFolder))
                ->get()
                ->result();

        if(sizeof($result)!=1){
            return false;
        }
		
        return $result[0]->id;

	}

    /**
     * recupere un film par l'id
     */
    public function getMovieById($id)
    {
        
        $result = $this->db->select('*')
                        ->from($this->tableMovies)
                        ->where('id', (int) $id)
                        ->get()
                        ->result();

        if(sizeof($result)!=1) return false;
        
        return $result[0];

    }

    /**
     * ajouter un genre a un film
     */
    public function add_genre($id_movie, $id_genre, $is_genre_principale)
    {

        $this->db->set('idMovie', $id_movie)
                ->set('idGenre', $id_genre);

        if($is_genre_principale) $this->db->set('genrePrincipale', 1);
        else $this->db->set('genrePrincipale', 0);

        $this->db->insert($this->tableRelation);

    }

    /**
     * recuperer tout les films
     */
    public function getAllMoives()
    {
        return $this->db->select('*')
            ->from($this->tableMovies)
            ->order_by('title', 'ASC')
            ->get()
            ->result();
    }

    public function getMovies($filter)
    {
        
        $this->db->select("{$this->tableMovies}.id")
            ->from($this->tableMovies)
            ->distinct()
            ->join($this->tableRelation, "{$this->tableRelation}.idMovie = {$this->tableMovies}.id", "left")
            ->join($this->tableGenres, "{$this->tableGenres}.id = {$this->tableRelation}.idGenre")
            ->order_by('title', 'ASC');

        if(!empty($filter->title)) 
        {

            $this->db->where("{$this->tableMovies}.title LIKE '%{$filter->title}%'");

        }

        if(sizeof($filter->genre)>0)
        {

            $where = '';

            for($i = 0; $i<sizeof($filter->genre); $i++)
            {

                if($i>=1) $where .= " OR ";
                $where .= "{$this->tableGenres}.designation = '{$filter->genre[$i]}'";

            }

            if(!empty($where))
            {

                $where = "( {$where} )";
                $this->db->where($where);
                
            }

        }

        return $this->db->get()->result();

    }
}
