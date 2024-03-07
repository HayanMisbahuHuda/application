@if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $errors)
                <li>{{$errors}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('message'))
    <div class="alert1 alert-success">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>Successfully 
    </div>
@endif

<style type="text/css">
    .alert {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        border-radius : 25px;
    }

    .alert1 {
    padding: 20px;
    background-color: #3772ff;
    color: white;
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
    }

    .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
    }

    .closebtn:hover {
    color: black;
}
</style>