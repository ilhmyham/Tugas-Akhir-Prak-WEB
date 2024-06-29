<div class="modal fade" id="exampleModal2<?php echo $val['id_obat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Data Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $val['id_obat'] ?>">
                    <div class="mb-3">
                        <label for="obat" class="form-label">Nama Obat</label>
                        <input type="text" name="obat" class="form-control" id="obat" value="<?php echo $val['nama_obat']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" value="<?php echo $val['stock']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga" value="<?php echo $val['harga']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi"><?php echo $val['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gudang" class="form-label">Gudang</label>
                        <select name="gudang" id="gudang">
                            <option value="disabled">Pilih</option>
                            <?php
                            require_once "../config.php";
                            $sql = "select * from gudang";
                            $query = mysqli_query($conn, $sql);

                            foreach ($query as $val) {
                            ?>
                                <option value="<?php echo $val['id_gudang'] ?>"><?php echo $val['nama_gudang'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>