<?php
class Movies extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('MoviesManager');
        $this->load->model('GenresManager');
		$this->load->helper('file');
		$this->load->helper('configs');
		$this->load->helper('transform_function');
		setHeader();
    }

	// ############################### numPC1: numDisc:2 ################################
	public $movie_directory_fantastique = array(
		'name' => 'J:\Films\Fantastique\\',
		'genre' => 3,
		'numPC' => 1,
		'numDisc' => 2
	);
	public $movie_directory_comedie = array(
		'name' => 'J:\Films\Comédies\\',
		'genre' => 2,
		'numPC' => 1,
		'numDisc' => 2
	);

	// ############################### numPC2: numDisc:2 ################################
	// public $movie_directory_action = array(
	// 	'name' => 'F:\Films\Actions\\',
	// 	'genre' => 1,
	// 	'numPC' => 2,
	// 	'numDisc' => 2
	// );
	public $movie_directory_live_action = array(
		'name' => 'F:\Films\Live Action\\',
		'genre' => 1,
		'numPC' => 2,
		'numDisc' => 2
	);
	public $movie_directory_dramatique = array(
		'name' => 'F:\Films\Dramatique\\',
		'genre' => 6,
		'numPC' => 2,
		'numDisc' => 2
	);
	// public $movie_directory_romantique = array(
	// 	'name' => 'F:\Films\Romantique\\',
	// 	'genre' => 4,
	// 	'numPC' => 2,
	// 	'numDisc' => 2
	// );
	public $movie_directory_fantastique1 = array(
		'name' => 'F:\Films\Fantastique\\',
		'genre' => 3,
		'numPC' => 2,
		'numDisc' => 2
	);
	
	// ############################### numPC2: numDisc:1 ################################
	public $movie_directory_action21 = array(
		'name' => 'D:\Films\Action\\',
		'genre' => 1,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_comedy21 = array(
		'name' => 'D:\Films\Comedy\\',
		'genre' => 2,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_fantastique21 = array(
		'name' => 'D:\Films\Fantastique\\',
		'genre' => 3,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_romantique21 = array(
		'name' => 'D:\Films\Romantique\\',
		'genre' => 4,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_survivals21 = array(
		'name' => 'D:\Films\Survivals\\',
		'genre' => 5,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_dramatique21 = array(
		'name' => 'D:\Films\Dramatique\\',
		'genre' => 6,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_animation21 = array(
		'name' => 'D:\Films\Animation\\',
		'genre' => 7,
		'numPC' => 2,
		'numDisc' => 1
	);
	public $movie_directory_filmTojo = array(
		'name' => 'E:\Film\Nouveau dossier\\',
		'genre' => 7,
		'numPC' => 1,
		'numDisc' => 1
	);

	

	public function index()
	{

		echo "salut {$this->movie_directory_fantastique}";

	}

	private function add($file, $dir)
	{

		$new_movie = get_movie_info($file, $dir);

		$this->MoviesManager->add_movie($new_movie);
		$id_movie = $this->MoviesManager->get_id($new_movie);

		$this->MoviesManager->add_genre($id_movie, $dir['genre'], 1);

	}
	
	public function generate_data()
	{
		$dir = $this->movie_directory_live_action;
		$list_movies = get_all_video_in($dir['name']);
		// echo json_encode($list_movies);
		// echo '<pre>'.htmlentities(print_r($list_movies, true), ENT_SUBSTITUTE).'</pre>';		
		foreach($list_movies as $movie_path)
		{
			
			$this->add($movie_path, $dir);
			
		}
		
	}

	public function get_all_movies()
	{

		$data = $this->MoviesManager->getAllMoives();

		$rows = [];
		foreach($data as $item)
		{

			$movie = toMovie($item);
			$rows[] = $movie->toArray();

		}

		$response = new PaginationResult();
		$response->set_totalResult(sizeof($data));
		$response->set_totalPage(1);
		$response->set_page(1);
		$response->set_totalRows(sizeof($data));
		$response->set_rows($rows);
		echo json_encode($response);

	}
	
	public function get_movies()
	{
		
		$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 500 ;
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1 ;
		$title = isset($_GET['title']) ? $_GET['title'] : '' ;
		$genre = isset($_GET['genre']) ? $_GET['genre'] : 'Comédie' ;

		$listGenre = [];
		if(!empty($genre)) $listGenre = str_getcsv($genre, ';');

		$filter = new Filter($limit, $page, $title, $listGenre);

		$data = $this->MoviesManager->getMovies($filter);

		$totalResult = sizeof($data);
		$totalPage = ceil( $totalResult / $filter->limit );

		$debut = ( $page -1 ) * $limit;
		// join(";", $filter->genre);
		// redirect(base_url()."");
		$fin = $debut + $limit;
		if($fin > $totalResult) $fin = $totalResult;

		$rows = [];
		for($i=$debut; $i<$fin; $i++)
		{

			$movie = toMovie($this->MoviesManager->getMovieById($data[$i]->id));
			$listGenre = $this->get_list_genre($movie);
			$movie->set_listGenre($listGenre);
			$rows[] = $movie->toArray();

		}

		$response = new PaginationResult();
		
		$response->set_totalResult($totalResult);
		$response->set_totalPage($totalPage);
		$response->set_totalRows(sizeof($rows));
		$response->set_page($filter->page);
		$response->set_limit($filter->limit);
		$response->set_rows($rows);

		$apiResponse = new ApiResponse();
		$apiResponse->set_data($response);
		$apiResponse->set_success(true);

		echo json_encode($apiResponse);
		// echo '<pre>'.htmlentities(print_r($apiResponse, true), ENT_SUBSTITUTE).'</pre>';

	}

	private function get_list_genre($movie)
	{
		
		$data = $this->GenresManager->getMovieGenreByMovieId($movie->id);

		$listGenre = [];
		
		foreach($data as $itemGenre)
		{
			
			$genre = toGenre($this->GenresManager->getGenreById($itemGenre->id));
			$listGenre[] = $genre->toArray();

		}

		return $listGenre;

	}

	public function get_by_id($idMovie)
	{

		$movie = $this->MoviesManager->getMovieById($idMovie);

		if($movie) {

			$response = new PaginationResult();
		
			// $response->set_totalResult(1);
			// $response->set_totalPage(1);
			// $response->set_totalRows(1);
			// $response->set_page(1);
			// $response->set_limit(1);
			$response->set_rows($movie);

			$apiResponse = new ApiResponse();
			$apiResponse->set_data($response);
			$apiResponse->set_success(true);
			
			echo json_encode($apiResponse);
		}
		else{
			
			$response = new PaginationResult();

			$response->set_message('Aucun film trouvé');

			$apiResponse = new ApiResponse();
			$apiResponse->set_success(false);
			$apiResponse->set_data($response);
			
			echo json_encode($apiResponse);
			
		}
		

	}
	
	public function scan_dir()
	{
		
		$dir = $this->movie_directory_survivals21;
		$resultat = scan_dir_hierarchie($dir['name']);
		echo '<pre>'.htmlentities(print_r($resultat, true), ENT_SUBSTITUTE).'</pre>';	

	}
	
	public function test_formate_name()
	{
		
		echo 'salut';

		$dir = $this->movie_directory_animation21;
		
		$list_movies = get_all_video_in($dir['name']);
		
		foreach($list_movies as $movie_path)
		{
			
			$new_movie = get_movie_info($movie_path, $dir);
			echo '<pre>'.htmlentities(print_r($new_movie, true), ENT_SUBSTITUTE).'</pre>';
			
		}

		// echo '<pre>'.htmlentities(print_r($list_movies, true), ENT_SUBSTITUTE).'</pre>';	

	}

	public function organise_movie()
	{

		$dir = $this->movie_directory_filmTojo;
		$list_movies = get_all_video_in($dir['name']);

		foreach($list_movies as $movie_path)
		{
			
			$new_movie = get_movie_info($movie_path, $dir);

			mkdir($new_movie->srcFolder.'/'.$new_movie->title);

			$current_file = $new_movie->srcFolder.'/'.$new_movie->videoSource;
			
			$destination_file = $new_movie->srcFolder.'/'.$new_movie->title.'/'.$new_movie->videoSource;
			echo $current_file.' ---------------> '.$destination_file.'<br>';

			if(is_file($current_file) && !is_file($destination_file)){
			    rename($current_file, $destination_file);
			}
			// echo '<pre>'.htmlentities(print_r($new_movie, true), ENT_SUBSTITUTE).'</pre>';	
			
		}


		// echo '<pre>'.htmlentities(print_r($list_movies, true), ENT_SUBSTITUTE).'</pre>';	

	}

}
