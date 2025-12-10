document.addEventListener('DOMContentLoaded', function() {
    var detailButtons = document.querySelectorAll('.btn-detail');
    var editButtons = document.querySelectorAll('.edit-btn');

    if (detailButtons) {
        detailButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var modal = document.getElementById('detailModal2');
                var target = event.currentTarget;
                
                if (modal) {
                    modal.querySelector('#modalNoKontrak').textContent = target.getAttribute('data-nokontrak');
                    modal.querySelector('#modalNamaPT').textContent = target.getAttribute('data-namapt');
                    modal.querySelector('#modalPekerjaan').textContent = target.getAttribute('data-pekerjaan');
                    modal.querySelector('#modalTanggalAsbuilt').textContent = target.getAttribute('data-tanggalasbuilt');
                    modal.querySelector('#modalTglTerimaBast').textContent = target.getAttribute('data-tglterimabast');
                    modal.querySelector('#modalTglTerimaBast2').textContent = target.getAttribute('data-tglterimabast2');
                    modal.querySelector('#modalTglPom').textContent = target.getAttribute('data-tglpom');
                    modal.querySelector('#modalTglPusat2').textContent = target.getAttribute('data-tglpusat2');
                    modal.querySelector('#modalTglKontraktor2').textContent = target.getAttribute('data-tglkontraktor2');
                    modal.querySelector('#modalKeterangan').textContent = target.getAttribute('data-keterangan');
                    modal.querySelector('#modalFilePdf').textContent = target.getAttribute('data-filepdf');
                    modal.querySelector('#modalFilePdfBast2').textContent = target.getAttribute('data-filepdfbast2');
                }
            });
        });
    } else {
        console.error('No detail buttons found in the DOM.');
    }

    if (editButtons) {
        editButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var modal = document.getElementById('editModal2');
                var target = event.currentTarget;

                if (modal) {
                    modal.querySelector('#editIdBast2').value = target.getAttribute('data-id_bast2');
                    modal.querySelector('#editNoKontrak').value = target.getAttribute('data-nokontrak');
                    modal.querySelector('#editNamaPT').value = target.getAttribute('data-namapt');
                    modal.querySelector('#editPekerjaan').value = target.getAttribute('data-pekerjaan');
                    modal.querySelector('#editTglTerimaBast').value = target.getAttribute('data-tglterimabast');
                    modal.querySelector('#editTglTerimaBast2').value = target.getAttribute('data-tglterimabast2');
                    modal.querySelector('#editTglPom').value = target.getAttribute('data-tglpom');
                    modal.querySelector('#editTglPusat2').value = target.getAttribute('data-tglpusat2');
                    modal.querySelector('#editTglKontraktor2').value = target.getAttribute('data-tglkontraktor2');
                    modal.querySelector('#editKeterangan').value = target.getAttribute('data-keterangan');
                    modal.querySelector('#editFilePdfBast2').value = target.getAttribute('data-filepdfbast2');
                }
            });
        });
    } else {
        console.error('No edit buttons found in the DOM.');
    }


    $.ajax({
        url: "/some/url",
        method: "GET",
        success: function(response) {
            if (response.no_kontrak) {
                // Do something with response.no_kontrak
            } else {
                console.error("no_kontrak not found in response");
            }
        },
        error: function(error) {
            console.error("Error fetching data: ", error);
        }
    });
    
});
