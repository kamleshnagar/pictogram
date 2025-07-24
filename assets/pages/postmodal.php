<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <img src="" id="post_img" style="display:none" class="w-100 rounded border">
        <form method="POST" action="assets/php/actions.php?addpost" enctype="multipart/form-data">
            <div class="my-3">
                <input class="form-control" name="post_img" type="file" id="select_post_img">
                 <div id="post_img_error" class="text-danger mt-2 small"></div>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
                <textarea name="post_text" class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
            </div>
    </div>
    <button type="submit" on=submit class="btn btn-primary">Post</button>
    </form>
</div>


