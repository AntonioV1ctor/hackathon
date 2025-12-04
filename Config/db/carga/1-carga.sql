USE saboresdoturismo;

-- ============================
-- 1) USUÁRIO ADMIN
-- ============================
INSERT INTO usuarios (nome, email, senha_hash, pergunta_seguranca, resposta_seguranca_hash, tipo)
VALUES (
  'Administrador',
  'admin@sabores.ms.gov',
  '$2y$12$UE951o.8kFPiv.s81T9YruKOg/ezCBtQ.6y8YTEpyqTe3V/wVwc62', -- Senha: Admin@123
  'Qual o nome da primeira cidade onde você morou?',
  '$2y$12$ADeSgXUxvdepVIGN1ZVTZOBc.25KnGyHf9fYbROVzXYeUH/dMtDgS', -- Resposta: Campo Grande
  'admin'
);

-- ============================
-- 2) RESTAURANTES DO MS
-- ============================
INSERT INTO restaurantes 
(nome, cidade, categoria, descricao, endereco, lat, log, horario_funcionamento, faixa_preco, caminho_imagem)
VALUES
('Casa do Peixe Pantaneiro', 'Campo Grande', 'Peixes e Frutos do Mar',
 'Especializado em pacu na brasa e pintado à urucum, com ambiente rústico e clima pantaneiro.',
 'Av. Afonso Pena, 4567', '-20.4697', '-54.6208', '11h - 22h', 'moderado', '/img/restaurantes/pantaneiro.jpg'),

('Churrascaria Boi de Ouro', 'Dourados', 'Churrascaria',
 'Uma das mais tradicionais da região, conhecida pelo costelão fogo de chão.',
 'Rua Cuiabá, 1290', '-22.2231', '-54.8120', '11h - 23h', 'caro', '/img/restaurantes/boideouro.jpg'),

('Sabor Caseiro da Dona Maria', 'Três Lagoas', 'Comida Caseira',
 'Buffet variado com comidas típicas regionais, incluindo arroz carreteiro e macarrão pantaneiro.',
 'Rua João Silva, 230', '-20.7841', '-51.7036', '10h - 14h', 'barato', '/img/restaurantes/donamaria.jpg'),

('Pantanal Sushi House', 'Campo Grande', 'Japonesa',
 'Combinação de culinária japonesa moderna com ingredientes regionais, incluindo sushi de pintado.',
 'Rua Ceará, 840', '-20.4542', '-54.6004', '18h - 23h', 'moderado', '/img/restaurantes/sushihouse.jpg'),

('La Trattoria Sul-Mato-Grossense', 'Campo Grande', 'Italiano/Massas',
 'Restaurante italiano sofisticado com massas artesanais e carta de vinhos selecionados.',
 'Av. Mato Grosso, 3121', '-20.4548', '-54.5880', '19h - 23h', 'sofisticado', '/img/restaurantes/trattoria.jpg'),

('Burger Pantanal', 'Naviraí', 'Lanches e Porções',
 'Hamburgueria artesanal com ingredientes regionais e combinações exclusivas.',
 'Rua das Palmeiras, 88', '-23.0614', '-54.1997', '17h - 00h', 'moderado', '/img/restaurantes/burgerpantanal.jpg'),

('Rancho do Peixe', 'Bonito', 'Peixes e Frutos do Mar',
 'Peixes frescos da região com pratos tradicionais como pintado grelhado e moqueca pantaneira.',
 'Rua Monte Castelo, 55', '-21.1269', '-56.4830', '11h - 22h', 'caro', '/img/restaurantes/ranchodopeixe.jpg'),

('Sabores do Cerrado', 'Coxim', 'Regional',
 'Restaurante regional com pratos típicos feitos com ingredientes locais.',
 'Av. Presidente Vargas, 1010', '-18.5018', '-54.7607', '10h - 15h', 'barato', '/img/restaurantes/saborescerrado.jpg'),

('Templo do Churrasco Gaúcho', 'Ponta Porã', 'Churrascaria',
 'Churrasco tradicional com cortes nobres e rodízio completo.',
 'BR-463, Km 4', '-22.5292', '-55.7201', '11h - 23h', 'caro', '/img/restaurantes/gaucho.jpg'),

('Estação Regional', 'Aquidauana', 'Regional',
 'Culinária típica com destaque para o arroz carreteiro, sopa paraguaia e farofa de banana.',
 'Rua Bodoquena, 333', '-20.4639', '-55.7867', '10h - 21h', 'moderado', '/img/restaurantes/estacaoregional.jpg');
