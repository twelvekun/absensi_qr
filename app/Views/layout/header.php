<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard'; ?> - Sistem Absensi SMP Hasyim Asy'ari</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e5631; /* Hijau tua khas sekolah */
            --secondary-color: #4c9a2a; /* Hijau muda */
            --bg-color: #f4f7f6;
            --text-dark: #333;
            --text-light: #fff;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-color);
            display: flex;
            height: 100vh;
            overflow: hidden; /* Mencegah scroll ganda */
        }

        /* --- SIDEBAR STYLING --- */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #143d22 100%);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .sidebar-header p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: var(--text-light);
            border-left-color: var(--secondary-color);
        }

        .sidebar-menu i {
            width: 25px;
            font-size: 16px;
            text-align: center;
            margin-right: 10px;
        }

        .menu-label {
            padding: 10px 25px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 15px;
        }

        /* --- MAIN CONTENT STYLING --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Topbar */
        .topbar {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            z-index: 10;
        }

        .topbar-left h3 {
            margin: 0;
            color: var(--text-dark);
            font-size: 18px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            text-align: right;
        }

        .user-info .name {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-info .role {
            display: block;
            font-size: 12px;
            color: #777;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-logout:hover { background-color: #c82333; }

        /* Dashboard Content */
        .content-wrapper {
            padding: 30px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 4px solid var(--primary-color);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(30, 86, 49, 0.1);
            color: var(--primary-color);
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
        }

        .stat-details h4 {
            margin: 0;
            font-size: 24px;
            color: var(--text-dark);
        }

        .stat-details span {
            font-size: 13px;
            color: #666;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(30, 86, 49, 0.2);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::after {
            content: '\f029'; /* Icon QR Code */
            font-family: 'FontAwesome';
            position: absolute;
            right: -20px;
            bottom: -30px;
            font-size: 150px;
            color: rgba(255,255,255,0.1);
            transform: rotate(-15deg);
        }

        .welcome-card h2 { margin: 0 0 10px 0; font-size: 24px; }
        .welcome-card p { margin: 0; font-size: 14px; opacity: 0.9; max-width: 600px; line-height: 1.6;}

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-header h2, .sidebar-header p, .sidebar-menu a span, .menu-label { display: none; }
            .sidebar-menu a { justify-content: center; padding: 15px 0; }
            .sidebar-menu i { margin-right: 0; font-size: 20px;}
            .topbar-left h3 { font-size: 16px; }
            .user-info { display: none; }
        }
    </style>
</head>
<body>