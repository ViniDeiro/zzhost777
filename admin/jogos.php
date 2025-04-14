<?php include 'partials/html.php'; ?>

<?php
#======================================#
ini_set('display_errors', 1);
error_reporting(E_ALL);
#======================================#
session_start();
include_once "services/database.php";
include_once "services/funcao.php";
include_once "services/crud.php";
include_once "services/crud-adm.php";
include_once 'services/checa_login_adm.php';
include_once "services/CSRF_Protect.php";
#======================================#

// Gera um token CSRF se ainda não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

checa_login_adm();
#======================================#

// Função para carregar todos os provedores ativos
function loadProviders() {
    global $mysqli;
    $providers = [];

    $qry = "SELECT code, name FROM provedores WHERE status = 1";
    if ($result = $mysqli->query($qry)) {
        while ($row = $result->fetch_assoc()) {
            // Normaliza o código para maiúsculas e remove espaços
            $code = strtoupper(trim($row['code']));
            $providers[$code] = $row['name'];
        }
        $result->free();
    } else {
        error_log("Erro ao buscar provedores: " . $mysqli->error);
    }

    return $providers;
}

// Carrega os provedores uma vez
$allProviders = loadProviders();

# Função para buscar todos os jogos com paginação e pesquisa
function get_games($limit, $offset, $search = '', $filters = []) {
    global $mysqli;
    $whereClauses = [];
    $params = [];
    $types = "";

    // Filtro de busca pelo nome do jogo
    if (!empty($search)) {
        $whereClauses[] = "game_name LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    // Filtro de status
    if (isset($filters['status']) && $filters['status'] !== 'all') {
        if ($filters['status'] === 'active') {
            $whereClauses[] = "status = ?";
            $params[] = 1;
            $types .= "i";
        } elseif ($filters['status'] === 'inactive') {
            $whereClauses[] = "status = ?";
            $params[] = 0;
            $types .= "i";
        }
    }

    // Filtros adicionais: distribuição e popularidade
    if (!empty($filters['distribution'])) {
        $whereClauses[] = "LOWER(distribution) = LOWER(?)";
        $params[] = trim($filters['distribution']);
        $types .= "s";
    }

    if (isset($filters['popular']) && $filters['popular'] !== '') {
        $whereClauses[] = "popular = ?";
        $params[] = (int)$filters['popular'];
        $types .= "i";
    }

    if (!empty($whereClauses)) {
        $where = implode(' AND ', $whereClauses);
        $qry = "SELECT * FROM games WHERE $where LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
    } else {
        $qry = "SELECT * FROM games LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
    }

    $stmt = $mysqli->prepare($qry);
    if (!$stmt) {
        error_log("Erro ao preparar query de busca: " . $mysqli->error);
        return [];
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

# Função para contar o total de jogos
function count_games($search = '', $filters = []) {
    global $mysqli;
    $whereClauses = [];
    $params = [];
    $types = "";

    if (!empty($search)) {
        $whereClauses[] = "game_name LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    if (isset($filters['status']) && $filters['status'] !== 'all') {
        if ($filters['status'] === 'active') {
            $whereClauses[] = "status = ?";
            $params[] = 1;
            $types .= "i";
        } elseif ($filters['status'] === 'inactive') {
            $whereClauses[] = "status = ?";
            $params[] = 0;
            $types .= "i";
        }
    }

    if (!empty($filters['distribution'])) {
        $whereClauses[] = "LOWER(distribution) = LOWER(?)";
        $params[] = trim($filters['distribution']);
        $types .= "s";
    }

    if (isset($filters['popular']) && $filters['popular'] !== '') {
        $whereClauses[] = "popular = ?";
        $params[] = (int)$filters['popular'];
        $types .= "i";
    }

    if (!empty($whereClauses)) {
        $where = implode(' AND ', $whereClauses);
        $qry = "SELECT COUNT(*) as total FROM games WHERE $where";
    } else {
        $qry = "SELECT COUNT(*) as total FROM games";
    }

    $stmt = $mysqli->prepare($qry);
    if (!$stmt) {
        error_log("Erro ao preparar query de contagem: " . $mysqli->error);
        return 0;
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}

# Função para atualizar os dados do jogo
function update_game($data) {
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE games SET 
        game_code = ?, 
        game_name = ?, 
        banner = ?, 
        status = ?, 
        provider = ?, 
        popular = ?, 
        type = ?, 
        game_type = ?,
        distribution = ? 
        WHERE id = ?");
    
    if (!$qry) {
        error_log("Erro ao preparar atualização: " . $mysqli->error);
        return false;
    }

    $qry->bind_param(
        "sssisisisi",
        $data['game_code'],
        $data['game_name'],
        $data['banner'],
        $data['status'],
        $data['provider'],
        $data['popular'],
        $data['type'],
        $data['game_type'],
        $data['distribution'],
        $data['id']
    );

    if (!$qry->execute()) {
        error_log("Erro ao atualizar jogo: " . $qry->error);
        return false;
    }
    return true;
}

# Função para inserir um novo jogo
function insert_game($data) {
    global $mysqli;
    $qry = $mysqli->prepare("INSERT INTO games (
        game_code, 
        game_name, 
        banner, 
        status, 
        provider, 
        popular, 
        type, 
        game_type, 
        distribution
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$qry) {
        error_log("Erro ao preparar inserção de jogo: " . $mysqli->error);
        return false;
    }
    
    $game_type = 0;
    
    $qry->bind_param(
        "sssisisis",
        $data['game_code'],
        $data['game_name'],
        $data['banner'],
        $data['status'],
        $data['provider'],
        $data['popular'],
        $data['type'],
        $game_type,
        $data['distribution']
    );
    
    if (!$qry->execute()) {
        error_log("Erro ao inserir jogo: " . $qry->error);
        return false;
    }
    return true;
}

# Função para atualizar o status do jogo
function update_status($id, $new_status) {
    global $mysqli;
    $qry = $mysqli->prepare("UPDATE games SET status = ? WHERE id = ?");
    
    if (!$qry) {
        error_log("Erro ao preparar atualização de status: " . $mysqli->error);
        return false;
    }
    
    $qry->bind_param("ii", $new_status, $id);
    
    if (!$qry->execute()) {
        error_log("Erro ao atualizar status: " . $qry->error);
        return false;
    }
    return true;
}

###########################
# NOVAS FUNÇÕES DE ORDEM #
###########################

function moveUp($idAtual) {
    global $mysqli;
    // Busca o jogo imediatamente acima (o maior id menor que o atual)
    $sql = "SELECT id FROM games WHERE id < ? ORDER BY id DESC LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idAtual);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $idAcima = $row['id'];
        $tempID = -9999999;
        $mysqli->query("UPDATE games SET id = $tempID WHERE id = $idAtual");
        $mysqli->query("UPDATE games SET id = $idAtual WHERE id = $idAcima");
        $mysqli->query("UPDATE games SET id = $idAcima WHERE id = $tempID");
        return true;
    }
    return false;
}

function moveDown($idAtual) {
    global $mysqli;
    // Busca o jogo imediatamente abaixo (o menor id maior que o atual)
    $sql = "SELECT id FROM games WHERE id > ? ORDER BY id ASC LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idAtual);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $idAbaixo = $row['id'];
        $tempID = -9999999;
        $mysqli->query("UPDATE games SET id = $tempID WHERE id = $idAtual");
        $mysqli->query("UPDATE games SET id = $idAtual WHERE id = $idAbaixo");
        $mysqli->query("UPDATE games SET id = $idAbaixo WHERE id = $tempID");
        return true;
    }
    return false;
}

##############################
# TRATAMENTO DAS AÇÕES POST  #
##############################

$toastType = null;
$toastMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Token CSRF inválido. Por favor, recarregue a página e tente novamente.');
        }
        $action = $_POST['action'] ?? '';

        if ($action === 'edit_game') {
            $data = [
                'id' => isset($_POST['id']) ? intval($_POST['id']) : null,
                'game_code' => trim($_POST['game_code']),
                'game_name' => trim($_POST['game_name']),
                'banner' => trim($_POST['banner']),
                'status' => intval($_POST['status']),
                'provider' => strtoupper(trim($_POST['provider'])),
                'popular' => intval($_POST['popular']),
                'type' => trim($_POST['type']),
                'distribution' => trim($_POST['distribution']),
            ];
            if ($data['id']) {
                $data['game_type'] = isset($_POST['game_type']) && $_POST['game_type'] !== '' ? intval($_POST['game_type']) : null;
                if (update_game($data)) {
                    $toastType = 'success';
                    $toastMessage = 'Jogo atualizado com sucesso!';
                } else {
                    $toastType = 'error';
                    $toastMessage = 'Erro ao atualizar o jogo. Tente novamente.';
                }
            } else {
                $data['game_type'] = 0;
                if (insert_game($data)) {
                    $toastType = 'success';
                    $toastMessage = 'Jogo adicionado com sucesso!';
                } else {
                    $toastType = 'error';
                    $toastMessage = 'Erro ao adicionar o jogo. Tente novamente.';
                }
            }
        } elseif ($action === 'update_status') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : null;
            $current_status = isset($_POST['current_status']) ? intval($_POST['current_status']) : null;
            if ($id !== null && ($current_status === 0 || $current_status === 1)) {
                $new_status = $current_status === 1 ? 0 : 1;
                if (update_status($id, $new_status)) {
                    $statusText = $new_status === 1 ? 'ativado' : 'desativado';
                    $toastType = 'success';
                    $toastMessage = "Jogo $statusText com sucesso!";
                } else {
                    $toastType = 'error';
                    $toastMessage = 'Erro ao atualizar o status do jogo. Tente novamente.';
                }
            } else {
                throw new Exception('Dados inválidos para atualização de status.');
            }
        } elseif ($action === 'add_game') {
            $data = [
                'game_code' => trim($_POST['game_code']),
                'game_name' => trim($_POST['game_name']),
                'banner' => trim($_POST['banner']),
                'status' => intval($_POST['status']),
                'provider' => strtoupper(trim($_POST['provider'])),
                'popular' => intval($_POST['popular']),
                'type' => trim($_POST['type']),
                'distribution' => trim($_POST['distribution']),
            ];
            $data['game_type'] = 0;
            if (insert_game($data)) {
                $toastType = 'success';
                $toastMessage = 'Jogo adicionado com sucesso!';
            } else {
                $toastType = 'error';
                $toastMessage = 'Erro ao adicionar o jogo. Tente novamente.';
            }
        } elseif ($action === 'move_up') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : null;
            if ($id !== null && moveUp($id)) {
                $toastType = 'success';
                $toastMessage = 'Jogo movido para cima com sucesso!';
            } else {
                $toastType = 'error';
                $toastMessage = 'Erro ao mover o jogo para cima.';
            }
        } elseif ($action === 'move_down') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : null;
            if ($id !== null && moveDown($id)) {
                $toastType = 'success';
                $toastMessage = 'Jogo movido para baixo com sucesso!';
            } else {
                $toastType = 'error';
                $toastMessage = 'Erro ao mover o jogo para baixo.';
            }
        } else {
            throw new Exception('Ação desconhecida.');
        }
    } catch (Exception $e) {
        $toastType = 'error';
        $toastMessage = $e->getMessage();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

# Configurações de paginação e filtros
$search = $_GET['search'] ?? '';
$filters = [
    'distribution' => $_GET['distribution'] ?? '',
    'popular' => $_GET['popular'] ?? '',
    'status' => $_GET['status'] ?? 'all',
];

$limit = 50;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$total_games = count_games($search, $filters);
$total_pages = ceil($total_games / $limit);
$games = get_games($limit, $offset, $search, $filters);

# Função para obter o nome do provedor usando os provedores carregados
function getProvider($cd) {
    global $allProviders;
    $cd = strtoupper(trim($cd));
    return $allProviders[$cd] ?? 'Desconhecido';
}

# Função auxiliar para verificar se o provider deve ser selecionado
function isSelectedProvider($gameProvider, $providerCode) {
    return strtoupper(trim($gameProvider)) === strtoupper(trim($providerCode)) ? 'selected' : '';
}

// Para o modal de ordenação via drag & drop: buscamos TODOS os jogos (sem paginação)
$orderQry = "SELECT id, game_name FROM games ORDER BY id ASC";
$orderResult = $mysqli->query($orderQry);
$allGamesOrder = $orderResult->fetch_all(MYSQLI_ASSOC);
?>

<head>
    <?php $title = "Gerenciamento de Jogos"; include 'partials/title-meta.php'; ?>
    <link rel="stylesheet" href="assets/libs/jsvectormap/jsvectormap.min.css">
    <!-- Inclua jQuery UI para Drag & Drop -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <?php include 'partials/head-css.php'; ?>
    
    <style>
    .custom-bg-color {
        background-color: #202221;
        color: white;
    }
    /* Estilo para indicar que as linhas são arrastáveis */
    #gamesOrderTable tbody tr {
        cursor: move;
    }
    </style>
    
