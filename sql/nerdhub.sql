-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 03:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nerdhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `atletica_membros`
--

CREATE TABLE `atletica_membros` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atletica_membros`
--

INSERT INTO `atletica_membros` (`id`, `nome`, `cargo`, `foto`, `instagram_url`, `data_criacao`) VALUES
(1, 'João Lucas', 'Presidente', NULL, '', '2025-06-25 21:07:14'),
(2, 'Moisés', 'Vice Presidente', NULL, '', '2025-06-26 00:39:47'),
(3, 'Alynne', 'Secretária', NULL, '', '2025-06-26 00:40:14'),
(4, 'Katherinne', 'Líd.Marketing', NULL, '', '2025-06-26 00:41:13'),
(5, 'Cibelle', 'Marketing', NULL, '', '2025-06-26 00:41:56'),
(6, 'Chagas', 'Financeiro', NULL, '', '2025-06-26 00:42:27'),
(7, 'Líd. Vôlei', 'Crisler Jr', NULL, '', '2025-06-26 00:43:08'),
(8, 'Thiago', 'Líd. Futsal', NULL, '', '2025-06-26 00:43:50'),
(9, 'Gabriel', 'Líd. Basquete', 'uploads/atletica/685ca3e7b95fd_gabriel.jpeg', '', '2025-06-26 00:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cor` varchar(20) NOT NULL DEFAULT '#001A35',
  `slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `cor`, `slug`) VALUES
(2, 'Tecnologia e Inovação', '#001A35', 'tecnologia-e-inovacao'),
(3, 'Vida no Campus', '#001A35', 'vida-no-campus'),
(4, 'Oportunidades de Carreira', '#001A35', 'oportunidades-de-carreira'),
(5, 'Pesquisa Científica', '#001A35', 'pesquisa-cientifica');

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) NOT NULL,
  `categoria_id` bigint(20) DEFAULT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `data_publicacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `noticia`
--

