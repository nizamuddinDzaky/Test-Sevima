<div class="modal-header">
    <h5 class="modal-title">Add Posting <b></b></span></h5>
</div>
<div class="modal-body">
    <input type="hidden" id="invoice-order-id" value="">
    <form action="{{route('posting.store')}}" id="form" method="POST">
    @csrf
        <div class="preview">
            <img id="img-preview"src="{{asset('assets/image/profile-icon.png') }}"/>
    
            <label class="label-upload-image" for="file-input">Upload Image</label>
            <input accept="image/*" type="file" id="file-input" name="image"/>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Caption</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="caption"></textarea>
        </div>
        <button data-url-save-payment = "" type="submit" class="btn btn-success" id="btn-save-payment"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Add Posting</button>
    </form>
</div>