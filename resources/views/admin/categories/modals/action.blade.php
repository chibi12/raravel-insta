{{-- Edit category--}}
<div class="modal fade" id="edit-category-{{$category->id}}">
  <div class="modal-dialog">
    <form action="{{route('admin.categories.update',$category->id)}}" method="post">
      @csrf
      @method('PATCH')
      <div class="modal-content border-warning">
        <div class="modal-header border-warning">
          <h3 class="h5 modal-title">
            <i class="fa-regular fa-pen-to-square"></i>Edit category
          </h3>
        </div>
        <div class="modal-body">
          <input type="text" name="new_name" class="form-control" placeholder="Category name" value="{{$category->name}}">
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit"class="btn btn-warning btn-s">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
{{--Delete category--}}
<div class="modal fade" id="edit-category-{{$category->id}}">
  <div class="modal-dialog">
    <form action="{{route('admin.categories.destroy',$category->id)}}" method="post">
      @csrf
      @method('DELETE')
      <div class="modal-content border-danger">
        <div class="modal-header border-danger">
          <h3 class="h5 modal-title">
            <i class="fa-regular fa-pen-to-square"></i>Delete category
          </h3>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete <span class="fw-bold{{$category->name}}"></span>category?</p>
          <p class="fw-light">This action will affect all posts under this category.Posts without category will fall under "Uncategorized"</p>
          <input type="text" name="new_name" class="form-control" placeholder="Category name" value="{{$category->name}}">
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit"class="btn btn-danger btn-s">Delete</button>
        </div>
      </div>
    </form>
  </div>
</div>