@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <header class="content-header">
        <div class="d-flex justify-content-between align-items-center gap-3">
            <div>
                <h1 class="greeting-text">Overview</h1>
                <p class="greeting-subtitle">
                    Selamat datang, {{ auth()->user()->name ?? 'User' }}. Dashboard IoT aktif memantau MQTT dan sensor.
                </p>
            </div>

            <div class="device-status-badge device-status-offline" id="mqtt-status">
                <span class="status-dot"></span>
                MQTT DISCONNECTED
            </div>
        </div>
    </header>

    <section class="section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Live Assets</h2>
            <span class="label-sm">Auto refresh adaptif</span>
        </div>

        <div class="iot-grid">
            <article class="iot-card card-temp">
                <div class="iot-header">
                    <div class="iot-title">
                        <span class="card-icon">T</span>
                        Suhu
                    </div>

                    <div id="temperature-status" class="iot-status status-offline">
                        <span class="status-dot"></span>
                        OFFLINE
                    </div>
                </div>

                <div class="sensor-value">
                    <span id="temperature-value">-</span>
                    <span class="sensor-unit">C</span>
                </div>

                <p class="sensor-info">Temperatur realtime dari broker MQTT.</p>
            </article>

            <article class="iot-card card-humidity">
                <div class="iot-header">
                    <div class="iot-title">
                        <span class="card-icon">H</span>
                        Kelembapan
                    </div>

                    <div id="humidity-status" class="iot-status status-offline">
                        <span class="status-dot"></span>
                        OFFLINE
                    </div>
                </div>

                <div class="sensor-value">
                    <span id="humidity-value">-</span>
                    <span class="sensor-unit">%</span>
                </div>

                <p class="sensor-info">Kondisi kelembapan ruangan terbaru.</p>
            </article>

            <article class="iot-card card-servo">
                <div class="iot-header">
                    <div class="iot-title">
                        <span class="card-icon">S</span>
                        Servo
                    </div>

                    <div class="iot-status status-online">
                        <span class="status-dot"></span>
                        ACTIVE
                    </div>
                </div>

                <div class="sensor-value">
                    <span id="servo-angle-value">90</span>
                    <span class="sensor-unit">deg</span>
                </div>

                <div class="servo-wrapper">
                    <div class="servo-labels d-flex justify-content-between">
                        <span class="label-sm">0 deg</span>
                        <span class="label-sm">180 deg</span>
                    </div>

                    <input id="servo-angle-slider" type="range" min="0" max="180" value="90" step="1" class="servo-slider">
                </div>
            </article>

            <article class="iot-card card-lcd">
                <div class="iot-header">
                    <div class="iot-title">
                        <span class="card-icon">L</span>
                        LCD Message
                    </div>

                    <div class="iot-status status-online">
                        <span class="status-dot"></span>
                        READY
                    </div>
                </div>

                <form id="lcd-form" class="lcd-form">
                    @csrf
                    <input id="lcd-input" type="text" class="lcd-input form-input" placeholder="Ketik pesan LCD..." maxlength="32">
                    <button type="submit" class="btn-primary">Kirim</button>
                </form>
            </article>
        </div>
    </section>

    <section class="device-monitor">
        <div class="device-monitor-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="section-title mb-0">Device Connected</h2>
                <p class="body-sm">Perangkat yang aktif dihitung dari aktivitas 15 detik terakhir.</p>
            </div>

            <div id="footer-status" class="device-status-badge device-status-offline">
                MQTT DISCONNECTED
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="table-header">Device ID</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Topic</th>
                        <th class="table-header">Last Activity</th>
                    </tr>
                </thead>
                <tbody id="device-table-body">
                    @forelse ($devices as $device)
                        <tr>
                            <td class="table-cell">
                                <span class="label-md">{{ $device['serial_number'] }}</span>
                            </td>
                            <td class="table-cell">
                                <div class="device-status-badge {{ $device['status'] === 'online' ? 'device-status-online' : 'device-status-offline' }}">
                                    <span class="status-dot"></span>
                                    {{ strtoupper($device['status']) }}
                                </div>
                            </td>
                            <td class="table-cell">{{ $device['topic'] ?? '-' }}</td>
                            <td class="table-cell">{{ $device['updated_at'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Data Terbaru</h2>
            <span id="last-activity" class="label-sm">Belum ada device yang terhubung</span>
        </div>

        <article class="card" style="padding: 0; overflow: hidden;">
            @if ($recentActivities && $recentActivities->count() > 0)
                <ul style="list-style: none; margin: 0; padding: 0;">
                    @foreach ($recentActivities as $activity)
                        <li style="padding: var(--space-2) var(--space-3); border-bottom: 1px solid var(--outline-variant); display: flex; align-items: flex-start; gap: var(--space-2);">
                            <div class="card-icon">
                                {{ $activity->type === 'device' ? 'D' : 'S' }}
                            </div>

                            <div style="flex: 1; min-width: 0;">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <span class="body-md" style="font-weight: 600; color: var(--on-surface);">
                                        {{ $activity->title ?? 'Tanpa judul' }}
                                    </span>

                                    <span class="device-status-badge {{ $activity->type === 'device' ? 'device-status-online' : 'device-status-offline' }}">
                                        {{ ucfirst($activity->type) }}
                                    </span>
                                </div>

                                <p class="body-sm">{{ $activity->description }}</p>
                                <span class="label-sm">{{ $activity->created_at }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="table-empty text-center">
                    <p class="body-md">Belum ada aktivitas terbaru</p>
                </div>
            @endif
        </article>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const servoAngleSlider = document.getElementById('servo-angle-slider');
            const servoAngleValue = document.getElementById('servo-angle-value');
            const currentRole = '{{ auth()->user()->role ?? 'user' }}';
            const isAdmin = currentRole === 'admin';

            if (servoAngleSlider && servoAngleValue) {
                if (!isAdmin) {
                    servoAngleSlider.disabled = true;
                    servoAngleSlider.style.opacity = '0.55';
                    servoAngleSlider.style.cursor = 'not-allowed';
                } else {
                    let debounceTimer = null;
                    let lastSentAngle = null;

                    const sendAngle = async (angle) => {
                        if (lastSentAngle === angle) return;
                        lastSentAngle = angle;

                        const response = await fetch('/servo/send', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            },
                            body: JSON.stringify({ angle })
                        });

                        if (!response.ok) {
                            const result = await response.json().catch(() => ({}));
                            alert(result.message || 'Gagal mengirim sudut servo');
                        }
                    };

                    servoAngleSlider.addEventListener('input', (event) => {
                        const angle = Number(event.target.value);
                        servoAngleValue.innerText = `${angle}`;
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => sendAngle(angle), 300);
                    });
                }
            }

            const lcdForm = document.getElementById('lcd-form');
            const lcdInput = document.getElementById('lcd-input');

            if (lcdForm && lcdInput) {
                lcdForm.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const message = lcdInput.value.trim();
                    if (!message) return;

                    const submitBtn = lcdForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Mengirim...';

                    try {
                        const response = await fetch('/lcd/send', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            },
                            body: JSON.stringify({ message })
                        });

                        const result = await response.json().catch(() => ({}));
                        if (!response.ok) {
                            alert(result.message || 'Gagal kirim pesan LCD');
                            return;
                        }

                        lcdInput.value = '';
                    } catch (error) {
                        console.error('LCD Error:', error);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerText = 'Kirim';
                    }
                });
            }

            fetchRealtimeData();
            scheduleRealtimeFetch();
        });

        let realtimeDelay = 1000;
        let realtimeTimer = null;

        function setSensorStatus(element, isOnline) {
            element.innerHTML = `<span class="status-dot"></span> ${isOnline ? 'ONLINE' : 'OFFLINE'}`;
            element.classList.toggle('status-online', isOnline);
            element.classList.toggle('status-offline', !isOnline);
        }

        function setMqttStatus(isConnected) {
            ['mqtt-status', 'footer-status'].forEach((id) => {
                const element = document.getElementById(id);
                element.innerHTML = `${id === 'mqtt-status' ? '<span class="status-dot"></span>' : ''} MQTT ${isConnected ? 'CONNECTED' : 'DISCONNECTED'}`;
                element.classList.toggle('device-status-online', isConnected);
                element.classList.toggle('device-status-offline', !isConnected);
            });
        }

        async function fetchRealtimeData() {
            try {
                const response = await fetch('/dashboard/realtime', {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                const data = await response.json();

                const temperatureValue = document.getElementById('temperature-value');
                const temperatureStatus = document.getElementById('temperature-status');
                temperatureValue.innerText = data.temperature ? data.temperature.data : '-';
                setSensorStatus(temperatureStatus, Boolean(data.temperature));

                const humidityValue = document.getElementById('humidity-value');
                const humidityStatus = document.getElementById('humidity-status');
                humidityValue.innerText = data.humidity ? data.humidity.data : '-';
                setSensorStatus(humidityStatus, Boolean(data.humidity));

                const devices = data.devices || [];
                const hasOnlineDevice = devices.some((device) => device.status === 'online');
                setMqttStatus(hasOnlineDevice);

                const tableBody = document.getElementById('device-table-body');
                if (devices.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                        </tr>
                    `;
                } else {
                    tableBody.innerHTML = devices.map((device) => `
                        <tr>
                            <td class="table-cell"><span class="label-md">${device.serial_number}</span></td>
                            <td class="table-cell">
                                <div class="device-status-badge ${device.status === 'online' ? 'device-status-online' : 'device-status-offline'}">
                                    <span class="status-dot"></span>
                                    ${device.status.toUpperCase()}
                                </div>
                            </td>
                            <td class="table-cell">${device.topic ?? '-'}</td>
                            <td class="table-cell">${device.updated_at ?? '-'}</td>
                        </tr>
                    `).join('');
                }

                const lastActivity = document.getElementById('last-activity');
                lastActivity.innerText = devices.length > 0
                    ? `${devices[0].serial_number} terakhir aktif`
                    : 'Belum ada device yang terhubung';

                realtimeDelay = document.hidden ? 5000 : 1000;
            } catch (error) {
                console.error('Fetch Error:', error);
                realtimeDelay = Math.min(realtimeDelay * 2, 10000);
            } finally {
                scheduleRealtimeFetch();
            }
        }

        function scheduleRealtimeFetch() {
            clearTimeout(realtimeTimer);
            realtimeTimer = setTimeout(fetchRealtimeData, realtimeDelay);
        }

        document.addEventListener('visibilitychange', () => {
            realtimeDelay = document.hidden ? 5000 : 1000;
        });
    </script>
@endpush
