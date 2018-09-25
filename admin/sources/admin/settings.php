<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Web Settings</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Web Settings
	</div>
	<div class="panel-body">
		<?php
		if(isset($_POST['btn_save'])) {
			$title = protect($_POST['title']);
			$description = protect($_POST['description']);
			$keywords = protect($_POST['keywords']);
			$name = protect($_POST['name']);
			$url = protect($_POST['url']);
			$infoemail = protect($_POST['infoemail']);
			$supportemail = protect($_POST['supportemail']);
			$withdrawal_comission = protect($_POST['withdrawal_comission']);
			$max_addresses_per_account = protect($_POST['max_addresses_per_account']);
			$fb_link = protect($_POST['fb_link']);
			$tw_link = protect($_POST['tw_link']);
			
	$default_language = protect($_POST['default_language']);
	$default_currency = protect($_POST['default_currency']);
			if(isset($_POST['document_verification'])) { $document_verification = '1'; } else { $document_verification = '0'; }
			if(isset($_POST['email_verification'])) { $email_verification = '1'; } else { $email_verification = '0'; }
			if(isset($_POST['phone_verification'])) { $phone_verification = '1'; } else { $phone_verification = '0'; }
			$nexmo_api_key = protect($_POST['nexmo_api_key']);
			$nexmo_api_secret = protect($_POST['nexmo_api_secret']);
			if(empty($title) or empty($description) or empty($keywords) or empty($name) or empty($url) or empty($infoemail) or empty($supportemail) or empty($default_language) or empty($default_currency)) {
				echo error("All fields are required."); 
			} elseif(!isValidURL($url)) { 
				echo error("Please enter valid site url address.");
			} elseif(!isValidEmail($infoemail)) { 
				echo error("Please enter valid info email address.");
			} elseif(!isValidEmail($supportemail)) { 
				echo error("Please enter valid support email address.");
			}  elseif(!is_numeric($withdrawal_comission)) { 
				echo error("Please enter withdrawal comission with numbers.");
			} elseif(!is_numeric($max_addresses_per_account)) { 
				echo error("Please enter max addresses per account with numbers.");
			} elseif(!empty($fb_link) && !isValidURL($fb_link)) {
				echo error("Please enter valid Facebook profile url.");
			} elseif(!empty($tw_link) && !isValidURL($tw_link)) {
				echo error("Please enter valid Twitter profile url.");
			} elseif($phone_verification == "1" && empty($nexmo_api_key)) {
				echo error("Please enter Nexmo API Key."); 
			} elseif($phone_verification == "1" && empty($nexmo_api_secret)) {
				echo error("Please enter Nexmo API Secret.");
			} else {
				$update = $db->query("UPDATE btc_settings SET title='$title',description='$description',default_language='$default_language',default_currency='$default_currency',keywords='$keywords',name='$name',url='$url',infoemail='$infoemail',supportemail='$supportemail',withdrawal_comission='$withdrawal_comission',max_addresses_per_account='$max_addresses_per_account',fb_link='$fb_link',tw_link='$tw_link',document_verification='$document_verification',email_verification='$email_verification',phone_verification='$phone_verification',nexmo_api_key='$nexmo_api_key',nexmo_api_secret='$nexmo_api_secret'");
				$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $settings['title']; ?>">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="description" rows="2"><?php echo $settings['description']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Keywords</label>
				<textarea class="form-control" name="keywords" rows="2"><?php echo $settings['keywords']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Site name</label>
				<input type="text" class="form-control" name="name" value="<?php echo $settings['name']; ?>">
			</div>
			<div class="form-group">
				<label>Site url address</label>
				<input type="text" class="form-control" name="url" value="<?php echo $settings['url']; ?>">
			</div>
			<div class="form-group">
				<label>Info email address</label>
				<input type="text" class="form-control" name="infoemail" value="<?php echo $settings['infoemail']; ?>">
			</div>
			<div class="form-group">
				<label>Support email address</label>
				<input type="text" class="form-control" name="supportemail" value="<?php echo $settings['supportemail']; ?>">
			</div>
			<div class="form-group">
		<label>Default language</label>
		<select class="form-control" name="default_language">
			<?php
			$language = glob("../languages/" . '*.php', GLOB_BRACE);
			foreach($language as $lang) {
				// The path to be parsed
				$path = pathinfo($lang);
				$filename = ucfirst(strtolower($path['filename']));
				if($settings['default_currency'] == $filename) { $sel = 'selected'; } else { $sel = ''; }
				// Add the filename into $available array
				$available .= '<option value="'.$filename.'" '.$sel.'>'.$filename.'</option>';
			}
			echo $available;
			?>
		</select>
	</div>
	<div class="form-group">
		<label>Default currency</label>
		<select class="form-control" name="default_currency">
											<option value="AED" <?php if($settings['default_currency'] == "AED") { echo 'selected'; } ?>>AED - United Arab Emirates Dirham</option>
											<option value="AFN" <?php if($settings['default_currency'] == "AFN") { echo 'selected'; } ?>>AFN - Afghanistan Afghani</option>
											<option value="ALL" <?php if($settings['default_currency'] == "ALL") { echo 'selected'; } ?>>ALL - Albania Lek</option>
											<option value="AMD" <?php if($settings['default_currency'] == "AMD") { echo 'selected'; } ?>>AMD - Armenia Dram</option>
											<option value="ANG" <?php if($settings['default_currency'] == "ANG") { echo 'selected'; } ?>>ANG - Netherlands Antilles Guilder</option>
											<option value="AOA" <?php if($settings['default_currency'] == "AOA") { echo 'selected'; } ?>>AOA - Angola Kwanza</option>
											<option value="ARS" <?php if($settings['default_currency'] == "ARS") { echo 'selected'; } ?>>ARS - Argentina Peso</option>
											<option value="AUD" <?php if($settings['default_currency'] == "AUD") { echo 'selected'; } ?>>AUD - Australia Dollar</option>
											<option value="AWG" <?php if($settings['default_currency'] == "AWG") { echo 'selected'; } ?>>AWG - Aruba Guilder</option>
											<option value="AZN" <?php if($settings['default_currency'] == "AZN") { echo 'selected'; } ?>>AZN - Azerbaijan New Manat</option>
											<option value="BAM" <?php if($settings['default_currency'] == "BAM") { echo 'selected'; } ?>>BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD" <?php if($settings['default_currency'] == "BBD") { echo 'selected'; } ?>>BBD - Barbados Dollar</option>
											<option value="BDT" <?php if($settings['default_currency'] == "BDT") { echo 'selected'; } ?>>BDT - Bangladesh Taka</option>
											<option value="BGN" <?php if($settings['default_currency'] == "BGN") { echo 'selected'; } ?>>BGN - Bulgaria Lev</option>
											<option value="BHD" <?php if($settings['default_currency'] == "BHD") { echo 'selected'; } ?>>BHD - Bahrain Dinar</option>
											<option value="BIF" <?php if($settings['default_currency'] == "BIF") { echo 'selected'; } ?>>BIF - Burundi Franc</option>
											<option value="BMD" <?php if($settings['default_currency'] == "BMD") { echo 'selected'; } ?>>BMD - Bermuda Dollar</option>
											<option value="BND" <?php if($settings['default_currency'] == "BND") { echo 'selected'; } ?>>BND - Brunei Darussalam Dollar</option>
											<option value="BOB" <?php if($settings['default_currency'] == "BOB") { echo 'selected'; } ?>>BOB - Bolivia Boliviano</option>
											<option value="BRL" <?php if($settings['default_currency'] == "BRL") { echo 'selected'; } ?>>BRL - Brazil Real</option>
											<option value="BSD" <?php if($settings['default_currency'] == "BSD") { echo 'selected'; } ?>>BSD - Bahamas Dollar</option>
											<option value="BTN" <?php if($settings['default_currency'] == "BTN") { echo 'selected'; } ?>>BTN - Bhutan Ngultrum</option>
											<option value="BWP" <?php if($settings['default_currency'] == "BWP") { echo 'selected'; } ?>>BWP - Botswana Pula</option>
											<option value="BYR" <?php if($settings['default_currency'] == "BYR") { echo 'selected'; } ?>>BYR - Belarus Ruble</option>
											<option value="BZD" <?php if($settings['default_currency'] == "BZD") { echo 'selected'; } ?>>BZD - Belize Dollar</option>
											<option value="CAD" <?php if($settings['default_currency'] == "CAD") { echo 'selected'; } ?>>CAD - Canada Dollar</option>
											<option value="CDF" <?php if($settings['default_currency'] == "CDF") { echo 'selected'; } ?>>CDF - Congo/Kinshasa Franc</option>
											<option value="CHF" <?php if($settings['default_currency'] == "CHF") { echo 'selected'; } ?>>CHF - Switzerland Franc</option>
											<option value="CLP" <?php if($settings['default_currency'] == "CLP") { echo 'selected'; } ?>>CLP - Chile Peso</option>
											<option value="CNY" <?php if($settings['default_currency'] == "CNY") { echo 'selected'; } ?>>CNY - China Yuan Renminbi</option>
											<option value="COP" <?php if($settings['default_currency'] == "COP") { echo 'selected'; } ?>>COP - Colombia Peso</option>
											<option value="CRC" <?php if($settings['default_currency'] == "CRC") { echo 'selected'; } ?>>CRC - Costa Rica Colon</option>
											<option value="CUC" <?php if($settings['default_currency'] == "CUC") { echo 'selected'; } ?>>CUC - Cuba Convertible Peso</option>
											<option value="CUP" <?php if($settings['default_currency'] == "CUP") { echo 'selected'; } ?>>CUP - Cuba Peso</option>
											<option value="CVE" <?php if($settings['default_currency'] == "CVE") { echo 'selected'; } ?>>CVE - Cape Verde Escudo</option>
											<option value="CZK" <?php if($settings['default_currency'] == "CZK") { echo 'selected'; } ?>>CZK - Czech Republic Koruna</option>
											<option value="DJF" <?php if($settings['default_currency'] == "DJF") { echo 'selected'; } ?>>DJF - Djibouti Franc</option>
											<option value="DKK" <?php if($settings['default_currency'] == "DKK") { echo 'selected'; } ?>>DKK - Denmark Krone</option>
											<option value="DOP" <?php if($settings['default_currency'] == "DOP") { echo 'selected'; } ?>>DOP - Dominican Republic Peso</option>
											<option value="DZD" <?php if($settings['default_currency'] == "DZD") { echo 'selected'; } ?>>DZD - Algeria Dinar</option>
											<option value="EGP" <?php if($settings['default_currency'] == "EGP") { echo 'selected'; } ?>>EGP - Egypt Pound</option>
											<option value="ERN" <?php if($settings['default_currency'] == "ERN") { echo 'selected'; } ?>>ERN - Eritrea Nakfa</option>
											<option value="ETB" <?php if($settings['default_currency'] == "ETB") { echo 'selected'; } ?>>ETB - Ethiopia Birr</option>
											<option value="EUR" <?php if($settings['default_currency'] == "EUR") { echo 'selected'; } ?>>EUR - Euro Member Countries</option>
											<option value="FJD" <?php if($settings['default_currency'] == "FJD") { echo 'selected'; } ?>>FJD - Fiji Dollar</option>
											<option value="FKP" <?php if($settings['default_currency'] == "FKP") { echo 'selected'; } ?>>FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP" <?php if($settings['default_currency'] == "GBP") { echo 'selected'; } ?>>GBP - United Kingdom Pound</option>
											<option value="GEL" <?php if($settings['default_currency'] == "GEL") { echo 'selected'; } ?>>GEL - Georgia Lari</option>
											<option value="GGP" <?php if($settings['default_currency'] == "GGP") { echo 'selected'; } ?>>GGP - Guernsey Pound</option>
											<option value="GHS" <?php if($settings['default_currency'] == "GHS") { echo 'selected'; } ?>>GHS - Ghana Cedi</option>
											<option value="GIP" <?php if($settings['default_currency'] == "GIP") { echo 'selected'; } ?>>GIP - Gibraltar Pound</option>
											<option value="GMD" <?php if($settings['default_currency'] == "GMD") { echo 'selected'; } ?>>GMD - Gambia Dalasi</option>
											<option value="GNF" <?php if($settings['default_currency'] == "GNF") { echo 'selected'; } ?>>GNF - Guinea Franc</option>
											<option value="GTQ" <?php if($settings['default_currency'] == "GTQ") { echo 'selected'; } ?>>GTQ - Guatemala Quetzal</option>
											<option value="GYD" <?php if($settings['default_currency'] == "GYD") { echo 'selected'; } ?>>GYD - Guyana Dollar</option>
											<option value="HKD" <?php if($settings['default_currency'] == "HKD") { echo 'selected'; } ?>>HKD - Hong Kong Dollar</option>
											<option value="HNL" <?php if($settings['default_currency'] == "HNL") { echo 'selected'; } ?>>HNL - Honduras Lempira</option>
											<option value="HPK" <?php if($settings['default_currency'] == "HPK") { echo 'selected'; } ?>>HRK - Croatia Kuna</option>
											<option value="HTG" <?php if($settings['default_currency'] == "HTG") { echo 'selected'; } ?>>HTG - Haiti Gourde</option>
											<option value="HUF" <?php if($settings['default_currency'] == "HUF") { echo 'selected'; } ?>>HUF - Hungary Forint</option>
											<option value="IDR" <?php if($settings['default_currency'] == "IDR") { echo 'selected'; } ?>>IDR - Indonesia Rupiah</option>
											<option value="ILS" <?php if($settings['default_currency'] == "TLS") { echo 'selected'; } ?>>ILS - Israel Shekel</option>
											<option value="IMP" <?php if($settings['default_currency'] == "IMP") { echo 'selected'; } ?>>IMP - Isle of Man Pound</option>
											<option value="INR" <?php if($settings['default_currency'] == "INR") { echo 'selected'; } ?>>INR - India Rupee</option>
											<option value="IQD" <?php if($settings['default_currency'] == "IDQ") { echo 'selected'; } ?>>IQD - Iraq Dinar</option>
											<option value="IRR" <?php if($settings['default_currency'] == "IRR") { echo 'selected'; } ?>>IRR - Iran Rial</option>
											<option value="ISK" <?php if($settings['default_currency'] == "ISK") { echo 'selected'; } ?>>ISK - Iceland Krona</option>
											<option value="JEP" <?php if($settings['default_currency'] == "JEP") { echo 'selected'; } ?>>JEP - Jersey Pound</option>
											<option value="JMD" <?php if($settings['default_currency'] == "JMD") { echo 'selected'; } ?>>JMD - Jamaica Dollar</option>
											<option value="JOD" <?php if($settings['default_currency'] == "JOD") { echo 'selected'; } ?>>JOD - Jordan Dinar</option>
											<option value="JPY" <?php if($settings['default_currency'] == "JPY") { echo 'selected'; } ?>>JPY - Japan Yen</option>
											<option value="KES" <?php if($settings['default_currency'] == "KES") { echo 'selected'; } ?>>KES - Kenya Shilling</option>
											<option value="KGS" <?php if($settings['default_currency'] == "KGS") { echo 'selected'; } ?>>KGS - Kyrgyzstan Som</option>
											<option value="KHR" <?php if($settings['default_currency'] == "KHR") { echo 'selected'; } ?>>KHR - Cambodia Riel</option>
											<option value="KMF" <?php if($settings['default_currency'] == "KMF") { echo 'selected'; } ?>>KMF - Comoros Franc</option>
											<option value="KPW" <?php if($settings['default_currency'] == "KPW") { echo 'selected'; } ?>>KPW - Korea (North) Won</option>
											<option value="KRW" <?php if($settings['default_currency'] == "KRW") { echo 'selected'; } ?>>KRW - Korea (South) Won</option>
											<option value="KWD" <?php if($settings['default_currency'] == "KWD") { echo 'selected'; } ?>>KWD - Kuwait Dinar</option>
											<option value="KYD" <?php if($settings['default_currency'] == "KYD") { echo 'selected'; } ?>>KYD - Cayman Islands Dollar</option>
											<option value="KZT" <?php if($settings['default_currency'] == "KZT") { echo 'selected'; } ?>>KZT - Kazakhstan Tenge</option>
											<option value="LAK" <?php if($settings['default_currency'] == "LAK") { echo 'selected'; } ?>>LAK - Laos Kip</option>
											<option value="LBP" <?php if($settings['default_currency'] == "LBP") { echo 'selected'; } ?>>LBP - Lebanon Pound</option>
											<option value="LKR" <?php if($settings['default_currency'] == "LKR") { echo 'selected'; } ?>>LKR - Sri Lanka Rupee</option>
											<option value="LRD" <?php if($settings['default_currency'] == "LRD") { echo 'selected'; } ?>>LRD - Liberia Dollar</option>
											<option value="LSL" <?php if($settings['default_currency'] == "LSL") { echo 'selected'; } ?>>LSL - Lesotho Loti</option>
											<option value="LYD" <?php if($settings['default_currency'] == "LYD") { echo 'selected'; } ?>>LYD - Libya Dinar</option>
											<option value="MAD" <?php if($settings['default_currency'] == "MAD") { echo 'selected'; } ?>>MAD - Morocco Dirham</option>
											<option value="MDL" <?php if($settings['default_currency'] == "MDL") { echo 'selected'; } ?>>MDL - Moldova Leu</option>
											<option value="MGA" <?php if($settings['default_currency'] == "MGA") { echo 'selected'; } ?>>MGA - Madagascar Ariary</option>
											<option value="MKD" <?php if($settings['default_currency'] == "MKD") { echo 'selected'; } ?>>MKD - Macedonia Denar</option>
											<option value="MMK" <?php if($settings['default_currency'] == "MMK") { echo 'selected'; } ?>>MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT" <?php if($settings['default_currency'] == "MNT") { echo 'selected'; } ?>>MNT - Mongolia Tughrik</option>
											<option value="MOP" <?php if($settings['default_currency'] == "MOP") { echo 'selected'; } ?>>MOP - Macau Pataca</option>
											<option value="MRO" <?php if($settings['default_currency'] == "MRO") { echo 'selected'; } ?>>MRO - Mauritania Ouguiya</option>
											<option value="MUR" <?php if($settings['default_currency'] == "MUR") { echo 'selected'; } ?>>MUR - Mauritius Rupee</option>
											<option value="MVR" <?php if($settings['default_currency'] == "MVR") { echo 'selected'; } ?>>MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK" <?php if($settings['default_currency'] == "MWK") { echo 'selected'; } ?>>MWK - Malawi Kwacha</option>
											<option value="MXN" <?php if($settings['default_currency'] == "MXN") { echo 'selected'; } ?>>MXN - Mexico Peso</option>
											<option value="MYR" <?php if($settings['default_currency'] == "MYR") { echo 'selected'; } ?>>MYR - Malaysia Ringgit</option>
											<option value="MZN" <?php if($settings['default_currency'] == "MZN") { echo 'selected'; } ?>>MZN - Mozambique Metical</option>
											<option value="NAD" <?php if($settings['default_currency'] == "NAD") { echo 'selected'; } ?>>NAD - Namibia Dollar</option>
											<option value="NGN" <?php if($settings['default_currency'] == "NGN") { echo 'selected'; } ?>>NGN - Nigeria Naira</option>
											<option value="NTO" <?php if($settings['default_currency'] == "NTO") { echo 'selected'; } ?>>NIO - Nicaragua Cordoba</option>
											<option value="NOK" <?php if($settings['default_currency'] == "NOK") { echo 'selected'; } ?>>NOK - Norway Krone</option>
											<option value="NPR" <?php if($settings['default_currency'] == "NPR") { echo 'selected'; } ?>>NPR - Nepal Rupee</option>
											<option value="NZD" <?php if($settings['default_currency'] == "NZD") { echo 'selected'; } ?>>NZD - New Zealand Dollar</option>
											<option value="OMR" <?php if($settings['default_currency'] == "OMR") { echo 'selected'; } ?>>OMR - Oman Rial</option>
											<option value="PAB" <?php if($settings['default_currency'] == "PAB") { echo 'selected'; } ?>>PAB - Panama Balboa</option>
											<option value="PEN" <?php if($settings['default_currency'] == "PEN") { echo 'selected'; } ?>>PEN - Peru Nuevo Sol</option>
											<option value="PGK" <?php if($settings['default_currency'] == "PHK") { echo 'selected'; } ?>>PGK - Papua New Guinea Kina</option>
											<option value="PHP" <?php if($settings['default_currency'] == "PHP") { echo 'selected'; } ?>>PHP - Philippines Peso</option>
											<option value="PKR" <?php if($settings['default_currency'] == "PKR") { echo 'selected'; } ?>>PKR - Pakistan Rupee</option>
											<option value="PLN" <?php if($settings['default_currency'] == "PLN") { echo 'selected'; } ?>>PLN - Poland Zloty</option>
											<option value="PYG" <?php if($settings['default_currency'] == "PYG") { echo 'selected'; } ?>>PYG - Paraguay Guarani</option>
											<option value="QAR" <?php if($settings['default_currency'] == "QAR") { echo 'selected'; } ?>>QAR - Qatar Riyal</option>
											<option value="RON" <?php if($settings['default_currency'] == "RON") { echo 'selected'; } ?>>RON - Romania New Leu</option>
											<option value="RSD" <?php if($settings['default_currency'] == "RSD") { echo 'selected'; } ?>>RSD - Serbia Dinar</option>
											<option value="RUB" <?php if($settings['default_currency'] == "RUB") { echo 'selected'; } ?>>RUB - Russia Ruble</option>
											<option value="RWF" <?php if($settings['default_currency'] == "RWF") { echo 'selected'; } ?>>RWF - Rwanda Franc</option>
											<option value="SAR" <?php if($settings['default_currency'] == "SAR") { echo 'selected'; } ?>>SAR - Saudi Arabia Riyal</option>
											<option value="SBD" <?php if($settings['default_currency'] == "SBD") { echo 'selected'; } ?>>SBD - Solomon Islands Dollar</option>
											<option value="SCR" <?php if($settings['default_currency'] == "SCR") { echo 'selected'; } ?>>SCR - Seychelles Rupee</option>
											<option value="SDG" <?php if($settings['default_currency'] == "SDG") { echo 'selected'; } ?>>SDG - Sudan Pound</option>
											<option value="SEK" <?php if($settings['default_currency'] == "SEK") { echo 'selected'; } ?>>SEK - Sweden Krona</option>
											<option value="SGD" <?php if($settings['default_currency'] == "SGD") { echo 'selected'; } ?>>SGD - Singapore Dollar</option>
											<option value="SHP" <?php if($settings['default_currency'] == "SHP") { echo 'selected'; } ?>>SHP - Saint Helena Pound</option>
											<option value="SLL" <?php if($settings['default_currency'] == "SLL") { echo 'selected'; } ?>>SLL - Sierra Leone Leone</option>
											<option value="SOS" <?php if($settings['default_currency'] == "SOS") { echo 'selected'; } ?>>SOS - Somalia Shilling</option>
											<option value="SRL" <?php if($settings['default_currency'] == "SRL") { echo 'selected'; } ?>>SPL* - Seborga Luigino</option>
											<option value="SRD" <?php if($settings['default_currency'] == "SRD") { echo 'selected'; } ?>>SRD - Suriname Dollar</option>
											<option value="STD" <?php if($settings['default_currency'] == "STD") { echo 'selected'; } ?>>STD - Sao Tome and Principe Dobra</option>
											<option value="SVC" <?php if($settings['default_currency'] == "SVC") { echo 'selected'; } ?>>SVC - El Salvador Colon</option>
											<option value="SYP" <?php if($settings['default_currency'] == "SYP") { echo 'selected'; } ?>>SYP - Syria Pound</option>
											<option value="SZL" <?php if($settings['default_currency'] == "SZL") { echo 'selected'; } ?>>SZL - Swaziland Lilangeni</option>
											<option value="THB" <?php if($settings['default_currency'] == "THB") { echo 'selected'; } ?>>THB - Thailand Baht</option>
											<option value="TJS" <?php if($settings['default_currency'] == "TJS") { echo 'selected'; } ?>>TJS - Tajikistan Somoni</option>
											<option value="TMT" <?php if($settings['default_currency'] == "TMT") { echo 'selected'; } ?>>TMT - Turkmenistan Manat</option>
											<option value="TND" <?php if($settings['default_currency'] == "TND") { echo 'selected'; } ?>>TND - Tunisia Dinar</option>
											<option value="TOP" <?php if($settings['default_currency'] == "TOP") { echo 'selected'; } ?>>TOP - Tonga Pa'anga</option>
											<option value="TRY" <?php if($settings['default_currency'] == "TRY") { echo 'selected'; } ?>>TRY - Turkey Lira</option>
											<option value="TTD" <?php if($settings['default_currency'] == "TTD") { echo 'selected'; } ?>>TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD" <?php if($settings['default_currency'] == "TVD") { echo 'selected'; } ?>>TVD - Tuvalu Dollar</option>
											<option value="TWD" <?php if($settings['default_currency'] == "TWD") { echo 'selected'; } ?>>TWD - Taiwan New Dollar</option>
											<option value="TZS" <?php if($settings['default_currency'] == "TZS") { echo 'selected'; } ?>>TZS - Tanzania Shilling</option>
											<option value="UAH" <?php if($settings['default_currency'] == "UAH") { echo 'selected'; } ?>>UAH - Ukraine Hryvnia</option>
											<option value="UGX" <?php if($settings['default_currency'] == "UGX") { echo 'selected'; } ?>>UGX - Uganda Shilling</option>
											<option value="USD"  <?php if($settings['default_currency'] == "USD") { echo 'selected'; } ?>>USD - United States Dollar</option>
											<option value="UYU" <?php if($settings['default_currency'] == "UYU") { echo 'selected'; } ?>>UYU - Uruguay Peso</option>
											<option value="UZS" <?php if($settings['default_currency'] == "UZS") { echo 'selected'; } ?>>UZS - Uzbekistan Som</option>
											<option value="VEF" <?php if($settings['default_currency'] == "VEF") { echo 'selected'; } ?>>VEF - Venezuela Bolivar</option>
											<option value="VND" <?php if($settings['default_currency'] == "VND") { echo 'selected'; } ?>>VND - Viet Nam Dong</option>
											<option value="VUV" <?php if($settings['default_currency'] == "VUV") { echo 'selected'; } ?>>VUV - Vanuatu Vatu</option>
											<option value="WST" <?php if($settings['default_currency'] == "WST") { echo 'selected'; } ?>>WST - Samoa Tala</option>
											<option value="XAF" <?php if($settings['default_currency'] == "XAF") { echo 'selected'; } ?>>XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD" <?php if($settings['default_currency'] == "XCD") { echo 'selected'; } ?>>XCD - East Caribbean Dollar</option>
											<option value="XDR" <?php if($settings['default_currency'] == "XDR") { echo 'selected'; } ?>>XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF" <?php if($settings['default_currency'] == "XOF") { echo 'selected'; } ?>>XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF" <?php if($settings['default_currency'] == "XPF") { echo 'selected'; } ?>>XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER" <?php if($settings['default_currency'] == "YER") { echo 'selected'; } ?>>YER - Yemen Rial</option>
											<option value="ZAR" <?php if($settings['default_currency'] == "ZAR") { echo 'selected'; } ?>>ZAR - South Africa Rand</option>
											<option value="ZMW" <?php if($settings['default_currency'] == "ZMW") { echo 'selected'; } ?>>ZMW - Zambia Kwacha</option>
											<option value="ZWD" <?php if($settings['default_currency'] == "ZWD") { echo 'selected'; } ?>>ZWD - Zimbabwe Dollar</option>
									</select>
	</div><div class="form-group">
				<label>Comission when client withdrawal or send Bitcoins to other address</label>
				<div class="input-group">
					<input type="text" class="form-control" name="withdrawal_comission" value="<?php echo $settings['withdrawal_comission']; ?>">
					<span class="input-group-addon" id="basic-addon2">BTC</span>
				</div>
				<small>This comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>.</small>
			</div>
			<div class="form-group">
				<label>Max wallet addresses per account</label>
				<input type="text" class="form-control" name="max_addresses_per_account" value="<?php echo $settings['max_addresses_per_account']; ?>">
			</div>	
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="document_verification" value="yes" <?php if($settings['document_verification'] == "1") { echo 'checked'; }?>> Require user to upload documents and you verify it before exchange
					</label>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="email_verification" value="yes" <?php if($settings['email_verification'] == "1") { echo 'checked'; }?>> Require user to verify their email address before exchange
					</label>
			</div>
			<div class="checkbox">
					<label>
					  <input type="checkbox" name="phone_verification" value="yes" <?php if($settings['phone_verification'] == "1") { echo 'checked'; }?>> Require user to verify their mobile number before exchange
					</label>
			</div>
			<div class="form-group">
				<label>Nexmo API Key</label>
				<input type="text" class="form-control" name="nexmo_api_key" value="<?php echo $settings['nexmo_api_key']; ?>">
				<small>Type Nexmo API Key if you turned on mobile verification. Get api key form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<div class="form-group">
				<label>Nexmo API Secret</label>
				<input type="text" class="form-control" name="nexmo_api_secret" value="<?php echo $settings['nexmo_api_secret']; ?>">
				<small>Type Nexmo API Secret if you turned on mobile verification. Get api key form <a href="http://nexmo.com" target="_blank">www.nexmo.com</a></small>
			</div>
			<div class="form-group">
				<label>Facebook profile url</label>
				<input type="text" class="form-control" name="fb_link" value="<?php echo $settings['fb_link']; ?>">
			</div>	
			<div class="form-group">
				<label>Twitter profile url</label>
				<input type="text" class="form-control" name="tw_link" value="<?php echo $settings['tw_link']; ?>">
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>