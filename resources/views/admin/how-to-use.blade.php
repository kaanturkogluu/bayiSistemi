@extends('layouts.admin')

@section('header', 'Nasıl Kullanılır?')

@section('content')

<style>
.howto-hero{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);border-radius:1.25rem;padding:3rem 2.5rem;margin-bottom:2.5rem;position:relative;overflow:hidden;}
.howto-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:280px;height:280px;background:radial-gradient(circle,rgba(99,102,241,.25) 0%,transparent 70%);border-radius:50%;}
.howto-hero::after{content:'';position:absolute;bottom:-80px;left:-40px;width:320px;height:320px;background:radial-gradient(circle,rgba(16,185,129,.15) 0%,transparent 70%);border-radius:50%;}
.hero-badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(99,102,241,.2);border:1px solid rgba(99,102,241,.4);color:#a5b4fc;font-size:.75rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:.3rem .9rem;border-radius:9999px;margin-bottom:1rem;}
.hero-title{font-size:2.25rem;font-weight:800;color:#fff;margin-bottom:.75rem;line-height:1.2;}
.hero-sub{color:#94a3b8;font-size:1rem;max-width:560px;line-height:1.6;}
.toc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:.75rem;margin-bottom:2.5rem;}
.toc-pill{display:flex;align-items:center;gap:.6rem;background:#fff;border:1.5px solid #e2e8f0;border-radius:.875rem;padding:.75rem 1rem;font-size:.82rem;font-weight:600;color:#475569;text-decoration:none;transition:all .2s;}
.toc-pill:hover{border-color:#6366f1;color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.08);}
.toc-pill .pill-num{width:28px;height:28px;border-radius:.5rem;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;flex-shrink:0;}
.section-block{background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;overflow:hidden;margin-bottom:2rem;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:box-shadow .2s;}
.section-block:hover{box-shadow:0 4px 20px rgba(0,0,0,.08);}
.section-header{display:flex;align-items:center;gap:1rem;padding:1.25rem 1.75rem;border-bottom:1px solid #f1f5f9;}
.section-icon{width:44px;height:44px;border-radius:.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.section-num{font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:.1rem;}
.section-title{font-size:1.05rem;font-weight:700;color:#0f172a;margin:0;}
.section-body{padding:1.5rem 1.75rem;}
.section-description{color:#475569;font-size:.875rem;line-height:1.75;margin-bottom:1.25rem;}
.steps-list{display:flex;flex-direction:column;gap:.6rem;margin-bottom:1.25rem;}
.step-item{display:flex;align-items:flex-start;gap:.75rem;font-size:.85rem;color:#334155;background:#f8fafc;border:1px solid #f1f5f9;border-radius:.6rem;padding:.6rem .9rem;}
.step-num{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;flex-shrink:0;margin-top:.05rem;}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1rem;}
@media(max-width:640px){.info-grid{grid-template-columns:1fr;}.hero-title{font-size:1.5rem;}.toc-grid{grid-template-columns:1fr 1fr;}}
.info-card{background:#f8fafc;border:1px solid #e2e8f0;border-radius:.75rem;padding:.9rem 1rem;}
.info-card-label{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:.3rem;}
.info-card-val{font-size:.85rem;font-weight:600;color:#1e293b;}
.tip-box{display:flex;align-items:flex-start;gap:.6rem;background:#f0f9ff;border:1px solid #bae6fd;border-left:3px solid #0ea5e9;border-radius:.6rem;padding:.75rem 1rem;font-size:.82rem;color:#0c4a6e;line-height:1.6;}
.warn-box{display:flex;align-items:flex-start;gap:.6rem;background:#fef9c3;border:1px solid #fde68a;border-left:3px solid #f59e0b;border-radius:.6rem;padding:.75rem 1rem;font-size:.82rem;color:#78350f;line-height:1.6;margin-top:.75rem;}
.tag{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:9999px;font-size:.72rem;font-weight:700;}
.cta-card{background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);border-radius:1.25rem;padding:2.5rem;text-align:center;margin-top:1rem;}
.cta-card h3{color:#fff;font-size:1.4rem;font-weight:800;margin-bottom:.5rem;}
.cta-card p{color:rgba(255,255,255,.8);margin-bottom:1.5rem;font-size:.9rem;}
.cta-btn{display:inline-flex;align-items:center;gap:.5rem;background:#fff;color:#6366f1;font-weight:700;font-size:.9rem;padding:.75rem 1.75rem;border-radius:.75rem;text-decoration:none;transition:transform .2s,box-shadow .2s;}
.cta-btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.2);}
.role-badge{display:inline-flex;align-items:center;gap:.25rem;padding:.2rem .65rem;border-radius:9999px;font-size:.7rem;font-weight:700;margin-left:.4rem;}
.divider-label{display:flex;align-items:center;gap:1rem;margin:2rem 0 1.5rem;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#94a3b8;}
.divider-label::before,.divider-label::after{content:'';flex:1;height:1px;background:#e2e8f0;}
</style>

{{-- ── HERO ──────────────────────────────────────────── --}}
<div class="howto-hero" style="position:relative;z-index:1;">
    <div style="position:relative;z-index:2;">
        <div class="hero-badge">
            <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.674M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            Detaylı Kullanım Kılavuzu
        </div>
        <h1 class="hero-title">Bayi Yönetim Sistemi Kılavuzu</h1>
        <p class="hero-sub">Sisteme ait tüm modüllerin açıklaması ve adım adım kullanım rehberi aşağıda yer almaktadır. Birbirine bağlı modüller hakkında sıralı okuma önerilir.</p>
    </div>
</div>

{{-- ── İÇİNDEKİLER ──────────────────────────────────── --}}
<div class="toc-grid">
    <a href="#giris" class="toc-pill"><span class="pill-num" style="background:#dbeafe;color:#2563eb;">1</span>Sisteme Giriş</a>
    <a href="#musteri" class="toc-pill"><span class="pill-num" style="background:#dcfce7;color:#16a34a;">2</span>Müşteri Yönetimi</a>
    <a href="#bakim" class="toc-pill"><span class="pill-num" style="background:#fce7f3;color:#db2777;">3</span>Bakım & Servis</a>
    <a href="#motorstok" class="toc-pill"><span class="pill-num" style="background:#e0e7ff;color:#4338ca;">4</span>Motorlar (Stok)</a>
    <a href="#motorsatis" class="toc-pill"><span class="pill-num" style="background:#d1fae5;color:#059669;">5</span>Motor Satışı</a>
    <a href="#cari" class="toc-pill"><span class="pill-num" style="background:#fef3c7;color:#d97706;">6</span>Cari & Ödeme</a>
    <a href="#kullanici" class="toc-pill"><span class="pill-num" style="background:#f3e8ff;color:#7c3aed;">7</span>Kullanıcı Yönetimi</a>
    <a href="#veri" class="toc-pill"><span class="pill-num" style="background:#f1f5f9;color:#475569;">8</span>Veri Merkezi</a>
    <a href="#fatura" class="toc-pill"><span class="pill-num" style="background:#fef9c3;color:#92400e;">9</span>Fatura Ayarları</a>
    <a href="#kayitlar" class="toc-pill"><span class="pill-num" style="background:#f8fafc;color:#64748b;">10</span>Sistem Kayıtları</a>
</div>

{{-- ── 1. GİRİŞ ────────────────────────────────────── --}}
<div class="section-block" id="giris" style="border-left:4px solid #2563eb;">
    <div class="section-header">
        <div class="section-icon" style="background:#eff6ff;">
            <svg style="width:22px;height:22px;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
        </div>
        <div><p class="section-num" style="color:#2563eb;">Modül 1</p><h2 class="section-title">Sisteme Giriş</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Tarayıcınızdan sistem adresini açtığınızda giriş sayfası karşınıza gelir. Yöneticinizden aldığınız kullanıcı adı ve şifreyi girerek sisteme erişirsiniz. Sistemde <strong>iki farklı rol</strong> mevcuttur:</p>
        <div class="info-grid">
            <div class="info-card" style="border-left:3px solid #2563eb;">
                <div class="info-card-label">Bayi Rolü</div>
                <div class="info-card-val">Tüm modüllere tam erişim. Müşteri, bakım, satış, cari, kullanıcı yönetimi ve ayarlar.</div>
            </div>
            <div class="info-card" style="border-left:3px solid #f59e0b;">
                <div class="info-card-label">Usta Rolü</div>
                <div class="info-card-val">Yalnızca kendisine atanan bakım kayıtlarını görür ve tamamlar. Diğer modüllere erişimi yoktur.</div>
            </div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Şifrenizi unutursanız Kullanıcı Yönetimi'nden yetkili bir bayi kullanıcısı şifrenizi sıfırlayabilir.</span></div>
    </div>
</div>

{{-- ── 2. MÜŞTERİ YÖNETİMİ ─────────────────────────── --}}
<div class="section-block" id="musteri" style="border-left:4px solid #16a34a;">
    <div class="section-header">
        <div class="section-icon" style="background:#f0fdf4;">
            <svg style="width:22px;height:22px;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div><p class="section-num" style="color:#16a34a;">Modül 2</p><h2 class="section-title">Müşteri Yönetimi</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Müşteri Yönetimi modülü; müşterilerin kişisel bilgilerini, araç plakalarını ve geçmiş işlemlerini tek bir yerde yönetmenizi sağlar. Dashboard'dan <strong>Müşteri Yönetimi</strong> kartına tıklayarak erişebilirsiniz.</p>

        <div class="divider-label">Yeni Müşteri Ekleme</div>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#dcfce7;color:#16a34a;">1</span><span>Sağ üstteki <strong>+ Yeni Müşteri Ekle</strong> butonuna tıklayın.</span></div>
            <div class="step-item"><span class="step-num" style="background:#dcfce7;color:#16a34a;">2</span><span><strong>Ad Soyad</strong> (zorunlu) ve <strong>Telefon</strong> bilgilerini girin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#dcfce7;color:#16a34a;">3</span><span><strong>TC No</strong> ve <strong>Adres</strong> bilgilerini girin. (Motor satışı yapılacaksa bu alanlar <em>zorunlu</em> hale gelir.)</span></div>
            <div class="step-item"><span class="step-num" style="background:#dcfce7;color:#16a34a;">4</span><span><strong>Araç Plakaları</strong> bölümüne araç plakasını yazın. <strong>+ Yeni Plaka Ekle</strong> ile birden fazla araç girebilirsiniz.</span></div>
            <div class="step-item"><span class="step-num" style="background:#dcfce7;color:#16a34a;">5</span><span><strong>Müşteriyi Kaydet</strong> butonuna tıklayın.</span></div>
        </div>

        <div class="divider-label">Müşteri Detay Sayfası</div>
        <p class="section-description">Müşteri listesindeki <strong>Görüntüle</strong> butonuna tıklayarak müşteri detay sayfasına ulaşabilirsiniz. Bu sayfada:</p>
        <div class="info-grid">
            <div class="info-card"><div class="info-card-label">Araç Plakaları</div><div class="info-card-val">Müşteriye ait tüm plakalar listelenir.</div></div>
            <div class="info-card"><div class="info-card-label">Cari Hesap Durumu</div><div class="info-card-val">Toplam borç, toplam ödeme ve kalan bakiye gösterilir.</div></div>
            <div class="info-card"><div class="info-card-label">İşlem Geçmişi</div><div class="info-card-val">Bakım ve satışa ait tüm borç/ödeme hareketleri listelenir.</div></div>
            <div class="info-card"><div class="info-card-label">Bakım Kayıtları</div><div class="info-card-val">"Bakımları Gör" bağlantısı ile müşteriye ait bakımlar listelenir.</div></div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Bakım kaydı oluştururken de arama kutucuğunun altındaki <em>"+ Yeni Müşteri Oluştur"</em> seçeneği ile anında müşteri ekleyebilirsiniz.</span></div>
    </div>
</div>

{{-- ── 3. BAKIM & SERVİS ───────────────────────────── --}}
<div class="section-block" id="bakim" style="border-left:4px solid #db2777;">
    <div class="section-header">
        <div class="section-icon" style="background:#fdf2f8;">
            <svg style="width:22px;height:22px;color:#db2777;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div><p class="section-num" style="color:#db2777;">Modül 3</p><h2 class="section-title">Bakım & Servis Kayıtları</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Her araç için servis işlemleri, kullanılan yedek parçalar ve işçilik maliyeti bu modülde kayıt altına alınır. Bakım oluşturulduğunda, toplam tutar otomatik olarak müşterinin cari hesabına <strong>borç</strong> olarak işlenir.</p>

        <div class="divider-label">Yeni Bakım Kaydı Oluşturma</div>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">1</span><span>Dashboard → <strong>Yedek Parça & Bakım</strong> → <strong>+ Yeni Bakım Kaydı</strong></span></div>
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">2</span><span>Açılır listeden <strong>Müşteri</strong> seçin. Listede yoksa <em>"+ Yeni Müşteri Oluştur"</em> ile ekleyin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">3</span><span>Müşteri seçilince araçları otomatik yüklenir. <strong>Araç (Plaka)</strong> seçin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">4</span><span><strong>KM</strong> bilgisini ve <strong>İşçilik Ücreti</strong>ni girin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">5</span><span><strong>+ Parça Ekle</strong> ile kullanılan yedek parçaları (ad, adet, birim fiyat) ekleyin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fce7f3;color:#db2777;">6</span><span><strong>Toplam Tutar</strong> otomatik hesaplanır; kontrol edip <strong>Bakımı Kaydet</strong>'e tıklayın.</span></div>
        </div>

        <div class="divider-label">Bakım Durumları</div>
        <div class="info-grid">
            <div class="info-card" style="border-left:3px solid #f59e0b;">
                <div class="info-card-label">⏳ Bekliyor</div>
                <div class="info-card-val">Bakım oluşturulmuş, henüz işlem tamamlanmamış. Usta görevi devam ettirir.</div>
            </div>
            <div class="info-card" style="border-left:3px solid #10b981;">
                <div class="info-card-label">✅ Tamamlandı</div>
                <div class="info-card-val">Tüm parçalar monte edilmiş ve "Tamamlandı" olarak işaretlenmiş.</div>
            </div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Bakım kaydı silindığinde, bağlı cari işlemler de silinir ve müşteri bakiyesi otomatik yeniden hesaplanır.</span></div>

        <div class="divider-label">Usta Paneli</div>
        <p class="section-description"><strong>Usta</strong> rolüyle giriş yapıldığında yalnızca <em>Bekleyen Bakımlar</em> ve <em>Tamamlanan Bakımlar</em> görünür. Usta, bakım detayından her parçayı tek tek "tamamlandı" olarak işaretleyebilir ve tüm işlem bitince bakımı kapatabilir.</p>
    </div>
</div>

{{-- ── 4. MOTORLAR (STOK) ──────────────────────────── --}}
<div class="section-block" id="motorstok" style="border-left:4px solid #4338ca;">
    <div class="section-header">
        <div class="section-icon" style="background:#eef2ff;">
            <svg style="width:22px;height:22px;color:#4338ca;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
        </div>
        <div><p class="section-num" style="color:#4338ca;">Modül 4</p><h2 class="section-title">Motorlar — Stok Yönetimi</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Bayiye giren tüm motosikletlerin stok takibi bu modülde yapılır. Her motor için şase numarası, motor numarası, renk, yıl, alış ve satış fiyatı tutulur.</p>

        <div class="divider-label">Stoka Yeni Motor Ekleme</div>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#e0e7ff;color:#4338ca;">1</span><span>Diğer İşlemler → <strong>Motorlar (Stok)</strong> → <strong>+ Yeni Motor Ekle</strong></span></div>
            <div class="step-item"><span class="step-num" style="background:#e0e7ff;color:#4338ca;">2</span><span><strong>Marka</strong> seçin. Ardından modeller otomatik yüklenir; <strong>Model</strong> seçin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#e0e7ff;color:#4338ca;">3</span><span><strong>Yıl</strong>, <strong>Geliş Tarihi</strong>, <strong>Durum</strong>, <strong>Alış Fiyatı</strong> ve <strong>Satış Fiyatı</strong>nı girin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#e0e7ff;color:#4338ca;">4</span><span>Her motor için <strong>Renk</strong>, <strong>Şase No</strong> ve <strong>Motor No</strong> girin. <em>Birden fazla</em> motor eklemek için + butonunu kullanın.</span></div>
            <div class="step-item"><span class="step-num" style="background:#e0e7ff;color:#4338ca;">5</span><span><strong>Kaydet</strong> butonuna tıklayın. Motorlar "Stokta" durumuyla eklenir.</span></div>
        </div>

        <div class="info-grid">
            <div class="info-card" style="border-left:3px solid #10b981;"><div class="info-card-label">Stokta</div><div class="info-card-val">Motor satışa hazır, stokta mevcut.</div></div>
            <div class="info-card" style="border-left:3px solid #6366f1;"><div class="info-card-label">Satıldı</div><div class="info-card-val">Motor Satışı modülünden satış yapıldığında otomatik güncellenir.</div></div>
            <div class="info-card" style="border-left:3px solid #f59e0b;"><div class="info-card-label">Revize Edildi</div><div class="info-card-val">Motor iade/revize edildi; manuel olarak ayarlanır.</div></div>
        </div>
        <div class="warn-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><span>Şase numarası ve motor numarası sistemde <strong>benzersiz</strong> olmalıdır. Aynı numarayı iki kez giremezsiniz.</span></div>
    </div>
</div>

{{-- ── 5. MOTOR SATIŞI ─────────────────────────────── --}}
<div class="section-block" id="motorsatis" style="border-left:4px solid #059669;">
    <div class="section-header">
        <div class="section-icon" style="background:#ecfdf5;">
            <svg style="width:22px;height:22px;color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04m16.732 3.04A11.955 11.955 0 0112 11a11.955 11.955 0 01-6.114-1.976m11.228 1.976A11.955 11.955 0 0112 21.056a11.955 11.955 0 01-9.112-4.056"/></svg>
        </div>
        <div><p class="section-num" style="color:#059669;">Modül 5</p><h2 class="section-title">Motor Satışı</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Stokta bulunan motorları müşterilere satmak için bu modülü kullanın. Satış kaydedildiğinde motorun durumu otomatik <strong>"Satıldı"</strong> olur ve satış tutarı müşterinin cari hesabına <strong>borç</strong> olarak işlenir.</p>

        <div class="divider-label">Satış İşlemi Adımları</div>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#d1fae5;color:#059669;">1</span><span>Dashboard → <strong>Motor Satışı</strong> → <strong>+ Yeni Satış</strong></span></div>
            <div class="step-item"><span class="step-num" style="background:#d1fae5;color:#059669;">2</span><span>Listeden <strong>Müşteri</strong> seçin. Müşteride <em>TC No</em> ve <em>Adres</em> yoksa satış gerçekleşmez.</span></div>
            <div class="step-item"><span class="step-num" style="background:#d1fae5;color:#059669;">3</span><span>Yalnızca <em>"Stokta"</em> durumundaki motorlar listeye gelir. <strong>Motor</strong> seçin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#d1fae5;color:#059669;">4</span><span><strong>Satış Fiyatı</strong> ve <strong>Satış Tarihi</strong>ni girin. İsteğe bağlı not ekleyebilirsiniz.</span></div>
            <div class="step-item"><span class="step-num" style="background:#d1fae5;color:#059669;">5</span><span><strong>Satışı Kaydet</strong>'e tıklayın. Motor "Satıldı" olarak güncellenir.</span></div>
        </div>

        <div class="warn-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><span>Motor satışı yapabilmek için müşterinin <strong>TC Kimlik No</strong> ve <strong>Adres</strong> bilgilerinin kayıtlı olması <em>zorunludur</em>. Eksik ise önce müşteri kaydını güncelleyin.</span></div>
        <div class="tip-box" style="margin-top:.75rem;"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Satış tutarı Cari & Ödeme modülünde görünür. Müşteri ödeme yaptıkça cari hesaptan düşülür.</span></div>
    </div>
</div>

{{-- ── 6. CARİ & ÖDEME ────────────────────────────── --}}
<div class="section-block" id="cari" style="border-left:4px solid #d97706;">
    <div class="section-header">
        <div class="section-icon" style="background:#fffbeb;">
            <svg style="width:22px;height:22px;color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <div><p class="section-num" style="color:#d97706;">Modül 6</p><h2 class="section-title">Cari Hesaplar & Ödeme Takibi</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Tüm müşterilerin borç-alacak durumunu tek sayfada izleyin. Bakım ve motor satışından doğan borçlar bu modüle otomatik düşer. Tahsilat işlemlerini buradan kaydedin.</p>

        <div class="divider-label">Özet Göstergeler</div>
        <div class="info-grid">
            <div class="info-card"><div class="info-card-label">Toplam Açık Bakiye</div><div class="info-card-val">Tüm müşterilerin toplam borcu (₺)</div></div>
            <div class="info-card"><div class="info-card-label">Borçlu Müşteri</div><div class="info-card-val">Bakiyesi pozitif olan müşteri sayısı</div></div>
            <div class="info-card"><div class="info-card-label">Borçsuz Müşteri</div><div class="info-card-val">Bakiyesi sıfır veya negatif müşteri sayısı</div></div>
            <div class="info-card"><div class="info-card-label">Filtreler</div><div class="info-card-val">Tümü / Borçlu / Borçsuz filtresiyle listele</div></div>
        </div>

        <div class="divider-label">Tahsilat (Ödeme) Kaydetme</div>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#fef3c7;color:#d97706;">1</span><span>Listeden müşteriye ait <strong>Detay</strong> butonuna veya müşteri adına tıklayın.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fef3c7;color:#d97706;">2</span><span><strong>+ Ödeme Ekle</strong> formuna tutar ve tarih girin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#fef3c7;color:#d97706;">3</span><span>Kaydettiğinizde bakiye anlık olarak güncellenir.</span></div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Yanlış eklenen bir ödeme kaydını, işlem geçmişinden kırmızı silme butonuyla kaldırabilirsiniz. Bakiye otomatik yeniden hesaplanır.</span></div>
    </div>
</div>

{{-- ── 7. KULLANICI YÖNETİMİ ───────────────────────── --}}
<div class="section-block" id="kullanici" style="border-left:4px solid #7c3aed;">
    <div class="section-header">
        <div class="section-icon" style="background:#f5f3ff;">
            <svg style="width:22px;height:22px;color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div><p class="section-num" style="color:#7c3aed;">Modül 7</p><h2 class="section-title">Kullanıcı Yönetimi</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Sisteme giriş yapacak personeli bu modülden yönetin. Her kullanıcıya <strong>Bayi</strong> veya <strong>Usta</strong> rolü atanır.</p>
        <div class="steps-list">
            <div class="step-item"><span class="step-num" style="background:#f3e8ff;color:#7c3aed;">1</span><span>Diğer İşlemler → <strong>Kullanıcı Yönetimi</strong> → <strong>+ Yeni Kullanıcı</strong></span></div>
            <div class="step-item"><span class="step-num" style="background:#f3e8ff;color:#7c3aed;">2</span><span>Kullanıcı adı ve en az 6 karakterlik şifre girin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#f3e8ff;color:#7c3aed;">3</span><span><strong>Bayi</strong> (tam yetki) veya <strong>Usta</strong> (yalnızca bakım) rolünü seçin.</span></div>
            <div class="step-item"><span class="step-num" style="background:#f3e8ff;color:#7c3aed;">4</span><span>Kaydedin. Kullanıcı hemen sisteme giriş yapabilir.</span></div>
        </div>
        <div class="warn-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><span>Kendi hesabınızı silemezsiniz. Silme işlemi geri alınamaz.</span></div>
    </div>
</div>

{{-- ── 8. VERİ MERKEZİ ────────────────────────────── --}}
<div class="section-block" id="veri" style="border-left:4px solid #475569;">
    <div class="section-header">
        <div class="section-icon" style="background:#f8fafc;">
            <svg style="width:22px;height:22px;color:#475569;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
        </div>
        <div><p class="section-num" style="color:#475569;">Modül 8</p><h2 class="section-title">Veri Merkezi</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Motor stok girişi yaparken kullanılan <strong>Marka</strong>, <strong>Model</strong> ve <strong>Renk</strong> tanımlamaları bu modülden yönetilir. Sisteme yeni marka veya model eklemeden önce burada tanımlamanız gerekir.</p>
        <div class="info-grid">
            <div class="info-card"><div class="info-card-label">Markalar</div><div class="info-card-val">Honda, Yamaha vb. motosiklet markalarını buradan tanımlayın.</div></div>
            <div class="info-card"><div class="info-card-label">Modeller</div><div class="info-card-val">Her marka altında model (CB125F, MT-07 vb.) tanımlayın.</div></div>
            <div class="info-card"><div class="info-card-label">Renkler</div><div class="info-card-val">Motorlara atanacak renk seçeneklerini buradan ekleyin.</div></div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Motor eklemeden önce ilgili marka ve modelin Veri Merkezi'nde tanımlı olduğundan emin olun.</span></div>
    </div>
</div>

{{-- ── 9. FATURA AYARLARI ──────────────────────────── --}}
<div class="section-block" id="fatura" style="border-left:4px solid #92400e;">
    <div class="section-header">
        <div class="section-icon" style="background:#fffbeb;">
            <svg style="width:22px;height:22px;color:#b45309;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div><p class="section-num" style="color:#92400e;">Modül 9</p><h2 class="section-title">Fatura Ayarları</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Bakım faturaları üzerinde görünecek firma bilgilerini buradan düzenleyin. Değişiklikler, yeni oluşturulan tüm faturalara anında yansır.</p>
        <div class="info-grid">
            <div class="info-card"><div class="info-card-label">Firma Adı</div><div class="info-card-val">Fatura başlığında görünecek işletme adı</div></div>
            <div class="info-card"><div class="info-card-label">Adres & Telefon</div><div class="info-card-val">İletişim bilgileri faturanın alt kısmında yer alır</div></div>
            <div class="info-card"><div class="info-card-label">Vergi No / IBAN</div><div class="info-card-val">Resmi fatura bilgileri için bu alanları doldurun</div></div>
            <div class="info-card"><div class="info-card-label">Logo</div><div class="info-card-val">Firma logosunu yükleyerek markalı fatura oluşturun</div></div>
        </div>
    </div>
</div>

{{-- ── 10. SİSTEM KAYITLARI ────────────────────────── --}}
<div class="section-block" id="kayitlar" style="border-left:4px solid #64748b;">
    <div class="section-header">
        <div class="section-icon" style="background:#f8fafc;">
            <svg style="width:22px;height:22px;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div><p class="section-num" style="color:#64748b;">Modül 10</p><h2 class="section-title">Sistem Kayıtları (Denetim)</h2></div>
    </div>
    <div class="section-body">
        <p class="section-description">Sistemde yapılan tüm oluşturma, düzenleme ve silme işlemleri otomatik olarak kayıt altına alınır. Kim, ne zaman, neyi değiştirdi bilgisine bu modülden ulaşabilirsiniz.</p>
        <div class="info-grid">
            <div class="info-card"><div class="info-card-label">Olay Türü</div><div class="info-card-val">created / updated / deleted</div></div>
            <div class="info-card"><div class="info-card-label">Kullanıcı</div><div class="info-card-val">İşlemi gerçekleştiren kullanıcı adı</div></div>
            <div class="info-card"><div class="info-card-label">Tarih & Saat</div><div class="info-card-val">İşlemin gerçekleştiği zaman</div></div>
            <div class="info-card"><div class="info-card-label">Değişiklik Detayı</div><div class="info-card-val">Önceki ve sonraki değerler karşılaştırmalı gösterilir</div></div>
        </div>
        <div class="tip-box"><svg style="width:14px;height:14px;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Sistem Kayıtları sadece okuma amaçlıdır; herhangi bir kayıt silinemez veya değiştirilemez.</span></div>
    </div>
</div>

{{-- ── CTA ─────────────────────────────────────────── --}}
<div class="cta-card">
    <h3>🚀 Artık Hazırsınız!</h3>
    <p>Tüm modülleri öğrendiniz. Sistemi kullanmaya başlamak için dashboard'a dönün.</p>
    <a href="{{ url('/admin') }}" class="cta-btn">
        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard'a Dön
    </a>
</div>

@endsection