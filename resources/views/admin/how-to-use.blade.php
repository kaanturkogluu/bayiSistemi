@extends('layouts.admin')

@section('header', 'Nasıl Kullanılır?')

@section('content')

    <style>
        /* ─── How-To Page Styles ─────────────────────────────── */
        .howto-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            border-radius: 1.25rem;
            padding: 3rem 2.5rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .howto-hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            border-radius: 50%;
        }

        .howto-hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.4);
            color: #a5b4fc;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.3rem 0.9rem;
            border-radius: 9999px;
            margin-bottom: 1rem;
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .hero-sub {
            color: #94a3b8;
            font-size: 1rem;
            max-width: 560px;
            line-height: 1.6;
        }

        /* ─── Step Flow ──────────────────────────────────────── */
        .steps-flow {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            row-gap: 0.5rem;
        }

        .step-pill {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 9999px;
            padding: 0.5rem 1.1rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            transition: all .2s;
            cursor: default;
            white-space: nowrap;
        }

        .step-pill:hover {
            border-color: #6366f1;
            color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .08);
        }

        .step-pill .pill-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .arrow-connector {
            width: 32px;
            text-align: center;
            color: #cbd5e1;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* ─── Section Cards ──────────────────────────────────── */
        .section-block {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            overflow: hidden;
            margin-bottom: 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
            transition: box-shadow .2s;
        }

        .section-block:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-num {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 0.15rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .section-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        @media (max-width: 768px) {
            .section-body {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .steps-flow {
                gap: 0.25rem;
            }
        }

        .section-text {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .section-description {
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }

        .bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .bullet-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            font-size: 0.85rem;
            color: #334155;
        }

        .bullet-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 0.05rem;
        }

        .bullet-icon svg {
            width: 11px;
            height: 11px;
        }

        .tip-box {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #6366f1;
            border-radius: 0.6rem;
            padding: 0.75rem 1rem;
            margin-top: 1.25rem;
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.5;
        }

        /* ─── Screenshot panel ───────────────────────────────── */
        .section-screenshot {
            border-left: 1px solid #f1f5f9;
            background: #f8fafc;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .screenshot-frame {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .1);
            width: 100%;
            max-width: 520px;
            position: relative;
        }

        .screenshot-bar {
            background: #1e293b;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot-r {
            background: #ef4444;
        }

        .dot-y {
            background: #f59e0b;
        }

        .dot-g {
            background: #10b981;
        }

        .screenshot-url {
            flex: 1;
            background: rgba(255, 255, 255, .08);
            border-radius: 4px;
            padding: 0.2rem 0.6rem;
            font-size: 0.68rem;
            color: #94a3b8;
            margin-left: 0.5rem;
            font-family: monospace;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .screenshot-frame img {
            width: 100%;
            display: block;
            object-fit: cover;
        }

        /* ─── Final CTA ──────────────────────────────────────── */
        .cta-card {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 1.25rem;
            padding: 2.5rem;
            text-align: center;
            margin-top: 1rem;
        }

        .cta-card h3 {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .cta-card p {
            color: rgba(255, 255, 255, .8);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fff;
            color: #6366f1;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .2);
        }
    </style>

    <!-- ─── HERO ──────────────────────────────────────────────── -->
    <div class="howto-hero" style="position:relative; z-index:1;">
        <div style="position:relative; z-index:2;">
            <div class="hero-badge">
                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.674M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                Başlangıç Rehberi
            </div>
            <h1 class="hero-title">Sistemi Nasıl Kullanırsınız?</h1>
            <p class="hero-sub">
                Bayi Servis Yönetim Paneli'ni hızlıca öğrenmek için aşağıdaki adım adım rehberi takip edin.
                Müşteri ekleme, bakım kaydı oluşturma ve ödeme takibi için tüm ekran görüntüleri mevcuttur.
            </p>
        </div>
    </div>

    <!-- ─── STEP FLOW ─────────────────────────────────────────── -->
    <div class="steps-flow">
        <a href="#step1" class="step-pill" style="text-decoration:none;">
            <span class="pill-num" style="background:#dbeafe;color:#2563eb;">1</span>
            Giriş Yap
        </a>
        <div class="arrow-connector">›</div>
        <a href="#step2" class="step-pill" style="text-decoration:none;">
            <span class="pill-num" style="background:#dcfce7;color:#16a34a;">2</span>
            Müşteri Ekle
        </a>
        <div class="arrow-connector">›</div>
        <a href="#step3" class="step-pill" style="text-decoration:none;">
            <span class="pill-num" style="background:#f3e8ff;color:#7c3aed;">3</span>
            Araç Kaydı
        </a>
        <div class="arrow-connector">›</div>
        <a href="#step4" class="step-pill" style="text-decoration:none;">
            <span class="pill-num" style="background:#fce7f3;color:#db2777;">4</span>
            Bakım Kaydı
        </a>
        <div class="arrow-connector">›</div>
        <a href="#step5" class="step-pill" style="text-decoration:none;">
            <span class="pill-num" style="background:#ffedd5;color:#ea580c;">5</span>
            Ödeme Takibi
        </a>
    </div>

    <!-- ─── STEP 1: GİRİŞ ─────────────────────────────────────── -->
    <div class="section-block" id="step1">
        <div class="section-header">
            <div class="section-icon" style="background:#eff6ff;">
                <svg style="width:24px;height:24px;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#2563eb;">Adım 1</p>
                <h2 class="section-title">Sisteme Giriş Yapın</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-text">
                <p class="section-description">
                    Tarayıcınızdan sisteme gidin. Karşınıza <strong>Yönetim Paneli Girişi</strong> ekranı çıkacak.
                    Size verilen <strong>Kullanıcı Adı</strong> ve <strong>Şifre</strong>'yi girerek "Giriş Yap" butonuna
                    basın.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#dbeafe;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Kullanıcı adınızı <em>Kullanıcı Adı</em> alanına yazın</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dbeafe;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Şifrenizi <em>Şifre</em> alanına yazın</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dbeafe;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>İsterseniz "Beni Hatırla" kutucuğunu işaretleyin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dbeafe;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Giriş Yap →</strong> butonuna tıklayın</span>
                    </li>
                </ul>
                <div class="tip-box">
                    <svg style="width:16px;height:16px;color:#6366f1;flex-shrink:0;margin-top:1px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Şifrenizi unutursanız sistem yöneticinizle iletişime geçin.</span>
                </div>
            </div>
            <div class="section-screenshot">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/servis/public/</span>
                    </div>
                    <img src="{{ asset('images/howto/01_login.png') }}" alt="Giriş Sayfası" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    <!-- ─── STEP 2: DASHBOARD ─────────────────────────────────── -->
    <div class="section-block" id="step2">
        <div class="section-header">
            <div class="section-icon" style="background:#f0fdf4;">
                <svg style="width:24px;height:24px;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#16a34a;">Ana Ekran</p>
                <h2 class="section-title">Kontrol Paneli (Dashboard)</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-screenshot" style="order: -1;">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/servis/public/admin</span>
                    </div>
                    <img src="{{ asset('images/howto/02_dashboard.png') }}" alt="Dashboard" loading="lazy">
                </div>
            </div>
            <div class="section-text">
                <p class="section-description">
                    Giriş yaptıktan sonra <strong>Kontrol Paneli</strong>'ne yönlendirilirsiniz.
                    Buradan sistemin tüm modüllerine tek tıkla ulaşabilirsiniz.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#f3e8ff;">
                            <svg fill="none" stroke="#7c3aed" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </span>
                        <span><strong>Yedek Parça & Bakım</strong> — Servis kayıtlarına erişim</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857" />
                            </svg>
                        </span>
                        <span><strong>Müşteri Yönetimi</strong> — Müşteri ve araç listesi</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dbeafe;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <span><strong>Cari & Ödeme</strong> — Borç/alacak takibi</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#fef9c3;">
                            <svg fill="none" stroke="#ca8a04" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35" />
                            </svg>
                        </span>
                        <span><strong>Fatura Ayarları</strong> — Firma bilgileri ve logo</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ─── STEP 3: MÜŞTERİ EKLE ─────────────────────────────── -->
    <div class="section-block" id="step3">
        <div class="section-header">
            <div class="section-icon" style="background:#fdf4ff;">
                <svg style="width:24px;height:24px;color:#9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#9333ea;">Adım 2</p>
                <h2 class="section-title">Müşteri Listesi ve Yeni Müşteri Ekleme</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-text">
                <p class="section-description">
                    Dashboard'dan <strong>Müşteri Yönetimi</strong>'ne tıklayın. Tüm kayıtlı müşteriler listelenir.
                    Yeni müşteri eklemek için sağ üstteki <strong>+ Yeni Müşteri Ekle</strong> butonuna basın.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#f3e8ff;">
                            <svg fill="none" stroke="#9333ea" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Müşteri adı veya telefon ile arama yapabilirsiniz</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#f3e8ff;">
                            <svg fill="none" stroke="#9333ea" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Her müşterinin kaç aracı olduğunu görebilirsiniz</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#f3e8ff;">
                            <svg fill="none" stroke="#9333ea" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Görüntüle, Düzenle veya Sil işlemlerini yapabilirsiniz</span>
                    </li>
                </ul>
            </div>
            <div class="section-screenshot">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/…/admin/customers</span>
                    </div>
                    <img src="{{ asset('images/howto/03_customers_list.png') }}" alt="Müşteri Listesi" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    <!-- ─── STEP 4: MÜŞTERİ OLUŞTURMA FORMU ─────────────────── -->
    <div class="section-block" id="step4" style="border-left: 3px solid #9333ea;">
        <div class="section-header">
            <div class="section-icon" style="background:#fdf4ff;">
                <svg style="width:24px;height:24px;color:#9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#9333ea;">Adım 3</p>
                <h2 class="section-title">Müşteri ve Araç Bilgilerini Girin</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-screenshot" style="order:-1;">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/…/admin/customers/create</span>
                    </div>
                    <img src="{{ asset('images/howto/04_customer_create.png') }}" alt="Müşteri Oluşturma" loading="lazy">
                </div>
            </div>
            <div class="section-text">
                <p class="section-description">
                    Müşteri ekleme formunda <strong>Ad Soyad</strong> ve <strong>Telefon numarası</strong> girmeniz
                    yeterlidir.
                    Aynı ekranda <strong>Araç Plakası</strong> da ekleyebilirsiniz.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Ad Soyad</strong> alanına müşteri adını yazın (Ör: Ali Yılmaz)</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Telefon</strong> alanına +90 ile birlikte numarayı girin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Araç Plakaları</strong> bölümüne plakaları girin (Ör: 34ABC123)</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>+ Yeni Plaka Ekle</strong> ile birden fazla araç ekleyebilirsiniz</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#dcfce7;">
                            <svg fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Son olarak <strong>Müşteriyi Kaydet</strong> butonuna tıklayın</span>
                    </li>
                </ul>
                <div class="tip-box">
                    <svg style="width:16px;height:16px;color:#9333ea;flex-shrink:0;margin-top:1px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bakım kaydı oluştururken de <em>"+ Yeni Müşteri Oluştur"</em> diyerek doğrudan müşteri
                        ekleyebilirsiniz.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── STEP 5: BAKIM LİSTESİ ────────────────────────────── -->
    <div class="section-block" id="step5">
        <div class="section-header">
            <div class="section-icon" style="background:#fef2f2;">
                <svg style="width:24px;height:24px;color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#dc2626;">Adım 4</p>
                <h2 class="section-title">Bakım Kayıtları</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-text">
                <p class="section-description">
                    <strong>Yedek Parça & Bakım</strong> bölümünde tüm servis kayıtlarınızı görürsünüz.
                    Her kayıtta müşteri adı, plaka, tutar ve tarih bilgisi yer alır.
                    Yeni bakım eklemek için <strong>+ Yeni Bakım Kaydı</strong> butonuna tıklayın.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#fee2e2;">
                            <svg fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Müşteri adı, telefon veya plaka ile arama yapın</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#fee2e2;">
                            <svg fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Duruma göre filtreleyin (Tümü / Devam Ediyor / Tamamlandı)</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#fee2e2;">
                            <svg fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Görüntüle</strong> ile fatura ve detay ekranına gidin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#fee2e2;">
                            <svg fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Düzenle</strong> ile mevcut kaydı güncelleyin</span>
                    </li>
                </ul>
            </div>
            <div class="section-screenshot">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/…/admin/maintenances</span>
                    </div>
                    <img src="{{ asset('images/howto/05_maintenances_list.png') }}" alt="Bakım Listesi" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    <!-- ─── STEP 6: BAKIM OLUŞTURMA ──────────────────────────── -->
    <div class="section-block" style="border-left: 3px solid #dc2626;">
        <div class="section-header">
            <div class="section-icon" style="background:#fef2f2;">
                <svg style="width:24px;height:24px;color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#dc2626;">Adım 5</p>
                <h2 class="section-title">Yeni Bakım / Servis Kaydı Oluşturun</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-screenshot" style="order:-1;">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/…/admin/maintenances/create</span>
                    </div>
                    <img src="{{ asset('images/howto/06_maintenance_create.png') }}" alt="Bakım Oluştur" loading="lazy">
                </div>
            </div>
            <div class="section-text">
                <p class="section-description">
                    Bakım oluşturma formu <strong>adım adım</strong> ilerler. İlk olarak müşteri seçimi yapılır,
                    ardından araç, yapılan işlemler ve kullanılan parçalar eklenir.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#ffedd5;">
                            <svg fill="none" stroke="#ea580c" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Açılır listeden <strong>Müşteri</strong> seçin veya yeni ekleyin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#ffedd5;">
                            <svg fill="none" stroke="#ea580c" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Müşterinin araçları otomatik yüklenir, <strong>Araç</strong> seçin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#ffedd5;">
                            <svg fill="none" stroke="#ea580c" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Yapılan işlemi ve tutarı girin (işçilik, bakım vb.)</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#ffedd5;">
                            <svg fill="none" stroke="#ea580c" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Kullanılan yedek parçaları ve maliyetlerini ekleyin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#ffedd5;">
                            <svg fill="none" stroke="#ea580c" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Kaydı oluşturun — fatura otomatik oluşturulur</span>
                    </li>
                </ul>
                <div class="tip-box">
                    <svg style="width:16px;height:16px;color:#ea580c;flex-shrink:0;margin-top:1px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bakım tamamlandığında usta "Tamamlandı" olarak işaretleyebilir ve bakım durumu güncellenir.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── STEP 7: CARİ & ÖDEME ─────────────────────────────── -->
    <div class="section-block" id="step6">
        <div class="section-header">
            <div class="section-icon" style="background:#ecfdf5;">
                <svg style="width:24px;height:24px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="section-num" style="color:#059669;">Adım 6</p>
                <h2 class="section-title">Cari Hesaplar & Ödeme Takibi</h2>
            </div>
        </div>
        <div class="section-body">
            <div class="section-text">
                <p class="section-description">
                    <strong>Cari Hesaplar</strong> ekranı, müşteri borç-alacak durumunu tek bakışta gösterir.
                    Toplam açık bakiye, borçlu müşteri sayısı ve borçsuz müşteri sayısı özetlenir.
                </p>
                <ul class="bullet-list">
                    <li>
                        <span class="bullet-icon" style="background:#d1fae5;">
                            <svg fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Toplam Açık Bakiye</strong> — Tüm müşterilerin borç toplamı</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#d1fae5;">
                            <svg fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span><strong>Borçlu / Borçsuz</strong> filtresi ile müşterileri ayırt edin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#d1fae5;">
                            <svg fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Müşteri adına tıklayarak tahsilat işlemi kaydedin</span>
                    </li>
                    <li>
                        <span class="bullet-icon" style="background:#d1fae5;">
                            <svg fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span>Yapılan ödemeler anlık olarak bakiyeden düşer</span>
                    </li>
                </ul>
            </div>
            <div class="section-screenshot">
                <div class="screenshot-frame">
                    <div class="screenshot-bar">
                        <span class="dot dot-r"></span>
                        <span class="dot dot-y"></span>
                        <span class="dot dot-g"></span>
                        <span class="screenshot-url">localhost/…/admin/cari</span>
                    </div>
                    <img src="{{ asset('images/howto/07_cari.png') }}" alt="Cari Hesaplar" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    <!-- ─── CTA / SON ─────────────────────────────────────────── -->
    <div class="cta-card">
        <h3>🚀 Artık Hazırsınız!</h3>
        <p>Tüm adımları tamamladıktan sonra sistemi verimli şekilde kullanmaya başlayabilirsiniz.</p>
        <a href="{{ url('/admin') }}" class="cta-btn">
            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard'a Dön
        </a>
    </div>

@endsection