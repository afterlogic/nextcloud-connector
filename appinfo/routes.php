<?php

return [
    'routes' => [
	['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
	['name' => 'ajax#setPersonal', 'url' => '/ajax/personal.php', 'verb' => 'POST'],
	['name' => 'ajax#setAdmin', 'url' => '/ajax/admin.php', 'verb' => 'POST'],
    ]
];
