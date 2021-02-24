<?php

/**
 * @param int $length o tamanho da string a ser gerada
 */
function randomString(Int $length): string{
	$random = random_bytes($length);
	return bin2hex($random);
}

/**
 * Os segundos contidos em X dias
 */
function daysInSeconds(Int $days): int {
   return 60 * 60 * 24 * $days;
}

/**
 * Força o redirecionamento para determinada url. Se por algum motivo, for preciso fazer esse 
 * redirecionamento após algum output, o redirecionamento sera feito com javascript. 
 * ******O arquivo morrerá após a execução da função*********
*/
function forceRedirect(String $url): void {
   header('Location: '.$url);
   echo "<script>window.location = '{$url}';</script>";
   die;
}


function curl_get(String $url): array {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $header ));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	return [
		'response' => $response,
		'info' => $info,
		'http_code' => $info['http_code']
	];
}

/**
 * Essa função retorna um status HTTP de acordo com o parâmetro, com direito a dois campos de texto e um array de dados convertidos em json. Após a exibição do json, o arquivo é encerrado OBRIGATORIAMENTE!
 * @param int $status Status HTTP a ser passado na resposta da requisição
 * @param string $type json.type (Opcional)
 * @param string $msg json.message (Opcional)
 * @param array $data json.data.[seu array de dados] (Opcional)
 * @return void o arquivo morre para não exibir nenhum conteúdo desnecessário para o DOM
 */
function returnRequest($status, $type = '', $msg = '', $data = ''): void {
	contentType('json');
	http_response_code($status);
	
	if($status != 204) {
		echo json_encode([
			'status' => $status,
			'type' => $type,
			'message' => $msg,
			'data' => $data
		]);
	}
	die;
}

/**
 * Seta o header Content type de forma rápida
 * 
 */
function contentType(String $type): void {
	switch($type) {
		case 'json':
			$type = 'application/json';
		break;
		
		case 'xml':
			$type = 'application/xml';
		break;

		case 'pdf':
			$type = 'application/pdf';
		break;

		default:
			$type = 'text/html; charset=utf-8';
		break;
	}

	header('Content-Type: '.$type);
}

function estadoName($sigla){
	$estados = [
		 'AC'=>'Acre',
		 'AL'=>'Alagoas',
		 'AP'=>'Amapá',
		 'AM'=>'Amazonas',
		 'BA'=>'Bahia',
		 'CE'=>'Ceará',
		 'DF'=>'Distrito Federal',
		 'ES'=>'Espírito Santo',
		 'GO'=>'Goiás',
		 'MA'=>'Maranhão',
		 'MT'=>'Mato Grosso',
		 'MS'=>'Mato Grosso do Sul',
		 'MG'=>'Minas Gerais',
		 'PA'=>'Pará',
		 'PB'=>'Paraíba',
		 'PR'=>'Paraná',
		 'PE'=>'Pernambuco',
		 'PI'=>'Piauí',
		 'RJ'=>'Rio de Janeiro',
		 'RN'=>'Rio Grande do Norte',
		 'RS'=>'Rio Grande do Sul',
		 'RO'=>'Rondônia',
		 'RR'=>'Roraima',
		 'SC'=>'Santa Catarina',
		 'SP'=>'São Paulo',
		 'SE'=>'Sergipe',
		 'TO'=>'Tocantins'
	];

	return $estados[$sigla];
}

function get_browser_name($user_agent){
	$t = strtolower($user_agent);

	$t = " " . $t;

	// Humans / Regular Users     
	if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;
	elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;
	elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;
	elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;
	elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;
	elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
  
	return 'Other (Unknown)';
}
?>