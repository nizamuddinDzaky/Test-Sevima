<div class="modal-header">
    <h5 class="modal-title">
        <b>{{$posting->user->username}}</b>
        <br>
        <span>{{$posting->caption}}</span>
    </h5>
</div>
<div class="modal-body">
    @foreach($posting->comments as $comment)
    <div class="card mb-1">
        <div class="card-header">
            {{$comment->user->username}}
        </div>
        <div class="card-body">
            <p class="card-text">{{$comment->comment}}</p>
        </div>
    </div>
    @endforeach

</div>
<div class="modal-footer">
    <form action="{{route('posting.comment.post', ['posting_id' => $posting->id])}}" style ="width:100%" method ="POST" id ='form-comment'>
        @csrf
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Comment</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Send Comment</button>
    </form>
</div>
