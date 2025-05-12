@extends('layouts.app')

@section('title','Admin: Posts')

@section('contents')
  <table class="table table-hover bg-white align-middle border text-secondary">
    <thead class="table-primary text-secondary small">
      <tr>
        <th></th>
        <th></th>
        <th>CATEGORY</th>
        <th>OWNER</th>
        <th>CREATED AT</th>
        <th>STATUS</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($all_posts as $post)
          
          <tr>
            <td class="text-end">{{$post->id}}</td>
            <td>
              <a href="{{route('post.show',$post->id)}}">
                <img src="{{$post->image}}" alt="post id{{$post->id}}" class="d-block mx-auto img-lg" style="width: 300" height="300">
              </a>
            </td>
            <td>
              <div class="col text-end">
                @forelse ($post->categoryPost as $category_post)
                    <div class="badge bg-secondary bg-opacity-50">
                        {{ $category_post->category->name }}
                    </div>
                @empty
                <div class="badge bg-dark text-wrap">Uncategorized</div>
                @endforelse
            </div>
            </td>
          <td>
            <a href="{{route('profile.show',$post->user->id)}}" class="text-dark text-decoration-none">{{$post->user->name}}</a>
          </td>
          <td>{{$post->created_at}}</td>
          <td>
            @if ($post->trashed())
            <i class="fa-solid fa-circle-minus text-secondary"></i>&nbsp;Hidden
            @else
            <i class="fa-solid fa-circle text-primary"></i>&nbsp;Visible
            @endif
          </td>
          <td>
            <div class="dropdown">
              <button class="btn btn-sm" data-bs-toggle="dropdown">
                <i class="fa-solid fa-ellipsis"></i>
              </button>
              
                @if ($post->trashed())
                <div class="dropdown-menu">
                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bd-target="#hide-post{{$post->id}}">
                  <i class="fa-solid fa-eye"></i>Unhide Post{{$post->id}}
                </button>
              </div>
                @else
                <div class="dropdown-menu">
                  <button class="drop-down-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                    <i class="fa-solid fa-eye-slash"></i>Hide Post{{$post->id}}
                  </button>
                </div>
                @endif
              </div>
            </div>
          @include('admin.posts.modals.status')
          </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="lead text-muted text-center">No posts yet.</div>
          </tr>
      @endforelse
    </tbody>
  </table>
  {{$all_posts->links()}}
@endsection