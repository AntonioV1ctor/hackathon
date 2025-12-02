INSERT INTO cidades (nome, slug, descricao) VALUES
('Campo Grande', 'campo-grande', 'Capital do estado de MS.'),
('Bonito', 'bonito', 'Um dos principais destinos turísticos de ecoturismo no Brasil.'),
('Corumbá', 'corumba', 'Cidade histórica e entrada do Pantanal.');

INSERT INTO destinos_turisticos (nome, slug, cidade_id, categoria, descricao) VALUES
('Gruta do Lago Azul', 'gruta-lago-azul', 2, 'natureza', 'Principal cartão postal de Bonito.'),
('Estrada Parque Pantanal', 'estrada-parque-pantanal', 3, 'natureza', 'Acesso ao Pantanal com vida selvagem.'),
('Parque das Nações Indígenas', 'parque-nacoes', 1, 'natureza', 'Parque urbano em Campo Grande.');

INSERT INTO restaurantes (nome, slug, cidade_id, tipo_cozinha, faixa_preco) VALUES
('Casa do Peixe', 'casa-do-peixe', 1, 'Pantaneira', 'medio'),
('Juanita', 'juanita', 2, 'Peixes e Carnes', 'medio'),
('Churrascaria do Gaúcho', 'churrascaria-gaucho', 1, 'Churrasco', 'alto');

INSERT INTO eventos (nome, slug, cidade_id, descricao, data_inicio) VALUES
('Festival do Sobá', 'festival-soba', 1, 'Evento gastronômico tradicional.', '2025-08-10');
