@extends('layout')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid" >

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <!-- Card Body -->
                <div class="card-body">
                    <div class="profile">

                        <div class="profile-image">
                            <img src="{{$user->photo_profile ?? asset('assets/image/profile-icon.png') }}" alt="">
                        </div>

                        <div class="profile-user-settings">

                            <h1 class="profile-user-name">{{$user->username}}</h1>

                            <button class="btn profile-edit-btn" data-url="{{route('update-profile')}}">Edit Profile</button>

                            <button class="btn profile-settings-btn" aria-label="profile settings"><i class="fas fa-cog" aria-hidden="true"></i></button>

                        </div>

                        <div class="profile-stats">

                            <hr>
                            <div class="profile-bio">

                                <p><span class="profile-real-name">{{$user->name}}</span> <br> {{$user->bio}}</p>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @include('posting.grid')

</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.profile-edit-btn').click(async function(){
            let res = await httpRequest($(this).data('url'), 'GET')
            $('#modal-content').html(res.data)
            $('#modal').modal('show');
        })

        const input = document.getElementById("file-input");
        // console.log(input);

        $(document).on('change', '#file-input', function(e){
            const image = document.getElementById("img-preview");
            if (e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                image.src = src;
            }

        })
        // input.addEventListener("change", (e) => {
        // });
    })
</script>
@endsection
@section('css')
<style>
</style>
@endsection