INSERT INTO `noticia` (`id`, `usuario_id`, `categoria_id`, `titulo`, `slug`, `conteudo`, `imagem`, `data_publicacao`) VALUES
(1, 1, 2, 'Nova Descoberta em Ciência de Dados #1', 'nova-descoberta-em-ciencia-de-dados-1', 'Conteúdo detalhado sobre Nova Descoberta em Ciência de Dados #1. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2025-03-20 01:01:06'),
(4, 1, 4, 'Palestra Imperdível de Inteligência Artificial #4', 'palestra-imperdivel-de-inteligencia-artificial-4', 'Conteúdo detalhado sobre Palestra Imperdível de Inteligência Artificial #4. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-10-16 06:03:02'),
(5, 3, 2, 'O Futuro do Desenvolvimento Desenvolvimento Web #5', 'o-futuro-do-desenvolvimento-desenvolvimento-web-5', 'Conteúdo detalhado sobre O Futuro do Desenvolvimento Desenvolvimento Web #5. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-09-08 11:03:12'),
(6, 3, 2, 'Desafios da Computação Quântica em Segurança da Informação #6', 'desafios-da-computacao-quantica-em-seguranca-da-informacao-6', 'Conteúdo detalhado sobre Desafios da Computação Quântica em Segurança da Informação #6. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2025-02-19 06:43:41'),
(7, 2, 2, 'Avanços em Segurança Cibernética para Jogos Digitais #7', 'avancos-em-seguranca-cibernetica-para-jogos-digitais-7', 'Conteúdo detalhado sobre Avanços em Segurança Cibernética para Jogos Digitais #7. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-04-02 20:17:38'),
(8, 2, NULL, 'Como a Realidade Virtual está mudando Sistemas Embarcados #8', 'como-a-realidade-virtual-esta-mudando-sistemas-embarcados-8', 'Conteúdo detalhado sobre Como a Realidade Virtual está mudando Sistemas Embarcados #8. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-10-27 17:04:21'),
(10, 1, 4, 'Inscrições Abertas para Hackathon de a Área da Saúde #10', 'inscricoes-abertas-para-hackathon-de-a-area-da-saude-10', 'Conteúdo detalhado sobre Inscrições Abertas para Hackathon de a Área da Saúde #10. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-09-27 02:47:50'),
(11, 1, 3, 'Semana da Computação: Destaques de o Agronegócio #11', 'semana-da-computacao-destaques-de-o-agronegocio-11', 'Conteúdo detalhado sobre Semana da Computação: Destaques de o Agronegócio #11. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-12-21 06:41:39'),
(12, 1, NULL, 'Oportunidade de Estágio em Educação a Distância #12', 'oportunidade-de-estagio-em-educacao-a-distancia-12', 'Conteúdo detalhado sobre Oportunidade de Estágio em Educação a Distância #12. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-01-24 09:57:08'),
(13, 2, 4, 'Bolsas de Estudo para o Varejo Online #13', 'bolsas-de-estudo-para-o-varejo-online-13', 'Conteúdo detalhado sobre Bolsas de Estudo para o Varejo Online #13. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-05-17 18:05:32'),
(14, 3, 5, 'Conferência Internacional sobre Indústria 4.0 #14', 'conferencia-internacional-sobre-industria-40-14', 'Conteúdo detalhado sobre Conferência Internacional sobre Indústria 4.0 #14. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-12-18 06:37:00'),
(15, 1, NULL, 'Debate sobre Ética na Tecnologia em Cidades Inteligentes #15', 'debate-sobre-etica-na-tecnologia-em-cidades-inteligentes-15', 'Conteúdo detalhado sobre Debate sobre Ética na Tecnologia em Cidades Inteligentes #15. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-08-23 12:33:00'),
(16, 2, NULL, 'Lançamento de Novo Curso de Energias Renováveis #16', 'lancamento-de-novo-curso-de-energias-renovaveis-16', 'Conteúdo detalhado sobre Lançamento de Novo Curso de Energias Renováveis #16. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-09-19 11:09:16'),
(17, 1, 5, 'Aplicações de Machine Learning em o Mercado de Trabalho #17', 'aplicacoes-de-machine-learning-em-o-mercado-de-trabalho-17', 'Conteúdo detalhado sobre Aplicações de Machine Learning em o Mercado de Trabalho #17. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-04-03 02:53:33'),
(18, 3, 5, 'Big Data e Análise de Dados para Startups de Tecnologia #18', 'big-data-e-analise-de-dados-para-startups-de-tecnologia-18', 'Conteúdo detalhado sobre Big Data e Análise de Dados para Startups de Tecnologia #18. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2025-02-25 10:35:13'),
(19, 2, 2, 'Desenvolvimento Mobile com Inovação Aberta #19', 'desenvolvimento-mobile-com-inovacao-aberta-19', 'Conteúdo detalhado sobre Desenvolvimento Mobile com Inovação Aberta #19. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-12-13 18:19:12'),
(20, 1, 2, 'Cloud Computing: Tendências para Transformação Digital #20', 'cloud-computing-tendencias-para-transformacao-digital-20', 'Conteúdo detalhado sobre Cloud Computing: Tendências para Transformação Digital #20. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-08-24 13:21:01'),
(21, 3, 2, 'Nova Descoberta em Jogos Digitais #21', 'nova-descoberta-em-jogos-digitais-21', 'Conteúdo detalhado sobre Nova Descoberta em Jogos Digitais #21. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-03-12 15:41:22'),
(23, 1, 3, 'Workshop sobre a Área da Saúde #23', 'workshop-sobre-a-area-da-saude-23', 'Conteúdo detalhado sobre Workshop sobre a Área da Saúde #23. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-06-23 04:24:00'),
(24, 2, NULL, 'Palestra Imperdível de o Agronegócio #24', 'palestra-imperdivel-de-o-agronegocio-24', 'Conteúdo detalhado sobre Palestra Imperdível de o Agronegócio #24. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2025-05-22 04:38:33'),
(25, 3, 2, 'O Futuro do Desenvolvimento Educação a Distância #25', 'o-futuro-do-desenvolvimento-educacao-a-distancia-25', 'Conteúdo detalhado sobre O Futuro do Desenvolvimento Educação a Distância #25. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-02-07 19:38:24'),
(26, 2, 2, 'Desafios da Computação Quântica em o Varejo Online #26', 'desafios-da-computacao-quantica-em-o-varejo-online-26', 'Conteúdo detalhado sobre Desafios da Computação Quântica em o Varejo Online #26. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2024-08-22 10:12:23'),
(27, 1, 3, 'Avanços em Segurança Cibernética para Indústria 4.0 #27', 'avancos-em-seguranca-cibernetica-para-industria-40-27', 'Conteúdo detalhado sobre Avanços em Segurança Cibernética para Indústria 4.0 #27. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-07-09 23:56:15'),
(28, 2, 2, 'Como a Realidade Virtual está mudando Cidades Inteligentes #28', 'como-a-realidade-virtual-esta-mudando-cidades-inteligentes-28', 'Conteúdo detalhado sobre Como a Realidade Virtual está mudando Cidades Inteligentes #28. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-07-05 01:28:26'),
(29, 3, 5, 'Estudantes Apresentam Projetos Inovadores em Energias Renováveis #29', 'estudantes-apresentam-projetos-inovadores-em-energias-renovaveis-29', 'Conteúdo detalhado sobre Estudantes Apresentam Projetos Inovadores em Energias Renováveis #29. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-12-04 00:58:40'),
(30, 3, NULL, 'Inscrições Abertas para Hackathon de o Mercado de Trabalho #30', 'inscricoes-abertas-para-hackathon-de-o-mercado-de-trabalho-30', 'Conteúdo detalhado sobre Inscrições Abertas para Hackathon de o Mercado de Trabalho #30. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-02-17 09:34:16'),
(31, 1, 4, 'Semana da Computação: Destaques de Startups de Tecnologia #31', 'semana-da-computacao-destaques-de-startups-de-tecnologia-31', 'Conteúdo detalhado sobre Semana da Computação: Destaques de Startups de Tecnologia #31. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2024-07-28 11:08:50'),
(33, 1, 2, 'Bolsas de Estudo para Transformação Digital #33', 'bolsas-de-estudo-para-transformacao-digital-33', 'Conteúdo detalhado sobre Bolsas de Estudo para Transformação Digital #33. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-03-12 01:19:08'),
(34, 1, 2, 'Conferência Internacional sobre Ciência de Dados #34', 'conferencia-internacional-sobre-ciencia-de-dados-34', 'Conteúdo detalhado sobre Conferência Internacional sobre Ciência de Dados #34. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2025-04-27 04:46:57'),
(35, 1, NULL, 'Debate sobre Ética na Tecnologia em Engenharia de Software #35', 'debate-sobre-etica-na-tecnologia-em-engenharia-de-software-35', 'Conteúdo detalhado sobre Debate sobre Ética na Tecnologia em Engenharia de Software #35. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-03-04 05:30:03'),
(36, 1, NULL, 'Lançamento de Novo Curso de Redes de Computadores #36', 'lancamento-de-novo-curso-de-redes-de-computadores-36', 'Conteúdo detalhado sobre Lançamento de Novo Curso de Redes de Computadores #36. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-05-14 04:59:20'),
(37, 2, 4, 'Aplicações de Machine Learning em Inteligência Artificial #37', 'aplicacoes-de-machine-learning-em-inteligencia-artificial-37', 'Conteúdo detalhado sobre Aplicações de Machine Learning em Inteligência Artificial #37. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2025-05-06 22:31:21'),
(38, 2, 5, 'Big Data e Análise de Dados para Desenvolvimento Web #38', 'big-data-e-analise-de-dados-para-desenvolvimento-web-38', 'Conteúdo detalhado sobre Big Data e Análise de Dados para Desenvolvimento Web #38. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-05-08 05:28:24'),
(39, 3, 4, 'Desenvolvimento Mobile com Segurança da Informação #39', 'desenvolvimento-mobile-com-seguranca-da-informacao-39', 'Conteúdo detalhado sobre Desenvolvimento Mobile com Segurança da Informação #39. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-12-07 05:14:22'),
(40, 3, 2, 'Cloud Computing: Tendências para Jogos Digitais #40', 'cloud-computing-tendencias-para-jogos-digitais-40', 'Conteúdo detalhado sobre Cloud Computing: Tendências para Jogos Digitais #40. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2024-10-11 16:10:24'),
(41, 1, 5, 'Nova Descoberta em Sistemas Embarcados #41', 'nova-descoberta-em-sistemas-embarcados-41', 'Conteúdo detalhado sobre Nova Descoberta em Sistemas Embarcados #41. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-01-27 06:10:27'),
(42, 1, 4, 'Impacto da Inteligência Artificial em o Setor Financeiro #42', 'impacto-da-inteligencia-artificial-em-o-setor-financeiro-42', 'Conteúdo detalhado sobre Impacto da Inteligência Artificial em o Setor Financeiro #42. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-06-17 16:55:56'),
(43, 3, 5, 'Workshop sobre a Área da Saúde #43', 'workshop-sobre-a-area-da-saude-43', 'Conteúdo detalhado sobre Workshop sobre a Área da Saúde #43. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2025-04-18 04:10:17'),
(44, 3, 2, 'Palestra Imperdível de o Agronegócio #44', 'palestra-imperdivel-de-o-agronegocio-44', 'Conteúdo detalhado sobre Palestra Imperdível de o Agronegócio #44. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-02-10 09:11:52'),
(45, 1, 2, 'O Futuro do Desenvolvimento Educação a Distância #45', 'o-futuro-do-desenvolvimento-educacao-a-distancia-45', 'Conteúdo detalhado sobre O Futuro do Desenvolvimento Educação a Distância #45. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2024-07-03 10:49:25'),
(46, 2, 3, 'Desafios da Computação Quântica em o Varejo Online #46', 'desafios-da-computacao-quantica-em-o-varejo-online-46', 'Conteúdo detalhado sobre Desafios da Computação Quântica em o Varejo Online #46. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_3.jpg', '2024-08-08 10:31:42'),
(47, 3, 5, 'Avanços em Segurança Cibernética para Indústria 4.0 #47', 'avancos-em-seguranca-cibernetica-para-industria-40-47', 'Conteúdo detalhado sobre Avanços em Segurança Cibernética para Indústria 4.0 #47. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2025-02-19 11:27:05'),
(48, 1, NULL, 'Como a Realidade Virtual está mudando Cidades Inteligentes #48', 'como-a-realidade-virtual-esta-mudando-cidades-inteligentes-48', 'Conteúdo detalhado sobre Como a Realidade Virtual está mudando Cidades Inteligentes #48. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_1.jpg', '2024-09-23 07:20:50'),
(49, 2, 3, 'Estudantes Apresentam Projetos Inovadores em Energias Renováveis #49', 'estudantes-apresentam-projetos-inovadores-em-energias-renovaveis-49', 'Conteúdo detalhado sobre Estudantes Apresentam Projetos Inovadores em Energias Renováveis #49. Este evento ou desenvolvimento representa um marco significativo...', 'public/assets/img/news_placeholder_2.jpg', '2025-02-07 18:37:40'),
(50, 2, NULL, 'Inscrições Abertas para Hackathon de o Mercado de Trabalho #50', 'inscricoes-abertas-para-hackathon-de-o-mercado-de-trabalho-50', 'Conteúdo detalhado sobre Inscrições Abertas para Hackathon de o Mercado de Trabalho #50. Este evento ou desenvolvimento representa um marco significativo...', NULL, '2024-10-15 13:06:52');

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `id` bigint(20) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `youtube` varchar(100) DEFAULT NULL,
  `github` varchar(100) DEFAULT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`id`, `id_usuario`, `nome`, `sobrenome`, `data_nascimento`, `bio`, `instagram`, `facebook`, `twitter`, `linkedin`, `youtube`, `github`, `tiktok`, `foto`, `cargo`) VALUES
