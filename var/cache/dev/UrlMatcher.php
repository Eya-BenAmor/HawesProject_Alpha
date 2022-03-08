<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/commentaire' => [[['_route' => 'commentaire', '_controller' => 'App\\Controller\\CommentaireController::index'], null, null, null, false, false, null]],
        '/publication' => [[['_route' => 'publication', '_controller' => 'App\\Controller\\PublicationController::index'], null, null, null, false, false, null]],
        '/pdfPublication' => [[['_route' => 'pdfPublication', '_controller' => 'App\\Controller\\PublicationController::pdfPublication'], null, null, null, false, false, null]],
        '/acceuil' => [[['_route' => 'acceuil', '_controller' => 'App\\Controller\\PublicationController::indexFront'], null, null, null, false, false, null]],
        '/listpubfront' => [[['_route' => 'listpubfront', '_controller' => 'App\\Controller\\PublicationController::listpubfront'], null, null, null, false, false, null]],
        '/listpub' => [[['_route' => 'listpub', '_controller' => 'App\\Controller\\PublicationController::list'], null, null, null, false, false, null]],
        '/addpub' => [[['_route' => 'addpub', '_controller' => 'App\\Controller\\PublicationController::add'], null, null, null, false, false, null]],
        '/search' => [[['_route' => 'ajax_search', '_controller' => 'App\\Controller\\PublicationController::searchAction'], null, null, null, false, false, null]],
        '/listpubjson' => [[['_route' => 'listpubjson', '_controller' => 'App\\Controller\\PublicationController::listjson'], null, null, null, false, false, null]],
        '/addpubjson' => [[['_route' => 'addpubjson', '_controller' => 'App\\Controller\\PublicationController::addpubjson'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/list(?'
                    .'|com/([^/]++)(*:189)'
                    .'|pubb/([^/]++)(*:210)'
                .')'
                .'|/addcom/([^/]++)(*:235)'
                .'|/update(?'
                    .'|com/([^/]++)(*:265)'
                    .'|pub(?'
                        .'|/([^/]++)(*:288)'
                        .'|json/([^/]++)(*:309)'
                    .')'
                .')'
                .'|/delete(?'
                    .'|com/([^/]++)(*:341)'
                    .'|pub(?'
                        .'|/([^/]++)(*:364)'
                        .'|json/([^/]++)(*:385)'
                    .')'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        189 => [[['_route' => 'listcom', '_controller' => 'App\\Controller\\CommentaireController::listcom'], ['id'], null, null, false, true, null]],
        210 => [[['_route' => 'listpubb', '_controller' => 'App\\Controller\\PublicationController::listpubb'], ['id'], null, null, false, true, null]],
        235 => [[['_route' => 'addcom', '_controller' => 'App\\Controller\\CommentaireController::add'], ['id'], null, null, false, true, null]],
        265 => [[['_route' => 'updatecom', '_controller' => 'App\\Controller\\CommentaireController::update'], ['id'], null, null, false, true, null]],
        288 => [[['_route' => 'updatepub', '_controller' => 'App\\Controller\\PublicationController::update'], ['id'], null, null, false, true, null]],
        309 => [[['_route' => 'updatepubjson', '_controller' => 'App\\Controller\\PublicationController::updatepubjson'], ['id'], null, null, false, true, null]],
        341 => [[['_route' => 'deletecom', '_controller' => 'App\\Controller\\CommentaireController::deletepub'], ['id'], null, null, false, true, null]],
        364 => [[['_route' => 'deletepub', '_controller' => 'App\\Controller\\PublicationController::deletepub'], ['id'], null, null, false, true, null]],
        385 => [
            [['_route' => 'deletepubjson', '_controller' => 'App\\Controller\\PublicationController::deletepubjson'], ['id'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
