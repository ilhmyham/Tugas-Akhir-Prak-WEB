<div class="modal fade" id="exampleModal2<?php echo $val['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="updateuser.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $val['id'] ?>">
                    <div class="mb-3">
                        <label for="User" class="form-label">Nama User</label>
                        <input type="text" name="user" class="form-control" id="User" value="<?php echo $val['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">status</label>
                        <input type="text" name="status" class="form-control" id="status" value="<?php echo $val['status']; ?>" required>
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