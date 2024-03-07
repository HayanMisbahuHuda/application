@extends('layouts.app')

@section('content')

<div class="text-center album-header">
    <div class="col-lg-6 col-md-8 mx-auto">
        <h5 class="fw-light text-capitalize">{{ $album->title }} </h5>
        <p class="lead text-body-secondary text-capitalize">{{ $album->description }}</p>
        <div class="text-center mt-2">
        @if (Auth::guest() || Auth::user()->id !== $album->user_id)
                <p></p>
                @else (Auth::user()->id === $album->user_id)
            <button data-toggle="modal" data-target="#uploadImage" class="btn--primary">
            <i class="fas fa-upload"></i>  Upload Image</button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Post-->
<div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-background"> 
            <div class="text-center pt-3">
                <!-- <h5 class="modal-title" id="modalLongTitle">Input Image Data</h5>  -->
            </div>
            <div class="modal-body">
                <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="album-id" value="{{ $album->id }}">
                    <div class="form-group">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <input maxlength="225" type="text" id="judul" name="title" class="form-control" placeholder="Title...."required>
                    </div>
                    <div class="form-group">
                        <textarea maxlength="225" name="description" class="form-control" placeholder="Description...." required></textarea> 
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-2">Upload Now</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Modal -->   

@if (count($album->posts) > 0)
<div class="container body-post container-rev">
    @foreach($album->posts as $post)
    <div class="box box-foto">
        <a href="#{{$post->id}}" data-toggle="modal">
            <img src="{{asset('images/'.$post->image)}}">
        </a>
        <div class="post-footer">
            <div class="button-footer">
                <a class="fas fa-comment btnCom" href="#{{$post->id}}" data-toggle="modal"></a>
                <span class="fa fa-heart btnLike {{$post->YouLiked()?'liked-btn':'unliked-btn'}}" onclick="postlike1('{{$post->id}}',this)"></span>
                <span class="number btn btn-default btn-xs" id="{{$post->id}}-count">{{$post->likes()->count()}}</span>
                <div class="text-end">
                @if (Auth::guest() || Auth::user()->id !== $post->user_id)
                <p></p>
                @else (Auth::user()->id === $post->user_id)
                    <form action="{{ route('post-destroy' , ['id' => $post->id] ) }}" method="post" class="form-dlt">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-toggle="modal" data-target="#konfirmasiDelete,{{$post->id}}" class="btn-delete btn-danger float-right">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <div class="form-edit mb-2">
                        <button data-toggle="modal" data-target= "#edit,{{$post->id}}" class="btn--edit">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiDelete,{{$post->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body text-center" style="font-size:20px;">
                Delete this post?
            </div>
            <div class="modal-footer text-center" style="justify-content: center !important;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="{{ route('post-destroy' , ['id' => $post->id] ) }}" method="post">
                @csrf
                @method('DELETE')
                    <button type="submit" name="button" class="btn btn-danger">DELETE</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Komen -->
    <div class="modal fade" id="{{$post->id}}">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-comment">
                    <div class="show_modal_image text-center">
                        <a href="">
                            <img src="{{asset('images/'.$post->image)}}">
                        </a>
                    </div>
                    <div class="desc-post">
                        <h4>{{$post->title}}</h4>    
                        {{$post->description}}                                                                 
                    </div>
                    <div class="modal-footer" style="background-color: #2d3744; border: none; border-radius: 12px;flex-wrap:nowrap !important;">
                        <div class="comment-time">
                            <span class="user-info">by {{$post->user->name}}</span>
                        </div>
                        <div class="comment-time">
                            <span class="user-time text-end">
                                <i class="fa fa-clock"></i> {{$post->created_at}}
                            </span>
                        </div>
                    </div>
                    <br>
                    <form action="{{route('addComment', $post->id)}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea type="text" name="content" class="form-control" placeholder="Comment here..." maxlength="225" style="background-color: #818599;"></textarea>
                        </div>
                        <div class="text-center mt-2">
                        @if (Auth::guest())
                        <button class="btn mt-2 btn-primary" type="submit">Login to comment</button>
                        @else (Auth::user()->id === $users->user_id)
                            <button class="btn mt-2 btn-primary" type="submit">Comment</button>
                            @endif
                        </div>
                    </form>
                    <hr>
                    <div class="comment-list">
                        @if($post->comments->isEmpty())
                        <div class="text-center">Tidak Ada Komentar!</div>
                        @else
                        @foreach($post->comments as $comment)
                        
                        <div class="comment-body">
                        Comment :
                            <small><P>{{$comment->content}}</P></small>
                            <div class="comment-info">
                                <span class="text-end">
                                <span>
                                    <small>by {{$comment->user->name}}</small> |
                                </span>
                                <small>{{$comment->created_at->diffForHumanS()}}</small>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="edit,{{$post->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"> 
                <div class="text-center pt-3">
                    <!-- <h5 class="modal-title" id="modalLongTitle" style="font-family: serif;">Edit Image Data</h5>  -->
                </div>
                <div class="modal-body">
                    <form action="{{route('post-update', $post->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="album-id" value="{{ $post->album_id }}">
                        <div class="form-group text-center">
                            <input type="file" name="image" class="form-control" value="{{ $post->image }}">
                            <img src="{{asset('images/'.$post->image)}}" width="100px" height="100%" class="mt-2">
                                <input class="text-center" type="text" name="image" class="form-control" value="{{ $post->image }}" disabled>
                            </img>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="">Title</label>
                            <input type="text" id="judul" name="title" value="{{ $post->title }}" class="form-control" placeholder="Title...."required>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <input name="description" class="form-control" value="{{ $post->description }}" required></input> 
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-2">Update Now</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
    <div class="text-center mt-5">
        <h3>No photos yet..</h3>
    </div>
@endif
@endsection

<style type="text/css">

    .form-dlt{
        display: contents !important;
    }
    .box-foto{
        position: relative;
    }

    .btn-delete {
        background-color: transparent !important;
        border: none;
        color: red;
        position: absolute;
        top: 42%;
        right: 1%;
    }

    .number {
        color: white !important;
    }

    .liked-btn{
        color:red !important;
    }

    .unliked-btn{
        color:grey !important;
    }

    .form-edit{
        display: contents;
    }

    .btn--edit{
        border-radius: 99em;
        background-color: transparent;
        background-image: transparent;
        color: #3772ff;
        border: none;
        position: absolute;
        top: 42%;
        right: 10%;
    }

    .btn--primary {
        border-radius: 99em;
        background-color: #3772ff;
        background-image: #3772ff;
        color: #ffff;
        padding: 0 1.375em;
        padding: 6px 1.375em;
        border: none;
    }

    .show_image img{
        width: 100%;
        height: 30%;
    }

    .post-footer{
        padding: 0px;
        padding-top: 13;
        padding-bottom: 0;
        position: relative;
    }

    .modal-body{
        /* background-color: #212529; */
        color: white;
        padding: 20px !important;
        
        
    }

    .modal-comment
    {
        background-color: #212529;
        color: white;
        padding: 20px !important;
    }

    .show_modal_image img{
        width: 400;
        height: 100%;
        border-radius: 15px;
        
    }

    .btnLike{
        color: grey;
    }

    .btnCom{
        color: grey;
        margin-right: 0.75rem;
    }
    .desc-post{
        padding : px;
        margin-bottom: 22px !important;
        margin-top: 22px !important;
        text-align: center;

    }
    .comment-body{
        background-color: #2d3744;
        color: #ffff;
        padding: 16px;
        border-radius:15px;
        margin-bottom: 10px;
    }
    .comment-body p{
        font-size: 17px;
        margin-bottom: 10px;
        border-bottom: 1px solid #eee;
        border-bottom-color: grey;
        border-width: 1px;
    }

    .comment-time{
        width:50%;
        align-items: flex-end; 
        display: grid;
    }

    .body-post{
        width: 100%;
        margin: 20px auto;
        columns: 4;
        column-gap: 20px;
        padding: 0 20px;
    }

    .body-post .box {
        width: 100%;
        margin-bottom: 10px;
        break-inside: avoid;
    }

    .body-post .box img{
        max-width: 100%;
        border-radius: 15px;
    }

    .container-rev{
        margin-left: 0 !important;
        margin-right: 0 !important;
        max-width: 100% !important;
        padding: 0 20px !important;
    }

    .album-header{
        background-color: #212529;
        color : white;
        padding-top: 1rem ;
        padding-bottom: 1rem ;
        
    }
    
    .album-header p{
        color : white !important;
        font-size: 15px;
        

    }

</style>

@section('js')
<script type="text/javascript">
    function postlike1(postId, elem){
        var csrfToken = '{{csrf_token()}}';
        var likeCount = parseInt($('#'+postId+"-count").text());

        $.post("{{ route('postlike') }}", {postId:postId,_token:csrfToken}, function (data){
            console.log(data);
            if(data.message==='liked'){
                $('#'+postId+"-count").text(likeCount+1);
                $(elem).addClass('liked-btn');
            }else{
                $('#'+postId+"-count").text(likeCount-1);
                $(elem).addClass('unliked-btn');
            }
            });
            location.reload(true)
        
    }
    // console.log(jQuery().jquery);

</script>
@endsection


