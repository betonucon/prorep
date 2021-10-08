<html>
    <head>  
        <title>KKWK  {{$periode}}</title>
        <style>
            
            @page {
                margin:3% 3% 10% 3%;
            }
            .footer{
                bottom:0;
                height: 40px;
            }

            .header{
                top: 0;
                height: 3%;
            } 

            .content{
                margin-top: 20px;
                margin-bottom: 30px;
            }
            th{
                font-size:11px;
                vertical-align:top;
                text-align:center;
                background:#c2d189;
            }
            td{
                font-size:11px;
                vertical-align:top;
                text-align:center;
            }
            .ttd{
                font-size:12px;
                vertical-align:top;
                text-align:left;
                padding-left:5px;
                border:solid 1px #fff;
            }
            .tth{
                font-size:15px;
                vertical-align:top;
                text-align:center;
                font-weight:bold;
                padding-left:5px;
                border:solid 1px #fff;
            }
            .tth p{
                margin:1%;
            }
        </style>
    </head> 
    <body >    
     <div class="content">   
        <table border="1" width="100%" style="border-collapse:collapse;margin-bottom:1%">
            <tr>
                <td class="tth" width="20%"><img src="{{url('img/logo_pt.png')}}" width="100%"></td>
                <td class="tth"><p>PT KRAKATAU INFORMATION TECHNOLOGY</p><p>FORM ABSENSI PERSONIL PKB / PROYEK   </p></td>
                <td class="tth" width="15%"></td>
            </tr>
        </table>
        <hr>
        <table border="1" width="100%" style="border-collapse:collapse;margin-bottom:1%">
            <tr>
                <td class="ttd" width="8%"><b>NAMA</b></td>
                <td class="ttd"><b>: {{$data->name}}</b></td>
                <td class="ttd" width="8%"><b>JABATAN</b></td>
                <td class="ttd"><b>:</b></td>
                <td class="ttd" width="8%"><b>PROJECT</b></td>
                <td class="ttd"><b>:</b></td>
                <td class="ttd" width="8%"><b>LOKASI</b></td>
                <td class="ttd"><b>:</b></td>
            </tr>
            <tr>
                <td class="ttd"><b>NIK</b></td>
                <td class="ttd"><b>: {{$data->username}}</b></td>
                <td class="ttd"><b>COSTCENTER</b></td>
                <td class="ttd"><b>:</b></td>
                <td class="ttd"><b>PERIODE</b></td>
                <td class="ttd"><b>: {{bulan($bulan)}} {{$tahun}}</b></td>
                <td class="ttd"></td>
                <td class="ttd"></td>
            </tr>
        </table>
        <table border="1" width="100%" style="border-collapse:collapse">
            <thead>
                <tr>
                    <th width="13%">TANGGAL</th>
                    <th width="7%">HARI</th>
                    <th width="7%">COST CENTER</th>
                    <th>KEGIATAN</th>
                    <th width="5%">MULAI</th>
                    <th  width="5%">SAMPAI</th>
                    <th  width="10%">LAMANYA</th>
                    <th  width="5%">TT<hr>YBS</th>
                    <th  width="5%">TT<hr>PM</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totaljam=0;
                    $lemburan=0;
                ?>
                @for($kal=1;$kal<=kalender($periode);$kal++)
                    <?php
                        // if($kal%2==0){$col="table-info";}else{$col="table-active";}
                        $tgl=$tahun.'-'.$bulan.'-'.ubah_bulan($kal);
                        
                    ?>
                    @for($de=1;$de<3;$de++)
                    <?php
                        if(hari_ini($tgl)=='Sabtu' || hari_ini($tgl)=='Minggu' ){
                            $totaljam+=0;
                            $coloor="aqua";
                        }else{
                            $totaljam+=4.0;
                            $coloor="#fff";
                        }
                    ?>
                        <tr style="background:{{$coloor}}">
                            @if($de==2)
                                <td ></td>
                                <td></td>
                                <td>{{$data->costcenter['name']}}</td>
                                <td>13:00</td>
                                <td>17:00</td>
                                <td>4.0 Jam</td>
                                <td></td>
                                <td></td>
                            @else
                                <td>{{tgl_indo($tgl)}}</td>
                                <td>{{hari_ini($tgl)}}</td>
                                <td>{{$data->costcenter['name']}}</td>
                                <td  rowspan="2" style="text-align:left">
                                    @foreach(aktifitas_personal($data->username,$tgl) as $nom=>$aktifitas_personal)
                                    <p style="margin:0px"><b>[{{$aktifitas_personal->project['name']}}]</b>&nbsp;{!!$aktifitas_personal->keterangan!!}</p>
                                    @endforeach
                                </td>
                                <td>08:00</td>
                                <td>12:00</td>
                                <td>4.0 Jam</td>
                                <td></td>
                                <td></td>
                            @endif
                        
                    @endfor
                    @foreach(lemburreport_get(Auth::user()['username'],$tgl) as $lembur)
                        <?php 
                            $totaljam+=selisih_jam($lembur['mulai'],$lembur['sampai']); 
                            $lemburan+=selisih_jam($lembur['mulai'],$lembur['sampai']); 
                        ?>
                            <tr style="background:#e9e9f1">    
                                <td></td>
                                <td></td>
                                <td>{{$data->costcenter['name']}}</td>
                                <td style="text-align:left">
                                    <b>[{{$lembur->project['name']}}]</b>&nbsp;{{$lembur->keterangan}}
                                </td>
                                <td>{{ubah_jam($lembur['mulai'])}}</td>
                                <td>{{ubah_jam($lembur['sampai'])}}</td>
                                <td>{{selisih_jam($lembur['mulai'],$lembur['sampai'])}} Jam</td>
                                <td></td>
                                <td></td>
                            </tr>
                    @endforeach
                @endfor
                <tr style="background:#e9e9f1">    
                    <td  colspan="6" style="text-align:right">TOTAL</td>
                    <td>{{$totaljam}} Jam</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="background:#e9e9f1">    
                    <td  colspan="6" style="text-align:right">LEMBUR</td>
                    <td>{{$lemburan}} Jam</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="footer">
            
        </div>
    </body>
</html>