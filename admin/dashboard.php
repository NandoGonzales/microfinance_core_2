<?php
// Start session FIRST to avoid headers already sent error
if (session_status() === PHP_SESSION_NONE) session_start();

require_once(__DIR__ . '/../initialize_coreT2.php');
require_once(__DIR__ . '/inc/sess_auth.php');
require_once __DIR__ . '/inc/check_auth.php';

if (!isset($_SESSION['userdata'])) {
    header("Location: login.php");
    exit();
}

$user_fullname = $_SESSION['userdata']['full_name'] ?? 'User';
$user_role = $_SESSION['userdata']['role'] ?? 'User';

// Include layout files
include("inc/header.php");
include("inc/navbar.php");
include("inc/sidebar.php");
?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #42e695 0%, #3bb2b8 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --danger-gradient: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        --purple-gradient: linear-gradient(135deg, #9d50bb 0%, #6e48aa 100%);
        --orange-gradient: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-content {
        padding: 20px;
    }

    .kpi-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        color: white;
        min-height: 140px;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.15);
        z-index: 1;
    }

    .kpi-card .card-body {
        position: relative;
        z-index: 2;
        padding: 1.5rem;
    }

    .kpi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .kpi-card.active {
        transform: translateY(-5px);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5), 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .kpi-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.2);
    }

    .kpi-value {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 10px 0;
        text-shadow: 1px 2px 3px rgba(0, 0, 0, 0.2);
    }

    .kpi-title {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .kpi-change {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .kpi-change.positive {
        color: #4ade80;
    }

    .kpi-change.negative {
        color: #f87171;
    }

    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .chart-title {
        font-weight: 600;
        color: #2d3748;
        font-size: 1.1rem;
    }

    .chart-period {
        font-size: 0.85rem;
        color: #718096;
        background: #f7fafc;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .chart-container {
        height: 300px;
        position: relative;
    }

    .quick-stats {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .quick-stat-item {
        text-align: center;
        padding: 0.5rem;
    }

    .quick-stat-label {
        font-size: 0.8rem;
        color: #718096;
        margin-bottom: 5px;
    }

    .quick-stat-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d3748;
    }

    .detail-panel {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .table-wrap {
        max-height: 500px;
        overflow: auto;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .loading {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .loading::after {
        content: '';
        display: inline-block;
        width: 30px;
        height: 30px;
        border: 3px solid #e2e8f0;
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .kpi-value {
            font-size: 1.8rem;
        }

        .chart-container {
            height: 250px;
        }
    }
</style>

<main class="main-content" id="main-content">
    <div class="container-fluid">

        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Dashboard Overview</h1>
                        <p class="text-muted mb-0">Welcome back, <?php echo htmlspecialchars($user_fullname); ?>! Here's what's happening today.</p>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small"><?php echo date('l, F j, Y'); ?></div>
                        <div class="text-primary small">Last updated: <span id="lastUpdateTime">Just now</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="row quick-stats">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Avg. Loan Size</div>
                    <div class="quick-stat-value" id="avgLoanSize">₱0</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Collection Rate</div>
                    <div class="quick-stat-value" id="collectionRate">0%</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Avg. Overdue Days</div>
                    <div class="quick-stat-value" id="avgOverdueDays">0</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Default Rate</div>
                    <div class="quick-stat-value" id="defaultRate">0%</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Active/Inactive Ratio</div>
                    <div class="quick-stat-value" id="activeRatio">0:0</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="quick-stat-item">
                    <div class="quick-stat-label">Today's Collections</div>
                    <div class="quick-stat-value" id="todayCollections">₱0</div>
                </div>
            </div>
        </div>

        <!-- Enhanced KPI Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--primary-gradient);" data-type="members">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="kpi-title">ACTIVE MEMBERS</div>
                        <div class="kpi-value" id="card_members">0</div>
                        <div class="kpi-change positive" id="memberChange">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>0% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--success-gradient);" data-type="loans" data-filter="Active">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="kpi-title">ACTIVE LOANS</div>
                        <div class="kpi-value" id="card_active_loans">0</div>
                        <div class="kpi-change" id="loanChange">
                            <i class="bi bi-arrow-right"></i>
                            <span>Total: ₱<span id="totalLoanAmount">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--info-gradient);" data-type="savings">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-piggy-bank-fill"></i>
                        </div>
                        <div class="kpi-title">TOTAL SAVINGS</div>
                        <div class="kpi-value" id="card_savings">₱0</div>
                        <div class="kpi-change positive" id="savingsChange">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+₱0 this month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--orange-gradient);" data-type="disbursements" data-filter="Released">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="kpi-title">TOTAL DISBURSED</div>
                        <div class="kpi-value" id="card_disbursements">₱0</div>
                        <div class="kpi-change" id="disbursementChange">
                            <i class="bi bi-calendar-week"></i>
                            <span>This month: ₱<span id="monthDisbursed">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--purple-gradient);" data-type="overdue">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="kpi-title">OVERDUE LOANS</div>
                        <div class="kpi-value" id="card_overdue">0</div>
                        <div class="kpi-change negative">
                            <i class="bi bi-arrow-down-right"></i>
                            <span>Amount: ₱<span id="overdueAmount">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--danger-gradient);" data-type="defaulted">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div class="kpi-title">DEFAULTED LOANS</div>
                        <div class="kpi-value" id="card_defaulted">0</div>
                        <div class="kpi-change negative">
                            <i class="bi bi-arrow-down-right"></i>
                            <span>Amount: ₱<span id="defaultedAmount">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--warning-gradient);" data-type="pending">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="kpi-title">PENDING LOANS</div>
                        <div class="kpi-value" id="card_pending">0</div>
                        <div class="kpi-change">
                            <i class="bi bi-arrow-right"></i>
                            <span>Value: ₱<span id="pendingAmount">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="kpi-card" style="background: var(--dark-gradient);" data-type="repayments">
                    <div class="card-body">
                        <div class="kpi-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="kpi-title">TODAY'S REPAYMENTS</div>
                        <div class="kpi-value" id="card_today_repayments">0</div>
                        <div class="kpi-change positive">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>Amount: ₱<span id="todayRepaymentAmount">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Charts Section -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Loan Portfolio Distribution</div>
                        <div class="chart-period">Real-time</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartLoanStatus"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Monthly Financial Trends</div>
                        <div class="chart-period">Last 6 months</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartMonthlyTrends"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Loan Risk Analysis</div>
                        <div class="chart-period">By Risk Category</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartRiskAnalysis"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Member Activity & Growth</div>
                        <div class="chart-period">Last 12 months</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartMemberActivity"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Performance Metrics Dashboard</div>
                        <div class="chart-period">Key Indicators</div>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartPerformance"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Panel -->
        <div class="detail-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-0" id="detail_title">Details</h4>
                    <p class="text-muted mb-0 small" id="detail_subtitle">Click any KPI card to view detailed records</p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_refresh">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" id="btn_export" disabled>
                        <i class="bi bi-download"></i> Export CSV
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm" id="btn_print">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>

            <div class="table-wrap" id="detail_container">
                <div class="loading">Select a KPI card to load detailed records</div>
            </div>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    Chart.register(ChartDataLabels);

    (async function() {
        let dashboardData = null;
        let currentDetailType = null;
        let currentDetailFilter = null;

        const fmt = n => new Intl.NumberFormat().format(n);
        const fmtCurrency = n => '₱' + fmt(parseFloat(n).toFixed(2));

        function updateLastUpdateTime() {
            const now = new Date();
            document.getElementById('lastUpdateTime').textContent =
                now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
        }

        async function loadDashboardData() {
            try {
                const res = await fetch('ajax_dashboard_data.php', {
                    cache: 'no-store',
                    headers: {
                        'Cache-Control': 'no-cache',
                        'Pragma': 'no-cache'
                    }
                });
                dashboardData = await res.json();

                if (!dashboardData || dashboardData.status !== 'success') {
                    console.error('Dashboard data error:', dashboardData);
                    return;
                }

                updateDashboardUI();
                updateLastUpdateTime();
            } catch (error) {
                console.error('Failed to load dashboard data:', error);
            }
        }

        function updateDashboardUI() {
            const d = dashboardData;

            const safeUpdate = (elementId, value, defaultValue = '0', isCurrency = false) => {
                const element = document.getElementById(elementId);
                if (element) {
                    if (value === undefined || value === null || value === '' ||
                        (typeof value === 'number' && isNaN(value))) {
                        element.textContent = defaultValue;
                    } else {
                        if (isCurrency) {
                            element.textContent = '₱' + fmt(parseFloat(value).toFixed(2));
                        } else if (typeof value === 'number') {
                            element.textContent = fmt(value);
                        } else {
                            element.textContent = value;
                        }
                    }
                }
            };

            safeUpdate('card_members', d.total_members, '0');
            safeUpdate('card_active_loans', d.active_loans, '0');
            safeUpdate('card_savings', d.total_savings, '0', true);
            safeUpdate('card_disbursements', d.total_disbursed, '0', true);
            safeUpdate('card_overdue', d.overdue_loans, '0');
            safeUpdate('card_defaulted', d.defaulted_loans, '0');
            safeUpdate('card_pending', d.pending_loans, '0');
            safeUpdate('card_today_repayments', d.today_repayments, '0');
            safeUpdate('avgLoanSize', d.avg_loan_size, '0', true);
            safeUpdate('collectionRate', d.collection_rate, '0%');
            safeUpdate('avgOverdueDays', d.avg_overdue_days, '0');
            safeUpdate('defaultRate', d.default_rate, '0%');
            safeUpdate('activeRatio', d.active_ratio, '0:0');
            safeUpdate('todayCollections', d.today_collections, '0', true);

            const memberChangeEl = document.getElementById('memberChange');
            if (memberChangeEl && d.member_change !== undefined) {
                const change = parseFloat(d.member_change) || 0;
                const sign = change >= 0 ? '+' : '';
                memberChangeEl.innerHTML = `<i class="bi bi-arrow-${change >= 0 ? 'up' : 'down'}-right"></i><span>${sign}${change}% from last month</span>`;
                memberChangeEl.className = `kpi-change ${change >= 0 ? 'positive' : 'negative'}`;
            }

            safeUpdate('totalLoanAmount', d.total_loan_amount, '0');
            safeUpdate('monthDisbursed', d.this_month_disbursed, '0');
            safeUpdate('overdueAmount', d.overdue_amount, '0');
            safeUpdate('defaultedAmount', d.defaulted_amount, '0');
            safeUpdate('pendingAmount', d.pending_amount, '0');
            safeUpdate('todayRepaymentAmount', d.today_repayment_amount, '0');

            const savingsChangeEl = document.getElementById('savingsChange');
            if (savingsChangeEl && d.savings_month_change !== undefined) {
                const change = parseFloat(d.savings_month_change) || 0;
                const sign = change >= 0 ? '+' : '';
                savingsChangeEl.innerHTML = `<i class="bi bi-arrow-up-right"></i><span>${sign}₱${fmt(Math.abs(change))} this month</span>`;
            }

            updateCharts();
        }

        function updateCharts() {
            updateLoanPortfolioChart(dashboardData);
            updateMonthlyTrendsChart(dashboardData);
            updateRiskAnalysisChart(dashboardData);
            updateMemberActivityChart(dashboardData);
            updatePerformanceChart(dashboardData);
        }

        function updateLoanPortfolioChart(d) {
            const ctx = document.getElementById('chartLoanStatus');
            if (!ctx) return;
            if (window.loanPortfolioChart) window.loanPortfolioChart.destroy();

            const data = d.loan_portfolio || {
                labels: [],
                values: []
            };

            window.loanPortfolioChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#007bff'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    cutout: '65%'
                }
            });
        }

        function updateMonthlyTrendsChart(d) {
            const ctx = document.getElementById('chartMonthlyTrends');
            if (!ctx) return;
            if (window.monthlyTrendsChart) window.monthlyTrendsChart.destroy();

            const months = d.monthly_trends?.labels || [];
            const disbursements = d.monthly_trends?.disbursements || [];
            const collections = d.monthly_trends?.collections || [];

            window.monthlyTrendsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Disbursements',
                        data: disbursements,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)'
                    }, {
                        label: 'Collections',
                        data: collections,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    }
                }
            });
        }

        function updateRiskAnalysisChart(d) {
            const ctx = document.getElementById('chartRiskAnalysis');
            if (!ctx) return;
            if (window.riskAnalysisChart) window.riskAnalysisChart.destroy();

            const riskData = d.risk_analysis || {
                labels: [],
                values: []
            };

            window.riskAnalysisChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: riskData.labels,
                    datasets: [{
                        data: riskData.values,
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    }
                }
            });
        }

        function updateMemberActivityChart(d) {
            const ctx = document.getElementById('chartMemberActivity');
            if (!ctx) return;
            if (window.memberActivityChart) window.memberActivityChart.destroy();

            const months = d.member_activity?.labels || [];
            const active = d.member_activity?.active || [];
            const newMembers = d.member_activity?.new_members || [];

            window.memberActivityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Active Members',
                        data: active,
                        borderColor: '#28a745',
                        tension: 0.3
                    }, {
                        label: 'New Members',
                        data: newMembers,
                        borderColor: '#007bff',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    }
                }
            });
        }

        function updatePerformanceChart(d) {
            const ctx = document.getElementById('chartPerformance');
            if (!ctx) return;
            if (window.performanceChart) window.performanceChart.destroy();

            const metrics = d.performance_metrics || {
                labels: [],
                values: [],
                targets: []
            };

            window.performanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: metrics.labels,
                    datasets: [{
                        label: 'Current',
                        data: metrics.values,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }, {
                        label: 'Target',
                        data: metrics.targets,
                        type: 'line',
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    }
                }
            });
        }

        async function loadDetailData(type, filter = '') {
            currentDetailType = type;
            currentDetailFilter = filter;

            const container = document.getElementById('detail_container');
            const title = document.getElementById('detail_title');
            const subtitle = document.getElementById('detail_subtitle');

            const typeNames = {
                'members': 'Active Members',
                'loans': 'Active Loans',
                'savings': 'Savings Accounts',
                'disbursements': 'Loan Disbursements',
                'overdue': 'Overdue Loans',
                'defaulted': 'Defaulted Loans',
                'pending': 'Pending Loans',
                'repayments': "Today's Repayments"
            };

            if (title) title.textContent = typeNames[type] || 'Details';
            if (subtitle) subtitle.textContent = filter ? `Filter: ${filter}` : 'All records';
            if (container) container.innerHTML = '<div class="loading">Loading detailed records...</div>';

            const exportBtn = document.getElementById('btn_export');
            if (exportBtn) exportBtn.disabled = true;

            try {
                const params = new URLSearchParams({
                    type,
                    filter
                });
                const res = await fetch(`ajax_dashboard_details.php?${params}`, {
                    cache: 'no-store'
                });
                const data = await res.json();

                if (!data || data.status !== 'success') {
                    throw new Error('Failed to load details');
                }

                if (!data.rows || data.rows.length === 0) {
                    if (container) container.innerHTML = '<div class="alert alert-info">No records found for this category.</div>';
                    return;
                }

                const columns = data.columns || Object.keys(data.rows[0] || {});
                let html = '<div class="table-responsive"><table class="table table-hover table-sm"><thead class="table-light"><tr>';

                columns.forEach(col => {
                    html += `<th>${col.toUpperCase()}</th>`;
                });
                html += '</tr></thead><tbody>';

                data.rows.forEach(row => {
                    html += '<tr>';
                    columns.forEach(col => {
                        let value = row[col];
                        if (value === null || value === undefined) value = '-';
                        html += `<td>${value}</td>`;
                    });
                    html += '</tr>';
                });
                html += '</tbody></table></div>';

                if (container) container.innerHTML = html;
                if (exportBtn) exportBtn.disabled = false;

            } catch (error) {
                console.error('Error loading details:', error);
                if (container) {
                    container.innerHTML = '<div class="alert alert-danger">Error loading details. Please try again.</div>';
                }
            }
        }

        document.querySelectorAll('.kpi-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.kpi-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                const type = card.dataset.type;
                const filter = card.dataset.filter || '';
                loadDetailData(type, filter);
            });
        });

        const refreshBtn = document.getElementById('btn_refresh');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                loadDashboardData();
                if (currentDetailType) {
                    loadDetailData(currentDetailType, currentDetailFilter);
                }
            });
        }

        const printBtn = document.getElementById('btn_print');
        if (printBtn) {
            printBtn.addEventListener('click', () => window.print());
        }

        await loadDashboardData();
        setInterval(loadDashboardData, 60000);

    })();
</script>

<script>
// Simple Auto Logout after 2 minutes of inactivity
let inactivityTimer;
const logoutTime = 120000;

function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(logoutDueToInactivity, logoutTime);
}

function logoutDueToInactivity() {
    alert('You have been logged out due to 2 minutes of inactivity.');
    window.location.href = '/coret2/admin/login.php?timeout=1&auto=1';
}

resetInactivityTimer();

['mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
    window.addEventListener(event, resetInactivityTimer);
});
</script>

<?php include("inc/footer.php"); ?>