CREATE DATABASE IF NOT EXISTS question_ia_db;
USE question_ia_db;

CREATE TABLE IF NOT EXISTS palavras_chave (
    id INT AUTO_INCREMENT PRIMARY KEY,
    palavra VARCHAR(255) UNIQUE NOT NULL,
    substituto VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS complexidade_niveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prefixo VARCHAR(255) NOT NULL,
    sufixo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS palavras_suspeitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    termo VARCHAR(255) UNIQUE NOT NULL,
    peso INT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS analisador_estrutura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL,
    valor INT NOT NULL
);


INSERT INTO palavras_suspeitas (termo, peso) VALUES
('é relevante destacar', 4),
('em outras palavras', 4),
('à primeira vista', 3),
('sendo assim', 4),
('desse modo', 3),
('em suma', 4),
('é possível perceber', 5),
('vale ressaltar', 4),
('não obstante', 4),
('conforme mencionado anteriormente', 5),
('cumpre ressaltar', 4),
('sob essa perspectiva', 5),
('nesse sentido', 3),
('é fato que', 3),
('em síntese', 4),
('por fim', 4),
('podemos inferir que', 4),
('de acordo com estudos', 5);

INSERT INTO palavras_chave (palavra, substituto) VALUES
('governo', 'instituição administrativa do Estado'),
('imposto', 'tributo obrigatório'),
('política', 'gestão pública e tomada de decisões'),
('economia', 'sistema de produção e distribuição de bens e serviços'),
('sociedade', 'conjunto de indivíduos organizados em grupo'),
('globalização', 'processo de integração mundial'),
('sustentabilidade', 'equilíbrio entre desenvolvimento e meio ambiente'),
('ética', 'princípios morais que regem a conduta'),
('ciência', 'conjunto de conhecimentos organizados'),
('tecnologia', 'aplicação prática do conhecimento científico'),
('filosofia', 'estudo do pensamento e da existência humana'),
('direitos humanos', 'garantias fundamentais do indivíduo'),
('cultura', 'conjunto de práticas, crenças e costumes de um povo');

INSERT INTO complexidade_niveis (prefixo, sufixo) VALUES
('Discuta a relação entre:', 'e sua influência na sociedade.'),
('Analise os impactos de:', 'considerando diferentes perspectivas.'),
('Compare e contraste:', 'com base em argumentos teóricos.'),
('Justifique a importância de:', 'apresentando exemplos práticos.'),
('Explique como:', 'pode ser aplicado em diferentes contextos.'),
('Reflexione sobre:', 'e proponha possíveis soluções.'),
('Demonstre o papel de:', 'utilizando dados concretos.'),
('A partir do contexto atual,', 'desenvolva uma reflexão sobre o tema.');

INSERT INTO analisador_estrutura (tipo, valor) VALUES
('tamanho_frase', 20),
('conectivo_excessivo', 3);
