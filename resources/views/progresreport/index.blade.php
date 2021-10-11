@extends('layouts.web')
@push('style')
	<style>
        .jstree .jstree-container-ul .jstree-node .jstree-anchor {
            color: #fff;
            font-weight: 600;
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
        <div class="col-lg-12 col-xl-12">
			<div class="m-b-10 m-t-10 f-s-10">
                <a href="#modal-widget-stat" class="pull-right text-grey-darker m-r-3 f-w-700" data-toggle="modal">source code</a>
                
            </div>
            
            <div class="row row-space-10 m-b-20">
                <!-- begin col-4 -->
                @if(progresreport_count()>0)
                    @foreach(progresreport_get() as $no=>$progresreport_get)
                        <?php
                            if($no%2){$color="bg-gradient-blue";}else{$color="bg-gradient-black";}
                        ?>
                        <div class="col-lg-6 col-sm-6">
                            <div class="widget widget-stats {{$color}} m-b-10">
                                <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                                <div class="stats-content">
                                    <div class="stats-title">{{$progresreport_get->kode_project}} </div>
                                    <div class="stats-number" style="font-size:19px">{{$progresreport_get->project['name']}}</div>
                                    <div class="stats-number" style="font-size:19px">Progres <font color="yellow">({{Total_progresreport_count($progresreport_get->kode_project)}}%)</font></div>
                                    <div class="stats-title">Project Manager : {{$progresreport_get->project->user['name']}}</div>
                                    <div class="stats-progress progress">
                                        <div class="progress-bar" style="width: 100%;"></div>
                                    </div>
                                    
                                    <div id="jstree{{$no}}">
                                        <ul>
                                            
                                                <li data-jstree='{"opened":false}' >
                                                    Job Order Team
                                                    <ul>
                                                        @foreach(orderproject_get(Auth::user()->username,$progresreport_get->kode_project) as $orderproject_get)
                                                            <li data-jstree='{ "icon" : "fa fa-calendar-alt fa-lg text-primary" }' onclick="ViewProgresreport({{$orderproject_get->id}})" style="color:#fff"><b>({{$orderproject_get->progres}}%)</b>&nbsp; {{$orderproject_get->name}} date {{$orderproject_get->startdate}} s/d {{$orderproject_get->enddate}} </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12 col-sm-6">
                        <div class="widget widget-stats  m-b-10" style="background:none;color: #000;border: dotted 1px #b8b8c9;text-align: center;">
                            No Project 
                        </div>
                    </div>

                @endif
            </div>
        </div>

        <div class="row">
            <div class="modal" id="modal-tambah" aria-hidden="true" style="display: none;background: #1717198a;">
                <div class="modal-dialog modal-lg" style="margin-top:0px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-yellow fade show m-b-10" style="padding: 1%;text-align: center;">
                                <span class="close" data-dismiss="alert">×</span>
                                <strong>Notif!</strong><br>Masukan nama project yang anda pimpin.
                            </div>
                            
                            <div class="btn-group" style="margin-bottom:2%">
                                
                            </div>
                            <form id="mycreate" onkeypress="return event.keyCode != 13" action="{{url('Project')}}" method="post" enctype="multipart/form-data">
                                
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>Project Name</b></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input type="text"  name="name" placeholder="Enter....." class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>CostCenter</b></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <select  name="costcenter_id" placeholder="Enter....." class="form-control">
                                                <option value="">--Select-----</option>
                                                @foreach(costcenter_get() as $costcenter_get)
                                                    <option value="{{$costcenter_get->id}}">-{{$costcenter_get->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>StartDate Project</b></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"  name="startdate" id="tanggalpicker" placeholder="Enter....." class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>EndDate Project</b></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"  name="enddate" id="tanggalpicker2" placeholder="Enter....." class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-primary" onclick="save_data()" >Create</a>
                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="modal fade" id="modal-notifikasi" style="display: none;background: #1717198a;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Notifikasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger m-b-0">
                                <h5><i class="fa fa-info-circle"></i> Erorr</h5>
                                <div id="isi-notifikasi"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('ajax')
    <script>
        $(document).ready(function() {
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tanggalpicker2').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });

        $(function() {
            @foreach(progresreport_get() as $no=>$progresreport_get)
                $('#jstree{{$no}}').jstree({
                    "core": {
                        "themes": {
                            "responsive": false
                        }            
                    },
                    "types": {
                        "default": {
                            "icon": "fa fa-folder text-warning fa-lg"
                        },
                        "file": {
                            "icon": "fa fa-file text-inverse fa-lg"
                        }
                    },
                    "plugins": ["types"]
                });
            @endforeach
        });

        function create_data(){
            $('#modal-tambah').modal('show');
        }

        function ViewProgresreport(id){
            location.assign("{{url('ViewProgresreport')}}?id="+id);
        }

        function save_data(){
            var form=document.getElementById('mycreate');
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Project')}}?_token="+token,
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            $('#modal-notifikasi').modal('show');
                            $('#isi-notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        }
    </script>

@endpush