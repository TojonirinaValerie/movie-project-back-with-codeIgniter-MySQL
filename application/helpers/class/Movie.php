<?php
class Movie 
{
    
    public $id;
    public $srcFolder;
    public $videoSource;
    public $imageSource;
    public $title;
    public $sinopsys;
    public $formatFile;
    public $mimeType;
    public $fileSize;
    public $playtimeString;
    public $dateRelease;
    public $listGenre = [];
	public $numPC;
	public $numDisc;

    public function __construct()
    {
        
    }

	public function set($srcFolder, $videoSource, $imageSource, $title, $sinopsys, $formatFile, $mimeType, $fileSize, $playtimeString, $dateRelease, $numPC, $numDisc)
	{
        $this->srcFolder = $srcFolder;
        $this->videoSource = $videoSource;
        $this->imageSource = $imageSource;
        $this->title = $title;
        $this->sinopsys = $sinopsys;
        $this->formatFile = $formatFile;
        $this->mimeType = $mimeType;
        $this->fileSize = $fileSize;
        $this->playtimeString = $playtimeString;
        $this->dateRelease = $dateRelease;
        $this->numPC = $numPC;
        $this->numDisc = $numDisc;
		
	}

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_srcFolder($srcFolder)
    {
        $this->srcFolder = $srcFolder;
    }

    public function set_videoSource($videoSource)
    {
        $this->videoSource = $videoSource;
    }

    public function set_imageSource($imageSource)
    {
        $this->imageSource = $imageSource;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_sinopsys($sinopsys)
    {
        $this->sinopsys = $sinopsys;
    }

    public function set_formatFile($formatFile)
    {
        $this->formatFile = $formatFile;
    }

    public function set_mimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function set_fileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    public function set_playtimeString($playtimeString)
    {
        $this->playtimeString = $playtimeString;
    }

    public function set_dateRelease($dateRelease)
    {
        $this->dateRelease = $dateRelease;
    }

    public function set_numPC($numPC)
    {
        $this->numPC = $numPC;
    }

    public function set_numDisc($numDisc)
    {
        $this->numDisc = $numDisc;
    }

    public function set_listGenre($listGenre)
    {
        $this->listGenre = $listGenre;
    }

    public function add_genre($idGenre)
    {
        $this->listGenre[] = $idGenre;
    }

    public function toArray()
    {

        return array(
            'id'=> $this->id,
            'srcFolder' => $this->srcFolder,
            'videoSource' => $this->videoSource,
            'imageSource' => $this->imageSource,
            'title' => $this->title,
            'sinopsys' => $this->sinopsys,
            'formatFile' => $this->formatFile,
            'mimeType' => $this->mimeType,
            'fileSize' => $this->fileSize,
            'playtimeString' => $this->playtimeString,
            'dateRelease' => $this->dateRelease,
            'listGenre' => $this->listGenre,
			'numPC' => $this->numPC,
			'numDisc' => $this->numDisc
        );

    }

}
