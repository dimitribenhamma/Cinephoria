$mysqlPath = "C:\wamp\bin\mysql\mysql8.2.0\bin\mysql.exe"
$mysqlLogFile = "C:\wamp\logs\mysql_queries.csv"
# Header
if (!(Test-Path $mysqlLogFile)) {
    "Timestamp,Id,User,Host,DB,Command,Time,State,Info" | Out-File $mysqlLogFile
}

while ($true) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $processlist = & $mysqlPath -u root -padmin -e "SHOW FULL PROCESSLIST;" | Select-Object -Skip 1
    foreach ($line in $processlist) {
        $lineToLog = "$timestamp,$line"
        $lineToLog | Out-File $mysqlLogFile -Append
    }
    Start-Sleep 10
}
