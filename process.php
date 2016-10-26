<?php
require_once('idmore.php');

$IdmoreRO = new IdmoreRO();
if(isset($_GET['act'])):
	switch ($_GET['act']) {

		case 'showprovince':
		$province = $IdmoreRO->showProvince();
		echo $province;
		break;

		case 'showcity':
		$idprovince = $_GET['province'];
		$city = $IdmoreRO->showCity($idprovince);
		echo $city;
		break;

		case 'cost':
		$origin = $_GET['origin'];
		$destination = $_GET['destination'];
		$weight = $_GET['weight'];
		$courier = $_GET['courier'];
		$cost = $IdmoreRO->hitungOngkir($origin,$destination,$weight,$courier);
		//parse json
		$costarray = json_decode($cost);
		$results = $costarray->rajaongkir->results;
		if(!empty($results)){
			foreach($results as $r):
				foreach($r->costs as $rc):
					foreach($rc->cost as $rcc):
						echo '<tr><td>'.$r->code.'</td><td>'.$rc->service.'</td><td>'.$rc->description.'</td><td>'.$rcc->etd.'</td><td>'.number_format($rcc->value).'</td><td><input onclick="totalOngkir()" type="radio" id="pilihpaket" name="pilihpaket" value="'.$rcc->value.'"></td></tr>';
					endforeach;
				endforeach;
			endforeach;
		}else{
			echo '<script language="javascript">';
			echo 'alert("Setiap Field Harus diisi")';
			echo '</script>';
		};
		//end of parse json
		break;
		default:
		echo 'aksi tidak tersedia';
		break;
	}
	endif;
