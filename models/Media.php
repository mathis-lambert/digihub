<?php

class Media
{
    public $id;
    public $titre;
    public $annee;
    public $synopsis;
    public $affiche;
    public $background;
    public $trailer;
    public $date_sortie;
    public $authors;
    public $actors;
    public $genres;
    public $type;

    public function __construct($id, $titre, $annee, $synopsis, $affiche, $background, $trailer, $date_sortie, $authors, $actors, $genres, $type)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->annee = $annee;
        $this->synopsis = $synopsis;
        $this->affiche = $affiche;
        $this->background = $background;
        $this->trailer = $trailer;
        $this->date_sortie = $date_sortie;
        $this->authors = $authors;
        $this->actors = $actors;
        $this->genres = $genres;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }
}
