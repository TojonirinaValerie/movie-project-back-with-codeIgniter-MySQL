<?php
require_once('getid3/getid3.php');

function get_all_video_in($dir)
{

    $tab = [];

    $result = scandir($dir);

    foreach($result as $item){

        if(is_dir($dir.$item) && $item!='.' && $item!='..'){

            $tmp_dir = $dir.$item.'\\';
            $values = get_all_video_in($tmp_dir);

            foreach($values as $value){

                $tab[] = $value;

            }

        }
        else{

            if($item!='.' && $item!='..'){

                $getID3 = new getID3;
                $ThisFileInfo = $getID3->analyze($dir.$item);

                if(isset($ThisFileInfo['mimeType'])){

                    $test = preg_match('#^video#', $ThisFileInfo['mimeType']);
                    
                    if($test){

                        $tab[] = $ThisFileInfo['filenamepath'];

                    } 

                }

                $getID3 = null;
                
            }
        }

    }

    return $tab;

}

function get_movie_info($file, $dir)
{

    $srcFolder = ''; //
    $videoSource = ''; //
    $imageSource = ''; //
    $title = ''; //
    $sinopsys = ''; //
    $formatFile = ''; //
    $mimeType = ''; //
    $fileSize = ''; //
    $playtimeString = ''; //
    $dateRelease = ''; //-------------

    $getID3 = new getID3;
    $movie_info = $getID3->analyze($file);
    
		// echo '<pre>'.htmlentities(print_r($movie_info, true), ENT_SUBSTITUTE).'</pre>';	
    $srcFolder = $movie_info['filepath'];
    $videoSource = $movie_info['filename'];
    $title = formate_movie_name($movie_info['filename']);
    $formatFile = $movie_info['fileformat'];
    $mimeType = $movie_info['mimeType'];
    $fileSize = $movie_info['filesize'];
    $playtimeString = isset($movie_info['playtimeString']) ? $movie_info['playtimeString'] : '';

    $srcFolder = $movie_info['filepath'];

    $res = scandir($srcFolder);

    // if(sizeof($res)>2){
    //     foreach($res as $item){
    //         if($item!='.' && $item!='..' && $item!=$movie_info['filename']){
                
    //             $item_info = $getID3->analyze($srcFolder.'\\'.$item);
    //             if(isset($item_info['fileformat'])){
    //                 $imageSource = $item;
    //             }
    //             else {
    //                 $sinopsys = file_get_contents($srcFolder.'\\'.$item);
    //             }
    //         }
    //     }
    // }

    // ovaovaina
    // $srcFolder = substr($srcFolder, 9);

    $film_info = new Movie();
    $film_info->set($srcFolder, $videoSource, $imageSource, $title, $sinopsys, $formatFile, $mimeType, $fileSize, $playtimeString, $dateRelease, $dir['numPC'], $dir{'numDisc'});

    return $film_info;

}

function scan_dir_hierarchie($dir)
{

    $tab = [];

    $result = scandir($dir);

    foreach($result as $item){

        if($item!='.' && $item!='..'){

            if(is_dir($dir.$item)){
    
                $tmp_dir = $dir.$item.'\\';
                $values = scan_dir_hierarchie($tmp_dir);
                $tab[] = $values;
    
            }
            else{
    
                $tab[] = $item;
                
            }

        }

    }

    return $tab;

}

function formate_movie_name($file_name)
{

    $res = $file_name;
    $regex = '#^N° [0-9]{3} - [0-9]{4} Dreamworks-(.+)$#i';
    $res = preg_replace($regex, '$1', $res);
    
    $tab = str_getcsv($res, '] ');

    if(sizeof($tab)>1){
        $tmp = $tab[1];
    } else {
        $tmp = $tab[0];
    }

    $tab = str_getcsv($tmp, '.');

    $title ='';
    for($i=0; $i<sizeof($tab)-1; $i++){

        if($i==sizeof($tab)-2){
            $title.= $tab[$i];
            continue;
        } else {
            $title.= $tab[$i].' ';
        }
        
    }

    $separator = ['TRUEFRENCH', 'FRENCH', 'MULTi', 'DSNP', 'LIMITED'];

    foreach($separator as $sep){
        $regex = '#^(.+)'.$sep.'(.+)$#i';
        $title = preg_replace($regex, '$1', $title);
    }

    return trim($title);

}
