<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email === 'hotelmanagersconference@gmail.com' && $password === 'Temitope@1981') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid email address or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | HMC Africa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --maroon-950: #1a0510;
            --maroon-900: #2d0a1e;
            --maroon-800: #4a1030;
            --maroon-700: #6b1a43;
            --gold-300: #e8cc6a;
            --gold-400: #d4af37;
            --gold-500: #b8942a;
            --cream: #fdf7f0;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, var(--maroon-900) 0%, var(--maroon-950) 100%);
            color: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow-x: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            perspective: 1000px;
        }

        .login-card {
            background: rgba(45, 10, 30, 0.45);
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 20px;
            padding: 40px 32px;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-2px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-area img {
            height: 52px;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .logo-area h1 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--gold-300);
            letter-spacing: 0.05em;
        }

        .logo-area p {
            font-size: 12px;
            color: rgba(253, 247, 240, 0.6);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold-400);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            background: rgba(26, 5, 16, 0.6);
            border: 1px solid rgba(253, 247, 240, 0.15);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--gold-400);
            background: rgba(26, 5, 16, 0.85);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }

        .error-message {
            background: rgba(217, 83, 79, 0.15);
            border-left: 3px solid #d9534f;
            color: #ff8884;
            padding: 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 24px;
            line-height: 1.4;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--gold-400) 0%, var(--gold-500) 100%);
            color: var(--maroon-950);
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, var(--gold-300) 0%, var(--gold-400) 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.35);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: rgba(253, 247, 240, 0.4);
        }

        .footer-note a {
            color: var(--gold-300);
            text-decoration: none;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-area">
                <img src="https://hotelmanagersconference.com/landingpage/images/hmc_logo.png" alt="HMC Logo">
                <h1>HMC Africa</h1>
                <p>Management Portal</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" required placeholder="admin@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
                </div>

                <button type="submit" class="submit-btn">Secure Login →</button>
            </form>

            <div class="footer-note">
                <a href="../index.php">← Back to Homepage</a>
            </div>
        </div>
    </div>
</body>
</html>
