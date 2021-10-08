@extends('layouts.web')
@push('style')
    <link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		label {
			display: inline-block;
			margin-bottom: 0px !important;
			font-weight: bold;
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
        
        <h1 class="page-header">{{$menu}}<small>{{name()}}</small></h1>
        <div class="profile">
			<div class="profile-header">
				<div class="profile-header-cover"></div>
				<div class="profile-header-content">
					<div class="profile-header-img">
						<img src="{{url('img/logo.png')}}" alt="">
					</div>
					<div class="profile-header-info">
						<h4 class="mt-0 mb-1">{{$data->project['name']}}</h4>
						<h4 class="mt-0 mb-1">{{$data->name}}</h4>
						<p class="mb-2">Project Manager : {{$data->user['name']}} </p>
						<p class="mb-2">Startdate - Endtdate: {{$data->startdate}} To {{$data->enddate}}</p>
						
						<!-- <a href="#" class="btn btn-xs btn-yellow">Edit Profile</a> -->
					</div>
				</div>
				
			</div>
		</div>  
        <div class="row">
            
            <div class="col-xl-12">
					<!-- begin nav-tabs -->
                <ul class="nav nav-tabs">
                @for($x=0;$x<selisih_bulan($data->startdate,$data->enddate);$x++)
                    <?php
                        if(bulanberikutnya($data->startdate,$data->enddate,$x)==$periode){
                            $aktif="active";
                        }else{
                            $aktif="";
                        }

                    ?>
                    <li class="nav-item" style="background: #eaeaf1;border-right: #fff solid 2px;">
                        <a href="#default-tab-1" onclick="progresisi(`{{bulanberikutnya($data->startdate,$data->enddate,$x)}}`)" data-toggle="tab" class="nav-link {{$aktif}}">
                            <span class="d-sm-none">Tab 1</span>
                            <span class="d-sm-block d-none">{{periode(bulanberikutnya($data->startdate,$data->enddate,$x))}}</span>
                        </a>
                    </li>
                @endfor   
                </ul>
                <!-- end nav-tabs -->
                <!-- begin tab-content -->
                <div class="tab-content">
                    <!-- begin tab-pane -->
                    <div class="tab-pane fade active show" id="default-tab-1">
                        <h3 class="m-t-10"><i class="fa fa-cog"></i> Startdate - Endtdate: {{$data->startdate}} To {{$data->enddate}}</h3>
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th width="4%">No</th>
                                        <th width="8%">Day</th>
                                        <th width="8%">Date</th>
                                        <th>Activitas</th>
                                        <th width="7%">Progres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($kal=1;$kal<=kalender($periode);$kal++)
                                        <?php
                                            if($kal%2==0){$col="table-info";}else{$col="table-active";}
                                            $tgl=$tahun.'-'.$bulan.'-'.ubah_bulan($kal);
                                        ?>
                                        @if($periodemulai==$bulan.$tahun)
                                            @if($tgl>=$data->startdate)
                                                <tr class="{{$col}}">
                                                    <td>{{$kal}}</td>
                                                    <td>{{date('D',strtotime($tgl))}}</td>
                                                    <td>{{ubah_bulan($kal)}}/{{substr(bulan($bulan),0,3)}}/{{$tahun}}</td>
                                                    @if(cek_aktifitas($data->id,$tgl)>0)
                                                        <td style="background: #fff;"><i class="fas fa-times-circle" onclick="hapus_aktivitas({{$data->id}},`{{$tgl}}`)"></i> {!!aktifitas($data->id,$tgl)!!}</td>
                                                        <td>{{progres_aktifitas($data->id,$tgl)}}%</td>
                                                    @else
                                                        @if($data->username==Auth::user()->username)
                                                            <td><span class="btn btn-green btn-xs" onclick="isi_aktivitas({{$data->id}},`{{$tgl}}`)" title="Create aktivitas {{ubah_bulan($kal)}}/{{substr(bulan($bulan),0,3)}}/{{$tahun}}"><i class="fas fa-calendar-plus"></i></span></td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        
                                                        <td>0%</td>
                                                    @endif
                                                </tr>
                                            @else
                                                <tr class="table-warning">
                                                    <td>{{$kal}}</td>
                                                    <td>{{date('D',strtotime($tgl))}}</td>
                                                    <td>{{ubah_bulan($kal)}}/{{substr(bulan($bulan),0,3)}}/{{$tahun}}</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr class="{{$col}}">
                                                <td>{{$kal}}</td>
                                                <td>{{date('D',strtotime($tgl))}}</td>
                                                <td>{{ubah_bulan($kal)}}/{{substr(bulan($bulan),0,3)}}/{{$tahun}}</td>
                                                @if(cek_aktifitas($data->id,$tgl)>0)
                                                    <td style="background: #fff;"><i class="fas fa-times-circle" onclick="hapus_aktivitas({{$data->id}},`{{$tgl}}`)"></i> {!!aktifitas($data->id,$tgl)!!}</td>
                                                    <td>{{progres_aktifitas($data->id,$tgl)}}%</td>
                                                @else
                                                    @if($data->username==Auth::user()->username)
                                                        <td><span class="btn btn-green btn-xs" onclick="isi_aktivitas({{$data->id}},`{{$tgl}}`)" title="Create aktivitas {{ubah_bulan($kal)}}/{{substr(bulan($bulan),0,3)}}/{{$tahun}}"><i class="fas fa-calendar-plus"></i></span></td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    
                                                    <td>0%</td>
                                                @endif
                                            </tr>
                                        @endif
                                        
                                       
                                    @endfor
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end tab-pane -->
                    
                </div>
                <!-- end tab-content -->
                
            </div>
        </div>

        <div class="row">
            <div class="modal" id="modal-tambah" aria-hidden="true" style="display: none;background: #1717198a;">
                <div class="modal-dialog modal-lg" style="margin-top:0px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Activitas & Progres</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="btn-group" style="margin-bottom:2%">
                                
                            </div>
                            <form id="mycreate" onkeypress="return event.keyCode != 13" action="{{url('Project')}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="project_team_id" id="project_team_id">
                                <input type="hidden" name="tanggal" id="tanggal-aktivitas">
                                
                                <div class="form-group">
                                    <label><b>Aktifitas</b></label>
                                    <textarea class="textarea form-control" name="keterangan" id="textareanya" placeholder="Enter text ..." rows="8"></textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <label><b>Progres</b></label>
                                    <input type="number" class="form-control" name="progres" id="progres" onkeyup="isi_progres(this.value)"placeholder="Enter text ..."  style="width:20%">
                                    
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
    <script src="{{url('assets/assets/plugins/ckeditor/ckeditor.js')}}"></script>
	<script src="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script src="{{url('assets/assets/js/demo/form-wysiwyg.demo.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tanggalpicker2').datepicker({
                format: 'yyyy-mm-dd',
                
            });

            $("#textareanya").wysihtml5();
        });

        function isi_progres(a){
            if(a.length>3){
                alert('Maximal 3 Carakter')
                $('#progres').val('');
            }else{
                if(a>100){
                    alert('Maximal 100')
                    $('#progres').val('');
                }else{

                }
            }
        }
        function progresisi(tgl){
            document.getElementById("loadnya").style.width = "100%";
            location.assign("{{url('ViewProgresreport?id='.$data->id)}}&periode="+tgl);
        }

        function hapus_aktivitas(id,tgl){
            $.ajax({
				type: 'GET',
				url: "{{url('Progresreport/hapus')}}",
				data: "project_team_id="+id+"&tgl="+tgl,
				success: function(msg){
					location.reloa();
				}
			});
        }
        function isi_aktivitas(id,tgl){
            $('#modal-tambah').modal('show');
            $('#project_team_id').val(id);
            $('#tanggal-aktivitas').val(tgl);
        }

        function save_data(){
            var form=document.getElementById('mycreate');
            var token= "{{csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Progresreport')}}?_token="+token,
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