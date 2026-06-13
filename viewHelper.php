<?php
class ViewHelper {
    // Fungsi untuk mencetak style dari page
    public static function renderStyles() {
        echo '
        <style>
            .pagination .page-link {
                color: #064e3b;
                border: none;
                border-radius: 6px !important;
                margin: 0 2px;
                min-width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
                font-weight: 500;
                padding: 0;
            }

            .pagination .page-item.active .page-link {
                background-color: #064e3b;
                color: white;
                border: none;
            }

            .pagination .page-link:hover {
                background-color: #f0fdf4;
                color: #064e3b;
            }

            .pagination .page-item.disabled .page-link {
                color: #9ca3af;
                background-color: transparent;
            }
        </style>';
    }

    // Fungsi untuk mencetak Header Halaman & Tombol Tambah 
    public static function renderHeader($title, $modalTarget = "", $buttonText = "Tambah Data") {
        echo '
        <style>
            /* Untuk mobile nya*/
            @media (max-width: 768px) {
                .responsive-header-wrapper { /* Mengubah susunan header dari kiri-kanan menjadi atas-bawah */
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 12px !important;
                }
                
                .responsive-header-wrapper button {
                    width: 100% !important;
                }

                .responsive-footer-wrapper { /* Mengubah susunan footer tabel menjadi bertumpuk di tengah */
                    flex-direction: column !important;
                    gap: 15px !important;
                    text-align: center !important;
                }
            }
        </style>';

        echo '
        <div class="container-box">
            <div class="d-flex justify-content-between align-items-end mb-4 responsive-header-wrapper">
                <div>
                    <h4 class="fw-bold m-0 text-dark">' . $title . '</h4>
                </div>';
        // Jika modal target ada maka tombol muncul       
        if (!empty($modalTarget)) {
            echo '
                <button class="btn btn-success shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#' . $modalTarget . '">
                    ' . $buttonText .'
                </button>';
        }

        echo '
            </div>
        </div>';
    }

    // Fungsi untuk membuat Search Bar
    public static function renderSearchBar($placeholder) {
        $searchValue = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
        echo '
        <div class="row mb-3">
            <div class="col-md-4 ms-auto">
                <form action="" method="GET" id="formSearch">
                    <div class="input-group shadow-sm border" style="border-radius: 8px; background-color: white;">
                        <span class="input-group-text bg-white border-0 pe-1">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 ps-2" name="search" 
                                id="inputSearch"
                               placeholder="' . $placeholder . '" value="' . $searchValue . '" 
                               style="box-shadow: none; background: transparent; height: 45px;">
                        ' . (!empty($searchValue) ? ' 
                        <span class="input-group-text bg-white border-0 ps-1" id="btnClearSearch"
                            style="cursor: pointer;" onclick="clearSearch()">
                            <i class="bi bi-x text-muted fs-5"></i>
                        </span>' : '').'
                    </div>
                </form>
            </div>
        </div>
        <script>
            function clearSearch() {
                document.getElementById("inputSearch").value = "";
                document.getElementById("formSearch").submit();
            }
        </script>';
    }

    // Fungsi untuk menghitung halaman
    public static function getPaginationData($totalData, $perPage = 10) {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages  = $totalData > 0 ? ceil($totalData / $perPage) : 1;
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset      = ($currentPage - 1) * $perPage;

        return [
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'offset'      => $offset,
            'perPage'     => $perPage,
        ];
    }

    // Function untuk mencetak informasi total data dan tombol navigasi halaman 
    public static function renderTableFooter($totalData, $unitName = "data", $pagination = null) {
        if ($pagination && $totalData > 0) {
            $from = $pagination['offset'] + 1;
            $to   = min($pagination['offset'] + $pagination['perPage'], $totalData);
            $info = 'Menampilkan ' . $from . '–' . $to . ' dari ' . $totalData . ' ' . $unitName;
        } else {
            $info = 'Menampilkan ' . $totalData . ' ' . $unitName;
        }

        $searchParam = (isset($_GET['search']) && $_GET['search'] !== '')
            ? '&search=' . urlencode($_GET['search'])
            : '';

        echo '
        <div class="d-flex justify-content-between align-items-center mt-3 responsive-footer-wrapper">
            <p class="text-muted small mb-0">' . $info . '</p>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">';

        if ($pagination && $pagination['totalPages'] > 1) {
            $current = (int)$pagination['currentPage'];
            $total   = (int)$pagination['totalPages'];

            // Tombol Previous
            $prevDisabled = $current <= 1 ? 'disabled' : '';
            $prevHref     = $current > 1 ? '?page=' . ($current - 1) . $searchParam : '#';
            echo '<li class="page-item ' . $prevDisabled . '">
                    <a class="page-link" href="' . $prevHref . '"><i class="bi bi-chevron-left"></i></a>
                </li>';

            $pages = [];
            for ($i = 1; $i <= $total; $i++) {
                if (
                    $i === 1 ||                  // 1 halaman pertama ditampilkan
                    $i === $total ||            // halaman terakhir selalu tampil
                    $i === $current ||          // halaman aktif
                    $i === $current - 1 ||      // 1 halaman sebelum aktif
                    $i === $current + 1         // 1 halaman setelah aktif
                ) {
                    $pages[] = $i;
                }
            }
            $pages = array_unique($pages);
            sort($pages);

            // Tampilkan nomor halaman dengan ellipsis
            $prev = null;
            foreach ($pages as $page) {
                // Tambahkan ellipsis kalau ada lompatan
                if ($prev !== null && $page - $prev > 1) {
                    echo '<li class="page-item disabled">
                            <a class="page-link" href="#">...</a>
                        </li>';
                }
                $active = $page === $current ? 'active' : '';
                echo '<li class="page-item ' . $active . '">
                        <a class="page-link" href="?page=' . $page . $searchParam . '">' . $page . '</a>
                    </li>';
                $prev = $page;
            }
            // Tombol Next
            $nextDisabled = $current >= $total ? 'disabled' : '';
            $nextHref     = $current < $total ? '?page=' . ($current + 1) . $searchParam : '#';
            echo '<li class="page-item ' . $nextDisabled . '">
                    <a class="page-link" href="' . $nextHref . '"><i class="bi bi-chevron-right"></i></a>
                </li>';
        } else {
            echo '<li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>';
        }
        echo '      </ul>
            </nav>
        </div>';
    }
}
?>