@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Auth::user() != null)
            <div class="profile">
                <div class="text-center" id="datetime"></div>
                <div class="wlc-text text-center">Welcome, {{Auth::user()->name}}</div>
                <div class="create-btn text-center mt-2">
                    <button data-toggle="modal" data-target="#uploadImage" class="btn--primary "><i class="fas fa-upload"></i>  Create Album</button>
                </div>
            </div>
            @else
            <div class="profile">
                <div class="text-center" id="datetime"></div>
                <div class="wlc-text text-center">Welcome, Guest</div>
                
            </div>
            @endif
            <br>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"> 
                <!-- <div class="text-center pt-3"> -->
                    <!-- <h5 class="modal-title mb-1" id="modalLongTitle">Input Album Data</h5>  -->
                <!-- </div> -->
                <div class="modal-body">
                    <form action="{{route ('album-store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <!-- <label for="cover-image">Cover Image</label> -->
                            <input type="file" name="cover-image" class="form-control">
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <!-- <label for="title">Title</label> -->
                            <input maxlength="225" type="text" id="title" name="title" class="form-control text-lowercase" placeholder="Title...." required>
                        </div>
                        <div class="form-group">
                            <!-- <label for="description">Description</label> -->
                            <textarea maxlength="225" id="description" name="description" class="form-control" placeholder="Description...." required></textarea> 
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-2">Create Now</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Modal -->   
    
    @if (count($albums) > 0)
    <div class="row row-cols-4 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach ($albums as $album)
        <div class="col">
            <div class="card shadow-sm">
                <a class="btn-view" href="{{ route('album-show', $album->id) }}">
                    <div class="card-body">
                        <div class="overlay-container mb-3">
                            <img class="img-album" src="storage/album_covers/{{ $album->image }}" alt="{{ $album->image }}" width="100%" height="225px">
                            <div class="overlay">
                                <div class="text-overlay"><i class="fa fa-search btnView"></i></div>
                            </div>
                        </div>
                        <h3 class="judul-album text-capitalize">{{ $album->title }}</h3>
                        <small class="time-album">{{$album->created_at->diffForHumanS()}}</small>
                        <p class="card-text text-line mt-2">{{ $album->description }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center mt-5">
        <h3>No albums yet..</h3>
    </div>
    @endif
</div> 


@endsection

<style type="text/css">

    .profile {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding: 1rem;
        width: 100%;
        background-color: #1b2028;
        border-radius: 16px;
        position: relative;
        border: 3px solid transparent;
        background-clip: padding-box;
        text-align: center;
        color: #f1f3f3;
        background-image: linear-gradient(
            135deg,
            rgba(#752e7c, 0.35),
            rgba(#734a58, 0.1) 15%,
            #1b2028 20%,
            #1b2028 100%
        );
        &:after {
            content: "";
            display: block;
            top: -3px;
            left: -3px;
            bottom: -3px;
            right: -3px;
            z-index: -1;
            position: absolute;
            border-radius: 16px;
            background-image: linear-gradient(
                135deg,
                #752e7c,
                #734a58 20%,
                #1b2028 30%,
                #2c333e 100%
            );
        }
    }

    .wlc-text{
        font-size: 30px;
        font-weight: bold;
    }

    .btn--primary {
        border-radius: 99em;
        background-color: #3772ff;
        background-image: linear-gradient(135deg, #5587ff, #3772ff);
        color: #fff;
        padding: 0 1.375em;
        padding: 6px 1.375em;
        border: none;
    }

    .text-line{
        -webkit-line-clamp: 3;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden; 
        height: 70px;
    }

    .judul-album{
        border-left: 3px solid #76317b;
        padding-left: 12px;
        font-weight: bold !important;
        color: white;
    }

    .time-album{
        color: rgba(255,255,255,0.6);
    }

    .btn-view{
        text-decoration: none;
        color: black;
    }

    .img-album{
        border-radius: 0.575rem;
    }

    .btnView{
        color: white;
        height: 2em !important;
        width: 2em !important;
    }

    .overlay-container{
        position: relative;
        border-color:none;
        
    }

    .overlay-container:hover .overlay {
        opacity: 1;
    }

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: rgba(0,0,0,0.6);
        border-radius: 0.575rem;
    }

    .text-overlay {
        color: black;
        font-weight: bold;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>

@section('js')
<script type="text/javascript">

    // Get current date and time
    var now = new Date();
    var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];

    // Insert date and time into HTML
    document.getElementById("datetime").innerHTML = ((monthNames[now.getMonth()])) +" "+ (("0"+now.getDate()).slice(-2)) +", "+ (now.getFullYear());

</script>
@endsection


