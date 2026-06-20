#!/bin/bash

VM2_IP="200.200.200.3"
VM2_USER="hady"

echo "======================================"
echo "    Sistem Monitoring Ujian Bahy      "
echo "======================================"

# 1. Cek HAProxy
if systemctl is-active --quiet haproxy; then
    echo "[OK] HAProxy Server Is RUNNING"
else
    echo "[CRITICAL] HAProxy Server Is INACTIVE"
fi

# 2. Cek Ping ke VM2
if ping -c 1 $VM2_IP &> /dev/null; then
    echo "[OK] VM2 Web Containers are REACHABLE"
else
    echo "[CRITICAL] VM2 Web Containers are REACHABLE"
fi

# 3. Cek Jumlah Replika Kontainer
echo "--------------------------------------"
echo "Status Kontainer (nginx_bahy) di VM 2:"
UP_CONTAINERS=$(ssh -o StrictHostKeyChecking=no $VM2_USER@$VM2_IP "docker ps | grep nginx_bahy | wc -l")

if [ "$UP_CONTAINERS" -ge 3 ]; then
    echo "Replika Web Kontainer : [OK] ($UP_CONTAINERS/3 berjalan)"
else
    echo "Replika Web Kontainer : [CRITICAL] (Hanya $UP_CONTAINERS/3 berjalan)"
fi
echo "======================================"
