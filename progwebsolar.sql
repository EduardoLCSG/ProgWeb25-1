--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4
-- Dumped by pg_dump version 17.4

-- Started on 2025-06-17 04:41:11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 16630)
-- Name: carrinho_itens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.carrinho_itens (
    id integer NOT NULL,
    carrinho_id integer,
    produto_id integer,
    quantidade integer NOT NULL,
    preco_unitario numeric(10,2) NOT NULL
);


--
-- TOC entry 218 (class 1259 OID 16633)
-- Name: carrinho_itens_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.carrinho_itens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4940 (class 0 OID 0)
-- Dependencies: 218
-- Name: carrinho_itens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.carrinho_itens_id_seq OWNED BY public.carrinho_itens.id;


--
-- TOC entry 219 (class 1259 OID 16634)
-- Name: carrinhos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.carrinhos (
    id integer NOT NULL,
    usuario_id integer,
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


--
-- TOC entry 220 (class 1259 OID 16638)
-- Name: carrinhos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.carrinhos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4941 (class 0 OID 0)
-- Dependencies: 220
-- Name: carrinhos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.carrinhos_id_seq OWNED BY public.carrinhos.id;


--
-- TOC entry 221 (class 1259 OID 16639)
-- Name: categorias; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.categorias (
    id integer NOT NULL,
    nome character varying(50) NOT NULL,
    descricao text DEFAULT 'A'::bpchar
);


--
-- TOC entry 222 (class 1259 OID 16643)
-- Name: categorias_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.categorias_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4942 (class 0 OID 0)
-- Dependencies: 222
-- Name: categorias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.categorias_id_seq OWNED BY public.categorias.id;


--
-- TOC entry 223 (class 1259 OID 16644)
-- Name: enderecos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.enderecos (
    id integer NOT NULL,
    usuario_id integer,
    rua character varying(100),
    numero character varying(10),
    complemento character varying(50),
    bairro character varying(50),
    cidade character varying(50),
    estado character varying(2),
    cep character varying(10)
);


--
-- TOC entry 224 (class 1259 OID 16647)
-- Name: enderecos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.enderecos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4943 (class 0 OID 0)
-- Dependencies: 224
-- Name: enderecos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.enderecos_id_seq OWNED BY public.enderecos.id;


--
-- TOC entry 225 (class 1259 OID 16648)
-- Name: pedido_itens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pedido_itens (
    id integer NOT NULL,
    pedido_id integer,
    produto_id integer,
    quantidade integer,
    preco_unitario numeric(10,2)
);


--
-- TOC entry 226 (class 1259 OID 16651)
-- Name: pedido_itens_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pedido_itens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4944 (class 0 OID 0)
-- Dependencies: 226
-- Name: pedido_itens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pedido_itens_id_seq OWNED BY public.pedido_itens.id;


--
-- TOC entry 227 (class 1259 OID 16652)
-- Name: pedidos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.pedidos (
    id integer NOT NULL,
    usuario_id integer,
    endereco_id integer,
    total numeric(10,2),
    status character varying(20) DEFAULT 'pendente'::character varying,
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


--
-- TOC entry 228 (class 1259 OID 16657)
-- Name: pedidos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.pedidos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4945 (class 0 OID 0)
-- Dependencies: 228
-- Name: pedidos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.pedidos_id_seq OWNED BY public.pedidos.id;


--
-- TOC entry 229 (class 1259 OID 16658)
-- Name: produtos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.produtos (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    descricao text,
    preco numeric(10,2) NOT NULL,
    estoque integer DEFAULT 0,
    categoria_id integer NOT NULL,
    imagem_path text
);


--
-- TOC entry 230 (class 1259 OID 16664)
-- Name: produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4946 (class 0 OID 0)
-- Dependencies: 230
-- Name: produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.produtos_id_seq OWNED BY public.produtos.id;


--
-- TOC entry 231 (class 1259 OID 16665)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome_completo character varying(100) NOT NULL,
    data_nascimento date,
    tipo_pessoa character(1),
    cpf_cnpj character varying(18),
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL,
    telefone character varying(20),
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT usuarios_tipo_pessoa_check CHECK ((tipo_pessoa = ANY (ARRAY['F'::bpchar, 'J'::bpchar])))
);


--
-- TOC entry 232 (class 1259 OID 16672)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4947 (class 0 OID 0)
-- Dependencies: 232
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 4730 (class 2604 OID 16673)
-- Name: carrinho_itens id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinho_itens ALTER COLUMN id SET DEFAULT nextval('public.carrinho_itens_id_seq'::regclass);


--
-- TOC entry 4731 (class 2604 OID 16674)
-- Name: carrinhos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinhos ALTER COLUMN id SET DEFAULT nextval('public.carrinhos_id_seq'::regclass);


--
-- TOC entry 4733 (class 2604 OID 16675)
-- Name: categorias id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categorias ALTER COLUMN id SET DEFAULT nextval('public.categorias_id_seq'::regclass);


--
-- TOC entry 4735 (class 2604 OID 16676)
-- Name: enderecos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.enderecos ALTER COLUMN id SET DEFAULT nextval('public.enderecos_id_seq'::regclass);


--
-- TOC entry 4736 (class 2604 OID 16677)
-- Name: pedido_itens id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_itens ALTER COLUMN id SET DEFAULT nextval('public.pedido_itens_id_seq'::regclass);


--
-- TOC entry 4737 (class 2604 OID 16678)
-- Name: pedidos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos ALTER COLUMN id SET DEFAULT nextval('public.pedidos_id_seq'::regclass);


--
-- TOC entry 4740 (class 2604 OID 16679)
-- Name: produtos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produtos ALTER COLUMN id SET DEFAULT nextval('public.produtos_id_seq'::regclass);


--
-- TOC entry 4742 (class 2604 OID 16680)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 4919 (class 0 OID 16630)
-- Dependencies: 217
-- Data for Name: carrinho_itens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.carrinho_itens (id, carrinho_id, produto_id, quantidade, preco_unitario) FROM stdin;
\.


--
-- TOC entry 4921 (class 0 OID 16634)
-- Dependencies: 219
-- Data for Name: carrinhos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.carrinhos (id, usuario_id, criado_em) FROM stdin;
\.


--
-- TOC entry 4923 (class 0 OID 16639)
-- Dependencies: 221
-- Data for Name: categorias; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.categorias (id, nome, descricao) FROM stdin;
1	Painéis Solares	Módulos fotovoltaicos para captação da luz solar e geração de energia elétrica.
2	Inversores	Equipamentos que convertem a corrente contínua (CC) dos painéis em corrente alternada (CA) para uso.
3	Baterias	Sistemas de armazenamento para garantir energia em períodos sem sol (sistemas Off-Grid ou Híbridos).
4	Controladores de Carga	Gerenciam o carregamento das baterias, protegendo-as contra sobrecarga e descarga excessiva.
5	Cabos e Conectores	Componentes para realizar a conexão segura e eficiente entre as partes do sistema solar.
6	Estruturas de Fixação	Suportes e perfis metálicos para a instalação segura dos painéis em diferentes tipos de superfícies.
7	Bombeamento Solar	Soluções de bombas d'água alimentadas por energia solar, ideais para locais remotos.
8	Kits Solares	Conjuntos completos com todos os componentes necessários para a montagem de um sistema fotovoltaico.
\.


--
-- TOC entry 4925 (class 0 OID 16644)
-- Dependencies: 223
-- Data for Name: enderecos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.enderecos (id, usuario_id, rua, numero, complemento, bairro, cidade, estado, cep) FROM stdin;
\.


--
-- TOC entry 4927 (class 0 OID 16648)
-- Dependencies: 225
-- Data for Name: pedido_itens; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pedido_itens (id, pedido_id, produto_id, quantidade, preco_unitario) FROM stdin;
\.


--
-- TOC entry 4929 (class 0 OID 16652)
-- Dependencies: 227
-- Data for Name: pedidos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.pedidos (id, usuario_id, endereco_id, total, status, criado_em) FROM stdin;
\.


--
-- TOC entry 4931 (class 0 OID 16658)
-- Dependencies: 229
-- Data for Name: produtos; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.produtos (id, nome, descricao, preco, estoque, categoria_id, imagem_path) FROM stdin;
1	Painel Solar 550W	Painel solar monocristalino de alta eficiência, ideal para sistemas residenciais e comerciais.	850.00	150	1	/static/images/produtos/painel-solar-550w-1.jpg
2	Inversor Grid-Tie 5kW	Inversor para conexão à rede, com monitoramento Wi-Fi integrado e alta performance.	3200.50	45	2	/static/images/produtos/inversor-grid-tie-5kw-2.jpg
3	Bateria Estacionária 150Ah	Bateria de ciclo profundo para sistemas off-grid, garantindo autonomia energética.	980.75	80	3	/static/images/produtos/bateria-estacionaria-150ah-3.jpg
4	Controlador de Carga MPPT 40A	Controlador de carga com tecnologia MPPT para máxima captação de energia dos painéis.	450.00	110	4	/static/images/produtos/controlador-carga-mppt-40a-4.jpg
5	Cabo Solar 6mm² (Rolo 100m)	Cabo flexível com proteção UV, específico para instalações fotovoltaicas. Rolo com 100 metros.	350.25	200	5	/static/images/produtos/cabo-solar-6mm-rolo-100m-5.jpg
6	Conector MC4 Par	Par de conectores (macho e fêmea) para conexão segura de painéis solares.	15.00	1500	5	/static/images/produtos/conector-mc4-par-6.jpg
7	Microinversor 800W	Microinversor para dois painéis, otimizando a geração individual de cada módulo.	1100.00	60	2	/static/images/produtos/microinversor-800w-7.jpg
8	Estrutura de Fixação Telhado Cerâmico	Kit completo de estrutura de alumínio para fixação de 4 painéis em telhado cerâmico.	680.90	95	6	/static/images/produtos/estrutura-telhado-ceramico-8.jpg
9	Bomba D'água Solar	Bomba submersa para poços, alimentada diretamente por painéis solares. Ideal para áreas rurais.	1800.00	30	7	/static/images/produtos/bomba-dagua-solar-9.jpg
10	Kit Solar Off-Grid 1.5kWp	Kit completo para sistema isolado, inclui painéis, controlador, inversor e baterias.	7500.00	15	8	/static/images/produtos/kit-solar-off-grid-1-5kwp-10.jpg
11	Painel Solar 450W Bifacial	Painel com tecnologia bifacial que capta luz de ambos os lados, aumentando a geração.	980.00	90	1	/static/images/produtos/painel-solar-450w-bifacial-11.jpg
12	Inversor Off-Grid 3kW Onda Pura	Inversor para sistemas isolados com saída de onda senoidal pura, ideal para equipamentos sensíveis.	2500.00	35	2	/static/images/produtos/inversor-off-grid-3kw-onda-pura-12.jpg
13	Bateria de Lítio 200Ah LiFePO4	Bateria de alta performance e longa vida útil (6000 ciclos) com BMS integrado.	5900.00	20	3	/static/images/produtos/bateria-litio-200ah-lifepo4-13.jpg
14	Estrutura para Telhado Metálico	Kit de fixação para telhas trapezoidais, com parafusos auto brocantes e vedação.	350.00	130	6	/static/images/produtos/estrutura-telhado-metalico-14.jpg
15	Disjuntor DC 2P 20A	Disjuntor bipolar para proteção de strings fotovoltaicas em corrente contínua.	65.50	400	5	/static/images/produtos/disjuntor-dc-2p-20a-15.jpg
16	Kit Solar para Iluminação de Jardim	Kit pequeno com 1 painel de 20W, bateria, controlador e 4 luminárias LED.	450.80	55	8	/static/images/produtos/kit-solar-iluminacao-jardim-16.jpg
17	Painel Solar Flexível 150W	Painel leve e flexível, ideal para motorhomes, barcos e superfícies curvas.	750.00	40	1	/static/images/produtos/painel-solar-flexivel-150w-17.jpg
18	Controlador de Carga MPPT 60A	Controlador de alta capacidade para bancos de bateria de 12V, 24V ou 48V.	950.00	75	4	/static/images/produtos/controlador-carga-mppt-60a-18.jpg
19	Monitor de Bateria Digital	Shunt com display digital para monitoramento preciso da tensão, corrente e carga da bateria.	210.00	95	3	/static/images/produtos/monitor-bateria-digital-19.jpg
20	DPS (Protetor de Surto) DC 1000V	Dispositivo de Proteção contra Surtos para o lado de corrente contínua do sistema.	120.00	250	5	/static/images/produtos/dps-protetor-surto-dc-1000v-20.jpg
21	Inversor Grid-Tie 15kW Trifásico	Inversor robusto para projetos comerciais e industriais com rede trifásica.	11500.00	18	2	/static/images/produtos/inversor-grid-tie-15kw-trifasico-21.jpg
22	Kit Bomba Solar 1CV com Painéis	Kit completo com bomba de 1CV, driver e 4 painéis de 340W para poços de até 80m.	9800.00	12	7	/static/images/produtos/kit-bomba-solar-1cv-paineis-22.jpg
23	Alicate Crimpador de Conector MC4	Ferramenta profissional para crimpagem perfeita de terminais e conectores do tipo MC4.	180.00	88	5	/static/images/produtos/alicate-crimpador-mc4-23.jpg
24	Kit Grid-Tie 5kWp Completo	Kit para conexão à rede com 10 painéis de 500W, inversor de 5kW, estrutura e cabos.	19900.00	10	8	/static/images/produtos/kit-grid-tie-5kwp-completo-24.jpg
25	Painel Solar 150W	Painel policristalino para pequenas aplicações, como eletrificação de cercas e sistemas de alarme.	420.00	110	1	/static/images/produtos/painel-solar-150w-25.jpg
26	String Box 4 Entradas / 1 Saída	Caixa de junção com proteção completa (DPS e fusíveis) para 4 strings.	890.00	60	5	/static/images/produtos/string-box-4-entradas-1-saida-26.jpg
27	Microinversor 2000W	Microinversor para até 4 painéis de alta potência, com monitoramento individual por módulo.	2200.00	50	2	/static/images/produtos/microinversor-2000w-27.jpg
28	Estrutura de Montagem em Solo (Ground Mount)	Estrutura de aço galvanizado para instalação de grande quantidade de painéis no solo.	2500.00	30	6	/static/images/produtos/estrutura-montagem-solo-28.jpg
29	Bateria Estacionária 240Ah	Bateria chumbo-ácido de grande capacidade para longos períodos de autonomia.	1950.00	45	3	/static/images/produtos/bateria-estacionaria-240ah-29.jpg
30	Driver para Bomba Solar	Controlador/Driver avulso para bombas solares de até 3CV, com tecnologia MPPT.	1300.00	28	7	/static/images/produtos/driver-bomba-solar-30.jpg
\.


--
-- TOC entry 4933 (class 0 OID 16665)
-- Dependencies: 231
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.usuarios (id, nome_completo, data_nascimento, tipo_pessoa, cpf_cnpj, email, senha, telefone, criado_em) FROM stdin;
16	eduardo	\N	\N	\N	eduardooooooo@gmail.com	$2y$12$Sgghn9qMeCT5bN8F7pcniuTOMY59tRIOKkkE5Q8gyGi1iKbbChKnm	\N	2025-06-16 02:10:02.467587
17	eduardo	\N	\N	\N	eduardo@gmail.com	$2y$12$k8K5JsSwJn.qjHcrNh3OUebMv8WdC8OCGO1rFRsmlcSftPC6M1tQm	\N	2025-06-16 03:23:43.410497
18	qwe	\N	\N	\N	qwe@qwe.com	$2y$12$d.1RJnEkIW6AMKjkIBeeX..FsInaRYZV4AbfLw8k/a51JVDJ3tDle	\N	2025-06-16 23:24:04.892922
19	asdf	\N	\N	\N	asdf@gmail.com	$2y$12$pmzCa6CDXzTwHOOzvfglG.KjXzxDWZCCTOHmn5mBx0BoYPEHVeZfG	\N	2025-06-17 00:56:17.584444
\.


--
-- TOC entry 4948 (class 0 OID 0)
-- Dependencies: 218
-- Name: carrinho_itens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.carrinho_itens_id_seq', 1, false);


--
-- TOC entry 4949 (class 0 OID 0)
-- Dependencies: 220
-- Name: carrinhos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.carrinhos_id_seq', 1, false);


--
-- TOC entry 4950 (class 0 OID 0)
-- Dependencies: 222
-- Name: categorias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.categorias_id_seq', 1, false);


--
-- TOC entry 4951 (class 0 OID 0)
-- Dependencies: 224
-- Name: enderecos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.enderecos_id_seq', 1, false);


--
-- TOC entry 4952 (class 0 OID 0)
-- Dependencies: 226
-- Name: pedido_itens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pedido_itens_id_seq', 1, false);


--
-- TOC entry 4953 (class 0 OID 0)
-- Dependencies: 228
-- Name: pedidos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.pedidos_id_seq', 1, false);


--
-- TOC entry 4954 (class 0 OID 0)
-- Dependencies: 230
-- Name: produtos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.produtos_id_seq', 1, false);


--
-- TOC entry 4955 (class 0 OID 0)
-- Dependencies: 232
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 19, true);


