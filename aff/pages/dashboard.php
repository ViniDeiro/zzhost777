<?php
session_start();


$user_id = $_SESSION['user_id'] ?? 0;


$stats = getUserStats($user_id);


$visitorCount = getVisitorCount($user_id);


$lastCommissions = getDepositosIndiretos($user_id, 'pago');


$performanceData = getPerformanceData($user_id, 7);
?>
<div class="dashboard">
    <!-- Navbar com título da página -->
    <nav class="navbar">
        <div class="navbar-left">
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="navbar-right">
            <!-- Botão exportar-->
            <!-- <button class="btn btn-outline">
                <i class="fas fa-download"></i>
                Exportar
            </button>-->
        </div>
    </nav>

    <!-- Primeira Linha de Estatísticas -->
    <div class="grid">
        <!-- Box Comissão Disponível -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--primary-color);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Comissão Disponível</h4>
                <div class="value">
                    R$ <?php echo number_format(getAvailableCommission($user_id), 2, ',', '.'); ?>
                </div>
            </div>
        </div>
        
        <!-- Box Total Sacado -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color);">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Total Sacado</h4>
                <div class="value">
                    R$ <?php echo number_format($stats['total_sacado'], 2, ',', '.'); ?>
                </div>
            </div>
        </div>
        
        <!-- Box Indicações Diretas -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Indicações Diretas</h4>
                <div class="value">
                    <?php echo $stats['total_indications']; ?>
                </div>
            </div>
        </div>
        <!-- Box Quantidade de Depósitos -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(75, 85, 99, 0.1); color: #4B5563;">
                    <i class="fas fa-list-ol"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Depósitos</h4>
                <div class="value">
                    <?php echo $stats['qtd_depositos']; ?>
                </div>
            </div>
        </div>
        
    </div>



    <!-- Segunda Linha de Estatísticas -->
    <div class="grid">
        
        
        <!-- Box Valor Depositado -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                    <i class="fas fa-money-check-alt"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Valor Depositado</h4>
                <div class="value">
                    R$ <?php echo number_format($stats['valor_depositado'], 2, ',', '.'); ?>
                </div>
            </div>
        </div>
        
        <!-- Box Desempenho -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(107, 114, 128, 0.1); color: #6B7280;">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Desempenho</h4>
                <div class="value">
                    <?php echo number_format($stats['desempenho'], 1, ',', '.'); ?>%
                </div>
            </div>
        </div>
        
        <!-- Box Visitas Únicas -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1); color: #8B5CF6;">
                    <i class="fas fa-network-wired"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Visitas Únicas</h4>
                <div class="value">
                    <?php echo $visitorCount; ?>
                </div>
            </div>
        </div>
        
        <!-- Box Primeiros Depósitos -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Primeiros Depósitos</h4>
                <div class="value">
                    <?php echo $stats['total_depositantes']; ?>
                </div>
            </div>
        </div>
    </div>
    

    <div class="grid">

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(134, 239, 172, 0.1); color: #22c55e;">
                    <i class="fas fa-handshake"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Porcentagem Cooperação</h4>
                <div class="value">
    <?php echo number_format($stats['comissao_percentual'], 0, ',', '.') . '%'; ?>
</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                    <i class="fas fa-money-check-alt"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Próximo Salário</h4>
                <div class="value">
                    R$ <?php echo number_format($stats['prox_salario_valor'] ?? 0, 2, ',', '.'); ?>
                </div>
            </div>
        </div>

        <!-- Box Data Próximo Salário -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon" style="background: rgba(96, 165, 250, 0.1); color: #60a5fa;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="stat-info">
                <h4>Data Próximo Salário</h4>
                <div class="value">
                    <?php 
                        $nextDate = $stats['prox_salario'] ?? '';
                        echo ($nextDate != '') ? date('d/m/Y', strtotime($nextDate)) : 'DD/MM/AAAA';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Comissões -->
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Últimas Comissões</h3>
                <button class="btn btn-outline">
                    Ver todas
                </button>
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
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lastCommissions)): ?>
                            <?php foreach ($lastCommissions as $com): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($com['data_hora'])); ?></td>
                                    <td><?php echo htmlspecialchars($com['nome_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($com['tipo']); ?></td>
                                    <td>
                                        <?php if ($com['status'] === 'pago'): ?>
                                            <span class="status-badge status-approved">Aprovado</span>
                                        <?php else: ?>
                                            <span class="status-badge status-pending"><?php echo $com['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        R$ <?php echo number_format($com['comissao'] ?? 0, 2, ',', '.'); ?>
                                    </td>
                                    <td>
                                        R$ <?php echo number_format($com['valor'], 2, ',', '.'); ?>
                                    </td>
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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const performanceData = <?php echo json_encode($performanceData); ?>;
    
    const performanceOptions = {
        series: [{
            name: 'Cadastros',
            data: performanceData.cadastros
        }, {
            name: 'Depósitos Efetivados',
            data: performanceData.depositos
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#6366f1', '#0ea5e9'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 100]
            }
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        grid: {
            borderColor: '#e2e8f0',
            strokeDashArray: 4
        },
        xaxis: {
            categories: performanceData.dates,
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value.toFixed(0);
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right'
        }
    };

    const performanceChart = new ApexCharts(document.querySelector("#performanceChart"), performanceOptions);
    performanceChart.render();
});
</script>
