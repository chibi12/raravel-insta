{{--Hide Post--}}
<div class="modal fade id="hide-post-{{$post->id}}">
  <div class="modal-content border-danger">
    <div class="modal-header border-danger">
      <h5 class="modal-title text-danger">
        <i class="fa-solid fa-eye-slash"></i>Hide Post
      </h5>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to hide this post?</p>
      <div class="mt-3">
        <img src="{{$post->image}}" alt="post id{{$post->id}}" class="img-lg">
        <p class="mt-1 text-muted">{{$post->description}}</p>
      </div>
    </div>
    <div class="modal-footer border-0">
      <form action="#" method="post">
        @csrf
        @method('DELETE')
        <button type="button btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit btn tn-danger btn-sm">Hide</button>
      </form>
    </div>
  </div>
</div>
{{--Unhide post--}}
<div class="modal fade" id="unhide-post-{{$post->id}}">
  <div class="modal-content border-primary">
    <div class="modal-header border-primary">
      <h5 class="modal-title text-primary">
        <i class="fa-solid fa-eye"></i>Unhide Post
      </h5>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to unhide this post?</p>
      <div class="mt-3">
        <img src="{{$post->image}}" alt="post id{{$post->id}}" class="img-lg">
        <p class="mt-1 text-muted">{{$post->description}}</p>
      </div>
    </div>
    <div class="modal-footer border-0">
      <form action="{{route('admin,.posts.unhide',$post->id)}}" method="post">
        @csrf
        @method('PATCH')
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm">Unhide</button>
      </form>
    </div>
  </div>
</div>