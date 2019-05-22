@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>欢迎登陆</p><button id="sign">签到</button>
                    <p>今日签到人数：<span id="count"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="http://client.lab993.com/js/jquery.js"></script>
<script>
    // 获取签到人数
    $.get(
        '/count',
        function(res){
            $('#count').html(res.num+'人');
        },
        'json'
    );

    $(function(){
        // 签到
        $('#sign').click(function(){
            $.get(
                '/sign',
                function(res){
                    alert(res.msg);
                },
                'json'
            );
        });


    });
</script>
