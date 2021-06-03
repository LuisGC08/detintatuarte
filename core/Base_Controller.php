<?php

abstract class Base_Controller {
    protected $view;

    function __construct() {
        $this->view = new View();
    }
}
