<style>
    .pagination a {
        width: 60px;
    }

    .pagination-outer {
        text-align: center;
    }

    .pagination {
        font-family: 'Manrope', sans-serif;
        display: inline-flex;
        position: relative;
    }

    .pagination li a.page-link {
        color: #555;
        background: #eee;
        font-size: 16px;
        font-weight: 700;
        text-align: center;
        line-height: 32px;
        height: 32px;
        width: 32px;
        padding: 0;
        margin: 0 6px;
        border: none;
        border-radius: 0;
        display: block;
        position: relative;
        z-index: 1;
        transition: all 0.5s ease 0s;
    }

    .pagination li:first-child a.page-link,
    .pagination li:last-child a.page-link {
        font-size: 23px;
        line-height: 28px;
    }

    .pagination li a.page-link:hover,
    .pagination li a.page-link:focus,
    .pagination li.active a.page-link:hover,
    .pagination li.active a.page-link {
        color: #c31db3;
        background: transparent;
        box-shadow: 0 0 0 1px #c31db3;
        border-radius: 5px;
    }

    .pagination li a.page-link:before,
    .pagination li a.page-link:after {
        content: '';
        background-color: #c31db3;
        height: 10px;
        width: 10px;
        opacity: 0;
        position: absolute;
        left: 0;
        top: 0;
        z-index: -2;
        transition: all 0.3s ease 0s;
    }

    .pagination li a.page-link:after {
        right: 0;
        bottom: 0;
        top: auto;
        left: auto;
    }

    .pagination li a.page-link:hover:before,
    .pagination li a.page-link:focus:before,
    .pagination li.active a.page-link:hover:before,
    .pagination li.active a.page-link:before,
    .pagination li a.page-link:hover:after,
    .pagination li a.page-link:focus:after,
    .pagination li.active a.page-link:hover:after,
    .pagination li.active a.page-link:after {
        opacity: 1;
    }

    .pagination li a.page-link:hover:before,
    .pagination li a.page-link:focus:before,
    .pagination li.active a.page-link:hover:before,
    .pagination li.active a.page-link:before {
        left: -3px;
        top: -3px;
    }

    .pagination li a.page-link:hover:after,
    .pagination li a.page-link:focus:after,
    .pagination li.active a.page-link:hover:after,
    .pagination li.active a.page-link:after {
        right: -3px;
        bottom: -3px;
    }

    @media only screen and (max-width: 480px) {
        .pagination {
            font-size: 0;
            display: inline-block;
        }

        .pagination li {
            display: inline-block;
            vertical-align: top;
            margin: 0 0 15px;
        }
    }
</style>

<?php
$totalPage = $data['meta']['pagination']['pageCount'];
$currentPage = isset($data['meta']['pagination']['page']) ? intval($data['meta']['pagination']['page']) : 1;
$maxVisiblePages = 5;
$cateFilter = isset($_GET['categoryId']) ? 'categoryId=' . $_GET['categoryId'] . '&' : "";

// Chỉ hiển thị phân trang nếu có ít nhất một trang
if ($totalPage > 0) {
    $startPage = max(1, $currentPage - floor($maxVisiblePages / 2));
    $endPage = min($totalPage, $currentPage + floor($maxVisiblePages / 2));
?>
    <nav class="pagination-outer" style="display: flex; width: 100%; justify-content: center; align-items: center;">
        <ul class="pagination">
            <?php
            if ($currentPage > 1) {
                echo '<li class="page-item">
                                <a class="page-link" href="index.php?' . $cateFilter . 'page=' . ($currentPage - 1) . '" aria-label="Previous">«</a>
                              </li>';
            } else {
                echo '<li class="page-item disabled">
                                <a class="page-link" aria-label="Previous">«</a>
                              </li>';
            }
            if ($startPage > 1) {
                echo '<li class="page-item">
                                <a class="page-link" href="index.php?' . $cateFilter . 'page=1">1</a>
                              </li>';
                if ($startPage > 2) {
                    echo '<li class="page-item disabled">
                                    <a class="page-link">...</a>
                                  </li>';
                }
            }
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo '<li class="page-item active" aria-current="page">
                                    <a href="index.php?' . $cateFilter . 'page=' . $i . '" class="page-link">' . $i . '</a>
                                  </li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="index.php?' . $cateFilter . 'page=' . $i . '">' . $i . '</a></li>';
                }
            }
            if ($endPage < $totalPage) {
                if ($endPage < $totalPage - 1) {
                    echo '<li class="page-item disabled">
                                    <a class="page-link">...</a>
                                  </li>';
                }
                echo '<li class="page-item">
                                <a class="page-link" href="index.php?' . $cateFilter . 'page=' . $totalPage . '">' . $totalPage . '</a>
                              </li>';
            }
            if ($currentPage < $totalPage) {
                echo '<li class="page-item">
                                <a class="page-link" href="index.php?' . $cateFilter . 'page=' . ($currentPage + 1) . '" aria-label="Next">»</a>
                              </li>';
            } else {
                echo '<li class="page-item disabled">
                                <a class="page-link" aria-label="Next">»</a>
                              </li>';
            }
            ?>
        </ul>
    </nav>
<?php
}
?>