<div class="container">
    <div class="row float-right">
        <div class="col-4">
            <h1>Buscador</h1>
            <form class="form-vertical" method="get" action="/">
                <div class="form-group">
                    <input type="hidden" name="action" value="news">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search news">
                    <div class="form-group">
                        <button class="btn btn-info" type="submit" value="Buscar">
                            <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z"
                                      clip-rule="evenodd"/>
                                <path fill-rule="evenodd"
                                      d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
            <h3>Filtro por Fechas</h3>
            <hr style="background-color: #0c5460">
            <form class="form-horizontal" action="/" method="GET">
                <input type="hidden" name="action" value="news">
                <div class="form-group">
                    <label for="date1">Fecha de inicio</label>
                    <input id="date1" type="date" class="form-control" name="date1" placeholder="Fecha de inicio">
                </div>
                <div class="form-group">
                    <label for="date2">Fecha de fin</label>
                    <input id="date2" type="date" class="form-control" name="date2" placeholder="Fecha de fin">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info" value="Mostrar">
                        <svg class="bi bi-clipboard-data" width="1em" height="1em" viewBox="0 0 16 16"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4 1.5H3a2 2 0 00-2 2V14a2 2 0 002 2h10a2 2 0 002-2V3.5a2 2 0 00-2-2h-1v1h1a1 1 0 011 1V14a1 1 0 01-1 1H3a1 1 0 01-1-1V3.5a1 1 0 011-1h1v-1z"
                                  clip-rule="evenodd"/>
                            <path fill-rule="evenodd"
                                  d="M9.5 1h-3a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h3a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5zm-3-1A1.5 1.5 0 005 1.5v1A1.5 1.5 0 006.5 4h3A1.5 1.5 0 0011 2.5v-1A1.5 1.5 0 009.5 0h-3z"
                                  clip-rule="evenodd"/>
                            <path d="M4 11a1 1 0 112 0v1a1 1 0 11-2 0v-1zm6-4a1 1 0 112 0v5a1 1 0 11-2 0V7zM7 9a1 1 0 012 0v3a1 1 0 11-2 0V9z"/>
                        </svg>
                    </button>
                </div>
            </form>
            <h4>Filtro por categoria</h4>
            <form class="form-horizontal" action="/" method="get">
                <input type="hidden" name="action" value="news">
                <label for="categories">Categoria</label>
                <select class="form-control" name="categoryId" id="categories">
                    <option value="-200" <?= (-200 == $categoryid) ? "selected=\"selected\"" : "" ?>>(Seleccionar
                        categoria)
                    </option>
                    <?php foreach ($categories as $category): ?>
                        <option <?= ($category->getId() == $categoryid) ? "selected=\"selected|" : "" ?>
                            value="<?= $category->getId() ?>">
                            <?= $category->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-info" value="Mostrar">
                        <svg class="bi bi-tag-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M2 1a1 1 0 00-1 1v4.586a1 1 0 00.293.707l7 7a1 1 0 001.414 0l4.586-4.586a1 1 0 000-1.414l-7-7A1 1 0 006.586 1H2zm4 3.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-sm-8">
            <hr class="bg-color-info">
            <br>
            <br>
            <h1 align="center"><?= $header ?></h1>
            <hr style="background-color: #0c5460">
            <?php foreach ($news as $new): ?>
                <div id="container">
                    <div class="col-md-12">
                        <div class="d-inline-flex m-30 p-15"><strong><a href="/news/show/<?= $new->getId() ?>">
                                    <h3> <?= $new->getTitle(); ?> </h3></a>
                                <br></strong>
                        </div>

                        <?php if ($new->getImage() != ''): ?>
                            <div class="img-thumbnail d-inline-flex border-top"><img name="image"
                                                                                     src="<?= \App\Entity\News::DIR_PATH ?><?= $new->getImage(); ?>"/>
                            </div>
                        <?php else: ?>
                            <svg class="bi bi-card-image" width="20em" height="20em" viewBox="0 0 16 16"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z"
                                      clip-rule="evenodd"/>
                                <path d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z"/>
                                <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                      clip-rule="evenodd"/>
                            </svg>
                        <?php endif; ?>
                        <div><span class="btn btn-info">Categoria:<?php
                                if ($new->getCategoryId() !== null)
                                    echo $newsModel->getCategories($new)->getName();
                                //  var_dump($newsModel->getCategories($new));
                                ?> </span>
                        </div>
                        <br>
                        <div><span class="btn btn-danger">Escrito por:<?php
                                if ($new->getAuthorId() !== null)
                                    echo $newsModel->getUsers($new)->getUsername();
                                //  var_dump($newsModel->getCategories($new));
                                ?> </span>
                        </div>
                        <div class="d-inline-flex"><p><?= substr($new->getDescription(), 0, 255) ?></p></div>

                        <div class="d-inline-block"><strong><a
                                    href="/news/show/<?= $new->getId(); ?>">Ver
                                    Contenido</a></strong></div>
                        <div class="d-inline-block">
                            <div><small><?= $new->getPublishedAt()->format('Y-m-d'); ?></small><br></div>
                        </div>
                    </div>

                </div>

                <hr>
            <?php endforeach; ?>
            <?php if ($totalPages > 1): ?>
                <?php
                require_once("../partials/paginator.partial.php");
                ?>

            <?php endif; ?>
        </div>
    </div>
</div>

