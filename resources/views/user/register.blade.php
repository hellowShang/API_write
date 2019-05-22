<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
    <h1>企业微信注册</h1>
    <form action="comregisterDo" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td>企业名称</td>
                <td><input type="text" name="firmname"></td>
            </tr>
            <tr>
                <td>法人代表</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>税务号</td>
                <td><input type="text" name="number"></td>
            </tr>
            <tr>
                <td>对公账号</td>
                <td><input type="text" name="account"></td>
            </tr>
            <tr>
                <td>营业执照</td>
                <td><input type="file" name="business_license"></td>
            </tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" value="提交信息"></td>
            </tr>
        </table>
    </form>
</body>
</html>