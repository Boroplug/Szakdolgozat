<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Controller\Home;
use App\Controller\ProductController;
use App\Controller\FilterController;
use App\Controller\AuthController;
use App\Controller\CartController;









/*****************************************************************************/
/************* Boroplug végpontok - endpoints **********************************/
/***************************************************************************/

//A program belépési pontja
Router::get('/', function () {
    return ((new ProductController())->mainproductslist());
});


Router::get('/allproduct', function () {
    return ((new ProductController())->mainproductslist());
});
Router::get('/sizedata', function () {
    return ((new ProductController())->sizelist());
});



Router::get('/allproductadidas', function () {
    return ((new ProductController())->adidasproductslist());
});
Router::get('/allproductnike', function () {
    return ((new ProductController())->nikeproductslist());
});



Router::get('/loginAll', function () {
    return ((new ProductController())->login());
});

Router::get('/profilData', function () {
    return ((new ProductController())->profil());
});
Router::get('/ordersData', function () {
    return ((new ProductController())->userordersList());
});
Router::get('/aboutUs', function () {
    return ((new ProductController())->aboutus());
});
Router::get('/frogotten', function () {
    return ((new ProductController())->forgotten());
});
Router::get('/contact', function () {
    return ((new ProductController())->contact());
});
Router::get('/faq', function () {
    return ((new ProductController())->faq());
});

Router::get("/chechkout", function (Request $req, Response $res) {
    return (new CartController())->ChechkOutList();
});

Router::on('/openProduct/([0-9]*)', function (Request $req, Response $res) {
    (new ProductController())->openByIdAll($req);
});
/************************************* */
Router::on('/login', function (Request $req, Response $res) {
    (new AuthController())->LoginPage($req);
});

Router::on("/logout", function () {
    (new AuthController())->LogoutPage();
});

Router::on('/signup', function (Request $req, Response $res) {
    (new AuthController())->SignUpPage($req);
});

Router::get("/cart", function (Request $req, Response $res) {
    return (new CartController())->cartList();
});

Router::get("/cartclear", function (Request $req, Response $res) {
    return (new CartController())->cartClear();
});
Router::on("/cart-remove", function (Request $req, Response $res) {
	return (new CartController())->RemoveProduct($req);
});
Router::on("/cart-edit", function (Request $req, Response $res) {
	return (new CartController())->EditProduct($req);
});


// Router::on("/cartclearid", function (Request $req, Response $res) {
//     return (new CartController())->removeProductById($req);
// });





/************************************* */
Router::get('/cipoDelete/([0-9]*)', function (Request $req, Response $res) {
    (new ProductController())->deleteById($req->params[0]);
});
Router::post('/cipoDelete', function () {
    (new ProductController())->delete();
});


Router::get('/cipoEdit/([0-9]*)', function (Request $req, Response $res) {
    (new ProductController())->editById($req->params[0]);
});


Router::post('/cipoEdit', function () {
    (new ProductController())->update();
});

Router::get('/cipoAdd', function () {
    (new ProductController())->add();
});


Router::post('/cipoAdd', function () {
    (new ProductController())->save();
});
//--------------------------------------------------Edit






Router::post('/adressEdit', function () {
    (new ProductController())->updateAdress();
});

Router::get('/openDelete', function () {
    (new ProductController())->openDelete();
});
Router::post('/profilDelete', function () {
    (new ProductController())->profilDelete();
});










//--------------------------------------------------Edit



Router::get('/alluserlist', function () {
    return ((new ProductController())->adminalluserlist());
});

Router::get('/orderlist', function () {
    return ((new ProductController())->orderlist());
});

Router::get('/orderEdit/([0-9]*)', function (Request $req, Response $res) {
    (new ProductController())->ordergetbyid($req->params[0]);
});


Router::post('/orderEdit', function () {
    (new ProductController())->orderupdate();
});



Router::get('/diagrams', function () {
    return ((new ProductController())->diagrams());
});


Router::get('/userDelete/([0-9]*)', function (Request $req, Response $res) {
    (new ProductController())->DeleteUserById($req->params[0]);
});
Router::post('/userDelete', function () {
    (new ProductController())->userDelete();
});




Router::post('/addnewuser', function () {
    (new ProductController())->save();
});
Router::get('/adminlist', function () {
    return ((new ProductController())->productlistadmin());
});
Router::on('/register', function (Request $req, Response $res) {
    (new AuthController())->SignUpPage($req);
});


Router::post('/megrendelesleadas', function () {
    (new ProductController())->megrendelesleadas();
});


Router::on('/adminregister', function (Request $req, Response $res) {
    (new AuthController())->AdminSignUpPage($req);
});
