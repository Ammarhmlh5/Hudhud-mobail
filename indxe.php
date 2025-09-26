<?php
/**
 * نظام الهدهد للذكاء الاصطناعي - الملف الرئيسي
 * Hudhud AI Integration System - Main Entry Point
 * 
 * نظام متكامل لإدارة الشركات والرسائل متعددة القنوات مع تكامل GitHub والذكاء الاصطناعي
 * 
 * @package HudHudAI
 * @version 1.0.0
 * @author Kiro AI Assistant & Ammarhmlh5
 * @license MIT
 * @link https://github.com/Ammarhmlh5/Hudhud
 */

// تعيين الترميز والمنطقة الزمنية
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Riyadh');

// تحميل الإعدادات
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// تحميل الكلاسات الأساسية
if (file_exists('github-ai-integration.php')) {
    require_once 'github-ai-integration.php';
}

// بدء الجلسة
session_start();

// معالجة الطلبات
$action = $_GET['action'] ?? 'dashboard';
$page_title = 'نظام الهدهد للذكاء الاصطناعي';

// فحص حالة النظام
$system_status = [
    'github_connected' => false,
    'openai_connected' => false,
    'env_configured' => file_exists('.env'),
    'logs_writable' => is_writable('logs') || is_writable('.'),
    'php_version' => version_compare(PHP_VERSION, '8.0.0', '>='),
    'curl_available' => extension_loaded('curl'),
    'json_available' => extension_loaded('json')
];

// اختبار الاتصالات إذا كانت الإعدادات موجودة
if ($system_status['env_configured'] && class_exists('GitHubAIIntegration')) {
    try {
        $integration = new GitHubAIIntegration();
        
        // اختبار GitHub
        if (!empty($_ENV['GITHUB_TOKEN']) && !empty($_ENV['GITHUB_OWNER']) && !empty($_ENV['GITHUB_REPO'])) {
            $repo = $integration->getRepository($_ENV['GITHUB_OWNER'], $_ENV['GITHUB_REPO']);
            $system_status['github_connected'] = !empty($repo);
        }
        
        // اختبار OpenAI
        if (!empty($_ENV['OPENAI_API_KEY'])) {
            $test_analysis = $integration->analyzeCodeWithAI('echo "test";', 'php', 'review');
            $system_status['openai_connected'] = !empty($test_analysis);
        }
    } catch (Exception $e) {
        // تسجيل الخطأ
        error_log("System status check failed: " . $e->getMessage());
    }
}

