<?php
/**
 * Created by PhpStorm.
 * User: jzc
 * Date: 2018/5/4
 * Time: 下午7:29
 * 饼图
 */
require_once ("../Library/jpgraph/src/jpgraph.php");
require_once ("../Library/jpgraph/src/jpgraph_pie.php");
require_once ("../Library/jpgraph/src/jpgraph_pie3d.php");

$data = array(19,23,34,38,45,67,71,78,85,87,90,96);

$graph = new PieGraph(550,500);
$graph->SetShadow();

$graph->title->Set("CDN流量比例");
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);

$pieplot = new PiePlot3D($data);  //创建PiePlot3D对象
$pieplot->SetCenter(0.4, 0.5); //设置饼图中心的位置
$pieplot->SetLegends($gDateLocale->GetShortMonth()); //设置图例

$graph->Add($pieplot);
$graph->Stroke();
?>