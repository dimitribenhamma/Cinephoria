$logFile = "C:\wamp\logs\apache_php_usage.csv"
# Créer le fichier CSV avec l'entête si pas existant
if (!(Test-Path $logFile)) {
    "Timestamp,PID,CPU,WorkingSet,IOReadBytes,IOWriteBytes" | Out-File $logFile
}

while ($true) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"

    Get-Process httpd | ForEach-Object {
        $line = "$timestamp,$($_.Id),$($_.CPU),$($_.WorkingSet),$($_.IOReadBytes),$($_.IOWriteBytes)"
        $line | Out-File $logFile -Append
    }

    Start-Sleep 10
}
