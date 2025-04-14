<?php
session_start();
global $mysqli;

$user_id = $_SESSION['user_id'] ?? 0;

$limit = 20;
$page = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($page - 1) * $limit;

$totalCommissions = getTotalCommissionCount($user_id);
$totalPages = ceil($totalCommissions / $limit);

$comHistory = getCommissionHistory($user_id, $limit, $offset);

$currentMonth = date('F Y');
?>
<div class="dashboard">
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="page-title">Comissões</h1>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=withdrawals">
                <button class="btn btn-primary">
                    <i class="fas fa-money-bill-wave"></i>
                    Solicitar Saque
                </button>
            </a>
        </div>
    </nav>

    <!-- Histórico de Comissões -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Histórico de Depósitos</h3>
            <div class="flex gap-2">
                <button class="btn btn-outline">
                    <i class="fas fa-filter"></i>
                    Filtrar
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i>
                    Exportar
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Referido</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Comissão</th>
                        <th>Depositado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($comHistory)): ?>
                        <?php foreach ($comHistory as $comRow): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($comRow['data_hora'])); ?></td>
                                <td><?php echo htmlspecialchars($comRow['referido']); ?></td>
                                <td><?php echo htmlspecialchars($comRow['tipo']); ?></td>
                                <td>
                                    <?php if (strtolower($comRow['status']) === 'pago'): ?>
                                        <span class="status-badge status-approved">Pago</span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">Pendente</span>
                                    <?php endif; ?>
                                </td>
                                <!-- Agora, a coluna Comissão exibirá o valor do campo 'valor' -->
                                <td>R$ <?php echo number_format($comRow['comissao'] ?? 0, 2, ',', '.'); ?></td>
                                <!-- E a coluna Depositado exibirá o valor do campo 'comissao' -->
                                <td>R$ <?php echo number_format($comRow['valor'] ?? 0, 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhuma comissão encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?pagina=<?= $i ?>" class="btn btn-sm <?= $i == $page ? 'btn-primary' : 'btn-outline' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.pagination {
    margin-top: 1rem;
    display: flex;
    gap: 10px;
    justify-content: center;
}
</style>
