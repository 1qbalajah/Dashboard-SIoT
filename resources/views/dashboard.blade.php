@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- =========================================
    HEADER
    ========================================= -->
    <header class="content-header">

        <h1 class="greeting-text">
            Halo, iqbal 👋
        </h1>

        <p class="greeting-subtitle">
            Selamat datang di Azure Metrics Dashboard
        </p>

    </header>

    <!-- =========================================
    IOT PANEL
    ========================================= -->
    <section class="section">

        <h2 class="section-title">
            IoT Monitoring Panel
        </h2>

        <div class="iot-grid">

            <!-- =========================================
            SUHU
            ========================================= -->
            <article class="iot-card card-temp">

                <div class="iot-header">

                    <div class="iot-title">
                        🌡️ Suhu
                    </div>

                    <div id="temperature-status" class="iot-status status-offline">
                        <span class="status-dot"></span>
                        OFFLINE
                    </div>

                </div>

                <div class="sensor-value">

                    <span id="temperature-value">
                        -
                    </span>

                    <span class="sensor-unit">
                        °C
                    </span>

                </div>

                <p class="sensor-info">
                    Sensor membaca temperatur realtime dari MQTT broker.
                </p>

            </article>

            <!-- =========================================
            KELEMBAPAN
            ========================================= -->
            <article class="iot-card card-humidity">

                <div class="iot-header">

                    <div class="iot-title">
                        💧 Kelembapan
                    </div>

                    <div id="humidity-status" class="iot-status status-offline">
                        <span class="status-dot"></span>
                        OFFLINE
                    </div>

                </div>

                <div class="sensor-value">

                    <span id="humidity-value">
                        -
                    </span>

                    <span class="sensor-unit">
                        %
                    </span>

                </div>

                <p class="sensor-info">
                    Monitoring kelembapan ruangan berbasis sensor DHT.
                </p>

            </article>

            <!-- =========================================
            SERVO
            ========================================= -->
            <article class="iot-card card-servo">

                <div class="iot-header">

                    <div class="iot-title">
                        ⚙️ Servo Control
                    </div>

                    <div class="iot-status status-online">
                        <span class="status-dot"></span>
                        ACTIVE
                    </div>

                </div>

                <div class="sensor-value" style="">

                    <span id="servo-angle-value" style="font-family: var(--font-mono); font-weight: 600;">
                        90
                    </span>

                    <span class="sensor-unit">
                        °
                    </span>

                </div>

                <div class="servo-wrapper" style="max-width: 420px; margin: 0 auto; padding: var(--space-2) 0;">

                    <div class="servo-labels" style="justify-content:space-between;">
                        <span class="label-sm" style="color: var(--on-surface-variant); font-size: 0.75rem;">0°</span>
                        <span class="label-sm" style="color: var(--on-surface-variant); font-size: 0.75rem;">180°</span>
                    </div>

                    <input
                        id="servo-angle-slider"
                        type="range"
                        min="0"
                        max="180"
                        value="90"
                        step="1"
                        class="servo-slider"
                    />

                </div>

            </article>

            <!-- =========================================
            LCD
            ========================================= -->
            <article class="iot-card card-lcd">

                <div class="iot-header">

                    <div class="iot-title">
                        🖥️ LCD Message
                    </div>

                    <div class="iot-status status-online">
                        <span class="status-dot"></span>
                        READY
                    </div>

                </div>

                <form id="lcd-form" class="lcd-form">

                    @csrf

                    <input id="lcd-input" type="text" class="lcd-input" placeholder="Ketik pesan LCD..." maxlength="100">

                    <button type="submit" class="btn-primary">
                        Kirim
                    </button>

                </form>

            </article>

        </div>

    </section>

    <!-- =========================================
    DEVICE TABLE
    ========================================= -->
    <section class="device-monitor">

        <div class="device-monitor-header d-flex justify-content-between align-items-center">

            <div>

                <h2 class="section-title" style="margin-bottom: 4px;">
                    Device Connected
                </h2>

                <p class="body-sm" style="color: var(--on-surface-variant);">
                    Monitoring device yang terhubung melalui MQTT broker
                </p>

            </div>

            <div id="mqtt-status" class="device-status-badge device-status-offline">
                <span class="status-dot"></span>
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

                    <tr>

                        <td class="table-cell">-</td>
                        <td class="table-cell">-</td>
                        <td class="table-cell">-</td>
                        <td class="table-cell">-</td>

                    </tr>

                </tbody>

            </table>

        </div>

        <!-- =========================================
        FOOTER
        ========================================= -->
        <div
            style="
            padding: var(--space-3);
            border-top: 1px solid var(--outline-variant);
            background: var(--surface-container-low);
        ">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <p class="body-sm" style="font-weight: 600;">
                        Last Device Activity
                    </p>

                    <span id="last-activity" class="label-sm">
                        Belum ada device yang terhubung
                    </span>

                </div>

                <div id="footer-status" class="device-status-badge device-status-offline">
                    MQTT DISCONNECTED
                </div>

            </div>

        </div>

    </section>

    <!-- =========================================
    RECENT ACTIVITY
    ========================================= -->
    <section class="section">

        <h2 class="section-title">
            Data Terbaru
        </h2>

        <article class="card" style="padding: 0; overflow: hidden;">

            @if ($recentActivities && $recentActivities->count() > 0)

                <ul
                    style="
                    list-style: none;
                    margin: 0;
                    padding: 0;
                ">

                    @foreach ($recentActivities as $activity)
                        <li
                            style="
                            padding: var(--space-2) var(--space-3);
                            border-bottom: 1px solid var(--outline-variant);
                            display: flex;
                            align-items: flex-start;
                            gap: var(--space-2);
                        ">

                            <div
                                style="
                                width: 32px;
                                height: 32px;
                                border-radius: var(--radius-md);
                                background:
                                    {{ $activity->type === 'device' ? 'var(--primary-fixed)' : 'var(--secondary-container)' }};
                                color:
                                    {{ $activity->type === 'device' ? 'var(--primary)' : 'var(--on-secondary)' }};
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-shrink: 0;
                            ">

                                📡

                            </div>

                            <div style="flex: 1; min-width: 0;">

                                <div class="d-flex justify-content-between align-items-center" style="gap: 8px;">

                                    <span class="body-md"
                                        style="
                                        font-weight: 500;
                                        color: var(--on-surface);
                                    ">
                                        {{ $activity->title ?? 'Tanpa judul' }}
                                    </span>

                                    <span class="label-sm"
                                        style="
                                        background:
                                            {{ $activity->type === 'device' ? 'var(--primary-fixed)' : 'var(--secondary-container)' }};
                                        color:
                                            {{ $activity->type === 'device' ? 'var(--primary)' : 'var(--on-secondary)' }};
                                        padding: 2px 8px;
                                        border-radius: var(--radius-sm);
                                    ">
                                        {{ ucfirst($activity->type) }}
                                    </span>

                                </div>

                                <p class="body-sm"
                                    style="
                                    margin-top: 2px;
                                    color: var(--on-surface-variant);
                                ">
                                    {{ $activity->description }}
                                </p>

                                <span class="label-sm"
                                    style="
                                    margin-top: 4px;
                                    display: inline-block;
                                ">
                                    {{ $activity->created_at }}
                                </span>

                            </div>

                        </li>
                    @endforeach

                </ul>
            @else
                <div
                    style="
                    padding: var(--space-4);
                    text-align: center;
                ">

                    <p class="body-md" style="color: var(--on-surface-variant);">
                        Belum ada aktivitas terbaru
                    </p>

                </div>

            @endif

        </article>

    </section>

