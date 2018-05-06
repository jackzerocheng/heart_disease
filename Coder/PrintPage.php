<?php

/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/6
 * Time: 下午6:57
 */
require_once ("../Library/jpgraph/src/jpgraph.php");
require_once ("../Library/jpgraph/src/jpgraph_line.php");

class PrintPage
{
    private $arrData;  //绘制图形数据
    private $width;   //图形宽度
    private $height; //图形高度
    private $xTickLabel;   //  x轴下方显示数据
    private $title = '数值与数据分布图'; //图形标题
    private $scale = 'textlin';   //设置刻度样式
    private $imgMargin = [60,30,30,70];   //设置图像边框
    private $valueColor = 'red';   //数值的颜色
    private $xtitle = '数值'; // x轴名称
    private $ytitle = ' 数量'; // y轴名称

    //初始化
    public function _construct($arrData,$width,$height,$xTickLabel){
        this.$arrData = $arrData;
        this.$width = $width;
        this.$height = $height;
        this.$xTickLabel = $xTickLabel;
    }

    //绘制折线图
    public function printLinechart(){
        $graph = new Graph(500,300);
        $graph->SetScale("textlin");
        $graph->SetShadow();
        $graph->img->SetMargin(60,30,30,70); //设置图像边距

        $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效

        $lineplot1=new LinePlot($this->arrData); //创建设置两条曲线对象
        $lineplot1->value->SetColor("red");
        $lineplot1->value->Show();
        $graph->Add($lineplot1);  //将曲线放置到图像上

        $graph->title->Set("CDN流量图");   //设置图像标题
        $graph->xaxis->title->Set("月份"); //设置坐标轴名称
        $graph->yaxis->title->Set("流 量(Gbits)");
        $graph->title->SetMargin(10);
        $graph->xaxis->title->SetMargin(10);
        $graph->yaxis->title->SetMargin(10);

        $graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $gDateLocale = new DateLocale();
        $graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());

        $graph->Stroke();  //输出图像
    }

    //绘制柱状图
    public function printHistogram(){
        $graph = new Graph(500,300);  //创建新的Graph对象
        $graph->SetScale("textlin");  //刻度样式
        $graph->SetShadow();          //设置阴影
        $graph->img->SetMargin(40,30,40,50); //设置边距

        $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效

        $barplot = new BarPlot($this->arrData);  //创建BarPlot对象
        $barplot->SetFillColor('blue'); //设置颜色
        $barplot->value->Show(); //设置显示数字
        $graph->Add($barplot);  //将柱形图添加到图像中

        $graph->title->Set("CDN流量图");
        $graph->xaxis->title->Set("月份"); //设置标题和X-Y轴标题
        $graph->yaxis->title->Set("流 量(Mbits)");
        $graph->title->SetColor("red");
        $graph->title->SetMargin(10);
        $graph->xaxis->title->SetMargin(5);
        $graph->xaxis->SetTickLabels($this->xTickLabel);

        $graph->title->SetFont(FF_SIMSUN,FS_BOLD);  //设置字体
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);

        $graph->Stroke();
    }

    //绘制饼图
    public function printPie(){
        $graph = new PieGraph(550,500);
        $graph->SetShadow();

        $graph->title->Set("CDN流量比例");
        $graph->title->SetFont(FF_SIMSUN,FS_BOLD);

        $pieplot = new PiePlot3D($this->arrData);  //创建PiePlot3D对象
        $pieplot->SetCenter(0.4, 0.5); //设置饼图中心的位置
        $gDateLocale = new DateLocale();
        $pieplot->SetLegends($gDateLocale->GetShortMonth()); //设置图例

        $graph->Add($pieplot);
        $graph->Stroke();
    }
}

?>