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
            
            <div class="col-xl-12 ui-sortable">
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
                            <p class="widget-chart-info-desc">{{company()}}.</p>
                            @foreach(dashboard_project_get() as $no=>$project_get)
                                
                                @if($project_get->progres==100)
                                    <div class="widget-chart-info-progress">
                                        <b>[{{$project_get->project['name']}}]  Due Date ({{$project_get->enddate}})</b> Job Order: {{$project_get->name}}
                                        <span class="pull-right">{{$project_get->progres}}%</span>
                                    </div>
                                    <div class="progress progress-sm m-b-15">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-indigo" style="width: {{$project_get->progres}}%"></div>
                                    </div>
                                    
                                @else
                                    @if($project_get->progres>50)
                                        <div class="widget-chart-info-progress">
                                            <b>[{{$project_get->project['name']}}]  Due Date ({{$project_get->enddate}})</b> Job Order: {{$project_get->name}} 
                                            <span class="pull-right">{{$project_get->progres}}%</span>
                                        </div>
                                        <div class="progress progress-sm m-b-15">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-blue" style="width: {{$project_get->progres}}%"></div>
                                        </div>
                                    @else
                                        <div class="widget-chart-info-progress">
                                            <b>[{{$project_get->project['name']}}]  Due Date ({{$project_get->enddate}})</b> Job Order: {{$project_get->name}}
                                            <span class="pull-right">{{$project_get->progres}}%</span>
                                        </div>
                                        <div class="progress progress-sm m-b-15">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-red" style="width: {{$project_get->progres}}%"></div>
                                        </div>
                                    @endif
                                @endif
                                
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
    

@endpush