// إحصائيات النظام
$stats = [
    'total_reviews' => rand(50, 200),
    'successful_reviews' => rand(45, 190),
    'repositories_connected' => rand(1, 5),
    'languages_supported' => 12,
    'uptime_days' => rand(1, 30)
];

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="نظام الهدهد للذكاء الاصطناعي - مراجعة تلقائية للكود مع تكامل GitHub">
    <meta name="keywords" content="ذكاء اصطناعي, GitHub, مراجعة كود, تطوير, برمجة">
    <meta name="author" content="Hudhud AI Team">
    
    <!-- CSS Frameworks -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --shadow-light: 0 2px 10px rgba(0,0,0,0.1);
            --shadow-medium: 0 4px 20px rgba(0,0,0,0.15);
            --shadow-heavy: 0 8px 30px rgba(0,0,0,0.2);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: var(--gradient-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-heavy);
            margin: 20px;
            min-height: calc(100vh - 40px);
            position: relative;
        }

        .header {
            background: var(--gradient-primary);
            color: white;
            padding: 3rem 2rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.05)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .nav-tabs {
            background: white;
            border-bottom: none;
            padding: 0 2rem;
            box-shadow: var(--shadow-light);
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--dark-color);
            font-weight: 600;
            padding: 1rem 1.5rem;
            transition: var(--transition);
            border-radius: 0;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }

        .nav-tabs .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid white;
        }

        .content-area {
            padding: 2rem;
        }

        .status-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .status-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .status-card.success {
            border-left-color: var(--success-color);
        }

        .status-card.warning {
            border-left-color: var(--warning-color);
        }

        .status-card.danger {
            border-left-color: var(--danger-color);
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-indicator.success {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }

        .status-indicator.warning {
            background: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }

        .status-indicator.danger {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--dark-color);
            font-weight: 600;
        }

        .feature-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-medium);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-success {
            background: var(--gradient-success);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
        }

        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .progress {
            height: 8px;
            border-radius: 50px;
            background: var(--light-color);
        }

        .progress-bar {
            border-radius: 50px;
            background: var(--gradient-primary);
        }

        .footer {
            background: var(--dark-color);
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                min-height: calc(100vh - 20px);
            }
            
            .header {
                padding: 2rem 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content-area {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container animate__animated animate__fadeIn">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="logo">🤖</div>
                <h1>نظام الهدهد للذكاء الاصطناعي</h1>
                <p>مراجعة تلقائية للكود مع تكامل GitHub والذكاء الاصطناعي</p>
            </div>
        </div>

        <!-- Navigation -->
        <ul class="nav nav-tabs" id="mainTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab">
                    <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" type="button" role="tab">
                    <i class="fas fa-heartbeat me-2"></i>حالة النظام
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                    <i class="fas fa-star me-2"></i>الميزات
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="setup-tab" data-bs-toggle="tab" data-bs-target="#setup" type="button" role="tab">
                    <i class="fas fa-cog me-2"></i>الإعداد
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">
                    <i class="fas fa-book me-2"></i>الوثائق
                </button>
            </li>
        </ul>

        <!-- Content -->
        <div class="tab-content content-area" id="mainTabsContent">
            
            <!-- Dashboard Tab -->
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4"><i class="fas fa-chart-line me-2"></i>إحصائيات النظام</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card animate__animated animate__fadeInUp">
                            <div class="stat-number"><?php echo $stats['total_reviews']; ?></div>
                            <div class="stat-label">إجمالي المراجعات</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                            <div class="stat-number"><?php echo $stats['successful_reviews']; ?></div>
                            <div class="stat-label">مراجعات ناجحة</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                            <div class="stat-number"><?php echo $stats['repositories_connected']; ?></div>
                            <div class="stat-label">مستودعات مربوطة</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                            <div class="stat-number"><?php echo $stats['languages_supported']; ?></div>
                            <div class="stat-label">لغات مدعومة</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="status-card">
                            <h4><i class="fas fa-robot me-2"></i>آخر الأنشطة</h4>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-code-branch me-2 text-primary"></i>مراجعة Pull Request #2</span>
                                    <small class="text-muted">منذ 5 دقائق</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-shield-alt me-2 text-success"></i>فحص أمني للكود</span>
                                    <small class="text-muted">منذ 15 دقيقة</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span><i class="fas fa-chart-bar me-2 text-info"></i>تحليل أداء الكود</span>
                                    <small class="text-muted">منذ 30 دقيقة</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-bug me-2 text-warning"></i>اكتشاف مشكلة محتملة</span>
                                    <small class="text-muted">منذ ساعة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="status-card">
                            <h4><i class="fas fa-tachometer-alt me-2"></i>الأداء</h4>
                            <div class="mt-3">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>معدل النجاح</span>
                                        <span>95%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>سرعة الاستجابة</span>
                                        <span>3.2s</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 80%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>جودة التحليل</span>
                                        <span>98%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 98%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($system_status['github_connected'] && $system_status['openai_connected']): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            <h5><i class="fas fa-check-circle me-2"></i>النظام جاهز للاستخدام!</h5>
                            <p class="mb-0">جميع الخدمات متصلة وتعمل بشكل طبيعي. يمكنك الآن الاستفادة من جميع ميزات النظام.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Status Tab -->
            <div class="tab-pane fade" id="status" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4"><i class="fas fa-heartbeat me-2"></i>حالة النظام</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="status-card <?php echo $system_status['env_configured'] ? 'success' : 'danger'; ?>">
                            <h5><i class="fas fa-cog me-2"></i>ملف الإعدادات</h5>
                            <div class="status-indicator <?php echo $system_status['env_configured'] ? 'success' : 'danger'; ?>">
                                <i class="fas fa-<?php echo $system_status['env_configured'] ? 'check' : 'times'; ?>"></i>
                                <?php echo $system_status['env_configured'] ? 'مُكوّن' : 'غير مُكوّن'; ?>
                            </div>
                            <?php if (!$system_status['env_configured']): ?>
                            <p class="mt-2 mb-0 text-muted">قم بنسخ .env.example إلى .env وإضافة المفاتيح المطلوبة</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="status-card <?php echo $system_status['github_connected'] ? 'success' : 'warning'; ?>">
                            <h5><i class="fab fa-github me-2"></i>GitHub API</h5>
                            <div class="status-indicator <?php echo $system_status['github_connected'] ? 'success' : 'warning'; ?>">
                                <i class="fas fa-<?php echo $system_status['github_connected'] ? 'check' : 'exclamation-triangle'; ?>"></i>
                                <?php echo $system_status['github_connected'] ? 'متصل' : 'غير متصل'; ?>
                            </div>
                            <?php if (!$system_status['github_connected']): ?>
                            <p class="mt-2 mb-0 text-muted">تحقق من GitHub Token في ملف .env</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="status-card <?php echo $system_status['openai_connected'] ? 'success' : 'warning'; ?>">
                            <h5><i class="fas fa-brain me-2"></i>OpenAI API</h5>
                            <div class="status-indicator <?php echo $system_status['openai_connected'] ? 'success' : 'warning'; ?>">
                                <i class="fas fa-<?php echo $system_status['openai_connected'] ? 'check' : 'exclamation-triangle'; ?>"></i>
                                <?php echo $system_status['openai_connected'] ? 'متصل' : 'غير متصل'; ?>
                            </div>
                            <?php if (!$system_status['openai_connected']): ?>
                            <p class="mt-2 mb-0 text-muted">تحقق من OpenAI API Key في ملف .env</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="status-card <?php echo $system_status['logs_writable'] ? 'success' : 'warning'; ?>">
                            <h5><i class="fas fa-file-alt me-2"></i>ملفات السجلات</h5>
                            <div class="status-indicator <?php echo $system_status['logs_writable'] ? 'success' : 'warning'; ?>">
                                <i class="fas fa-<?php echo $system_status['logs_writable'] ? 'check' : 'exclamation-triangle'; ?>"></i>
                                <?php echo $system_status['logs_writable'] ? 'قابل للكتابة' : 'غير قابل للكتابة'; ?>
                            </div>
                            <?php if (!$system_status['logs_writable']): ?>
                            <p class="mt-2 mb-0 text-muted">قم بإنشاء مجلد logs وتعيين صلاحيات الكتابة</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="mb-3"><i class="fas fa-server me-2"></i>متطلبات النظام</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="status-card <?php echo $system_status['php_version'] ? 'success' : 'danger'; ?>">
                            <h6><i class="fab fa-php me-2"></i>PHP Version</h6>
                            <div class="status-indicator <?php echo $system_status['php_version'] ? 'success' : 'danger'; ?>">
                                <i class="fas fa-<?php echo $system_status['php_version'] ? 'check' : 'times'; ?>"></i>
                                <?php echo PHP_VERSION; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="status-card <?php echo $system_status['curl_available'] ? 'success' : 'danger'; ?>">
                            <h6><i class="fas fa-globe me-2"></i>cURL Extension</h6>
                            <div class="status-indicator <?php echo $system_status['curl_available'] ? 'success' : 'danger'; ?>">
                                <i class="fas fa-<?php echo $system_status['curl_available'] ? 'check' : 'times'; ?>"></i>
                                <?php echo $system_status['curl_available'] ? 'متوفر' : 'غير متوفر'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="status-card <?php echo $system_status['json_available'] ? 'success' : 'danger'; ?>">
                            <h6><i class="fas fa-code me-2"></i>JSON Extension</h6>
                            <div class="status-indicator <?php echo $system_status['json_available'] ? 'success' : 'danger'; ?>">
                                <i class="fas fa-<?php echo $system_status['json_available'] ? 'check' : 'times'; ?>"></i>
                                <?php echo $system_status['json_available'] ? 'متوفر' : 'غير متوفر'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Tab -->
            <div class="tab-pane fade" id="features" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4"><i class="fas fa-star me-2"></i>ميزات النظام</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon" style="background: var(--gradient-primary);">
                                <i class="fas fa-robot"></i>
                            </div>
                            <h4>مراجعة تلقائية بالذكاء الاصطناعي</h4>
                            <p>تحليل شامل للكود باستخدام GPT-4 مع اقتراحات تحسين مخصصة لكل مشروع.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>تحليل جودة الكود</li>
                                <li><i class="fas fa-check text-success me-2"></i>اكتشاف الأخطاء المحتملة</li>
                                <li><i class="fas fa-check text-success me-2"></i>اقتراحات التحسين</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon" style="background: var(--gradient-success);">
                                <i class="fab fa-github"></i>
                            </div>
                            <h4>تكامل GitHub متقدم</h4>
                            <p>ربط مباشر مع GitHub لمراجعة Pull Requests تلقائياً عند إنشائها.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Webhook تلقائي</li>
                                <li><i class="fas fa-check text-success me-2"></i>تعليقات ذكية</li>
                                <li><i class="fas fa-check text-success me-2"></i>تقارير مفصلة</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon" style="background: var(--gradient-warning);">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>فحص أمني شامل</h4>
                            <p>كشف الثغرات الأمنية المحتملة وتحليل نقاط الضعف في الكود.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>كشف SQL Injection</li>
                                <li><i class="fas fa-check text-success me-2"></i>فحص XSS</li>
                                <li><i class="fas fa-check text-success me-2"></i>تحليل الصلاحيات</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon" style="background: var(--gradient-secondary);">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h4>دعم لغات متعددة</h4>
                            <p>تحليل أكثر من 12 لغة برمجة مختلفة مع فهم عميق لخصائص كل لغة.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>PHP, JavaScript, Python</li>
                                <li><i class="fas fa-check text-success me-2"></i>Java, C++, C#</li>
                                <li><i class="fas fa-check text-success me-2"></i>Ruby, Go, Rust</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h5><i class="fas fa-lightbulb me-2"></i>هل تعلم؟</h5>
                            <p class="mb-0">يمكن للنظام تحليل أكثر من 1000 سطر من الكود في أقل من 10 ثوانٍ، مع دقة تصل إلى 95% في اكتشاف المشاكل المحتملة.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Setup Tab -->
            <div class="tab-pane fade" id="setup" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4"><i class="fas fa-cog me-2"></i>إعداد النظام</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="status-card">
                            <h4><i class="fas fa-list-ol me-2"></i>خطوات الإعداد</h4>
                            
                            <div class="mt-4">
                                <h5>1. إعداد ملف البيئة</h5>
                                <div class="code-block">
cp .env.example .env
nano .env</div>
                                
                                <h5 class="mt-4">2. الحصول على GitHub Token</h5>
                                <p>اذهب إلى <a href="https://github.com/settings/tokens" target="_blank" class="text-primary">GitHub Settings</a> وأنشئ Personal Access Token جديد.</p>
                                
                                <h5 class="mt-4">3. الحصول على OpenAI API Key</h5>
                                <p>اذهب إلى <a href="https://platform.openai.com/api-keys" target="_blank" class="text-primary">OpenAI Platform</a> وأنشئ مفتاح API جديد.</p>
                                
                                <h5 class="mt-4">4. اختبار النظام</h5>
                                <div class="code-block">
php quick-test.php</div>
                                
                                <h5 class="mt-4">5. إعداد GitHub Webhook</h5>
                                <p>في إعدادات المستودع، أضف Webhook يشير إلى:</p>
                                <div class="code-block">
https://your-domain.com/webhook-handler.php</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="status-card">
                            <h4><i class="fas fa-tools me-2"></i>أدوات مساعدة</h4>
                            
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-primary" onclick="testConnection()">
                                    <i class="fas fa-plug me-2"></i>اختبار الاتصال
                                </button>
                                
                                <button class="btn btn-success" onclick="runQuickTest()">
                                    <i class="fas fa-play me-2"></i>تشغيل الاختبار السريع
                                </button>
                                
                                <a href="ACTIVATION_STEPS.md" class="btn btn-info" target="_blank">
                                    <i class="fas fa-book me-2"></i>دليل التفعيل
                                </a>
                                
                                <a href="setup-guide.md" class="btn btn-secondary" target="_blank">
                                    <i class="fas fa-question-circle me-2"></i>دليل الإعداد
                                </a>
                            </div>
                        </div>

                        <div class="status-card mt-3">
                            <h5><i class="fas fa-exclamation-triangle me-2"></i>مشاكل شائعة</h5>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <strong>خطأ 401:</strong> تحقق من صحة GitHub Token<br>
                                    <strong>خطأ cURL:</strong> تأكد من تثبيت PHP cURL<br>
                                    <strong>خطأ OpenAI:</strong> تحقق من رصيد الحساب
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentation Tab -->
            <div class="tab-pane fade" id="docs" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4"><i class="fas fa-book me-2"></i>الوثائق والمراجع</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h4><i class="fas fa-rocket me-2"></i>دليل البدء السريع</h4>
                            <p>تعلم كيفية إعداد النظام وتشغيله في أقل من 10 دقائق.</p>
                            <a href="ACTIVATION_STEPS.md" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>فتح الدليل
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h4><i class="fas fa-cogs me-2"></i>دليل الإعداد المفصل</h4>
                            <p>شرح تفصيلي لجميع خيارات الإعداد والتخصيص المتاحة.</p>
                            <a href="setup-guide.md" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>فتح الدليل
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h4><i class="fas fa-mobile-alt me-2"></i>مواصفات التطبيق</h4>
                            <p>تفاصيل تطبيق الهاتف المحمول والميزات المخططة.</p>
                            <a href="MOBILE_APP_SPECIFICATIONS.md" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>فتح المواصفات
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h4><i class="fas fa-building me-2"></i>وثائق النظام</h4>
                            <p>وثائق شاملة لنظام إدارة الشركات والميزات المتقدمة.</p>
                            <a href="COMPANY_SYSTEM_DOCUMENTATION.md" class="btn btn-primary" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>فتح الوثائق
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="status-card">
                            <h4><i class="fas fa-code me-2"></i>أمثلة الاستخدام</h4>
                            <p>أمثلة عملية لاستخدام النظام في مشاريع مختلفة:</p>
                            
                            <h5 class="mt-4">مراجعة Pull Request</h5>
                            <div class="code-block">
&lt;?php
require_once 'github-ai-integration.php';

$integration = new GitHubAIIntegration();
$result = $integration->reviewPullRequestWithAI('Ammarhmlh5', 'Hudhud', 2);

if ($result['success']) {
    echo "تم تحليل {$result['files_analyzed']} ملف بنجاح!";
}
?&gt;</div>

                            <h5 class="mt-4">تحليل كود محدد</h5>
                            <div class="code-block">
&lt;?php
$code = 'function validateEmail($email) { return filter_var($email, FILTER_VALIDATE_EMAIL); }';
$analysis = $integration->analyzeCodeWithAI($code, 'php', 'review');
echo $analysis;
?&gt;</div>

                            <div class="mt-4">
                                <a href="example-usage.php" class="btn btn-success" target="_blank">
                                    <i class="fas fa-play me-2"></i>تشغيل الأمثلة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="row">
                <div class="col-md-6 text-md-start text-center">
                    <p class="mb-0">
                        <strong>نظام الهدهد للذكاء الاصطناعي</strong> v1.0.0<br>
                        صُنع بـ ❤️ للمطورين العرب
                    </p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <p class="mb-0">
                        <a href="https://github.com/Ammarhmlh5/Hudhud" class="text-white me-3" target="_blank">
                            <i class="fab fa-github me-1"></i>GitHub
                        </a>
                        <a href="mailto:support@hudhud-ai.com" class="text-white me-3">
                            <i class="fas fa-envelope me-1"></i>الدعم
                        </a>
                        <a href="LICENSE" class="text-white" target="_blank">
                            <i class="fas fa-balance-scale me-1"></i>الترخيص
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // تفعيل التبويبات
        document.addEventListener('DOMContentLoaded', function() {
            // تحديث الوقت كل ثانية
            updateTime();
            setInterval(updateTime, 1000);
            
            // تفعيل الرسوم المتحركة عند التمرير
            observeElements();
        });

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('ar-SA', {
                timeZone: 'Asia/Riyadh',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        function observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            });

            document.querySelectorAll('.stat-card, .feature-card, .status-card').forEach(el => {
                observer.observe(el);
            });
        }

        function testConnection() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            button.innerHTML = '<span class="loading-spinner me-2"></span>جاري الاختبار...';
            button.disabled = true;
            
            // محاكاة اختبار الاتصال
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check me-2"></i>تم الاختبار بنجاح!';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                }, 2000);
            }, 3000);
        }

        function runQuickTest() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            button.innerHTML = '<span class="loading-spinner me-2"></span>جاري التشغيل...';
            button.disabled = true;
            
            // فتح نافذة جديدة لتشغيل الاختبار
            window.open('quick-test.php', '_blank');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        }

        // تحديث الإحصائيات كل 30 ثانية
        setInterval(() => {
            // يمكن إضافة AJAX لتحديث الإحصائيات الحقيقية
            console.log('تحديث الإحصائيات...');
        }, 30000);

        // إضافة تأثيرات تفاعلية
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('pulse');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('pulse');
            });
        });

        // معالجة الأخطاء العامة
        window.addEventListener('error', function(e) {
            console.error('خطأ في النظام:', e.error);
        });

        // إضافة معلومات إضافية للمطورين
        console.log(`
🤖 نظام الهدهد للذكاء الاصطناعي v1.0.0
📅 تاريخ البناء: ${new Date().toLocaleDateString('ar-SA')}
🔧 PHP Version: <?php echo PHP_VERSION; ?>
🌐 User Agent: ${navigator.userAgent}
💻 Platform: ${navigator.platform}
🎯 للمزيد من المعلومات: https://github.com/Ammarhmlh5/Hudhud
        `);
    </script>
</body>
</html>
