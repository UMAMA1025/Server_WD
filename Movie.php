<?php
class Movie {
    public $name;
    public $isan;
    public $year;
    public $score;

    public function __construct($name, $isan, $year, $score) {
        $this->name = htmlspecialchars($name);
        $this->isan = $isan;
        $this->year = $year;
        $this->score = $score;
    }
}
