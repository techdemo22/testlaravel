@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Edit Post</h3>
            <div class="card mt-3">
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="posted">Post Date</label>
                            <input type="date" name="posted" value="" class="form-control" id="posted" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="is_draft" value="1" class="form-check-input" id="is_draft">
                            <label class="form-check-label" for="is_draft">Draft</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="is_members_only" value="1" class="form-check-input" id="is_members_only">
                            <label class="form-check-label" for="is_members_only">Members Only</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
