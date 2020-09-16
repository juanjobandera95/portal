<?php

$router->addGet("", "MainController", 'index');
$router->addPost("", "MainController", 'index');


$router->addGet("notFound", "ErrorController", 'notFound');

/*rutas News El get para que me muestre la pagina y el metodo POST para que pueda filtrar y hacer la accion de los forms de
filtraje
*/
$router->addGet("news", "NewsController", 'news');
$router->addPost("news", "NewsController", 'news');

/*
 * Para que me muestre solo la noticia/:id
 */
$router->addGet("news/show/:id", "NewsController", "show", ["id" => "number"]);


//rutas Category

/*
 *
 * El get para que me muestre la pagina y el metodo POST para que pueda filtrar y hacer la accion de los forms de
filtraje

//GET para que muestren los elementos/formularios y el filtraje
//POST para crear, actualizar y eliminar elementos
  *
 */
$router->addPost("admin/category/insert", "CategoryController", "createCategory", [], "ROLE_USER");
$router->addGet("admin/category/insert", "CategoryController", "createCategory", [], "ROLE_USER");

$router->addGet("admin/categories", "CategoryController", "categoriesAdmin", [], "ROLE_USER");
//con parametros /admin/category/delete/:id
$router->addGet("admin/category/delete/:id", "CategoryController", "deleteCategory", ["id" => "number"], "ROLE_ADMIN");
$router->addGet("admin/category/edit/:id", "CategoryController", "editCategory", ["id" => "number"], "ROLE_USER");

$router->addPost("admin/category/delete/:id", "CategoryController", "deleteCategory", ["id" => "number"], "ROLE_ADMIN");

$router->addPost("admin/category/edit/:id", "CategoryController", "editCategory", ["id" => "number"], "ROLE_USER");

//rutas Admin
$router->addPost("admin/news/insert", "AdminController", "create", [], "ROLE_USER");
$router->addPost("admin/news", "AdminController", "newsAdmin", [], "ROLE_USER");
$router->addGet("admin/news", "AdminController", "newsAdmin", [], "ROLE_USER");
$router->addGet("admin/news/insert", "AdminController", "create", [], "ROLE_USER");
//con parametros /admin/news/edit/:id
$router->addGet("admin/news/edit/:id", "AdminController", "edit", ["id" => "number"], "ROLE_USER");
$router->addPost("admin/news/edit/:id", "AdminController", "edit", ["id" => "number"], "ROLE_USER");
$router->addGet("admin/news/delete/:id", "AdminController", "delete", ["id" => "number"], "ROLE_ADMIN");
$router->addGet("admin/news/show/:id", "AdminController", "show", ["id" => "number"], "ROLE_USER");
$router->addPost("admin/news/delete/:id", "AdminController", "delete", ["id" => "number"], "ROLE_ADMIN");
$router->addPost("admin/news/show/:id", "AdminController", "show", ["id" => "number"], "ROLE_USER");

//rutas User

$router->addGet("admin/users", "UserController", "userAdmin", [], "ROLE_USER");
$router->addGet("admin/user/insert", "UserController", "createUser", [], "ROLE_ADMIN");
$router->addPost("admin/user/insert", "UserController", "createUser", [], "ROLE_ADMIN");
$router->addGet("admin/user/edit/:id", "UserController", "editUser", ["id" => "number"], "ROLE_ADMIN");
$router->addPost("admin/user/edit/:id", "UserController", "editUser", ["id" => "number"], "ROLE_ADMIN");
$router->addGet("admin/user/delete/:id", "UserController", "deleteUser", ["id" => "number"], "ROLE_ADMIN");
$router->addPost("admin/user/delete/:id", "UserController", "deleteUser", ["id" => "number"], "ROLE_ADMIN");
$router->addGet("admin/user/show/:id", "UserController", "showUser", ["id" => "number"], "ROLE_USER");

//rutas auth
$router->addGet("login", "AuthController", "login");
$router->addGet("logout", "AuthController", "logout");
$router->addPost("login", "AuthController", "checkLogin");

//rutas registered
$router->addGet("registered", "RegisteredController", "registered");
$router->addPost("registered", "RegisteredController", "checkRegistered");

//perfil - cambios
$router->addGet("profile/:id", "UserController", "profileUser", ["id" => "number"], "ROLE_USER");
$router->addGet("profile/changed/:id", "UserController", "changeProfile", ["id" => "number"], "ROLE_USER");
$router->addPost("profile/changed/:id", "UserController", "changeProfile", ["id" => "number"], "ROLE_USER");

