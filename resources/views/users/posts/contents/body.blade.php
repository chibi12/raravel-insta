{{-- Clickable image --}}
<div class="container p-0">
    <a href="{{ route('post.show', $post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>
<div class="card-body">
    {{-- Heart button + no. of likes + categories --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if($post->isLiked())
            <form action="{{route('like.destroy',$post->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-solid fa-heart text-danger"></i></button>
            </form>
            @else
            <form action="{{route('like.store',$post->id)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
            </form>
            @endif

            
        </div>
        <div class="col px-0">
            <span>{{$post->likes->count()}}</span>
        </div>
        <div class="col text-end">
            
            @forelse ($post->categoryPost as $category_post)
                <div class="badge bg-secondary bg-opacity-50">
                    {{ $category_post->category->name }}
                </div>
            @empty
            <div class="badge bg-dark text-wrap">Uncategorized</div>
            @endforelse
        </div>
    </div>

    {{-- Owner of the post + description of the post --}}
    <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>&nbsp;
    <p class="d-inline fw-light">{{ $post->description }}</p>
    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>

    {{-- 
        date(arg1, arg2)
        date('M d, Y', created_at)  --> the date and time the post is created
        Output: February 13, 2025
    --}}


    {{-- Comments --}}
    @include('users.posts.contents.comments')
</div>








