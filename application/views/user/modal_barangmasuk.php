<div x-data @open-detail.window="detail = $event.detail; open = true" x-show="open" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 p-6 relative" @click.away="open = false">
        <h2 class="text-xl font-bold mb-4">Detail Barang Masuk</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Jenis Barang:</strong> <span x-text="detail.jenis_barang"></span></p>
                <p><strong>Nama Barang:</strong> <span x-text="detail.nama_barang"></span></p>
                <p><strong>Lokasi:</strong> <span x-text="detail.lokasi"></span></p>
                <p><strong>Jumlah:</strong> <span x-text="detail.jumlah"></span></p>
                <p><strong>Satuan:</strong> <span x-text="detail.satuan"></span></p>
            </div>
            <div>
                <p><strong>Tanggal Masuk:</strong> <span x-text="detail.tanggal_masuk"></span></p>
                <p><strong>Pengirim:</strong> <span x-text="detail.pengirim"></span></p>
                <p><strong>Perusahaan:</strong> <span x-text="detail.perusahaan"></span></p>
                <p><strong>Penerima:</strong> <span x-text="detail.penerima"></span></p>
                <p><strong>Keterangan:</strong> <span x-text="detail.keterangan"></span></p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <button @click="open=false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Close</button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('detailModal', () => ({
            open: false,
            detail: {},
        }));
    });
</script>


<!-- Modal Edit -->

<div x-data="{ open: false, edit: {} }" @open-edit.window="edit = $event.detail; open = true" x-show="open" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 p-6 relative" @click.away="open = false">
        <h2 class="text-xl font-bold mb-4">Edit Barang Masuk</h2>
        <form :action="'<?= base_url('Gudang/update'); ?>'" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" :value="edit.id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold">Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="border px-3 py-2 rounded-lg w-full" x-model="edit.jenis_barang">
                </div>
                <div>
                    <label class="block font-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="border px-3 py-2 rounded-lg w-full" x-model="edit.nama_barang">
                </div>
                <!-- Lainnya sama seperti form edit sebelumnya -->
            </div>
            <div class="mt-4 text-right">
                <button type="button" @click="open=false" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>




<div class="modal fade" id="pindahModal" tabindex="-1" role="dialog" aria-labelledby="pindahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pindahModalLabel">Pindahkan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pindahForm" method="post" action="<?= base_url('Gudang/pindahkan_barang'); ?>">
                <div class="modal-body">
                    <input type="hidden" id="pindah-id" name="id">
                    <div class="form-group">
                        <label for="pindah-jenis_barang">Jenis Barang</label>
                        <input type="text" class="form-control" id="pindah-jenis_barang" name="jenis_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pindah-nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="pindah-nama_barang" name="nama_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pindah-lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="pindah-lokasi" name="lokasi" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pindah-jumlah_keluar">Jumlah Keluar</label>
                        <input type="number" class="form-control" id="pindah-jumlah_keluar" name="jumlah_keluar" required>
                    </div>
                    <div class="form-group">
                        <label for="pindah-satuan">Satuan</label>
                        <input type="text" class="form-control" id="pindah-satuan" name="satuan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pindah-tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="pindah-tanggal_keluar" name="tanggal_keluar" required>
                    </div>
                    <div class="form-group">
                        <label for="pindah-pengirim">Pengirim</label>
                        <input type="text" class="form-control" id="pindah-pengirim" name="pengirim" required>
                    </div>
                    <div class="form-group">
                        <label for="pindah-perusahaan">Nama PT</label>
                        <input type="text" class="form-control" id="pindah-perusahaan" name="perusahaan" required>
                    </div>
                    <div class="form-group">
                        <label for="pindah-penerima">Penerima</label>
                        <input type="text" class="form-control" id="pindah-penerima" name="penerima" required>
                    </div>
                    <div class="form-group">
                        <label for="pindah-keterangan">Keterangan</label>
                        <textarea class="form-control" id="pindah-keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Pindahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal Import Data -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Gudang/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih file Excel</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>