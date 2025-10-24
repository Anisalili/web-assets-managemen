@extends('layouts.public')

@section('title', 'Beranda - Sistem Manajemen Asset OMBÉ')

@section('meta_description', 'Sistem manajemen, monitoring, dan perbaikan asset internal PT Panen Embun Kemakmuran.')

@section('content')
    <!-- Start header Area -->
    <section id="hero-area" class="header-area header-eight">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="header-content">
                        <h1>Sistem Manajemen Asset OMBÉ</h1>
                        <p>
                            Platform terintegrasi untuk manajemen, monitoring, dan perbaikan asset perusahaan.
                            Tingkatkan efisiensi operasional dengan sistem pengelolaan asset yang modern dan handal.
                        </p>
                        <div class="button">
                            <a href="{{ route('login') }}" class="btn primary-btn">Akses Sistem</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="header-image">
                        <img src="{{ asset('templates/business/assets/images/header/hero-image.jpg') }}" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End header Area -->

    <!--====== ABOUT FIVE PART START ======-->
    <section class="about-area about-five">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12">
                    <div class="about-image-five">
                        <svg class="shape" width="106" height="134" viewBox="0 0 106 134" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="1.66654" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="1.66654" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="16.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="16.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="16.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="16.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="16.333" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="30.9998" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="30.9998" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="30.9998" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="30.9998" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="31" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="74.6668" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="45.6665" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="89.3333" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="60.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="1.66679" r="1.66667" fill="#DADADA" />
                            <circle cx="60.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="16.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="60.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="31.0001" r="1.66667" fill="#DADADA" />
                            <circle cx="60.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="45.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="60.3335" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="88.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="117.667" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="74.6668" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="103" r="1.66667" fill="#DADADA" />
                            <circle cx="60.333" cy="132" r="1.66667" fill="#DADADA" />
                            <circle cx="104" cy="132" r="1.66667" fill="#DADADA" />
                        </svg>
                        <img src="{{ asset('templates/business/assets/images/about/LOGO_OMBE.png') }}" alt="about" />
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-five-content">
                        <h6 class="small-title text-lg">TENTANG PERUSAHAAN</h6>
                        <h2 class="main-title fw-bold">PT Panen Embun Kemakmuran</h2>
                        <div class="about-five-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-who-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-who" type="button" role="tab" aria-controls="nav-who"
                                        aria-selected="true">Profil Perusahaan</button>
                                    <button class="nav-link" id="nav-vision-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-vision" type="button" role="tab"
                                        aria-controls="nav-vision" aria-selected="false">Visi & Misi</button>
                                    <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-history" type="button" role="tab"
                                        aria-controls="nav-history" aria-selected="false">Sejarah</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-who" role="tabpanel"
                                    aria-labelledby="nav-who-tab">
                                    <p>PT Panen Embun Kemakmuran merupakan perusahaan yang bergerak dibidang industri Air Minum 
                                        Dalam Kemasan (AMDK) yang berlokasi di Jl. A. Yani, Desa Nusa Indah, RT. 010 RW. 002,
                                        Kec. Bati-Bati, Kab. Tanah Laut Prov. Kalimantan Selatan.</p>
                                    <p>Kami memproduksi Air Minum Dalam Kemasan (AMDK) dengan melalui
                                         berbagai tahap pengolahan dan proses produksi sehingga menghasilkan 
                                         air mineral yang siap minum dengan merk dagang “OMBE” dalam berbagai 
                                         variasi ukuran kemasan, meliputi: Cup dengan volume 220 ml, Botol dengan 
                                         volume 250ml, 350ml, 600ml, dan 1500ml, serta Galon dengan volume 19L.</p>
                                </div>
                                <div class="tab-pane fade" id="nav-vision" role="tabpanel"
                                    aria-labelledby="nav-vision-tab">
                                    <p>Visi kami adalah Menjadi Produsen Produk Air Mineral yang bermutu pilihan konsumen.</p>
                                    <p>Misi kami adalah sebagai berikut:

                                    "Mengembangkan Usaha untuk meningkatkan kesejahteraan karyawan" &
                                    "Memberikan pelayanan prima bagi pelanggan"</p>
                                </div>
                                <div class="tab-pane fade" id="nav-history" role="tabpanel"
                                    aria-labelledby="nav-history-tab">
                                    <p>Didirikan pada 30 Mei 2014, PT Panen Embun Kemakmuran memulai operasional komersialnya
                                        pada 20 November 2020. Dalam perjalanannya, perusahaan terus berkembang menjadi salah
                                        satu produsen AMDK yang dipercaya di wilayah Kalimantan Selatan.</p>
                                    <p>Dengan fasilitas produksi modern dan sistem manajemen yang terintegrasi, kami berkomitmen
                                        untuk terus meningkatkan kualitas produk dan layanan kepada konsumen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </section>

    <!--====== ABOUT FIVE PART ENDS ======-->

    <!-- ===== service-area start ===== -->
    <section id="services" class="services-area services-eight">
        <!--======  Start Section Title Five ======-->
        <div class="section-title-five">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <h6>Fitur Sistem</h6>
                            <h2 class="fw-bold">Fitur Manajemen Asset</h2>
                            <p>
                                Sistem komprehensif untuk pengelolaan, monitoring,serta pemeliharaan dan kerusaakan
                                asset perusahaan dengan teknologi terkini.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!--======  End Section Title Five ======-->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-package"></i>
                        </div>
                        <div class="service-content">
                            <h4>Inventarisasi Asset</h4>
                            <p>
                                Pendataan lengkap semua asset perusahaan mulai dari mesin produksi,
                                kendaraan, peralatan, hingga infrastruktur pabrik.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-graph"></i>
                        </div>
                        <div class="service-content">
                            <h4>Monitoring Real-time</h4>
                            <p>
                                Pantau kondisi dan status asset secara real-time untuk memastikan
                                operasional produksi berjalan optimal dan efisien.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-cog"></i>
                        </div>
                        <div class="service-content">
                            <h4>Manajemen Pemeliharaan dan kerusakan asset</h4>
                            <p>
                                Jadwal maintenance terpadu, tracking perbaikan, dan histori
                                perawatan untuk menjaga performa optimal asset.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-analytics"></i>
                        </div>
                        <div class="service-content">
                            <h4>Laporan & Analisis</h4>
                            <p>
                                Dashboard analitik dan laporan komprehensif untuk mendukung
                                pengambilan keputusan manajemen yang tepat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-shield"></i>
                        </div>
                        <div class="service-content">
                            <h4>Keamanan Data</h4>
                            <p>
                                Sistem keamanan berlapis dengan enkripsi data, backup otomatis,
                                dan kontrol akses berbasis role untuk proteksi maksimal.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-mobile"></i>
                        </div>
                        <div class="service-content">
                            <h4>Akses Multi-Device</h4>
                            <p>
                                Akses sistem dari berbagai perangkat - desktop, tablet, atau smartphone
                                untuk kemudahan monitoring di lapangan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== service-area end ===== -->

    <!-- Start Cta Area -->
    <section id="call-action" class="call-action">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-9">
                    <div class="inner-content">
                        <h2>Kelola Asset Perusahaan <br />dengan Lebih Efisien</h2>
                        <p>
                            Transformasikan cara Anda mengelola asset dengan sistem yang terintegrasi dan mudah digunakan.
                            Tingkatkan produktivitas operasional dan maksimalkan nilai investasi asset perusahaan Anda
                            dengan teknologi manajemen asset modern.
                        </p>
                        <div class="light-rounded-buttons">
                            <a href="{{ route('login') }}" class="btn primary-btn-outline">Akses Sistem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Cta Area -->

    <!-- ========================= contact-section start ========================= -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="contact-item-wrapper">
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="lni lni-phone"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h4>Kontak</h4>
                                        <p>+628172817818</p>
                                        <p>ombeairmineral@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="lni lni-map-marker"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h4>Alamat</h4>
                                        <p>Jl. A. Yani Km. 33, Desa Nusa Indah RT. 10 RW.02</p>
                                        <p>Kec. Bati-Bati, Kab. Tanah Laut, Kalimantan Selatan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="lni lni-alarm-clock"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h4>Jam Operasional</h4>
                                        <p>Senin - Kamis: 08:00 - 16:00 WITA</p>
                                        <p>Jumat        : 08:00 - 17:00 WITA</p>
                                        <p>Sabtu        : 08:00 - 13:00 WITA</p>
                                        <p>Minggu & Hari Libur: Tutup</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="contact-form-wrapper">
                        <div class="row">
                            <div class="col-xl-10 col-lg-8 mx-auto">
                                <div class="section-title text-center">
                                    <span> Hubungi Kami </span>
                                    <h2>
                                        Butuh Bantuan?
                                    </h2>
                                    <p>
                                        Tim IT Support kami siap membantu Anda dengan segala pertanyaan terkait
                                        sistem manajemen asset. Hubungi kami untuk dukungan teknis.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form action="#" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" placeholder="Nama" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="phone" id="phone" placeholder="No. Telepon" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="subject" id="subject" placeholder="Subjek" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="message" id="message" placeholder="Pesan Anda" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="button text-center rounded-buttons">
                                        <button type="submit" class="btn primary-btn rounded-full">
                                            Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= contact-section end ========================= -->

    <!-- ========================= map-section start ========================= -->
    <section class="map-section map-style-9">
        <div class="map-container">
            <iframe style="border:0; height: 500px; width: 100%;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.5304894!2d114.7319207!3d-3.5570746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de68fc49b9d3833%3A0x8c5fc45cc0f7d9af!2sOMB%C3%89%20AIR%20MINERAL%20FACTORY%20(PT.%20PANEN%20EMBUN%20KEMAKMURAN)!5e0!3m2!1sid!2sid!4v1234567890"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <!-- ========================= map-section end ========================= -->
@endsection
