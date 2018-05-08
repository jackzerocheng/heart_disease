<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>数据处理</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/demo.css" />
    <link rel="stylesheet" href="css/templatemo-style.css">

    <script type="text/javascript" src="js/modernizr.custom.86080.js"></script>

</head>

<body>

<div id="particles-js"></div>

<ul class="cb-slideshow">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>
<div class="container-fluid">
    <div class="row cb-slideshow-text-container ">
        <div class= "tm-content col-xl-6 col-sm-8 col-xs-8 ml-auto section" style="margin: auto">
            <div style="height: 100px;"></div>
            <div>
                <header class="mb-5"><h1 style="color: #fdfffd;">数据操作 </h1></header>
                <button type="button" class="tm-btn-subscribe" onclick="javascript:window.location.href='./index.html'">首页</button>
                <button type="button" class="tm-btn-subscribe" onclick="javascript:window.location.href='./dataDeal.php'">数据下载</button>
                <button type="button" class="tm-btn-subscribe" onclick="javascript:window.location.href='./dataDeal.php'">生成SQL</button>
                <button type="button" class="tm-btn-subscribe" onclick="javascript:window.location.href='./dataDeal.php'">导入SQL</button>
                <button type="button" class="tm-btn-subscribe" onclick="javascript:window.location.href='./dataDeal.php'">数据查看</button>
            </div>
            <div style="height: 50px;"></div>
            <header class="mb-5"><h1 style="color: #fdfffd;">数据集介绍 </h1></header>
            <table style="color: #fdfffd;font-size: large;border-collapse:separate; border-spacing:0px 10px;" cellpadding="10" cellspacing="10">
                <thead>
                <tr>
                    <th>字段名</th>
                    <th style="text-align:center">含义</th>
                    <th style="text-align:right">类型</th>
                    <th style="text-align:right">描述</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>age</td>
                    <td style="text-align:center">年龄</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">对象的年龄，数字表示</td>
                </tr>
                <tr>
                    <td>sex</td>
                    <td style="text-align:center">性别</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">对象的性别，female和male</td>
                </tr>
                <tr>
                    <td>cp</td>
                    <td style="text-align:center">胸部疼痛类型</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">痛感由重到无typical、atypical、non-anginal、asymptomatic</td>
                </tr>
                <tr>
                    <td>trestbps</td>
                    <td style="text-align:center">血压</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">血压数值</td>
                </tr>
                <tr>
                    <td>chol</td>
                    <td style="text-align:center">胆固醇</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">胆固醇数值</td>
                </tr>
                <tr>
                    <td>fbs</td>
                    <td style="text-align:center">空腹血糖</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">血糖含量大于120mg/dl为true，否则为false</td>
                </tr>
                <tr>
                    <td>restecg</td>
                    <td style="text-align:center">心电图结果</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">是否有T波，由轻到重为norm、hyp</td>
                </tr>
                <tr>
                    <td>thalach</td>
                    <td style="text-align:center">最大心跳数</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">最大心跳数</td>
                </tr>
                <tr>
                    <td>exang</td>
                    <td style="text-align:center">运动时是否心绞痛</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">是否有心绞痛，true为是，false为否</td>
                </tr>
                <tr>
                    <td>oldpeak</td>
                    <td style="text-align:center">运动相对于休息的ST depression</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">st段压数值</td>
                </tr>
                <tr>
                    <td>slop</td>
                    <td style="text-align:center">心电图ST segment的倾斜度</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">ST segment的slope，程度分为down、flat、up</td>
                </tr>
                <tr>
                    <td>ca</td>
                    <td style="text-align:center">透视检查看到的血管数</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">透视检查看到的血管数</td>
                </tr>
                <tr>
                    <td>thal</td>
                    <td style="text-align:center">缺陷种类</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">并发种类，由轻到重norm、fix、rev</td>
                </tr>
                <tr>
                    <td>status</td>
                    <td style="text-align:center">是否患病</td>
                    <td style="text-align:right">string</td>
                    <td style="text-align:right">是否患病，buff是健康、sick是患病</td>
                </tr>
                </tbody>
            </table>
            <div style="height: 50px;"></div>
        </div>
    </div>
</body>

<script type="text/javascript" src="js/particles.js"></script>
<script type="text/javascript" src="js/app.js"></script>
</html>