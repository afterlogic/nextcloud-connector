<?php

/** @var $this OC\Route\Router */

$this->create('afterlogic_admin', 'ajax/admin.php')
    ->actionInclude('afterlogic/ajax/admin.php');
$this->create('afterlogic_personal', 'ajax/personal.php')
    ->actionInclude('afterlogic/ajax/personal.php');

$this->create('afterlogic_index', '/')->action(
    function($params){
        require OC_App::getAppPath('afterlogic').'/index.php';
    }
);

