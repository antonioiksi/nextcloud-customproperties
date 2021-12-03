<?php
return [
	'routes' => [
		['name' => 'CustomProperties#index', 'url' => '/customproperties', 'verb' => 'GET'],
		['name' => 'CustomProperties#create', 'url' => '/customproperties', 'verb' => 'PUT'],
		['name' => 'CustomProperties#update', 'url' => '/customproperties', 'verb' => 'POST'],
		['name' => 'CustomProperties#delete', 'url' => '/customproperties/{id}', 'verb' => 'DELETE'],
		['name' => 'Page#reindexFiles', 'url' => '/customproperties/reindexFiles', 'verb' => 'GET'],
		['name' => 'Page#json', 'url' => '/customproperties/json', 'verb' => 'GET'],
		['name' => 'Page#xml', 'url' => '/customproperties/xml', 'verb' => 'GET'],
		['name' => 'Page#defaultjson', 'url' => '/customproperties/defaultjson', 'verb' => 'GET'],
		['name' => 'Terminal#exec', 'url' => '/exec', 'verb' => 'POST'],

	]
];
