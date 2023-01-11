<!DOCTYPE html>
<html>
<head>

    <style scoped>
        .invoice-box {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .invoice-box table tr.heading2 td {
            background: rgb(255, 255, 255);
        }
        
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        /** RTL **/
        
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }
        
        .invoice-box.rtl table {
            text-align: right;
        }
        
        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box" style="margin-top: 5rem; margin-bottom: 5rem">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.sparksuite.com/images/logo.png" style="width: 100%; max-width: 300px" />
                            </td>

                            <td style=" text-align: right;">
                                <span style="font-weight: 500;font-size: 25px;">Slip Penggajian</span><br><br /> No Transaksi. {{$data['no_transaksi']}}<br /> {{$data['tanggal']}}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <span style="font-weight: 500;"> {{$data['namapt']}}</span><br /> {{$data['kota']}}, {{$data['provinsi']}}<br />{{$data['kodepos']}}
                            </td>

                            <td style=" text-align: right;">
                                {{$data['nama']}}<br /> {{$data['jabatan']}}<br /> NIP.{{$data['nopegawai']}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Pembayaran</td>

                <td style=" text-align: right;">Status</td>
            </tr>

            <tr class="details">
                <td><dt> Mandiri</dt></td>

                <td style=" text-align: right;"><dt>Berhasil</dt></td>
            </tr>
            <tr class="heading">
                <td>Gaji Pokok</td>

                <td style=" text-align: right;">Nominal</td>
            </tr>

            <tr class="item">
                <td>
                    <dt>
                        {{$data['jabatan']}}
                    </dt>
                </td>

                <td style=" text-align: right;margin-top: -0,5rem">
                    <dt>
                        Rp. {{number_format($data['gajipokok'],2)}}
                    </dt>
                </td>
            </tr>
            <tr class="heading">
                <td>Tunjangan</td>

                <td style=" text-align: right;">Nominal</td>
            </tr>

            <tr class="item">
                <td>
                    @foreach ($data['tunjangan'] as $item)
                        @if($item == "-")
                        <dt style="display: none">{{$item}}</dt>
                         @endif
                        @if($item != "-")
                        <dt>{{$item}}</dt>
                         @endif 
                     @endforeach
                </td>

                <td style=" text-align: right;margin-top: -0,5rem">
                    @foreach ($data['nomtun'] as $item)
                    @if($item == 0)
                    <dt style="display: none">Rp. {{number_format($item,2)}}</dt>
                    @endif
                    @if($item != 0)
                    <dt>Rp. {{number_format($item,2)}}</dt>
                    @endif    
                    @endforeach
                </td>
            </tr>
            <tr class="heading">
                <td>Bonus</td>

                <td style=" text-align: right;">Nominal</td>
            </tr>
            <tr class="item">
                <td>
                    @foreach ($data['bonus'] as $item)
                        @if($item == "-")
                         <dt style="display: none">{{$item}}</dt>
                        @endif
                        @if($item != "-")
                         <dt>{{$item}}</dt>
                        @endif 
                     @endforeach
                </td>

                <td style=" text-align: right;">
                    @foreach ($data['nombon'] as $item)
                        @if($item == 0)
                        <dt style="display: none">Rp. {{number_format($item,2)}}</dt>
                        @endif
                        @if($item != 0)
                        <dt>Rp. {{number_format($item,2)}}</dt>
                        @endif    
                    @endforeach
                </td>
            </tr>
            <tr class="heading">
                <td>Potongan</td>

                <td style=" text-align: right;">Nominal</td>
            </tr>
            <tr class="item">
                <td>
                    @foreach ($data['potongan'] as $item)
                    @if($item == "-")
                    <dt style="display: none">{{$item}}</dt>
                   @endif
                   @if($item != "-")
                    <dt>{{$item}}</dt>
                   @endif 
                     @endforeach
                </td>

                <td style=" text-align: right;">
                    @foreach ($data['nompot'] as $item)
                    @if($item == 0)
                    <dt style="display: none">Rp. {{number_format($item,2)}}</dt>
                    @endif
                    @if($item != 0)
                    <dt>Rp. {{number_format($item,2)}}</dt>
                    @endif    
                    @endforeach
                </td>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" style="margin-top: 1rem;padding-left:10rem;">
            <tr class="heading2">
                <td>Gaji Pokok</td>

                <td style=" text-align: right;">Rp. {{number_format($data['gajipokok'],2)}}</td>
            </tr>
            <tr class="heading2">
                <td>Total Tunjangan</td>

                <td style=" text-align: right;">Rp. {{number_format($data['totaltunjangan'],2)}}</td>
            </tr>
            <tr class="heading2">
                <td>Total Bonus</td>

                <td style=" text-align: right;">Rp. {{number_format($data['totalbonus'],2)}}</td>
            </tr>
            <tr class="heading2">
                <td>Total Potongan</td>

                <td style=" text-align: right;"> (-)Rp. {{number_format($data['totalpotongan'],2)}}</td>
            </tr>
            <tr class="heading2">
                <td>Gaji Kotor</td>

                <td style=" text-align: right;"> Rp. {{number_format($data['gajikotor'],2)}}</td>
            </tr>
            <tr class="heading" style="font-size: large;">
                <td>Terima Bersih</td>

                <td style=" text-align: right;">Rp. {{number_format($data['gajibersih'],2)}}</td>
            </tr>

        </table>
        <div style="margin-top: 4rem; margin-bottom: 4rem">
            <tr class="">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <span>Mengetahui</span><br /> <br /><br /><br /> {{$data['jabatanadmin']}} {{$data['namapt']}}
                            </td>
                            <td style=" text-align: right;">
                                <span>Diterima Oleh</span><br /> <br /><br /><br /> {{$data['nama']}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </div>
    </div>
</body>

</html>