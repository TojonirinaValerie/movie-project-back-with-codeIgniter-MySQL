<?php
class Genre{

    public $id;
    public $designation;
    public $genrePrincipale;

    public function __construct($id, $designation)
    {

        $this->id = $id;
        $this->designation = $designation;
        // $this->genrePrincipale = $genrePrincipale;
        
    }

    public function toArray()
    {

        return array(
            'id'=> $this->id,
            'designation' => $this->designation
            // 'genrePrincipal' => $this->genrePrincipale
        );

    }
    
}