</head>

<body>
    <?php include 'partials/topbar.php'; ?>
    <?php include 'partials/startbar.php'; ?>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">
                

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
  <h5>Gerenciamento de Jogos</h5>
  <div>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGameModal">
      Adicionar Jogo
    </button>
    <button class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#orderModal">
      Ordenar Jogos
    </button>
  </div>
</div>
                                <form method="GET" action="" class="mb-3">
    <div class="row gx-2">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar pelo nome do jogo" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="all" <?= $filters['status'] === 'all' ? 'selected' : '' ?>>Todos</option>
                <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>Ativos</option>
                <option value="inactive" <?= $filters['status'] === 'inactive' ? 'selected' : '' ?>>Desativados</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="distribution" class="form-select">
                <option value="">Todos</option>
                
                <option value="igamewin" <?= $filters['distribution'] === 'igamewin' ? 'selected' : '' ?>>iGameWin/iSlotFlix</option>
                <option value="Clone" <?= $filters['distribution'] === 'Clone' ? 'selected' : '' ?>>Api PgSoft 16 Jogos</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="popular" class="form-select">
                <option value="">Todos</option>
                <option value="1" <?= $filters['popular'] === '1' ? 'selected' : '' ?>>Popular</option>
                <option value="0" <?= $filters['popular'] === '0' ? 'selected' : '' ?>>Não Popular</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" type="submit">Aplicar Filtros</button>
        </div>
    </div>
