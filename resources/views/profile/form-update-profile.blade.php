<div class="modal-header">
    <h5 class="modal-title">Update Profile <b></b></span></h5>
</div>
<div class="modal-body">
    <input type="hidden" id="invoice-order-id" value="">
    <form action="{{route('update-profile-post')}}" id="form" method="POST">
    @csrf
        @foreach($config as $conf)
        @if($conf->type == 'image')
        <div class="preview">
            <img id="img-preview"src="{{$user->photo_profile ?? asset('assets/image/profile-icon.png') }}"/>
    
            <label class="label-upload-image" for="file-input">{{$conf->title}}</label>
            <input accept="image/*" type="file" id="file-input" name="{{$conf->type}}"/>
        </div>
        @elseif($conf->type == 'textarea')
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">{{$conf->title}}</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="{{$conf->type}}">{{$user->bio}}</textarea>
        </div>
        @elseif($conf->type == 'checkbox')
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="{{$conf->type}}" {{$user->enable_comment == '1' ? 'checked' : ''}}>
                <label class="form-check-label" for="flexCheckDefault">
                {{$conf->title}}
                </label>
            </div>
        </div>
        @endif
        @endforeach
        <button data-url-save-payment = "" type="submit" class="btn btn-success" id="btn-save-payment"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Update Profile</button>
    </form>
</div>
<div class="modal-footer">
    
</div>