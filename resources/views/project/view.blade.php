@extends('layouts.web')
@push('style')
	
@endpush
@section('conten')   
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{$menu}}</a></li>
        </ol>
        
        <h1 class="page-header">{{$menu}} <small>{{name()}}</small></h1>
        <div class="profile">
			<div class="profile-header">
				<div class="profile-header-cover"></div>
				<div class="profile-header-content">
					<!-- <div class="profile-header-img">
						<img src="{{url('img/logo.png')}}" alt="">
					</div> -->
					<div class="profile-header-info">
						<h4 class="mt-0 mb-1"><font color="yellow">({{progres_bar_project($data->kode_project)}}%)</font> {{$data->name}} {{jml_minggu()}}</h4>
						<p class="mb-2">Project Manager : {{$data->user['name']}} </p>
						<p class="mb-2">Costcenter : {{$data->costcenter['name']}} </p>
						<p class="mb-2">Startdate - Endtdate: {{$data->startdate}} To {{$data->enddate}}</p>
						
						<!-- <a href="#" class="btn btn-xs btn-yellow">Edit Profile</a> -->
					</div>
				</div>
				
			</div>
		</div>  
        <div class="row">
            <div class="col-xl-12 ui-sortable">
                <div class="panel panel-inverse" data-sortable-id="table-basic-9">
						<!-- begin panel-heading -->
                    <div class="panel-heading ui-sortable-handle">
                        <h4 class="panel-title"><span class="btn btn-blue btn-sm" onclick="create_data()"><i class="fa fa-plus"></i> Create Team & Job Order</span></h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datafixedheader" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="20%">Team</th>
                                        <th>Job Order</th>
                                        <th width="8%">Status</th>
                                        <th width="7%">Act</th>
                                        <th width="11%">Activitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(projectteam_get($data->kode_project) as $nom=>$projectteam_get)
                                        <?php
                                            if($nom%2==0){$col="table-info";}else{$col="table-active";}
                                        ?>
                                        <tr class="{{$col}}">
                                            <td>{{$nom+1}}</td>
                                            <td>{{$projectteam_get->user['name']}}</td>
                                            <td><b>({{$projectteam_get->progres}}%)</b> {{$projectteam_get->name}}
                                                
                                                    @if($projectteam_get->progres==100)
                                                        <div class="progress progress-sm m-b-15">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-indigo" style="width: {{$projectteam_get->progres}}%"></div>
                                                        </div>
                                                    @else
                                                        @if($projectteam_get->progres>50)
                                                            <div class="progress progress-sm m-b-15">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-blue" style="width: {{$projectteam_get->progres}}%"></div>
                                                            </div>
                                                        @else
                                                            <div class="progress progress-sm m-b-15">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-red" style="width: {{$projectteam_get->progres}}%"></div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    
                                            </td>
                                            <td>
                                                @if($projectteam_get->prosesdate=='' ||$projectteam_get->prosesdate==null )
                                                    @if($projectteam_get->enddate>date('Y-m-d'))
                                                        <font style="color:blue;font-weight:bold;">OnProgres</font>
                                                    @else
                                                        <font style="color:red;font-weight:bold;">Outstanding</font>
                                                    @endif

                                                @else
                                                    @if($projectteam_get->prosesdate>$projectteam_get->enddate)
                                                        <font style="color:red;font-weight:bold;">Outstanding</font>
                                                    @else
                                                        <font style="color:blue;font-weight:bold;">OnProgres</font>
                                                    @endif
                                                @endif
                                            </td>
                                            <td><span class="btn btn-green btn-xs" onclick="solve({{$projectteam_get->id}},{{$projectteam_get->progres}})"><i class="fas fa-check-circle"></i>Solve </span></td>
                                            <td><span class="btn btn-blue btn-xs" onclick="ViewProgresreport({{$projectteam_get->id}})"><i class="fas fa-calendar-check"></i> Progres</span></td>
                                        </tr>
                                       
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
						
				</div>
            </div>
        </div>

        <div class="row">
            <div class="modal" id="modal-tambah" aria-hidden="true" style="display: none;background: #1717198a;">
                <div class="modal-dialog modal-lg" style="margin-top:0px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Team Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-yellow fade show m-b-10" style="padding: 1%;text-align: center;">
                                <span class="close" data-dismiss="alert">×</span>
                                <strong>Notif!</strong><br>Masukan Team project dan tugasnya.
                            </div>
                            
                            <div class="btn-group" style="margin-bottom:2%">
                                
                            </div>
                            <form id="mycreate" onkeypress="return event.keyCode != 13" action="{{url('Project')}}" method="post" enctype="multipart/form-data">
                                
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>Team Project</b></label>
                                        <div class="col-lg-9 col-xl-9">
                                        <select class="form-control selectpicker" name="username" data-size="10" data-live-search="true" data-style="btn-white">
											<option value="" selected>--Select Team--</option>
                                            @foreach(user_gate() as $user_gate)
											<option value="{{$user_gate->username}}">[{{$user_gate->username}}] {{$user_gate->name}}</option>
											@endforeach
										</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>Job Order</b></label>
                                        <div class="col-lg-9 col-xl-9">
                                        <select class="form-control selectpicker" name="job_order_id" data-size="10" data-live-search="true" data-style="btn-white">
											<option value="" selected>--Select Job Order--</option>
                                            @foreach(joborder_get($data->kategori_id) as $joborder_get)
											<option value="{{$joborder_get->id}}">{{$joborder_get->name}}</option>
											@endforeach
										</select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>Job Order Name</b></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input type="text"  name="name"  placeholder="Enter....." class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="form-group row m-b-10">
                                        <label class="col-lg-3 text-lg-right col-form-label"><b>Date(Start & End)</b></label>
                                        <div class="col-lg-9 col-xl-3">
                                            <input type="text"  name="startdate" id="tanggalpicker" placeholder="Enter....." class="form-control">
                                        </div>
                                        <div class="col-lg-9 col-xl-3">
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
            $('#datafixedheader').DataTable({
                lengthMenu: [20, 40, 60],
                fixedHeader: {
                    header: true,
                    headerOffset: $('#header').height()
                },
                responsive: false,
                langth: false,
                paging: true,
                order: false,
                info: false,
            });
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tanggalpicker2').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });
        function solve(id,progres){
            if(progres==100){
                $.ajax({
                    type: 'GET',
                    url: "{{url('Project/solve')}}",
                    data: "id="+id,
                    success: function(msg){
                        location.reload();
                    }
                });
            }else{
                var r = confirm("Progres Masih "+progres+"% Apakah ingin melanjutkan?");
                if (r == true) {
                    $.ajax({
                        type: 'GET',
                        url: "{{url('Project/solve')}}",
                        data: "id="+id,
                        success: function(msg){
                            location.reload();
                        }
                    });
                } else {
                    
                }
            }
                
        }
        function ViewProgresreport(id){
            location.assign("{{url('ViewProgresreport')}}?id="+id);
        }
        function create_data(){
            $('#modal-tambah').modal('show');
        }

        function save_data(){
            var form=document.getElementById('mycreate');
            var kode_project= "{{$data->kode_project}}";
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/ProjectTeam')}}?_token="+token+"&kode_project="+kode_project,
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