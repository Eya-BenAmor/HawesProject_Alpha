<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format'], ['variable', '/', '\\d+', 'code'], ['text', '/_error']], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token'], ['text', '/_wdt']], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    'commentaire' => [[], ['_controller' => 'App\\Controller\\CommentaireController::index'], [], [['text', '/commentaire']], [], []],
    'listcom' => [['id'], ['_controller' => 'App\\Controller\\CommentaireController::listcom'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/listcom']], [], []],
    'addcom' => [['id'], ['_controller' => 'App\\Controller\\CommentaireController::add'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/addcom']], [], []],
    'updatecom' => [['id'], ['_controller' => 'App\\Controller\\CommentaireController::update'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/updatecom']], [], []],
    'deletecom' => [['id'], ['_controller' => 'App\\Controller\\CommentaireController::deletepub'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/deletecom']], [], []],
    'publication' => [[], ['_controller' => 'App\\Controller\\PublicationController::index'], [], [['text', '/publication']], [], []],
    'pdfPublication' => [[], ['_controller' => 'App\\Controller\\PublicationController::pdfPublication'], [], [['text', '/pdfPublication']], [], []],
    'acceuil' => [[], ['_controller' => 'App\\Controller\\PublicationController::indexFront'], [], [['text', '/acceuil']], [], []],
    'listpubfront' => [[], ['_controller' => 'App\\Controller\\PublicationController::listpubfront'], [], [['text', '/listpubfront']], [], []],
    'listpub' => [[], ['_controller' => 'App\\Controller\\PublicationController::list'], [], [['text', '/listpub']], [], []],
    'addpub' => [[], ['_controller' => 'App\\Controller\\PublicationController::add'], [], [['text', '/addpub']], [], []],
    'updatepub' => [['id'], ['_controller' => 'App\\Controller\\PublicationController::update'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/updatepub']], [], []],
    'deletepub' => [['id'], ['_controller' => 'App\\Controller\\PublicationController::deletepub'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/deletepub']], [], []],
    'listpubb' => [['id'], ['_controller' => 'App\\Controller\\PublicationController::listpubb'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/listpubb']], [], []],
    'ajax_search' => [[], ['_controller' => 'App\\Controller\\PublicationController::searchAction'], [], [['text', '/search']], [], []],
    'listpubjson' => [[], ['_controller' => 'App\\Controller\\PublicationController::listjson'], [], [['text', '/listpubjson']], [], []],
    'addpubjson' => [[], ['_controller' => 'App\\Controller\\PublicationController::addpubjson'], [], [['text', '/addpubjson']], [], []],
    'updatepubjson' => [['id'], ['_controller' => 'App\\Controller\\PublicationController::updatepubjson'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/updatepubjson']], [], []],
    'deletepubjson' => [['id'], ['_controller' => 'App\\Controller\\PublicationController::deletepubjson'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/deletepubjson']], [], []],
];
