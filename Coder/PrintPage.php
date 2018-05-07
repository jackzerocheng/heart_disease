<?php

/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/6
 * Time: 下午6:57
 */
require_once ("../Library/jpgraph/src/jpgraph.php");
require_once ("../Library/jpgraph/src/jpgraph_line.php");
require_once ("../Library/jpgraph/src/jpgraph_bar.php");
require_once ("../Library/jpgraph/src/jpgraph_pie.php");
require_once ("../Library/jpgraph/src/jpgraph_pie3d.php");

class PrintPage
{
    private $arrData;  //绘制图形数据
    private $width;   //图形宽度
    private $height; //图形高度
    private $xTickLabel;   //  x轴下方显示数据
    private $title; //图形标题
    private $scale;   //设置刻度样式
    private $imgMargin;   //设置图像边框
    private $valueColor;   //数值的颜色
    private $xtitle; // x轴名称
    private $ytitle; // y轴名称

    //初始化
    function __construct(){
         $this->width = 500;
         $this->height = 300;
         $this->title = '数值与数据分布图';
         $this->scale = 'textlin';
         $this->imgMargin = [60,30,30,70];
         $this->valueColor = 'red';
         $this->xtitle = '数值';
         $this->ytitle = '数量';
    }

    //绘制折线图
    public function printLinechart($arrData,$width,$height,$xTickLabel,$color = 'red'){
        $this->imgMargin = [60,30,30,70];
        $graph = new Graph($width,$height);
        $graph->SetScale($this->scale);
        $graph->SetShadow();
        $graph->img->SetMargin($this->imgMargin[0],$this->imgMargin[1],$this->imgMargin[2],$this->imgMargin[3]); //设置图像边距

        $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效

        $lineplot1=new LinePlot($arrData); //创建设置两条曲线对象
        $lineplot1->value->SetColor($color);
        $lineplot1->value->Show();
        $graph->Add($lineplot1);  //将曲线放置到图像上

        $graph->title->Set($this->title);   //设置图像标题
        $graph->xaxis->title->Set($this->xtitle); //设置坐标轴名称
        $graph->yaxis->title->Set($this->ytitle);
        $graph->title->SetMargin(10);
        $graph->xaxis->title->SetMargin(10);
        $graph->yaxis->title->SetMargin(10);

        $graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);

        $graph->xaxis->SetTickLabels($xTickLabel);

        $graph->Stroke();  //输出图像
    }

    //绘制柱状图
    public function printHistogram($arrData,$width,$height,$xTickLabel,$color = 'blue'){
        $this->imgMargin = [40,30,40,50];
        $graph = new Graph($width,$height);  //创建新的Graph对象

        $graph->SetScale($this->scale);  //刻度样式
        $graph->SetShadow();          //设置阴影
        $graph->img->SetMargin($this->imgMargin[0],$this->imgMargin[1],$this->imgMargin[2],$this->imgMargin[3]); //设置边距

        $graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效

        $barplot = new BarPlot($arrData);  //创建BarPlot对象
        $barplot->SetFillColor($color); //设置颜色
        $barplot->value->Show(); //设置显示数字
        $graph->Add($barplot);  //将柱形图添加到图像中

        $graph->title->Set($this->title);
        $graph->xaxis->title->Set($this->xtitle); //设置标题和X-Y轴标题
        $graph->yaxis->title->Set($this->ytitle);
        $graph->title->SetColor($this->valueColor);
        $graph->title->SetMargin(10);
        $graph->xaxis->title->SetMargin(5);
        $graph->xaxis->SetTickLabels($xTickLabel);

        $graph->title->SetFont(FF_SIMSUN,FS_BOLD);  //设置字体
        $graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
        $graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);

        $graph->Stroke();
    }

    //绘制饼图
    public function printPie($arrData,$width,$height,$xTickLabel,$color = 'red'){
        $graph = new PieGraph($width,$height);
        $graph->SetShadow();

        $graph->title->Set($this->title);
        $graph->title->SetFont(FF_SIMSUN,FS_BOLD);

        $pieplot = new PiePlot3D($arrData);  //创建PiePlot3D对象
        $pieplot->SetCenter(0.4, 0.5); //设置饼图中心的位置
        $gDateLocale = new DateLocale();
        $pieplot->SetLegends($xTickLabel); //设置图例

        $graph->Add($pieplot);
        $graph->Stroke();
    }

    public function demo(){
        $data1 = array(19,23,34,38,45,67,71,78,85,87,96,145);
        //$gDateLocale = new DateLocale();
        $xTick = array(1,2,3,4,5,6,7,8,9,10,11,12);
        $a = new PrintPage();
        $a->printPie($data1,500,400,$xTick);
    }
}
