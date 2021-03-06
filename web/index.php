<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->get('/testGet', function()
{
  return  '<h1>Hello testGet</h1>';
});


$app->get('/testPost', function()
{
  return  '<h1>Hello testPost</h1>';
});

$app->post('/testPostJsonData', function()
{
  $postData = file_get_contents('php://input');
  return  $postData;
});


$app->run();
