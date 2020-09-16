<nav aria-label="Page navigation bg-color info">
    <ul class="pagination">
        <li class="page-item <?php if ($currentPage == 1) echo "disabled"; ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $array = explode("&", $query);


        $array = (array_filter($array, function ($v) {
            return (strpos($v, "page=") !== 0);
        }));

        if (count($array) == 0) {
            $url2 = $path . '?';
        } else
            $url2 = $path . '?' . implode($array, '&') . '&';

        ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i !== $currentPage): ?>
                <li class="page-item"><a class="page-link"
                                         href="<?= $url2 ?>?&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php else: ?>
                <li class="page-item active"><a class="page-link"><?= $i ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>
        <li class="page-item <?php if ($currentPage === $totalPages) echo "disabled"; ?>">
            <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>