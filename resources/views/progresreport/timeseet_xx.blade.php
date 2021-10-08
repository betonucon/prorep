@extends('layouts.web')
@push('style')
    <link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		label {
			display: inline-block;
			margin-bottom: 0px !important;
			font-weight: bold;
		}
        th{
            text-align:center;
            background:#c3eda9;
        }
        td{
            padding-left:1%;
            vertical-align:top;
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
					<div class="profile-header-info">
						<h4 class="mt-0 mb-1">{{$data->name}}</h4>
						<p class="mb-2">Costcenter : {{$data->costcenter['name']}} </p>
						
					</div>
				</div>
				
			</div>
		</div>  
        <div class="row">
            
            <div class="col-xl-12">
                <div class="panel panel-inverse" data-sortable-id="ui-buttons-7">
                    <div class="panel-heading ui-sortable-handle">
                        <h4 class="panel-title">Activitas {{periode($periode)}}</h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>	
                        
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="input-group m-b-10" style="width: 30%;">
                                <select style="width:10%" id="bulan" class="form-control">
                                    @for($x=1;$x<13;$x++)
                                        <option value="{{ubah_bulan($x)}}" @if($bulan==ubah_bulan($x)) selected @endif>{{bulan(ubah_bulan($x))}}</option>
                                    @endfor

                                </select>
                                <select style="width:10%" id="tahun" class="form-control">
                                    @for($x=2019;$x<=date('Y');$x++)
                                        <option value="{{$x}}" @if($tahun==$x) selected @endif>{{$x}}</option>
                                    @endfor

                                </select>
								<div class="input-group-append">
                                    <span class="input-group-text" style="border-right:solid 2px #fff" onclick="cari()"><i class="fa fa-search"></i></span>
                                    <span class="input-group-text" style="border-right:solid 2px #fff" onclick="downexcel()"><i class="fa fa-print"></i></span>
                                    
                                </div>
							</div>
                            <div class="tab-pane fade active show" id="default-tab-1">
                                <div class="table-responsive">
                                <table border="1" style="border-collapse:collapse">
                                        <thead>
                                            <tr>
                                                <td width="6%">NAMA</td>
                                                <td width="14%" colspan="2">{{Auth::user()['name']}}</td>
                                                <td width="7%"></td>
                                                <td width="10%">JABATAN</td>
                                                <td>KEGIATAN</td>
                                                <td  width="7%">PROJECT</td>
                                                <td  colspan="2" width="15%">SAMPAI</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">TANGGAL</th>
                                                <th>HARI</th>
                                                <th>COST CENTER</th>
                                                <th colspan="2">KEGIATAN</th>
                                                <th >MULAI</th>
                                                <th  width="5%">SAMPAI</th>
                                                <th  width="10%">LAMANYA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($kal=1;$kal<=kalender($periode);$kal++)
                                                <?php
                                                    // if($kal%2==0){$col="table-info";}else{$col="table-active";}
                                                    $tgl=$tahun.'-'.$bulan.'-'.ubah_bulan($kal);
                                                ?>
                                                @for($de=1;$de<4;$de++)
                                                    <tr >
                                                        @if($de==2)
                                                            <td colspan="2"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>13:00</td>
                                                            <td>17:00</td>
                                                            <td></td>
                                                        @elseif($de==3)
                                                            <td colspan="2"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td  colspan="2"></td>
                                                            <td>13:00</td>
                                                            <td>17:00</td>
                                                            <td></td>
                                                        @else
                                                            <td colspan="2">{{tgl_indo($tgl)}}</td>
                                                            <td>{{hari_ini($tgl)}}</td>
                                                            <td>{{$data->costcenter['name']}}</td>
                                                            <td  colspan="2" rowspan="2">
                                                                @foreach(aktifitas_personal($data->username,$tgl) as $nom=>$aktifitas_personal)
                                                                <p style="margin:0px"><b>[{{$aktifitas_personal->project['name']}}]</b>&nbsp;{!!$aktifitas_personal->keterangan!!}</p>
                                                                @endforeach
                                                            </td>
                                                            <td>08:00</td>
                                                            <td>12:00</td>
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endfor
                                                
                                            @endfor
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab-pane -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
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
        function cari(){
            var bulan=$('#bulan').val();
            var tahun=$('#tahun').val();
            location.assign("{{url('Timeseet?username='.Auth::user()->username)}}&periode="+tahun+"-"+bulan+"-01");
        }
        function downexcel(){
            var bulan=$('#bulan').val();
            var tahun=$('#tahun').val();
            location.assign("{{url('TimeseetDownload?username='.Auth::user()->username)}}&periode="+tahun+"-"+bulan+"-01");
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