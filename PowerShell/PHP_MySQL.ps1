$mysqlPath = "C:\wamp\bin\mysql\mysql8.2.0\bin\mysql.exe"
while ($true) {
    Clear-Host
    Write-Host "=== MySQL ==="
    Get-Process mysqld | Select Name, CPU, WorkingSet, IOReadBytes, IOWriteBytes
& $mysqlPath -u root -padmin -e "SHOW FULL PROCESSLIST;"
& $mysqlPath -u root -padmin -e "SELECT EVENT_ID, SQL_TEXT, TIMER_WAIT, ROWS_SENT FROM performance_schema.events_statements_current;"
    Write-Host "`n=== Apache / PHP ==="
    Get-Process httpd | Select Name, CPU, WorkingSet, IOReadBytes, IOWriteBytes

    Start-Sleep 10 }
