<?php
class ViewHelper {
    // Fungsi untuk mencetak Header Halaman & Tombol Tambah
    public static function renderHeader($title, $modalTarget, $buttonText = "Tambah Data") {
        echo '
        <div class="container-box">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h4 class="fw-bold m-0 text-dark">' . $title . '</h4>
                </div>
                <button class="btn btn-success shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#' . $modalTarget . '">
                    ' . $buttonText .'
                </button>
            </div>
        </div>';
    }

    // Fungsi untuk membuat Search Bar dinamis
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
}