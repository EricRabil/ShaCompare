<?php

/*
 * After this require, all Steel classes, instances, objects are loaded. Steel has not been run yet.
 */
require '../classes/Steel/Steel.php';

$steel = new Steel\Steel;

$steel->map(new \Steel\MVC\MVCIdentifier('MVC-INDEX', 'index', 'IndexModel', 'IndexView', 'IndexController', [], []));

$steel->config['sha-compare']['directory-one'] = __DIR__.'/../comparison/original/';
$steel->config['sha-compare']['directory-two'] = __DIR__.'/../comparison/tampered/';

$steel->init();
