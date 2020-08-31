<?php

class View {
    public function render($viewPath) {
        $this->view = $viewPath;
        require_once('Views/' . $viewPath . '.php');
    }
}