--
-- TOC entry 4746 (class 2606 OID 16682)
-- Name: carrinho_itens carrinho_itens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinho_itens
    ADD CONSTRAINT carrinho_itens_pkey PRIMARY KEY (id);


--
-- TOC entry 4748 (class 2606 OID 16684)
-- Name: carrinhos carrinhos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinhos
    ADD CONSTRAINT carrinhos_pkey PRIMARY KEY (id);


--
-- TOC entry 4750 (class 2606 OID 16686)
-- Name: categorias categorias_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id);


--
-- TOC entry 4752 (class 2606 OID 16688)
-- Name: enderecos enderecos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.enderecos
    ADD CONSTRAINT enderecos_pkey PRIMARY KEY (id);


--
-- TOC entry 4754 (class 2606 OID 16690)
-- Name: pedido_itens pedido_itens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_itens
    ADD CONSTRAINT pedido_itens_pkey PRIMARY KEY (id);


--
-- TOC entry 4756 (class 2606 OID 16692)
-- Name: pedidos pedidos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id);


--
-- TOC entry 4758 (class 2606 OID 16694)
-- Name: produtos produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id);


--
-- TOC entry 4760 (class 2606 OID 16696)
-- Name: usuarios usuarios_cpf_cnpj_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_cpf_cnpj_key UNIQUE (cpf_cnpj);


