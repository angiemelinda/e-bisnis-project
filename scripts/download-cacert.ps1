# Script untuk download CA Bundle untuk fix SSL certificate issue
# Jalankan dengan: powershell -ExecutionPolicy Bypass -File scripts/download-cacert.ps1

Write-Host "Downloading CA Bundle for SSL certificate fix..." -ForegroundColor Yellow

# Create directory if not exists
$cacertPath = "C:\xampp\php\extras\ssl"
if (-not (Test-Path $cacertPath)) {
    New-Item -ItemType Directory -Path $cacertPath -Force | Out-Null
    Write-Host "Created directory: $cacertPath" -ForegroundColor Green
}

# Download CA bundle
$cacertFile = Join-Path $cacertPath "cacert.pem"
try {
    Invoke-WebRequest -Uri "https://curl.se/ca/cacert.pem" -OutFile $cacertFile -UseBasicParsing
    Write-Host "CA Bundle downloaded successfully to: $cacertFile" -ForegroundColor Green
    
    # Get php.ini path
    $phpIniPath = (php --ini | Select-String "Loaded Configuration File" | ForEach-Object { $_.Line -replace ".*:\s+" })
    
    Write-Host "`nNext steps:" -ForegroundColor Yellow
    Write-Host "1. Open php.ini file: $phpIniPath" -ForegroundColor White
    Write-Host "2. Find and uncomment/edit these lines:" -ForegroundColor White
    Write-Host "   curl.cainfo = `"$cacertFile`"" -ForegroundColor Cyan
    Write-Host "   openssl.cafile = `"$cacertFile`"" -ForegroundColor Cyan
    Write-Host "3. Save php.ini and restart Apache/XAMPP" -ForegroundColor White
    Write-Host "4. Run: php -r `"echo ini_get('curl.cainfo');`" to verify" -ForegroundColor White
} catch {
    Write-Host "Error downloading CA bundle: $_" -ForegroundColor Red
    Write-Host "You can manually download from: https://curl.se/ca/cacert.pem" -ForegroundColor Yellow
}
