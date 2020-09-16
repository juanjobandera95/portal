<?php


use App\Core\App;
use App\Core\Controller;
use App\Model\CategoryModel;
use App\Model\NewsModel;
use App\Model\UserModel;

class MainController extends Controller
{
    public function index()
    {
        $newsModel = App::getModel(NewsModel::class);
        $categoryModel = App::getModel(CategoryModel::class);
        $userModel = App::getModel(UserModel::class);

        //elemento search para poder hacer la consulta del buscador
        $text = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
        $id = -200;//cogemos la id para que nos muestre todas las noticias por categoria

        //cogemos la fecha de inicio y la fecha de finalizacion para hacer la consulta
        $date1 = filter_input(INPUT_GET, 'date1', FILTER_SANITIZE_STRING);
        $date2 = filter_input(INPUT_GET, 'date2', FILTER_SANITIZE_STRING);

        //el id de la categoria para mostrar la noticias por categoria
        $categoryid = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT);

        //las categorias a mostrar
        $categories = $categoryModel->findAll();
        //los usuarios-autores de las noticias
        $users = $userModel->findAll();

        //elementos de paginar
        $currentPage = (int)(filter_input(INPUT_GET, 'page') ?? 1);
        //total de paginas a paginar
        $totalPages = 0;

        if (!empty($text)) {
            //url de filtraje de busqueda mientras se pagina
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "search?=$text&";
            $header = "Resultados de la busqueda($text)";
            //array de noticias por busqueda(coge como parametro el texto a buscar, la pagina actual y el total de paginas de la paginacion)
            $news = $newsModel->getByTextPaginated($text, $currentPage, $totalPages);
            return $this->getResponse()->renderView('index', 'default', compact('newsModel', 'categoryModel', 'userModel', 'users', 'categories', 'text', 'news', 'categoryid', 'totalPages', 'currentPage', 'url', 'header'));
        } elseif (!empty($date1) || !empty($date2)) {
            //url de filtraje de fechas mientras se pagina
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "date1?=$date1&date2?=$date2&";
            $header = "Resultados del filtraje ($date1 y $date2)";
            ///filtraje por fechas (coge como parametro el texto a buscar, la pagina actual y el total de paginas de la paginacion)
            $news = $newsModel->getByDatePaginated($date1, $date2, $currentPage, $totalPages);
            return $this->getResponse()->renderView('index', 'default', compact('newsModel', 'categoryModel', 'categoryid', 'userModel', 'users', 'date1', 'date2', 'news', 'categories', 'totalPages', 'currentPage', 'url', 'header'));
        } elseif (!empty($categoryid) && -200 != $categoryid) {
            //url querystring de filtraje por fecha
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "category?=$categoryid&";
            $header = "Resultados de categoria($categoryid)";
            //array por categorias (coge como parametro el texto a buscar, la pagina actual y el total de paginas de la paginacion)
            $news = $newsModel->getByCategoryPaginated($categoryid, $currentPage, $totalPages);
            return $this->getResponse()->renderView('index', 'default', compact('newsModel', 'categoryModel', 'categoryid', 'userModel', 'users', 'news', 'categories', 'totalPages', 'currentPage', 'url', 'header'));
        } else {
            $header = "Ultimas noticias";
            //array de noticias paginadas
            $news = $newsModel->getAll($currentPage, $totalPages);
            return $this->getResponse()->renderView('index', 'default', compact('newsModel', 'categoryModel', 'userModel', 'users', 'categoryid', 'categories', 'currentPage', 'totalPages', 'news', 'header'));
        }
    }
}