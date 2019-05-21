<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://client.lab993.com/js/jquery.js"></script>
    <title>信息详情</title>
</head>
<body>
    <table class="table table-bordered">
        <tr>
            <td>编号</td>
            <td>企业名称</td>
            <td>法人代表</td>
            <td>税务号</td>
            <td>对公账号</td>
            <td>营业执照</td>
            <td>操作</td>
        </tr>
        @foreach($arr as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->firmname}}</td>
            <td>{{$v->username}}</td>
            <td>{{$v->number}}</td>
            <td>{{$v->account}}</td>
            <td><img src="/{{$v->business_license}}" width="50" height="40"></td>
            <td user_id="{{$v->id}}">
                @if($v->status == 0)
                    <a href="javascript:;" class="aggree">审批</a>
                    <a href="javascript:;" class="notice">驳回</a>
                @elseif($v->status == 1)
                    <font color="green">已通过</font>
                @else
                    <font color="red">已驳回</font>
                @endif
            </td>
        </tr>
            @endforeach
    </table>
    <script>
        $(function(){

            // 审批
            $('.aggree').click(function(){
                var _this = $(this);
                var id = $(this).parent().attr('user_id');
                $.post(
                    '/admin/userInfo/operation',
                    {id:id,type:1},
                    function(res){
                       if(res.msg == '审批成功'){
                            _this.parent().html("<font color='green'>已通过</font>");
                       }
                    },
                    'json'
                );
            });

            // 驳回
            $('.notice').click(function(){
                var id = $(this).parent().attr('user_id');
                var _this = $(this);
                $.post(
                    '/admin/userInfo/operation',
                    {id:id,type:2},
                    function(res){
                        if(res.msg == '驳回成功'){
                            _this.parent().html("<font color='red'>已驳回</font>")
                        }
                    },
                    'json'
                );
            });
        });
    </script>
</body>
</html>