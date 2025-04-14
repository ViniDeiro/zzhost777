<?php
session_start();

$user_id = $_SESSION['user_id'] ?? 0;

$statsRefs = getReferralsStats($user_id);

$referralsList = getReferrals($user_id);

$currentMonth = date('F Y');
?>
<div class="dashboard">
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="page-title">Indicações</h1>
        </div>
        <div class="navbar-right">
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i>
                Filtrar
            </button>
            <button class="btn btn-outline">
                <i class="fas fa-download"></i>
                Exportar
            </button>
        </div>
    </nav>

    <!-- Estatísticas de Referidos -->
    <div class="grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Total de Referidos</h4>
                <div class="value"><?php echo $statsRefs['total']; ?></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Depositantes</h4>
                <div class="value"><?php echo $statsRefs['ativos']; ?></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Sem Depósitos</h4>
                <div class="value"><?php echo $statsRefs['pendentes']; ?></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color);">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Inativos</h4>
                <div class="value"><?php echo $statsRefs['inativos']; ?></div>
            </div>
        </div>
    </div>

    <!-- Lista de Referidos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Referidos</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data Cadastro</th>
                        <th>Status</th>
                        <th>Depósitos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($referralsList)): ?>
                        <?php foreach ($referralsList as $ref): ?>
                            <tr>
                                <td>#<?php echo $ref['id']; ?></td>
                                <td><?php echo htmlspecialchars($ref['mobile']); ?></td>
                                <!-- Supondo data_cad seja algo como 2024-03-15 10:23:00 -->
                                <td><?php echo date('d/m/Y', strtotime($ref['data_cad'])); ?></td>
                                
                                <!-- Exibindo o status_calculado que definimos na função getReferrals -->
                                <?php if ($ref['status_calculado'] === 'Ativo'): ?>
                                    <td><span class="status-badge status-approved">Ativo</span></td>
                                <?php elseif ($ref['status_calculado'] === 'Pendente'): ?>
                                    <td><span class="status-badge status-pending">Pendente</span></td>
                                <?php else: ?>
                                    <td><span class="status-badge status-inactive">Inativo</span></td>
                                <?php endif; ?>
                                
                                <!-- Depósitos -->
                                <td>R$ <?php echo number_format($ref['soma_depositos'], 2, ',', '.'); ?></td>
                                
                                
                                
                                
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Nenhum referido encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
