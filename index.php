<?php
require 'src/backend/config.php';
contentType('json');
require 'cities.php';
die;

$i = 0;
$log_file = 'src/log/request.txt';

while($i < 10) {
   $req = curl_get('https://insightsmachine.com.br'); // função que eu utilizo, mas nao vem ao caso
   $body = "HTTP Status: {$req['http_code']}, Request Time: $i \n-------------------\n";
   // fwrite($log_file, $body);
   // file_put_contents($log_file, file_get_contents($log_file) . $body);
   file_put_contents($log_file, $body, FILE_APPEND);

   sleep(0); // para o script nao rodar muito rapido e eu poder visualizar a interação
   $i++;
}

// fclose($log_file);


returnRequest(
   $req['http_code'],
   '',
   '',
   $req['info']
);

?>