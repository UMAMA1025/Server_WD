<?php
require_once 'Movie.php';

// Manages a list of movies
class MovieManager {
    public $movies = array();

    public function __construct($movies = array()) {
        $this->movies = $movies;
    }

    public function addMovie($movie) {
        // Update if exists
        for ($i = 0; $i < count($this->movies); $i++) {
            if ($this->movies[$i]->isan == $movie->isan) {
                $this->movies[$i] = $movie;
                return;
            }
        }
        $this->movies[] = $movie;
    }

    public function deleteMovie($isan) {
        for ($i = 0; $i < count($this->movies); $i++) {
            if ($this->movies[$i]->isan == $isan) {
                unset($this->movies[$i]);
                $this->movies = array_values($this->movies);
                return;
            }
        }
    }

    public function searchByName($name) {
        $result = array();
        for ($i = 0; $i < count($this->movies); $i++) {
            if (stripos($this->movies[$i]->name, $name) !== false) {
                $result[] = $this->movies[$i];
            }
        }
        return $result;
    }

    public function exists($isan) {
        for ($i = 0; $i < count($this->movies); $i++) {
            if ($this->movies[$i]->isan == $isan) {
                return true;
            }
        }
        return false;
    }
}
