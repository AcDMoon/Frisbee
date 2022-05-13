<?php
use Applications\Core\Router;


//// главная страница вашсайт.рф
//Router::route('/', function(){
//    print 'Домашняя станица';
//});
//
//// маршрут будет срабатывать на адрес вашсайт.рф/blog/myrusakov/12091983
//// и подобные
//Router::route('/blog/(\w+)/(\d+)', function($category, $id){
//    print $category . ':' . $id;
//});
//
//// запускаем маршрутизатор, передавая ему запрошенный адрес
//Router::execute($_SERVER['REQUEST_URI']);






Router::route('/aboutus', function(){
    print 'перенаправление на страницу AboutUs';
});

Router::route('/support', function(){
    print 'перенаправление на страницу support';
});

Router::route('/donation', function(){
    print 'перенаправление на страницу donation';
});