--
-- TOC entry 4762 (class 2606 OID 16698)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 4764 (class 2606 OID 16700)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 4765 (class 2606 OID 16701)
-- Name: carrinho_itens carrinho_itens_carrinho_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinho_itens
    ADD CONSTRAINT carrinho_itens_carrinho_id_fkey FOREIGN KEY (carrinho_id) REFERENCES public.carrinhos(id);


--
-- TOC entry 4766 (class 2606 OID 16706)
-- Name: carrinho_itens carrinho_itens_produto_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinho_itens
    ADD CONSTRAINT carrinho_itens_produto_id_fkey FOREIGN KEY (produto_id) REFERENCES public.produtos(id);


--
-- TOC entry 4767 (class 2606 OID 16711)
-- Name: carrinhos carrinhos_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.carrinhos
    ADD CONSTRAINT carrinhos_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);


--
-- TOC entry 4768 (class 2606 OID 16716)
-- Name: enderecos enderecos_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.enderecos
    ADD CONSTRAINT enderecos_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);


--
-- TOC entry 4769 (class 2606 OID 16721)
-- Name: pedido_itens pedido_itens_pedido_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_itens
    ADD CONSTRAINT pedido_itens_pedido_id_fkey FOREIGN KEY (pedido_id) REFERENCES public.pedidos(id);


--
-- TOC entry 4770 (class 2606 OID 16726)
-- Name: pedido_itens pedido_itens_produto_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedido_itens
    ADD CONSTRAINT pedido_itens_produto_id_fkey FOREIGN KEY (produto_id) REFERENCES public.produtos(id);


--
-- TOC entry 4771 (class 2606 OID 16731)
-- Name: pedidos pedidos_endereco_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_endereco_id_fkey FOREIGN KEY (endereco_id) REFERENCES public.enderecos(id);


--
-- TOC entry 4772 (class 2606 OID 16736)
-- Name: pedidos pedidos_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);


--
-- TOC entry 4773 (class 2606 OID 16741)
-- Name: produtos produtos_categoria_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_categoria_id_fkey FOREIGN KEY (categoria_id) REFERENCES public.categorias(id);


-- Completed on 2025-06-17 04:41:11

--
-- PostgreSQL database dump complete
--

