<div class="gallery-image row">
    @foreach($postings as $keyPosting => $posting)
    <div class="col-md-4">

        <div class="card border-left-primary" style="margin: 10px;">
            <div class="card-body d-flex justify-content-center">
                <div class="img-box" data-url-preview-image="{{route('posting.preview-image', ['posting_id' => $posting->id])}}">
                    <img src="{{$posting->image}}" alt=""/>
                    <div class="transparent-box">

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span><b>{{$posting->user->username}}</b></span>
                <p class="opacity-low">{{$posting->caption}}</p>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <div class="p-2 ">
                        @if(count($posting->like) > 0)
                        <a class="dislike"
                            style="cursor: pointer;"
                            data-url-like="{{route('posting.like', ['posting_id' => $posting->id])}}"
                            data-url-dislike="{{route('posting.dislike', ['posting_id' => $posting->id])}}"
                        >
                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>Dislike
                        </a>
                        @else
                        <a class="like"
                            style="cursor: pointer;"
                            data-url-like="{{route('posting.like', ['posting_id' => $posting->id])}}"
                            data-url-dislike="{{route('posting.dislike', ['posting_id' => $posting->id])}}"
                        >
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>Like
                        </a>
                        @endif
                    </div>

                    <div class="p-2 ">
                        @if($posting->user->enable_comment == 1)
                        <a
                            class="comment"
                            style="cursor: pointer;"
                            data-url-comment="{{route('posting.comment', ['posting_id' => $posting->id])}}"
                        >
                            Comment ({{count($posting->comments)}})
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
