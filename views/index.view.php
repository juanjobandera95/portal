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