<?php

namespace cmsWRT\Domain;

class Article 
{
    /**
     * Article id.
     *
     * @var integer
     */
    private $id;

    /**
     * Article titre.
     *
     * @var string
     */
    private $titre;

    /**
     * Article contenu.
     *
     * @var string
     */
    private $contenu;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function setcontenu($contenu) {
        $this->contenu = $contenu;
        return $this;
    }
}