@endsection

@push('scripts')
    <script>
        /*
        =========================================
        LCD FORM HANDLER - NEW FEATURE
        =========================================
        */
        document.addEventListener('DOMContentLoaded', function() {
            // ================================
            // SERVO SLIDER (0–180) - new logic
            // ================================
            const servoAngleSlider = document.getElementById('servo-angle-slider');
            const servoAngleValue = document.getElementById('servo-angle-value');

            const currentRole = '{{ auth()->user()->role ?? 'user' }}';
            const isAdmin = currentRole === 'admin';

            if (servoAngleSlider && servoAngleValue) {
                // disable if non-admin
                if (!isAdmin) {
                    servoAngleSlider.disabled = true;
                    servoAngleSlider.style.opacity = '0.6';
                    servoAngleSlider.style.cursor = 'not-allowed';
                    return;
                }

                // initialize UI
                servoAngleValue.innerText = `${servoAngleSlider.value}`;

                let debounceTimer = null;
                let lastSentAngle = null;

                const sendAngle = async (angle) => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (!csrfToken) {
                        alert('CSRF token not found');
                        return;
                    }

                    // avoid duplicate spam
                    if (lastSentAngle === angle) return;
                    lastSentAngle = angle;

                    const payload = { angle };

                    const res = await fetch('/servo/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await res.json().catch(() => ({}));
                    if (!res.ok) {
                        alert(result.message || 'Gagal mengirim servo angle');
                    }
                };

                servoAngleSlider.addEventListener('input', (e) => {
                    const angle = Number(e.target.value);
                    servoAngleValue.innerText = `${angle}`;

                    // debounce ~300ms
                    if (debounceTimer) clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        sendAngle(angle);
                    }, 300);
                });
            }

            // ================================
            // LCD existing handler
            // ================================

            const lcdForm = document.getElementById('lcd-form');
            const lcdInput = document.getElementById('lcd-input');

            if (lcdForm && lcdInput) {
                lcdForm.addEventListener('submit', async (e) => {

                    e.preventDefault();

                    const message = lcdInput.value.trim();
                    if (!message) return;

                    // Disable button saat loading
                    const submitBtn = lcdForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Mengirim...';

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                        if (!csrfToken) {
                            throw new Error('CSRF token not found');
                        }

                        const response = await fetch('/lcd/send', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                message: message
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            lcdInput.value = '';
                            console.log('LCD SENT:', result.message);
                            alert('Message berhasil dikirim ke LCD 🚀');
                        } else {
                            alert(result.message || 'Gagal kirim message LCD');
                        }

                    } catch (error) {
                        console.error('LCD Error:', error);
                        alert('Error koneksi ke server');
                    } finally {
                        // Kembalikan button ke state semula
                        const submitBtn = lcdForm.querySelector('button[type="submit"]');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Kirim';
                    }
                });
            }
        });

        /*
        =========================================
        FETCH REALTIME DATA - EXISTING FEATURE
        =========================================
        */
        async function fetchRealtimeData() {
            try {
                const response = await fetch('/dashboard/realtime');
                const data = await response.json();


                /* TEMPERATURE */
                const temperature = data.temperature;
                const temperatureValue = document.getElementById('temperature-value');
                const temperatureStatus = document.getElementById('temperature-status');

                if (temperature) {
                    temperatureValue.innerText = temperature.data;
                    temperatureStatus.innerHTML = `<span class="status-dot"></span> ONLINE`;
                    temperatureStatus.classList.remove('status-offline');
                    temperatureStatus.classList.add('status-online');
                } else {
                    temperatureValue.innerText = '-';
                }

                /* HUMIDITY */
                const humidity = data.humidity;
                const humidityValue = document.getElementById('humidity-value');
                const humidityStatus = document.getElementById('humidity-status');

                if (humidity) {
                    humidityValue.innerText = humidity.data;
                    humidityStatus.innerHTML = `<span class="status-dot"></span> ONLINE`;
                    humidityStatus.classList.remove('status-offline');
                    humidityStatus.classList.add('status-online');
                } else {
                    humidityValue.innerText = '-';
                }

                /*
                =========================================
                MQTT STATUS
                =========================================
                */

                const mqttStatus =
                    document.getElementById('mqtt-status');

                const footerStatus =
                    document.getElementById('footer-status');

                const hasOnlineDevice =
                    data.devices.some(
                        device => device.status === 'online'
                    );

                if (hasOnlineDevice) {

                    mqttStatus.innerHTML = `
                        <span class="status-dot"></span>
                        MQTT CONNECTED
                    `;

                    footerStatus.innerHTML = `
                        MQTT CONNECTED
                    `;

                    mqttStatus.classList.remove(
                        'device-status-offline'
                    );

                    mqttStatus.classList.add(
                        'device-status-online'
                    );

                    footerStatus.classList.remove(
                        'device-status-offline'
                    );

                    footerStatus.classList.add(
                        'device-status-online'
                    );

                } else {

                    mqttStatus.innerHTML = `
                        <span class="status-dot"></span>
                        MQTT DISCONNECTED
                    `;

                    footerStatus.innerHTML = `
                        MQTT DISCONNECTED
                    `;

                    mqttStatus.classList.remove(
                        'device-status-online'
                    );

                    mqttStatus.classList.add(
                        'device-status-offline'
                    );

                    footerStatus.classList.remove(
                        'device-status-online'
                    );

                    footerStatus.classList.add(
                        'device-status-offline'
                    );

                }

                /* DEVICE TABLE */
                const tableBody = document.getElementById('device-table-body');
                tableBody.innerHTML = '';

                if (!data.devices || data.devices.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                            <td class="table-cell">-</td>
                        </tr>
                    `;
                    return;
                }

                data.devices.forEach(device => {
                    tableBody.innerHTML += `
                        <tr>
                            <td class="table-cell">
                                <span class="label-md">${device.serial_number}</span>
                            </td>
                            <td class="table-cell">
                                <div class="device-status-badge ${device.status === 'online' ? 'device-status-online' : 'device-status-offline'}">
                                    <span class="status-dot"></span>
                                    ${device.status.toUpperCase()}
                                </div>
                            </td>
                            <td class="table-cell">${device.topic ?? '-'}</td>
                            <td class="table-cell">${device.updated_at}</td>
                        </tr>
                    `;
                });

                /* LAST ACTIVITY */
                const lastActivity = document.getElementById('last-activity');
                if (data.devices && data.devices.length > 0) {
                    const latestDevice = data.devices[0];
                    lastActivity.innerText = `${latestDevice.serial_number} terakhir aktif`;
                }

            } catch (error) {
                console.error('Fetch Error:', error);
            }
        }

        /*
        =========================================
        AUTO REFRESH - EXISTING FEATURE
        =========================================
        */
        fetchRealtimeData();
        setInterval(fetchRealtimeData, 1000);
    </script>
@endpush