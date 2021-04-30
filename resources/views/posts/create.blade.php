<div class="modal fade" id="add-post" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="async" action="{{ route('create-post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" name="title" placeholder="Post title" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <input type="text" onfocus="this.type='file'" name="imageFile" placeholder="Image" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea name="body" rows="7" placeholder="Post body" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user->uuid }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>