<div class="mt-3">
    @if ($post->comments->isNotEmpty())
        <ul class="list-group">
            <hr>
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>&nbsp;
                    <p class="d-inline fw-light">{{ $comment->body }}</p>


                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <span class="text-muted text-uppercase xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                        {{-- If the AUTH USER is the owner of the comment, show a delete button --}}
                        @if (Auth::user()->id === $comment->user->id)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent p-0 xsmall">Delete</button>
                        @endif
                    </form>

                </li>
            @endforeach

            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small"> View All {{ $post->comments->count() }} comments</a>
                </li>
            @endif

        </ul>
    @endif


    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm" title="post"><i class="fa-regular fa-paper-plane"></i></button>
        </div>
        @error('comment_body' . $post->id)
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>


</div>





