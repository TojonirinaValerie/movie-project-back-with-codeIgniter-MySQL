<?php

// echo '<pre>'.htmlentities(print_r($movie->to_array(), true), ENT_SUBSTITUTE).'</pre>';
function toMovie($resultDBMmovie)
{
    
    $movie = new Movie();
    $movie->set_id($resultDBMmovie->id);
    $movie->set_srcFolder($resultDBMmovie->srcFolder);
    $movie->set_videoSource($resultDBMmovie->videoSource);
    $movie->set_imageSource($resultDBMmovie->imageSource);
    $movie->set_title($resultDBMmovie->title);
    $movie->set_sinopsys($resultDBMmovie->sinopsys);
    $movie->set_formatFile($resultDBMmovie->formatFile);
    $movie->set_mimeType($resultDBMmovie->mimeType);
    $movie->set_fileSize($resultDBMmovie->fileSize);
    $movie->set_playtimeString($resultDBMmovie->playtimeString);
    $movie->set_dateRelease($resultDBMmovie->dateRelease);
	$movie->set_numPC($resultDBMmovie->numPC);
	$movie->set_numDisc($resultDBMmovie->numDisc);
    if(isset($resultDBMmovie->listGenre)) $movie->set_listGenre($resultDBMmovie->listGenre);

    return $movie;

}

function toGenre($resultDBGenre)
{
    
    $genre = new Genre($resultDBGenre->id, $resultDBGenre->designation);

    return $genre;

}