(1, 4, 'Jhenefer Amorim', '', NULL, 'Bem-vindo ao NerdHub!', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 11, 'Arlisson', 'Wady', NULL, 'Arlison Wady Sousa Martins é Mestre em Ciência da Computação pela Universidade Federal do Maranhão (UFMA) e possui diversas especializações na área de tecnologia e gestão. Atua como professor na Faculdade Estácio desde 2018, lecionando disciplinas como algoritmos, estrutura de dados, engenharia de software, programação orientada a objetos e banco de dados e também atua como líder do projeto de Laboratório de Transformação Digital (LTD).', NULL, NULL, NULL, '', NULL, '', NULL, 'uploads/educadores/img_6859e8dbda3d55.46215707.png', 'Professor'),
(6, 12, 'Antonio ', 'Reis', NULL, 'Antônio Reis de Sousa é professor no Centro Universitário Estácio São Luís, atuando na área de Tecnologia da Informação. Contribui na formação de alunos em cursos de graduação, aplicando seus conhecimentos em desenvolvimento de software, banco de dados e engenharia da computação.', NULL, NULL, NULL, '', NULL, '', NULL, 'uploads/educadores/img_6859e858005c40.79129706.png', 'Professor'),
(9, 15, 'Suzane Carvalho', '', NULL, 'Suzane Carvalho dos Santos é professora e coordenadora do curso de Ciência da Computação no Centro Universitário Estácio São Luís. Com vasta experiência na área acadêmica, ela aplica metodologias ativas e tecnologias educacionais para garantir uma aprendizagem significativa aos seus alunos. Além de sua atuação  docente, Suzane contribui para a Comissão Própria de Avaliação (CPA) da instituição.', NULL, NULL, NULL, '', NULL, '', NULL, 'uploads/educadores/img_6859e6e4581026.37667188.png', 'Coordenadora e Professora');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  `is_educador` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `email`, `senha`, `data_cadastro`, `is_admin`, `is_educador`) VALUES
(1, 'Usuário Editor Dois', 'editor2@example.com', '$2y$10$seuHashDeSenhaAqui2', '2025-06-03 01:39:39', 0, 0),
(2, 'Usuário Autor Tres', 'autor3@example.com', '$2y$10$seuHashDeSenhaAqui3', '2025-06-03 01:39:39', 0, 0),
(3, 'joao', 'jao@gmail.com', '$2y$10$seuHashDeSenhaAqui2', '2025-06-03 01:39:39', 0, 0),
(4, 'Jhenefer Amorim', 'jhenefer.fdc@gmail.com', '$2y$10$MTS4OU20/FOTyiLnFiKfbe7zFsFyhhEst1/niWraJnTbWFEzvmbJC', '2025-06-18 11:56:43', 0, 0),
(11, 'Arlisson.wady', 'arlison.wady@gmail.com', '$2y$10$GdKLo8plO4LluP0DjPivjugJj8EZtkuGpKmP8SizJ8MHBuFyvIx5a', '2025-06-22 11:42:53', 1, 1),
(12, 'antonio.reis', 'antonio@gmail.com', '$2y$10$r0P7nt.wdWUgFGcPWhPSMOsxBkacX6aERKDCIpWJE8M2gAM6liW7y', '2025-06-22 12:08:21', 0, 1),
(15, 'suzane.vidaloca', 'suzane.carvalho@gmail.com', '$2y$10$2gs/5FyoMZOuMJjQrmto4.juHu9cUmKUh9WSfh6TtFuGJ39OpyuGG', '2025-06-22 18:23:22', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atletica_membros`
--
ALTER TABLE `atletica_membros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_noticia_usuario` (`usuario_id`),
  ADD KEY `fk_noticia_categoria` (`categoria_id`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atletica_membros`
--
ALTER TABLE `atletica_membros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `fk_noticia_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_noticia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `fk_perfil_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
