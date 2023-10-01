<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('music/upload', 'Music::upload');
// $routes->post('music/upload', 'Music::store');
$routes->get('/', 'Playlist::index');
$routes->get('/viewplaylists/(:num)', 'Playlist::viewplays/$1');
$routes->post('playlist/create', 'Playlist::create');
$routes->post('/Playlist/uploadaudio', 'Playlist::uploadaudio');
// $routes->get('ann', 'Playlist::playTrack');
$routes->post('Playlist/addtoplaylist', 'Playlist::addtoplaylist');
$routes->post('Playlist/deletethis', 'Playlist::deletethis');
$routes->post('Playlist/deletethistoo', 'Playlist::deletethistoo');

$routes->get('Playlist/play/(:num)', 'Playlist::play/$1');


// $routes->delete('playlist/delete/(:num)', 'Playlist::delete/$1');
// $routes->post('playlist/track/add', 'PlaylistTrack::addTrack');
// $routes->delete('playlist/track/remove', 'PlaylistTrack::removeTrack');

