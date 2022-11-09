<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
	<meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
	<meta name="author" content="pixelstrap">
	<title>Perusahaan</title>
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<style type="text/css">
		body {
			width: 650px;
			font-family: work-Sans, sans-serif;
			background-color: #f6f7fb;
			display: block;
		}

		a {
			text-decoration: none;
		}

		span {
			font-size: 14px;
		}

		p {
			font-size: 13px;
			line-height: 1.7;
			letter-spacing: 0.7px;
			margin-top: 0;
		}

		.text-center {
			text-align: center
		}
	</style>
</head>

<body style="margin: 30px auto;">
	<table style="width: 100%">
		<tbody>
			<tr>
				<td>
					<table style="background-color: #f6f7fb; width: 100%">
						<tbody>
							<tr>
								<td>
									<table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
										<tbody>
											<tr>
												{{-- <td><img src="https://appt.demoo.id/omahan/voc/assets/images/logo-03.png" width="75" alt="VOC"></td> --}}
												<td style="text-align: right; color:#999"><span>{{ $data['judul'] }}</span></td>
											</tr>
										</tbody>
									</table>
									<table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
										<tbody>
											@if($data['hasil'] == 'Diterima')
											<tr>
												<td style="padding: 30px; text-align: center;">
													Approvement Akun Perusahaan Anda</br></br>
													<p>Halo {{ $data['email'] }}</p>
                                                   Berdasarkan pertimbangan kami, akun perusahaan anda telah :</br></br>
													<h1><b style="color: #2dce89">{{ $data['hasil'] }}</b></h1>
													<h4>Anda bisa menggunakan akun ini untuk perusahaan anda</h4>
													<h4>Silahkan Klik Tombol Berikut Untuk Login</h4>
													<a href="http://127.0.0.1:8000/" style="padding: 10px; background: linear-gradient(35deg, #2dce89 0, #2dcecc 100%) !important; color: #fff; display: inline-block; border-radius: 4px; margin-bottom: 18px">Login</a>
												</td>
											</tr>
											@endif
											@if($data['hasil'] == 'Ditolak')
											<tr>
												<td style="padding: 30px; text-align: center;">
													Approvement Akun Perusahaan Anda</br></br>
													<p>Halo {{ $data['email'] }}</p>
                                                   Berdasarkan pertimbangan kami, akun perusahaan anda telah :</br></br>
													<h1><b style="color: red">{{ $data['hasil'] }}</b></h1>
													<h4>Terimakasih Atas Kerja Samanya</h4>
												</td>
											</tr>
											@endif
											@if($data['hasil'] == 'Nonaktif')
											<tr>
												<td style="padding: 30px; text-align: center;">
													Informasi Terkait Akun Anda</br></br>
													<p>Halo {{ $data['email'] }}</p>
                                                   Berdasarkan pertimbangan kami, akun perusahaan anda telah :</br></br>
													<h1><b style="color: red">{{ $data['hasil'] }}</b></h1>
													<h4>Terimakasih Atas Kerja Samanya</h4>
												</td>
											</tr>
											@endif
										</tbody>
									</table>
									<table style="width: 650px; margin: 0 auto; margin-top: 30px">
										<tbody>
											<tr style="text-align: center">
												<td>
													<p style="color: #999; margin-bottom: 0">Jl. Kolonel Sutarto
														No.150, Jebres, Kec. Jebres,
														Kota Surakarta,
														Jawa Tengah 57126</p>
													<p style="color: #999; margin-bottom: 0">HR Managament System</p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
