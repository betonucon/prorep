@extends('layouts.web')
@push('style')
    <style>
        #style-3::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px #fff;
            background-color: #fff;
        }

        #style-3::-webkit-scrollbar
        {
            width: 3px;
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar-thumb
        {
            background-color: #fff;
        }

    </style>
@endpush
@section('conten')   
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{$menu}}</a></li>
        </ol>
        
        <h1 class="page-header">{{$menu}} <small>{{name()}}</small></h1>
        
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-xl-8 ui-sortable">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="chart-js-1">
                    <div class="panel-heading ui-sortable-handle">
                        <h4 class="panel-title">Line Chart</h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            A line chart is a way of plotting data points on a line.
                            Often, it is used to show trend data, and the comparison of two data sets.
                        </p>
                        <div>
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="bar-chart" data-render="chart-js" width="495" height="247" style="display: block; width: 495px; height: 247px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
            <!-- begin col-6 -->
            <div class="col-xl-4 ui-sortable">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="chart-js-2" >
                    <div class="panel-heading ui-sortable-handle">
                        <h4 class="panel-title">Bar Chart</h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="widget-chart-info" id="style-3" style="height: 387px;overflow-y:scroll">
                            <h4 class="widget-chart-info-title">Task Progres Report</h4>
                            <p class="widget-chart-info-desc">Vestibulum sollicitudin in lectus a cursus.</p>
                            @foreach(dashboard_project_get() as $no=>$project_get)
                                <div class="widget-chart-info-progress">
                                    <b>{{$project_get->name}}</b>
                                    <span class="pull-right">{{progres_bar_project($project_get->kode_project)}}%</span>
                                </div>
                                <div class="progress progress-sm m-b-15">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-indigo" style="width: {{progres_bar_project($project_get->kode_project)}}%"></div>
                                </div>
                            @endforeach
                            
                        </div>
                        
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        
    </div>
@endsection
@push('ajax')
    <script>
       /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */

        Chart.defaults.global.defaultFontColor = COLOR_DARK;
        Chart.defaults.global.defaultFontFamily = FONT_FAMILY;
        Chart.defaults.global.defaultFontStyle = FONT_WEIGHT;

        var randomScalingFactor = function() { 
            return Math.round(Math.random()*100)
        };

        var lineChartData = {
            
            labels: [
                @foreach(dashboard_project_get() as $no=>$project_get)
                    '{{$project_get->name}}',
                @endforeach
            ],
            datasets: [{
                label: '{{name()}}',
                borderColor: COLOR_DARK_LIGHTER,
                pointBackgroundColor: COLOR_DARK,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: COLOR_DARK_TRANSPARENT_3,
                data: [
                        @foreach(dashboard_project_get() as $no=>$project_get)
                            {{progres_bar_project($project_get->kode_project)}},
                        @endforeach
                    ]
                }]

        };

        var barChartData = {
            labels: [
                @foreach(dashboard_project_get() as $no=>$project_get)
                    '{{$project_get->name}}',
                @endforeach
            ],
            datasets: [
            {
                label: '{{name()}}',
                borderWidth: 2,
                borderColor: [
                    @foreach(dashboard_project_get() as $no=>$project_get)
                        '{{warna($no+1)}}',
                    @endforeach
                ],
                backgroundColor:  [
                    @foreach(dashboard_project_get() as $no=>$project_get)
                        '{{warna($no+1)}}',
                    @endforeach
                ],
                data: [
                    @foreach(dashboard_project_get() as $no=>$project_get)
                                    {{progres_bar_project($project_get->kode_project)}},
                    @endforeach
                ]
            },
            ]
        };

        var radarChartData = {
            labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
            datasets: [{
                label: 'Dataset 1',
                borderWidth: 2,
                borderColor: COLOR_RED,
                pointBackgroundColor: COLOR_RED,
                pointRadius: 2,
                backgroundColor: COLOR_RED_TRANSPARENT_2,
                data: [65,59,90,81,56,55,40]
            }, {
                label: 'Dataset 2',
                borderWidth: 2,
                borderColor: COLOR_DARK,
                pointBackgroundColor: COLOR_DARK,
                pointRadius: 2,
                backgroundColor: COLOR_DARK_TRANSPARENT_2,
                data: [28,48,40,19,96,27,100]
            }]
        };

        var polarAreaData = {
            labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
            datasets: [{
                data: [300, 160, 100, 200, 120],
                backgroundColor: [COLOR_INDIGO_TRANSPARENT_7, COLOR_BLUE_TRANSPARENT_7, COLOR_GREEN_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
                borderColor: [COLOR_INDIGO, COLOR_BLUE, COLOR_GREEN, COLOR_GREY, COLOR_DARK],
                borderWidth: 2,
                label: 'My dataset'
            }]
        };

        var pieChartData = {
            labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
            datasets: [{
                data: [300, 50, 100, 40, 120],
                backgroundColor: [COLOR_RED_TRANSPARENT_7, COLOR_ORANGE_TRANSPARENT_7, COLOR_MUTED_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
                borderColor: [COLOR_RED, COLOR_ORANGE, COLOR_MUTED, COLOR_GREY, COLOR_DARK],
                borderWidth: 2,
                label: 'My dataset'
            }]
        };

        var doughnutChartData = {
            labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
            datasets: [{
                data: [300, 50, 100, 40, 120],
                backgroundColor: [COLOR_INDIGO_TRANSPARENT_7, COLOR_BLUE_TRANSPARENT_7, COLOR_GREEN_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
                borderColor: [COLOR_INDIGO, COLOR_BLUE, COLOR_GREEN, COLOR_GREY, COLOR_DARK],
                borderWidth: 2,
                label: 'My dataset'
        }]
        };

        var handleChartJs = function() {
            // var ctx = document.getElementById('line-chart').getContext('2d');
            // var lineChart = new Chart(ctx, {
            //     type: 'line',
            //     data: lineChartData
            // });

            var ctx2 = document.getElementById('bar-chart').getContext('2d');
            var barChart = new Chart(ctx2, {
                type: 'bar',
                data: barChartData
            });

            var ctx3 = document.getElementById('radar-chart').getContext('2d');
            var radarChart = new Chart(ctx3, {
                type: 'radar',
                data: radarChartData
            });

            var ctx4 = document.getElementById('polar-area-chart').getContext('2d');
            var polarAreaChart = new Chart(ctx4, {
                type: 'polarArea',
                data: polarAreaData
            });

            var ctx5 = document.getElementById('pie-chart').getContext('2d');
            window.myPie = new Chart(ctx5, {
                type: 'pie',
                data: pieChartData
            });

            var ctx6 = document.getElementById('doughnut-chart').getContext('2d');
            window.myDoughnut = new Chart(ctx6, {
                type: 'doughnut',
                data: doughnutChartData
            });
        };

        var ChartJs = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleChartJs();
                }
            };
        }();

        $(document).ready(function() {
            ChartJs.init();
        });
    </script>

@endpush