</form>

                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Banner</th>
                                            <th>ID</th>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Status</th>
                                            <th>Provider</th>
                                            <th>Popular</th>
                                            <th>Tipo</th>
                                            <th>Distribuição</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($games)): ?>
                                            <tr>
                                                <td colspan="10" class="text-center">Nenhum jogo encontrado.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($games as $game): ?>
                                                <tr>
                                                    <td><img src="<?= htmlspecialchars($game['banner']) ?>" alt="Banner" class="rounded-circle" style="width: 50px; height: 50px;"></td>
                                                    <td><?= htmlspecialchars($game['id']) ?></td>
                                                    <td><?= htmlspecialchars($game['game_code']) ?></td>
                                                    <td><?= htmlspecialchars($game['game_name']) ?></td>
                                                    <td><?= $game['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                                                    <td><?= htmlspecialchars(getProvider($game['provider'])) ?></td>
                                                    <td><?= $game['popular'] == 1 ? 'Sim' : 'Não' ?></td>
                                                    <td><?= htmlspecialchars($game['type']) ?></td>
                                                    <td><span class="badge text-bg-info" style="color: black !important;"><?= htmlspecialchars($game['distribution']) ?></span></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editGameModal<?= $game['id'] ?>">Editar</button>
                                                            <!-- Formulário para Atualizar Status -->
                                                            <form method="POST" action="" style="display: inline;">
                                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                                <input type="hidden" name="action" value="update_status">
                                                                <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                                                                <input type="hidden" name="current_status" value="<?= htmlspecialchars($game['status']) ?>">
                                                                <button type="submit" class="btn btn-<?= $game['status'] == 1 ? 'warning' : 'success' ?>" onclick="return confirm('Tem certeza de que deseja <?= $game['status'] == 1 ? 'desativar' : 'ativar' ?> este jogo?');">
                                                                    <?= $game['status'] == 1 ? 'Desativar' : 'Ativar' ?>
                                                                </button>
                                                            </form>
                                                            <!-- Botões para mover o jogo -->
                                                            <form method="POST" action="" style="display:inline; margin-left:4px;">
                                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                                <input type="hidden" name="action" value="move_up">
                                                                <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                                                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="Mover para cima">↑</button>
                                                            </form>
                                                            <form method="POST" action="" style="display:inline; margin-left:4px;">
                                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                                <input type="hidden" name="action" value="move_down">
                                                                <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                                                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="Mover para baixo">↓</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Modal Editar Jogo -->
                                                <div class="modal fade" id="editGameModal<?= $game['id'] ?>" tabindex="-1" aria-labelledby="editGameModalLabel<?= $game['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editGameModalLabel<?= $game['id'] ?>">Editar Jogo</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                                    <input type="hidden" name="action" value="edit_game">
                                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                                                                    <div class="mb-3">
                                                                        <label for="game_name" class="form-label">Nome do Jogo</label>
                                                                        <input type="text" name="game_name" class="form-control" value="<?= htmlspecialchars($game['game_name']) ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="game_code" class="form-label">Código do Jogo</label>
                                                                        <input type="text" name="game_code" class="form-control" value="<?= htmlspecialchars($game['game_code']) ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="banner" class="form-label">Banner</label>
                                                                        <input type="text" name="banner" class="form-control" value="<?= htmlspecialchars($game['banner']) ?>">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Status</label>
                                                                        <select name="status" class="form-select" required>
                                                                            <option value="1" <?= $game['status'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                                                            <option value="0" <?= $game['status'] == 0 ? 'selected' : '' ?>>Inativo</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="provider" class="form-label">Provider</label>
                                                                        <select name="provider" class="form-select" required>
                                                                            <option value="">Selecione um Provedor</option>
                                                                            <?php foreach ($allProviders as $code => $name): ?>
                                                                                <option value="<?= htmlspecialchars($code) ?>" <?= isSelectedProvider($game['provider'], $code) ?>>
                                                                                    <?= htmlspecialchars($name) ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="popular" class="form-label">Popular</label>
                                                                        <select name="popular" class="form-select" required>
                                                                            <option value="1" <?= $game['popular'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                                            <option value="0" <?= $game['popular'] == 0 ? 'selected' : '' ?>>Não</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="distribution" class="form-label">Distribuição</label>
                                                                        <select name="distribution" class="form-select" required>
                                                                            <option value="Clone" <?= strtolower($game['distribution']) == 'Clone' ? 'selected' : '' ?>>Api PgSoft 16 Jogos</option>
                                                                            <option value="igamewin" <?= strtolower($game['distribution']) == 'igamewin' ? 'selected' : '' ?>>iGameWin/iSlotFlix</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="type" class="form-label">Tipo</label>
                                                                        <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($game['type']) ?>">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="game_type" class="form-label">Game Type</label>
                                                                        <input type="number" name="game_type" class="form-control" value="<?= htmlspecialchars($game['game_type']) ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($filters['status']) ?>&distribution=<?= urlencode($filters['distribution']) ?>&popular=<?= urlencode($filters['popular']) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Adicionar Jogo -->
            <div class="modal fade" id="addGameModal" tabindex="-1" aria-labelledby="addGameModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adicionar Novo Jogo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <form method="POST" action="">
                            <div class="modal-body">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                <input type="hidden" name="action" value="add_game">
                                <div class="mb-3">
                                    <label for="game_code" class="form-label">Código do Jogo</label>
                                    <input type="text" name="game_code" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="game_name" class="form-label">Nome do Jogo</label>
                                    <input type="text" name="game_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="banner" class="form-label">Banner</label>
                                    <input type="text" name="banner" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="provider" class="form-label">Provider</label>
                                    <select name="provider" class="form-select" required>
                                        <option value="">Selecione um Provedor</option>
                                        <?php foreach ($allProviders as $code => $name): ?>
                                            <option value="<?= htmlspecialchars($code) ?>">
                                                <?= htmlspecialchars($name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="popular" class="form-label">Popular</label>
                                    <select name="popular" class="form-select custom-bg-color" required>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Tipo</label>
                                    <input type="text" name="type" class="form-control" value="slot" required>
                                </div>
                                <div class="mb-3">
                                    <label for="distribution" class="form-label">Distribuição</label>
                                    <select name="distribution" class="form-select custom-bg-color" required>
                                        
                                        <option value="igamewin">iGameWin/iSlotFlix</option>
                                        <option value="Clone">Api PgSoft 16 Jogos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Adicionar Jogo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Ordenar Jogos via Drag & Drop -->
            <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel">Ordenar Jogos (Drag & Drop)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <p>Arraste as linhas para reordenar os jogos. A nova ordem será salva automaticamente.</p>
                            <table class="table" id="gamesOrderTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome do Jogo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($allGamesOrder)): ?>
                                        <?php foreach ($allGamesOrder as $g): ?>
                                            <tr data-id="<?= $g['id'] ?>">
                                                <td><?= $g['id'] ?></td>
                                                <td><?= htmlspecialchars($g['game_name']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2">Nenhum jogo encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="toastPlacement" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

            <?php include 'partials/vendorjs.php'; ?>
            <script src="assets/js/app.js"></script>
            <!-- Inclua jQuery e jQuery UI (caso ainda não estejam inclusos) -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

            <script>
                function showToast(type, message) {
                    const toastPlacement = document.getElementById('toastPlacement');
                    const toast = document.createElement('div');
                    toast.className = `toast align-items-center bg-${type} text-white border-0 fade show`;
                    toast.setAttribute('role', 'alert');
                    toast.setAttribute('aria-live', 'assertive');
                    toast.setAttribute('aria-atomic', 'true');
                    toast.innerHTML = `
                        <div class="toast-header">
                            <img src="assets/images/logo-sm.png" alt="" height="20" class="me-1">
                            <strong class="me-auto">EXPFY</strong>
                            <small>Agora</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">${message}</div>
                    `;
                    toastPlacement.appendChild(toast);
                    const bootstrapToast = new bootstrap.Toast(toast);
                    bootstrapToast.show();
                    setTimeout(() => {
                        bootstrapToast.hide();
                        setTimeout(() => toast.remove(), 500);
                    }, 3000);
                }

                <?php if ($toastType && $toastMessage): ?>
                    showToast('<?= addslashes($toastType) ?>', '<?= addslashes($toastMessage) ?>');
                <?php endif; ?>

                // Código para tornar o tbody do modal ordenável via Drag & Drop
                $(function() {
                    $("#gamesOrderTable tbody").sortable({
                        update: function(event, ui) {
                            var novaOrdem = [];
                            $("#gamesOrderTable tbody tr").each(function(){
                                novaOrdem.push($(this).data("id"));
                            });
                            // Envia a nova ordem via AJAX para update_order.php
                            $.ajax({
                                url: 'update_order.php',
                                method: 'POST',
                                data: { 
                                    order: novaOrdem, 
                                    csrf_token: '<?= htmlspecialchars($_SESSION['csrf_token']) ?>' 
                                },
                                success: function(res) {
                                    showToast('success', 'Ordem atualizada com sucesso!');
                                    // Opcional: recarregar a página para atualizar os IDs na listagem
                                    // location.reload();
                                },
                                error: function() {
                                    showToast('error', 'Erro ao atualizar a ordem.');
                                }
                            });
                        }
                    });
                });
            </script>
        </div>
    </div>
</body>
</html>