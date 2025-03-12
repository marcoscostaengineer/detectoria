<?php
header("Content-Type: application/json");
require 'db.php'; // Conexão com banco de dados

function modificar_questao($texto) {
    global $pdo;

    $texto = strtolower($texto);

    // Buscar palavras-chave e substituí-las
    $stmt = $pdo->query("SELECT palavra, substituto FROM palavras_chave");
    $palavras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($palavras as $palavra) {
        $texto = str_replace($palavra['palavra'], $palavra['substituto'], $texto);
    }

    // Adicionar complexidade conforme nível salvo no banco
    $stmt = $pdo->query("SELECT prefixo, sufixo FROM complexidade_niveis ORDER BY RAND() LIMIT 1");
    $complexidade = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($complexidade) {
        $texto = $complexidade['prefixo'] . " " . ucfirst($texto) . " " . $complexidade['sufixo'];
    }

    return json_encode(["questao_modificada" => trim($texto)], JSON_PRETTY_PRINT);
}

function detectar_ia($texto) {
    global $pdo;
    
    $texto = strtolower($texto);
    $resultado = [
        "probabilidade_ia" => 0,
        "motivos" => []
    ];

    // 1. Analisar palavras suspeitas
    $stmt = $pdo->query("SELECT termo, peso FROM palavras_suspeitas");
    $palavras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pontuacao = 0;
    foreach ($palavras as $palavra) {
        if (strpos($texto, $palavra['termo']) !== false) {
            $pontuacao += $palavra['peso'];
            $resultado["motivos"][] = "Palavra-chave detectada: " . $palavra['termo'];
        }
    }

    // 2. Analisar estrutura do texto
    $frases = preg_split('/[.!?]/', $texto);
    $total_frases = count($frases);
    $media_palavras = array_sum(array_map(fn($f) => str_word_count($f), $frases)) / max(1, $total_frases);

    $stmt = $pdo->query("SELECT tipo, valor FROM analisador_estrutura");
    $parametros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($parametros as $param) {
        if ($param['tipo'] == 'tamanho_frase' && $media_palavras > $param['valor']) {
            $pontuacao += 3;
            $resultado["motivos"][] = "Frases longas detectadas (média: {$media_palavras} palavras)";
        }
        if ($param['tipo'] == 'conectivo_excessivo') {
            $conectivos = ['portanto', 'assim', 'dessa forma', 'ou seja', 'além disso'];
            $contador_conectivos = 0;
            foreach ($conectivos as $c) {
                if (strpos($texto, $c) !== false) {
                    $contador_conectivos++;
                }
            }
            if ($contador_conectivos > $param['valor']) {
                $pontuacao += 4;
                $resultado["motivos"][] = "Uso excessivo de conectivos ({$contador_conectivos} encontrados)";
            }
        }
    }

    // 3. Normalizar pontuação para uma escala de 0 a 100
    $resultado["probabilidade_ia"] = min(100, ($pontuacao * 10));

    return json_encode($resultado, JSON_PRETTY_PRINT);
}

// Roteamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($_GET['acao'])) {
        if ($_GET['acao'] == "modificar_questao" && isset($input['texto'])) {
            echo modificar_questao($input['texto']);
        } elseif ($_GET['acao'] == "detectar_ia" && isset($input['texto'])) {
            echo detectar_ia($input['texto']);
        } else {
            echo json_encode(["erro" => "Ação ou texto inválido"], JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode(["erro" => "Nenhuma ação especificada"], JSON_PRETTY_PRINT);
    }
}
?>
