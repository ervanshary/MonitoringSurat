<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .footer-background {

            background-size: cover;
            background-position: center;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Content Wrapper -->

    <!-- Other content of your page -->

    <!-- Footer -->
    <div class="footer-background">
        <footer class="sticky-footer text-white font-bold">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Tokyo Riverside | Aplikasi Monitoring</span>
                </div>
            </div>
        </footer>
    </div>
    <!-- End of Footer -->

    <!-- End of Content Wrapper -->

    <!-- End of Footer -->

    <!-- Scroll to Top Button-->
    <!-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> -->

    <!-- Logout Modal-->
    <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.473/pdf.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/main.js"></script>

    <script>
        $(document).ready(function() {
            // Memuat DataTables setelah jQuery dimuat
            $('#data-tabel').DataTable();

            $('[data-target="#Modal-import-Fa"]').click(function(e) {
                e.preventDefault(); // Menghentikan aksi default dari tautan

                // Membuka modal
                $('#Modal-import-Fa').modal('show');
            });
        });

        // Mengatur nama file pada input custom-file
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });


        // Ajax untuk mengubah akses
        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                }
            })
        });

        // Ajax untuk mendapatkan data detail
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('user/get_finalaccount_data'); ?>',
                method: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    $('#modalNoKontrak').text(data.no_kontrak);
                    $('#modalNamaPT').text(data.nama_pt);
                    $('#modalPekerjaan').text(data.pekerjaan);
                    $('#modalStatus').text(data.status);
                    $('#finalAccountDetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        });

        // Ajax untuk menghapus data
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var btnDelete = $(this); // Simpan referensi tombol yang diklik
            if (confirm("Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: '<?= base_url('user/finalaccount/delete'); ?>',
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function() {
                        alert('Data berhasil dihapus!');
                        location.reload();
                        btnDelete.off('click'); // Menghapus event handler hanya pada tombol yang diklik
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + error);
                    }
                });
            }
        });


        $(document).ready(function() {
            var table = $('#data-tabel').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= base_url('user/get_finalaccounts'); ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": -1,
                    "orderable": false,
                }, ]
            });

            $('#data-tabel tbody').on('click', '.editBtn', function() {
                var id = $(this).data('id');
                // Gunakan AJAX untuk memuat data ke dalam modal
                $.ajax({
                    url: '<?= base_url('user/get_finalaccount_data'); ?>',
                    method: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Periksa apakah data berhasil dimuat
                        if (data && Object.keys(data).length > 0) {
                            // Isi nilai input dalam modal dengan data yang dimuat
                            $('#editId').val(data.id);
                            $('#no_kontrak').val(data.no_kontrak);
                            $('#nama_pt').val(data.nama_pt);
                            $('#pekerjaan').val(data.pekerjaan);
                            $('#status').val(data.status);
                            // Lanjutkan untuk input data lainnya jika diperlukan
                            $('#editModal').modal('show');
                        } else {
                            // Data tidak ditemukan, jadi jangan tampilkan modal
                            console.error("Data tidak ditemukan.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + error);
                    }
                });
            });
        });



        // Menampilkan data detail pada modal
        $(document).ready(function() {
            $('.btn-detail').on('click', function() {
                var id = $(this).data('id');

                $('#modalNoKontrak').text($(this).data('no-kontrak'));
                $('#modalNamaPT').text($(this).data('nama-pt'));
                $('#modalPekerjaan').text($(this).data('pekerjaan'));
                $('#modalTanggalAsbuilt').text($(this).data('tanggal-asbuilt'));
                $('#modalStatusAsbuilt').text($(this).data('status-asbuilt'));
                $('#modalTglTerimaBast').text($(this).data('tgl-terima-bast'));
                $('#modalTglPusat').text($(this).data('tgl-pusat'));
                $('#modalTglPom').text($(this).data('tgl-pom'));
                $('#modalTglKontraktor').text($(this).data('tgl-kontraktor'));
                $('#modalKeteranganBast').text($(this).data('keterangan'));

                var pdfUrl = '<?= base_url('assets/upload/'); ?>' + $(this).data('file-pdf');
                $('#pdfDownloadLink').attr('href', pdfUrl).text($(this).data('file-pdf'));

                $('#detailModal').modal('show');
            });

            // Mengunggah file PDF
            $('#pdfUploadInput').change(function() {
                var file = this.files[0];
                var formData = new FormData();
                formData.append('pdfFile', file);

                // Menggunakan AJAX untuk mengunggah file
                $.ajax({
                    url: '<?= base_url('user/upload_pdf_file'); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Tambahkan logika di sini untuk menanggapi respons pengunggahan
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + error);
                    }
                });
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            $('#no_kontrak').change(function() {
                var no_kontrak = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('user/get_id_asbuilt_by_no_kontrak'); ?>",
                    method: "POST",
                    data: {
                        no_kontrak: no_kontrak
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#id_asbuilt').val(data.id_asbuilt);
                    }
                });
            });
        });
    </script>


    <script>
        function showPdfPreview(pdfUrl) {
            // Fetch PDF as array buffer
            fetch(pdfUrl)
                .then(response => response.arrayBuffer())
                .then(arrayBuffer => {
                    // Convert PDF to Data URL
                    const pdfData = new Uint8Array(arrayBuffer);
                    const pdfUrl = URL.createObjectURL(new Blob([pdfData], {
                        type: 'application/pdf'
                    }));

                    // Render PDF as images
                    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                            pdf.getPage(pageNum).then(page => {
                                const scale = 1.5;
                                const viewport = page.getViewport({
                                    scale: scale
                                });

                                // Prepare canvas element
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                // Render PDF page to canvas
                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext).promise.then(() => {
                                    // Convert canvas to data URL
                                    const imageData = canvas.toDataURL('image/jpeg');

                                    // Create img element
                                    const img = document.createElement('img');
                                    img.src = imageData;

                                    // Append image to preview div
                                    document.getElementById('pdfPreviewDetail').appendChild(img);
                                });
                            });
                        }
                    });
                })
                .catch(error => console.error('Error fetching PDF:', error));
        }

        // Menampilkan data detail pada modal
        $(document).ready(function() {
            $('.btn-detail').on('click', function() {
                var id = $(this).data('id');

                $('#modalNoKontrak').text($(this).data('no-kontrak'));
                $('#modalNamaPT').text($(this).data('nama-pt'));
                $('#modalPekerjaan').text($(this).data('pekerjaan'));
                $('#modalTanggalAsbuilt').text($(this).data('tanggal-asbuilt'));
                $('#modalStatusAsbuilt').text($(this).data('status-asbuilt'));
                $('#modalTglTerimaBast').text($(this).data('tgl-terima-bast'));
                $('#modalTglPusat').text($(this).data('tgl-pusat'));
                $('#modalTglPom').text($(this).data('tgl-pom'));
                $('#modalTglKontraktor').text($(this).data('tgl-kontraktor'));
                $('#modalKeteranganBast').text($(this).data('keterangan'));

                var pdfUrl = '<?= base_url('assets/upload/'); ?>' + $(this).data('file-pdf');
                $('#pdfDownloadLink').attr('href', pdfUrl).text($(this).data('file-pdf'));

                $('#detailModal').modal('show');
            });

            // Mengunggah file PDF
            $('#pdfUploadInput').change(function() {
                var file = this.files[0];
                var formData = new FormData();
                formData.append('pdfFile', file);

                // Menggunakan AJAX untuk mengunggah file
                $.ajax({
                    url: '<?= base_url('user/upload_pdf_file'); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Tambahkan logika di sini untuk menanggapi respons pengunggahan
                        console.log(response);
                    },
                    // error: function(xhr, status, error) {
                    //     console.error("Terjadi kesalahan: " + error);
                    // }
                });
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            $('#no_kontrak').change(function() {
                var no_kontrak = $(this).val();
                $.ajax({
                    url: "<?php echo base_url('user/get_id_asbuilt_by_no_kontrak'); ?>",
                    method: "POST",
                    data: {
                        no_kontrak: no_kontrak
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#id_asbuilt').val(data.id_asbuilt);
                    }
                });
            });
        });
    </script>


    <script>
        function showPdfPreview(pdfUrl) {
            // Fetch PDF as array buffer
            fetch(pdfUrl)
                .then(response => response.arrayBuffer())
                .then(arrayBuffer => {
                    // Convert PDF to Data URL
                    const pdfData = new Uint8Array(arrayBuffer);
                    const pdfUrl = URL.createObjectURL(new Blob([pdfData], {
                        type: 'application/pdf'
                    }));

                    // Render PDF as images
                    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                            pdf.getPage(pageNum).then(page => {
                                const scale = 1.5;
                                const viewport = page.getViewport({
                                    scale: scale
                                });

                                // Prepare canvas element
                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                // Render PDF page to canvas
                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext).promise.then(() => {
                                    // Convert canvas to data URL
                                    const imageData = canvas.toDataURL('image/jpeg');

                                    // Create img element
                                    const img = document.createElement('img');
                                    img.src = imageData;

                                    // Append image to preview div
                                    document.getElementById('pdfPreviewDetail').appendChild(img);
                                });
                            });
                        }
                    });
                })
                .catch(error => console.error('Error fetching PDF:', error));
        }

        function openDetailModal(pdfUrl, bastData) {
            $('#modalNoKontrak').text(bastData.no_kontrak);
            $('#modalNamaPT').text(bastData.nama_pt);
            $('#modalPekerjaan').text(bastData.pekerjaan);
            $('#modalTanggalAsbuilt').text(bastData.tanggal_terima_asbuilt);
            $('#modalStatusAsbuilt').text(bastData.status_asbuilt);
            $('#modalTglTerimaBast').text(bastData.tgl_terima_bast);
            $('#modalTglPusat').text(bastData.tgl_pusat);

            $('#modalTglKontraktor').text(bastData.tgl_kontraktor);
            $('#modalKeteranganBast').text(bastData.keterangan_bast);

            // Menampilkan nama file PDF sebagai link
            var pdfLink = $('<a>').attr('href', '<?= base_url('assets/upload/'); ?>' + bastData.file_pdf).attr('target', '_blank').text(bastData.file_pdf);

            $('#modalPdfFilename').html(pdfLink);

            // Kosongkan konten preview PDF
            $('#pdfPreviewDetail').empty();

            // Menampilkan preview PDF per halaman
            showPdfPreview(pdfUrl);
        }

        // Fungsi untuk menampilkan modal detail
        function showDetailModal() {
            var button = $(this);
            var pdfUrl = button.data('pdf');
            var bastData = {
                no_kontrak: button.data('no-kontrak'),
                nama_pt: button.data('nama-pt'),
                pekerjaan: button.data('pekerjaan'),
                tanggal_terima_asbuilt: button.data('tanggal-asbuilt'),
                status_asbuilt: button.data('status-asbuilt'),
                tgl_terima_bast: button.data('tgl-terima-bast'),
                tgl_pusat: button.data('tgl-pusat'),

                tgl_kontraktor: button.data('tgl-kontraktor'),
                keterangan_bast: button.data('keterangan'),
                file_pdf: button.data('pdf')
            };
            openDetailModal(pdfUrl, bastData);
        }

        // Menggunakan fungsi showDetailModal untuk menangani klik pada .btn-detail
        $(document).on('click', '.btn-detail', showDetailModal);
    </script>
    </script>
    </script>
    <script>
        // Mengatur nama file pada input custom-file
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
    <script>
        // Mengunggah file PDF
        $('#pdfUploadInput').change(function() {
            var file = this.files[0];
            var formData = new FormData();
            formData.append('pdfFile', file);

            // Menggunakan AJAX untuk mengunggah file
            $.ajax({
                url: '<?= base_url('user/upload_pdf_file'); ?>',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tambahkan logika di sini untuk menanggapi respons pengunggahan
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        });

        // Ajax untuk mendapatkan data detail
        $(document).on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '<?= base_url('user/get_closing_data'); ?>', // Sesuaikan URL dengan metode di controller closing
                method: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    $('#modalNoKontrak').text(data.no_kontrak);
                    $('#modalNamaPT').text(data.nama_pt);
                    $('#modalPekerjaan').text(data.pekerjaan);
                    $('#modalStatus').text(data.status);
                    $('#modalTglTerimaBast').text(data.tgl_terima_bast);
                    $('#modalTglClosing').text(data.tgl_closing);

                    var pdfUrl = '<?= base_url('assets/upload/'); ?>' + data.file_pdf;
                    $('#pdfDownloadLink').attr('href', pdfUrl).text(data.file_pdf);

                    $('#finalAccountDetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan: " + error);
                }
            });
        });

        // Ajax untuk menghapus data
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            if (confirm("Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: '<?= base_url('user/closing_delete'); ?>', // Sesuaikan URL dengan metode di controller closing
                    method: 'post',
                    data: {
                        id: id
                    },
                    success: function() {
                        alert('Data berhasil dihapus!');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + error);
                    }
                });
            }
        });

        $(document).ready(function() {
            $('.editBtn').on('click', function() {
                var id = $(this).data('id');
                // Gunakan AJAX untuk memuat data ke dalam modal
                $.ajax({
                    url: '<?= base_url('user/get_closing_data'); ?>', // Sesuaikan URL dengan metode di controller closing
                    method: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Periksa apakah data berhasil dimuat
                        if (data) {
                            // Isi nilai input dalam modal dengan data yang dimuat
                            $('#editId').val(data.id_closing); // Sesuaikan dengan nama field yang benar
                            $('#no_kontrak').val(data.no_kontrak);
                            $('#nama_pt').val(data.nama_pt);
                            $('#pekerjaan').val(data.pekerjaan);
                            $('#status').val(data.status);
                            // Lanjutkan untuk input data lainnya jika diperlukan
                        } else {
                            alert('Data tidak ditemukan.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + error);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.btn-detail').on('click', function() {
                var id = $(this).data('id');

                $('#modalNoKontrak').text($(this).data('no-kontrak'));
                $('#modalNamaPT').text($(this).data('nama-pt'));
                $('#modalPekerjaan').text($(this).data('pekerjaan'));
                $('#modalTanggalAsbuilt').text($(this).data('tanggal-asbuilt'));
                $('#modalStatusAsbuilt').text($(this).data('status-asbuilt'));
                $('#modalTglTerimaBast').text($(this).data('tgl-terima-bast'));
                $('#modalTglPusat').text($(this).data('tgl-pusat'));
                $('#modalTglPom').text($(this).data('tgl-pom'));
                $('#modalTglKontraktor').text($(this).data('tgl-kontraktor'));
                $('#modalKeteranganBast').text($(this).data('keterangan'));

                var pdfUrl = '<?= base_url('assets/upload/'); ?>' + $(this).data('file-pdf');
                $('#pdfDownloadLink').attr('href', pdfUrl).text($(this).data('file-pdf'));

                $('#detailModal').modal('show');
            });
        });


        function previewPDF() {
            var file = document.getElementById('file_pdf').files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var loadingTask = pdfjsLib.getDocument({
                    data: e.target.result
                });
                loadingTask.promise.then(function(pdf) {
                    // Fetch the first page
                    return pdf.getPage(1).then(function(page) {
                        var scale = 1.5;
                        var viewport = page.getViewport({
                            scale: scale
                        });

                        // Prepare canvas using PDF page dimensions
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        // Render PDF page into canvas context
                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function() {
                            document.getElementById('pdfPreview').innerHTML = '';
                            document.getElementById('pdfPreview').appendChild(canvas);
                        });
                    });
                });
            };
            reader.readAsArrayBuffer(file);
        }



        $(document).ready(function() {
            $('#bast2-table').DataTable();

            $('.btn-detail').on('click', function() {
                var nokontrak = $(this).data('nokontrak');
                var namapt = $(this).data('namapt');
                var pekerjaan = $(this).data('pekerjaan');
                var tanggalasbuilt = $(this).data('tanggalasbuilt');
                var tglterimabast = $(this).data('tglterimabast');
                var filepdf = $(this).data('filepdf');
                var tglterimabast2 = $(this).data('tglterimabast2');
                var tglpom = $(this).data('tglpom');
                var tglpusat2 = $(this).data('tglpusat2');
                var tglkontraktor2 = $(this).data('tglkontraktor2');
                var filepdfbast2 = $(this).data('filepdfbast2');
                var keterangan = $(this).data('keterangan');

                $('#modalNoKontrak').text(nokontrak);
                $('#modalNamaPT').text(namapt);
                $('#modalPekerjaan').text(pekerjaan);
                $('#modalTanggalAsbuilt').text(tanggalasbuilt);
                $('#modalTglTerimaBast').text(tglterimabast);
                $('#modalFilePdf').text(filepdf);
                $('#modalTglTerimaBast2').text(tglterimabast2);
                $('#modalTglPom').text(tglpom);
                $('#modalTglPusat2').text(tglpusat2);
                $('#modalTglKontraktor2').text(tglkontraktor2);
                $('#modalFilePdfBast2').text(filepdfbast2);
                $('#modalKeterangan').text(keterangan);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const noKontrakSelect = document.getElementById('no_kontrak');
            const idAsbuiltInput = document.getElementById('id_asbuilt');

            noKontrakSelect.addEventListener('change', function() {
                const selectedOption = noKontrakSelect.options[noKontrakSelect.selectedIndex];
                const idAsbuilt = selectedOption.getAttribute('data-id-asbuilt');
                idAsbuiltInput.value = idAsbuilt;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-detail').on('click', function() {
                var noKontrak = $(this).data('no-kontrak');
                var namaPt = $(this).data('nama-pt');
                var pekerjaan = $(this).data('pekerjaan');
                var tanggalAsbuilt = $(this).data('tanggal-asbuilt');
                var statusAsbuilt = $(this).data('status-asbuilt');
                var tglTerimaBast = $(this).data('tgl-terima-bast');
                var tglPusat = $(this).data('tgl-pusat');
                var tglKontraktor = $(this).data('tgl-kontraktor');
                var keterangan = $(this).data('keterangan');
                var filePdf = $(this).data('pdf');

                $('#modalNoKontrak').text(noKontrak);
                $('#modalNamaPT').text(namaPt);
                $('#modalPekerjaan').text(pekerjaan);
                $('#modalTanggalAsbuilt').text(tanggalAsbuilt);
                $('#modalStatusAsbuilt').text(statusAsbuilt);
                $('#modalTglTerimaBast').text(tglTerimaBast);
                $('#modalTglPusat').text(tglPusat);
                $('#modalTglKontraktor').text(tglKontraktor);
                $('#modalKeterangan').text(keterangan);
                $('#modalFilePdf').text(filePdf);
            });

            // $('.edit-btn').on('click', function() {
            //     var idBast = $(this).data('id_bast');
            //     var noKontrak = $(this).data('no-kontrak');
            //     var namaPt = $(this).data('nama-pt');
            //     var pekerjaan = $(this).data('pekerjaan');
            //     var tanggal_terima_asbuilt = $(this).data('tanggal-terima-asbuilt');
            //     var statusAsbuilt = $(this).data('status-asbuilt');
            //     var tglTerimaBast = $(this).data('tgl-terima-bast');
            //     var tglPusat = $(this).data('tgl-pusat');
            //     var tglKontraktor = $(this).data('tgl-kontraktor');
            //     var keterangan = $(this).data('keterangan');
            //     var opsiretensi = $(this).data('opsi_retensi');
            //     var filePdf = $(this).data('pdf');

            //     $('#edit_id_bast').val(idBast);
            //     $('#edit_no_kontrak').val(noKontrak);
            //     $('#edit_nama_pt').val(namaPt);
            //     $('#edit_pekerjaan').val(pekerjaan);
            //     $('#editTanggalAsbuilt').val(tanggal_terima_asbuilt);
            //     $('#edit_status_asbuilt').val(statusAsbuilt);
            //     $('#edit_tgl_terima_bast').val(tglTerimaBast);
            //     $('#edit_tgl_pusat').val(tglPusat);
            //     $('#edit_tgl_kontraktor').val(tglKontraktor);
            //     $('#edit_keterangan').val(keterangan);
            //     $('#edit_opsi_retensi').val(opsiretensi);
            //     // handle file_pdf if needed
            // });
        });
    </script>



    <script>
        /////////////////////////CLOSING JAVA SCIPT///////////////////
        function sendData(button) {
            // Ambil data dari atribut data- pada tombol
            var noKontrak = button.getAttribute('data-no-kontrak');
            var namaPT = button.getAttribute('data-nama-pt');
            var pekerjaan = button.getAttribute('data-pekerjaan');
            var tglTerimaBAST = button.getAttribute('data-tgl-terima-bast');
            var filePDF = button.getAttribute('data-pdf');

            // Siapkan data untuk dikirim ke server
            var data = {
                no_kontrak: noKontrak,
                nama_pt: namaPT,
                pekerjaan: pekerjaan,
                tgl_terima_bast: tglTerimaBAST,
                file_pdf: filePDF,
                tgl_closing: new Date().toISOString().split('T')[0] // Tanggal closing saat ini
            };

            // Kirim data menggunakan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= base_url('user/closing_statment') ?>", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Sukses
                        alert("Data berhasil dikirim.");
                        location.reload(); // Muat ulang halaman untuk melihat perubahan
                    } else {
                        // Gagal
                        alert("Gagal mengirim data.");
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#reportTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url('user/get_report_data'); ?>",
                    "type": "POST"
                },
                "columns": [{
                        "data": "no_kontrak"
                    },
                    {
                        "data": "nama_pt"
                    },
                    {
                        "data": "pekerjaan"
                    },
                    {
                        "data": "tgl_terima_bast"
                    },
                    {
                        "data": "keterangan"
                    }
                ]
            });
        });
    </script>



    <script>
        document.getElementById('newFaModal').addEventListener('submit', function(event) {
            // Ambil nilai input
            var no_kontrak = document.getElementById('no_kontrak').value;

            // Lakukan pemeriksaan duplikasi dengan data yang ada di tabel
            var isDuplicate = false;
            document.querySelectorAll('#data-tabel tbody tr').forEach(function(row) {
                if (row.children[1].innerText === no_kontrak) {
                    isDuplicate = true;
                }
            });

            if (isDuplicate) {
                alert('Data dengan No Kontrak tersebut sudah ada.');
                event.preventDefault();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            //////////////////////////////INSERT///////////////////////////////////////////
            $('.btn-insert').on('click', function(event) {
                event.preventDefault(); // Prevent the default action of the link

                var no_kontrak = $(this).data('no-kontrak');
                var nama_pt = $(this).data('nama-pt');
                var pekerjaan = $(this).data('pekerjaan');
                var id_insert = $(this).data('id-insert');

                $.ajax({
                    url: '<?= base_url('user/insert_data'); ?>',
                    type: 'POST',
                    dataType: 'json', // Menentukan tipe data yang diharapkan dari server
                    data: {
                        no_kontrak: no_kontrak,
                        nama_pt: nama_pt,
                        pekerjaan: pekerjaan,
                        id_insert: id_insert
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil dikirim!');
                        } else {
                            alert('Gagal mengirim data: ' + response.message);
                        }
                    },

                });
            });

            // Update id_insert hidden input when no_kontrak selection changes
            $('#no_kontrak').change(function() {
                var selectedOption = $(this).find(':selected');
                var id_insert = selectedOption.data('id-insert');
                $('#id_insert').val(id_insert);
            });

            $('#no_kontrak_add').change(function() {
                var selectedOption = $(this).find(':selected');
                var id_asbuilt = selectedOption.data('id-asbuilt');
                $('#id_asbuilt_add').val(id_asbuilt);
            });

            $('#no_kontrak_insert').change(function() {
                var selectedOption = $(this).find(':selected');
                var id_asbuilt = selectedOption.data('id-asbuilt');
                $('#id_asbuilt_insert').val(id_asbuilt);
            });

            $('#exportButton').on('click', function() {
                var search = $('#dataTable').DataTable().search();
                window.location.href = '/user/export_report?search=' + encodeURIComponent(search);
            });
        });
    </script>

    <script>
        // Insert data to user_insert
        $('.btn-insert').on('click', function() {
            const no_kontrak = $(this).data('no-kontrak');
            const nama_pt = $(this).data('nama-pt');
            const pekerjaan = $(this).data('pekerjaan');
            const id = $(this).data('id-insert');

            $.ajax({
                url: '<?= base_url('user/insert_finalaccount') ?>',
                method: 'post',
                data: {
                    no_kontrak: no_kontrak,
                    nama_pt: nama_pt,
                    pekerjaan: pekerjaan,
                    id: id
                },
                success: function(response) {
                    // Display a success message or reload the table
                    alert('Data berhasil dimasukkan ke tabel user_insert');
                }
            });
        });
    </script>
</body>

</html>