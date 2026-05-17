<?php
class ViewHelper {
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

    // Fungsi untuk membuat Search Bar (Tetap aman seperti kode asli Anda)
    public static function renderSearchBar($placeholder) {
        $searchValue = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
        echo '
        <div class="row mb-3">
            <div class="col-md-4 ms-auto">
                <form action="" method="GET">
                    <div class="input-group shadow-sm border" style="border-radius: 8px; background-color: white;">
                        <span class="input-group-text bg-white border-0 pe-1">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 ps-2" name="search" 
                               placeholder="' . $placeholder . '" value="' . $searchValue . '" 
                               style="box-shadow: none; background: transparent; height: 45px;">
                    </div>
                </form>
            </div>
        </div>';
    }

    // Function untuk mencetak informasi total data dan tombol navigasi halaman 
    public static function renderTableFooter($totalData, $unitName = "data") {
        echo '
            <div class="d-flex justify-content-between align-items-center mt-3 responsive-footer-wrapper">
                <p class="text-muted small mb-0">Menampilkan ' . $totalData . ' ' . $unitName . '</p>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#" style="border-radius: 6px 0 0 6px;">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#" style="border-radius: 0 6px 6px 0;">Selanjutnya</a></li>
                    </ul>
                </nav>
            </div>';
    }
    
}
?>