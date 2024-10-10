<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Clima para Bombinhas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #01579b;
            font-size: 3.5em;
            margin: 40px 0 20px;
            text-align: center;
        }

        .weather-card {
            background-color: #ffffff;
            border-left: 5px solid #0288d1;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            width: 90%;
            max-width: 900px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative;
        }

        h2 {
            color: #0288d1;
            font-size: 2.5em;
            margin: 10px 0;
        }

        .weather-icon {
            width: 100px;
            height: 100px;
            display: inline-block;
            margin: 20px auto;
        }

        p {
            font-size: 1.5em;
            margin: 10px 0;
            text-align: center;
            background-color: #bbdefb; 
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        p:hover {
            background-color: #90caf9;
        }

        strong {
            color: #0277bd;
        }

        hr {
            border: none;
            height: 2px;
            background-color: #81d4fa;
            width: 80%;
            margin: 30px auto;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2em;
            }

            h2 {
                font-size: 1.5em;
            }

            p {
                font-size: 1em;
            }

            .weather-icon {
                width: 80px;
                height: 80px;
            }

            .weather-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <h1>Previsão do Clima para Bombinhas - SC</h1>
    <div class="cards-container">

<?php
    $url = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/5092/days/15?token=cba2ef2afc4f459f71aaba943dace57f";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Erro ao conectar à API: ' . curl_error($curl);
        exit;
    }

    curl_close($curl);

    $dados = json_decode($response, true);
    date_default_timezone_set('America/Sao_Paulo');

    function getCardinalDirection($degree) {
        $directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'];
        $index = round($degree / 22.5);
        return $directions[$index % 16];
    }


    function getWindDirectionIcon($degree) {
        if ($degree >= 337.5 || $degree < 22.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5'/>
                    </svg>";
        } elseif ($degree >= 22.5 && $degree < 67.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-right' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z'/>
                    </svg>"; 
        } elseif ($degree >= 67.5 && $degree < 112.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-right' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8'/>
                    </svg>"; 
        } elseif ($degree >= 112.5 && $degree < 157.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down-right' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M14 13.5a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1 0-1h4.793L2.146 2.854a.5.5 0 0 1 .708-.708L13 12.293V7.5a.5.5 0 0 1 1 0z'/>
                    </svg>"; 
        } elseif ($degree >= 157.5 && $degree < 202.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1'/>
                    </svg>"; 
        } elseif ($degree >= 202.5 && $degree < 247.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down-left' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2 13.5a.5.5 0 0 0 .5.5h6a.5.5 0 0 0 0-1H3.707l10.647-10.646a.5.5 0 0 0-.708-.708L2 12.793V8.5a.5.5 0 0 0-1 0z'/>
                    </svg>"; 
        } elseif ($degree >= 247.5 && $degree < 292.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5h-11.793l3.146-3.146a.5.5 0 0 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L1.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                    </svg>"; 
        } elseif ($degree >= 292.5 && $degree < 337.5) {
            return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-left' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M2 2.5a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L1.5 14.293V3a.5.5 0 0 1 .5-.5'/>
                    </svg>"; 
        }
    }

    if (isset($dados['error'])) {
        echo "<p>Erro na resposta da API: " . $dados['error'] . "</p>";
    } else {
        if (isset($dados['data'][0])) {
            $dia = $dados['data'][0]; 
            $data = $dia['date_br'];
            $temp_min = $dia['temperature']['min'];
            $temp_max = $dia['temperature']['max'];
            $chuva = $dia['rain']['probability'] ?? 0;
            $vento_velocidade = $dia['wind']['velocity_avg'];
            $vento_direcao_graus = $dia['wind']['direction_degree'] ?? null;
            $umidade_min = $dia['humidity']['min'];
            $umidade_max = $dia['humidity']['max'];

            $nascer_do_sol = new DateTime($dia['sun']['sunrise']);
            $por_do_sol = new DateTime($dia['sun']['sunset']);
            $nascer_do_sol = $nascer_do_sol->format('H:i');
            $por_do_sol = $por_do_sol->format('H:i');

            $dawn_condicao = $dia['text_icon']['icon']['dawn'] ?? 'Condição desconhecida';
            $morning_condicao = $dia['text_icon']['icon']['morning'] ?? 'Condição desconhecida';
            $afternoon_condicao = $dia['text_icon']['icon']['afternoon'] ?? 'Condição desconhecida';
            $night_condicao = $dia['text_icon']['icon']['night'] ?? 'Condição desconhecida';
            $descricao_condicao = $dia['text_icon']['text']['pt'] ?? 'Condição desconhecida';

           
            $vento_direcao_cardinal = getCardinalDirection($vento_direcao_graus);
            $vento_icon = getWindDirectionIcon($vento_direcao_graus); 

            if ($chuva < 50) {
                $icone = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg>';
            } elseif ($chuva < 75) {
                $icone = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-half" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/><path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/></svg>';
            } else {
                $icone = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-fill" viewBox="0 0 16 16"><path d="M8 16a6 6 0 0 0 6-6c0-1.655-1.122-2.904-2.432-4.362C10.254 4.176 8.75 2.503 8 0c0 0-6 5.686-6 10a6 6 0 0 0 6 6M6.646 4.646l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448c.82-1.641 1.717-2.753 2.093-3.13"/></svg>';
            }

            echo "<div class='weather-card'>";
            echo "<h2>Previsão para o dia: {$data}</h2>";
            echo "<img src='realistic/70px/{$dawn_condicao}.png' alt='Ícone do clima' class='weather-icon'>";
            echo "<img src='realistic/70px/{$morning_condicao}.png' alt='Ícone do clima' class='weather-icon'>";
            echo "<img src='realistic/70px/{$afternoon_condicao}.png' alt='Ícone do clima' class='weather-icon'>";
            echo "<img src='realistic/70px/{$night_condicao}.png' alt='Ícone do clima' class='weather-icon'>";

            echo "<p><strong>Condição (Descrição):</strong> {$descricao_condicao}</p>"; 
            echo "<p><strong>Temperatura Mínima:</strong> 
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down' viewBox='0 0 16 16'>
              <path fill-rule='evenodd' d='M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1'/>
            </svg>
            <span style='color: #d32f2f;'>{$temp_min}°C</span></p>";
            echo "<p><strong>Temperatura Máxima:</strong> 
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up' viewBox='0 0 16 16'>
              <path fill-rule='evenodd' d='M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5'/>
            </svg>
            <span style='color: #d32f2f;'>{$temp_max}°C</span></p>";
            echo "<p><strong>Gotas de chuva:</strong> {$icone} <span style='color: #1976d2;'>{$chuva}%</span></p>";            echo "<p><strong>Velocidade do vento:</strong> <span style='color: #1976d2;'>{$vento_velocidade} km/h</span></p>";
            echo "<p><strong>Direção do vento:</strong> {$vento_icon} <span style='color: #1976d2;'>{$vento_direcao_cardinal}</span></p>";
            echo "<p><strong>Umidade Mínima:</strong> <span style='color: #0288d1;'>{$umidade_min}%</span></p>";
            echo "<p><strong>Umidade Máxima:</strong> <span style='color: #0288d1;'>{$umidade_max}%</span></p>";
            echo "<p><strong>Horário da Alvorada:</strong> <span style='color: #8e24aa;'>{$nascer_do_sol}</span></p>";
            echo "<p><strong>Pôr do Sol:</strong> <span style='color: #8e24aa;'>{$por_do_sol}</span></p>";
            echo "<hr>";
            echo "</div>";
        }
    }
?>

    </div>
</body>
</html>