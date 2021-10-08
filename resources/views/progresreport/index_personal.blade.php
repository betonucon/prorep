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
        <div class="panel panel-success" data-sortable-id="ui-widget-11" >
            <div class="panel-heading">
                <h4 class="panel-title">Personal {{Auth::user()->costcenter['name']}}</h4>
                <div class="panel-heading-btn">
                    <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <!-- @if(Auth::user()->sts_anggota==2) -->
                <div class="btn-group" style="margin-bottom:2%">
                    <button type="button" class="btn btn-green btn-sm" onclick="tambah_import()"><i class="fa fa-calendar-alt"></i> Import Data Simpanan wajib</button>
                    <button type="button" class="btn btn-blue btn-sm" onclick="tambah()"><i class="fa fa-plus"></i> Buat Simpanan wajib</button>
                </div>
                <!-- @endif -->
                <table id="datafixedheader" class="table table-striped table-bordered table-td-valign-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th class="text-wrap" width="15%">NIK</th>
                            <th class="text-wrap">Nama</th>
                            <th class="text-nowrap" width="12%">CostCenter</th>
                            <th class="text-nowrap" width="9%">Project</th>
                            <th class="text-nowrap" width="9%">Act</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach(user_personal_get() as $no=>$data)
                            <tr class="odd gradeX">
                                <td>{{$no+1}}</td>
                                <td>{{$data->username}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->costcenter['name']}}</td>
                                <td>
                                    <span onclick="view(`{{$data->username}}`)" class="btn btn-green  btn-xs"><i class="fas fa-suitcase"></i> Project</span> 
                                </td>
                                <td>
                                    <span onclick="personal_view(`{{$data->username}}`)" class="btn btn-purple  btn-xs"><i class="fas fa-edit fa-sm"></i> View</span> 
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                </table>

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
            <div class="modal" id="modal-ubah" aria-hidden="true" style="display: none;background: #1717198a;">
                <div class="modal-dialog modal-lg" style="margin-top:0px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Progres Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            
                            <form id="myupdate" onkeypress="return event.keyCode != 13" action="{{url('Project')}}" method="post" enctype="multipart/form-data">
                                
                                <div id="tampil_ubah"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
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
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#datafixedheader').length !== 0) {
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
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
            TableManageFixedHeader.init();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });

        function personal_view(username){
            location.assign("{{url('Activitas/personal')}}?username="+username);
        }
        function create_data(){
            $('#modal-tambah').modal('show');
        }

        function view(id){
			$.ajax({
				type: 'GET',
				url: "{{url('Activitas/view')}}",
				data: "username="+id,
				success: function(msg){
					$('#modal-ubah').modal('show');
					$('#tampil_ubah').html(msg);
				}
			});
			
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
        function update_data(){
            var form=document.getElementById('myupdate');
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Otorisasi/update')}}?_token="+token,
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