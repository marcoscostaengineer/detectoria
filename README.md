# Question & AI Detector API

Esta API combina duas funcionalidades principais:
1. **Modificador de Questões** – Reescreve questões para dificultar respostas por IA.
2. **Detector de Texto Gerado por IA** – Analisa respostas para identificar padrões de IA.

## 📌 Funcionalidades

### 🔹 Modificador de Questões
- Reescreve questões substituindo palavras-chave por sinônimos ou descrições alternativas.
- Adiciona um nível de complexidade baseado no banco de dados.
- Torna as questões menos previsíveis para ferramentas de IA.

### 🔹 Detector de IA
- Analisa a resposta e identifica padrões comuns em textos gerados por IA.
- Verifica uso excessivo de conectivos, frases longas e termos suspeitos.
- Retorna um índice de probabilidade de a resposta ter sido gerada por IA.

---

## 🛠 Tecnologias Utilizadas
- **PHP** – Backend da API.
- **MySQL** – Banco de dados para armazenar palavras-chave e padrões de texto.
- **Apache/Nginx** – Servidor web.

---

## 📦 Instalação e Configuração

### 1️⃣ Configurar o ambiente
- Tenha um servidor local (XAMPP, WAMP, LAMP ou outro que suporte PHP e MySQL).
- Configure o banco de dados no MySQL.

### 2️⃣ Criar o Banco de Dados
1. Crie um banco de dados chamado `question_ia_db`.
2. Importe o arquivo `database.sql` para criar as tabelas e popular com dados iniciais.

### 3️⃣ Ajustar Configurações do Banco
Abra o arquivo `db.php` e edite as credenciais conforme necessário:
```php
$host = 'localhost';
$dbname = 'question_ia_db';
$user = 'root';
$pass = '';
```

---

## 🚀 Como Usar a API

### 🔹 Modificar Questão
**Endpoint:** `POST /api.php?acao=modificar_questao`

**Corpo da requisição (JSON):**
```json
{
  "texto": "O que é democracia?"
}
```

**Resposta:**
```json
{
  "questao_modificada": "Considerando o contexto atual: O que é regime baseado na participação popular? Discuta e justifique sua resposta."
}
```

---

### 🔹 Detectar IA em Resposta
**Endpoint:** `POST /api.php?acao=detectar_ia`

**Corpo da requisição (JSON):**
```json
{
  "texto": "Portanto, é importante ressaltar que a sociedade deve considerar..."
}
```

**Resposta:**
```json
{
  "probabilidade_ia": 75,
  "motivos": [
    "Palavra-chave detectada: é importante ressaltar",
    "Uso excessivo de conectivos (3 encontrados)"
  ]
}
```

---

## 📄 Estrutura do Banco de Dados

### 🔹 Tabelas Principais

#### **palavras_chave** – Substituições de palavras
| id | palavra | substituto |
|----|---------|-----------|
| 1  | capital | cidade sede do governo |
| 2  | democracia | regime baseado na participação popular |

#### **complexidade_niveis** – Estruturas para aumentar complexidade
| id | prefixo | sufixo |
|----|---------|--------|
| 1  | Analise criticamente: | e justifique sua resposta. |
| 2  | Considere o contexto atual: | e discorra sobre o tema. |

#### **palavras_suspeitas** – Termos comuns em textos gerados por IA
| id | termo | peso |
|----|-------|------|
| 1  | é importante ressaltar | 5 |
| 2  | por fim | 3 |
| 3  | em suma | 4 |

#### **analisador_estrutura** – Parâmetros para análise textual
| id | tipo | valor |
|----|------|-------|
| 1  | tamanho_frase | 20 |
| 2  | conectivo_excessivo | 3 |

---

## 📌 Melhorias Futuras
- Aprimorar o detector com Machine Learning.
- Criar um painel web para gerenciamento das questões e padrões de IA.
- Expandir o banco de dados de palavras-chave.

---

## ✨ Contribuição
Caso queira contribuir, basta adicionar novas palavras-chave no banco de dados para tornar o sistema mais eficiente.

---

### 📞 Suporte
Se tiver dúvidas ou sugestões, entre em contato!

🚀 **API pronta para dificultar a vida da IA e melhorar avaliações educacionais!**

