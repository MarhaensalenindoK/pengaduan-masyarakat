<div class="modal fade" id="updatePengaduan" tabindex="-1" role="dialog" aria-labelledby="Update Pengaduan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePengaduanTitle">Update Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="basic-form" novalidate>
                    <input type="hidden" name="pengaduan_id">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label class="fancy-radio custom-color-green">
                                        <input name="status" value="todo" type="radio" checked>
                                        <span>
                                            <i></i>Sedang dilakukan
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div>
                                    <label class="fancy-radio custom-color-green">
                                        <input name="status" value="inprogress" type="radio">
                                        <span>
                                            <i></i>Sedang berlangsung
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="justify-content-center">
                                    <label class="fancy-radio custom-color-green">
                                        <input name="status" value="done" type="radio">
                                        <span>
                                            <i></i>Selesai
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-round btn-primary" onclick="updatePengaduan()">Update</button>
            </div>
        </div>
    </div>
</div>
