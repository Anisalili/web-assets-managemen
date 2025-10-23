@extends('layouts.public')

@section('title', 'Home - Web Assets Management')

@section('meta_description', 'Professional web assets management system to organize and manage your digital resources efficiently.')

@section('content')
    <!-- Start header Area -->
    <section id="hero-area" class="header-area header-eight">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="header-content">
                        <h1>Modern Web Assets Management System.</h1>
                        <p>
                            We provide a comprehensive solution to manage, organize, and optimize your web assets.
                            Streamline your digital workflow with our powerful management tools.
                        </p>
                        <div class="button">
                            <a href="javascript:void(0)" class="btn primary-btn">Get Started</a>
                            <a href="https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM"
                                class="glightbox video-button">
                                <span class="btn icon-btn rounded-full">
                                    <i class="lni lni-play"></i>
                                </span>
                                <span class="text">Watch Intro</span>
                            </a>
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
                        <img src="{{ asset('templates/business/assets/images/about/about-img1.jpg') }}" alt="about" />
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-five-content">
                        <h6 class="small-title text-lg">OUR STORY</h6>
                        <h2 class="main-title fw-bold">Our team comes with the experience and knowledge</h2>
                        <div class="about-five-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-who-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-who" type="button" role="tab" aria-controls="nav-who"
                                        aria-selected="true">Who We Are</button>
                                    <button class="nav-link" id="nav-vision-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-vision" type="button" role="tab"
                                        aria-controls="nav-vision" aria-selected="false">our Vision</button>
                                    <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-history" type="button" role="tab"
                                        aria-controls="nav-history" aria-selected="false">our History</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-who" role="tabpanel"
                                    aria-labelledby="nav-who-tab">
                                    <p>We are a dedicated team focused on providing the best web assets management solution.
                                        Our platform helps businesses organize, optimize, and deliver their digital content
                                        efficiently.</p>
                                    <p>With years of experience in web development and digital asset management, we understand
                                        the challenges businesses face in managing their digital resources.</p>
                                </div>
                                <div class="tab-pane fade" id="nav-vision" role="tabpanel"
                                    aria-labelledby="nav-vision-tab">
                                    <p>Our vision is to revolutionize how businesses manage their web assets. We aim to
                                        provide a seamless, intuitive platform that makes asset management effortless and
                                        efficient.</p>
                                    <p>We believe in continuous innovation and improvement, always striving to deliver the
                                        best possible experience to our users.</p>
                                </div>
                                <div class="tab-pane fade" id="nav-history" role="tabpanel"
                                    aria-labelledby="nav-history-tab">
                                    <p>Founded with a mission to simplify web asset management, we've grown from a simple
                                        tool to a comprehensive platform trusted by businesses worldwide.</p>
                                    <p>Our journey has been driven by user feedback and a commitment to solving real-world
                                        problems in digital asset management.</p>
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
                            <h6>Services</h6>
                            <h2 class="fw-bold">Our Best Services</h2>
                            <p>
                                Comprehensive solutions for all your web assets management needs,
                                from organization to optimization and delivery.
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
                            <i class="lni lni-capsule"></i>
                        </div>
                        <div class="service-content">
                            <h4>Modern Design</h4>
                            <p>
                                Clean and intuitive interface designed for efficiency. Manage your assets
                                with ease using our modern dashboard.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-bootstrap"></i>
                        </div>
                        <div class="service-content">
                            <h4>Built with Laravel</h4>
                            <p>
                                Powered by Laravel framework for robust security, scalability,
                                and maintainability of your assets.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-shortcode"></i>
                        </div>
                        <div class="service-content">
                            <h4>Multiple Features</h4>
                            <p>
                                Comprehensive set of features including upload, organize, search,
                                and manage all your web assets in one place.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-dashboard"></i>
                        </div>
                        <div class="service-content">
                            <h4>Speed Optimized</h4>
                            <p>
                                Fast loading times and optimized performance ensure smooth
                                workflow and efficient asset management.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-layers"></i>
                        </div>
                        <div class="service-content">
                            <h4>Fully Customizable</h4>
                            <p>
                                Tailor the system to your needs with flexible configuration
                                options and customizable workflows.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services">
                        <div class="service-icon">
                            <i class="lni lni-reload"></i>
                        </div>
                        <div class="service-content">
                            <h4>Regular Updates</h4>
                            <p>
                                Continuous improvements and new features to keep your asset
                                management system up-to-date and secure.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== service-area end ===== -->


    <!-- Start Pricing  Area -->
    <section id="pricing" class="pricing-area pricing-fourteen">
        <!--======  Start Section Title Five ======-->
        <div class="section-title-five">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <h6>Pricing</h6>
                            <h2 class="fw-bold">Pricing & Plans</h2>
                            <p>
                                Choose the plan that best fits your needs. Start free and upgrade
                                as your asset management requirements grow.
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
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="pricing-style-fourteen">
                        <div class="table-head">
                            <h6 class="title">Starter</h4>
                                <p>Perfect for individuals and small projects getting started.</p>
                                <div class="price">
                                    <h2 class="amount">
                                        <span class="currency">$</span>0<span class="duration">/mo </span>
                                    </h2>
                                </div>
                        </div>

                        <div class="light-rounded-buttons">
                            <a href="javascript:void(0)" class="btn primary-btn-outline">
                                Start free trial
                            </a>
                        </div>

                        <div class="table-content">
                            <ul class="table-list">
                                <li> <i class="lni lni-checkmark-circle"></i> 100 MB Storage</li>
                                <li> <i class="lni lni-checkmark-circle"></i> Basic Asset Management</li>
                                <li> <i class="lni lni-checkmark-circle deactive"></i> Advanced Analytics</li>
                                <li> <i class="lni lni-checkmark-circle deactive"></i> Priority Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="pricing-style-fourteen middle">
                        <div class="table-head">
                            <h6 class="title">Professional</h4>
                                <p>For growing teams and businesses with higher demands.</p>
                                <div class="price">
                                    <h2 class="amount">
                                        <span class="currency">$</span>99<span class="duration">/mo </span>
                                    </h2>
                                </div>
                        </div>

                        <div class="light-rounded-buttons">
                            <a href="javascript:void(0)" class="btn primary-btn">
                                Start free trial
                            </a>
                        </div>

                        <div class="table-content">
                            <ul class="table-list">
                                <li> <i class="lni lni-checkmark-circle"></i> 10 GB Storage</li>
                                <li> <i class="lni lni-checkmark-circle"></i> Advanced Asset Management</li>
                                <li> <i class="lni lni-checkmark-circle"></i> Basic Analytics</li>
                                <li> <i class="lni lni-checkmark-circle deactive"></i> Priority Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="pricing-style-fourteen">
                        <div class="table-head">
                            <h6 class="title">Enterprise</h4>
                                <p>For large organizations with comprehensive needs.</p>
                                <div class="price">
                                    <h2 class="amount">
                                        <span class="currency">$</span>150<span class="duration">/mo </span>
                                    </h2>
                                </div>
                        </div>

                        <div class="light-rounded-buttons">
                            <a href="javascript:void(0)" class="btn primary-btn-outline">
                                Start free trial
                            </a>
                        </div>

                        <div class="table-content">
                            <ul class="table-list">
                                <li> <i class="lni lni-checkmark-circle"></i> Unlimited Storage</li>
                                <li> <i class="lni lni-checkmark-circle"></i> Full Asset Management</li>
                                <li> <i class="lni lni-checkmark-circle"></i> Advanced Analytics</li>
                                <li> <i class="lni lni-checkmark-circle"></i> 24/7 Priority Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Pricing  Area -->



    <!-- Start Cta Area -->
    <section id="call-action" class="call-action">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-9">
                    <div class="inner-content">
                        <h2>We love to make perfect <br />solutions for your business</h2>
                        <p>
                            Transform the way you manage your digital assets with our comprehensive solution.
                            Get started today and experience the difference professional asset management can make
                            for your business workflow and productivity.
                        </p>
                        <div class="light-rounded-buttons">
                            <a href="javascript:void(0)" class="btn primary-btn-outline">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Cta Area -->



    <!-- Start Latest News Area -->
    <div id="blog" class="latest-news-area section">
        <!--======  Start Section Title Five ======-->
        <div class="section-title-five">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <h6>latest news</h6>
                            <h2 class="fw-bold">Latest News & Blog</h2>
                            <p>
                                Stay updated with the latest insights, tips, and updates about
                                web assets management and digital workflow optimization.
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
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news">
                        <div class="image">
                            <a href="javascript:void(0)"><img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/1.jpg') }}"
                                    alt="Blog" /></a>
                            <div class="meta-details">
                                <img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/b6.jpg') }}"
                                    alt="Author" />
                                <span>BY ADMIN</span>
                            </div>
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="javascript:void(0)"> Best Practices for Digital Asset Management </a>
                            </h4>
                            <p>
                                Learn the essential practices for managing your digital assets effectively.
                                Discover tips and techniques to optimize your workflow.
                            </p>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news">
                        <div class="image">
                            <a href="javascript:void(0)"><img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/2.jpg') }}"
                                    alt="Blog" /></a>
                            <div class="meta-details">
                                <img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/b6.jpg') }}"
                                    alt="Author" />
                                <span>BY ADMIN</span>
                            </div>
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="javascript:void(0)">
                                    How to Organize Your Web Assets Efficiently
                                </a>
                            </h4>
                            <p>
                                Explore strategies for organizing and categorizing your web assets
                                for maximum efficiency and easy retrieval.
                            </p>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news">
                        <div class="image">
                            <a href="javascript:void(0)"><img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/3.jpg') }}"
                                    alt="Blog" /></a>
                            <div class="meta-details">
                                <img class="thumb"
                                    src="{{ asset('templates/business/assets/images/blog/b6.jpg') }}"
                                    alt="Author" />
                                <span>BY ADMIN</span>
                            </div>
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="javascript:void(0)">
                                    5 Ways to Improve Your Asset Management Workflow
                                </a>
                            </h4>
                            <p>
                                Discover actionable tips to streamline your asset management
                                processes and boost team productivity.
                            </p>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Latest News Area -->

    <!-- Start Brand Area -->
    <div id="clients" class="brand-area section">
        <!--======  Start Section Title Five ======-->
        <div class="section-title-five">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <h6>Meet our Clients</h6>
                            <h2 class="fw-bold">Our Awesome Clients</h2>
                            <p>
                                Trusted by leading companies worldwide for their web assets
                                management needs and digital workflow solutions.
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
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="clients-logos">
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/graygrids.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/uideck.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/ayroui.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/lineicons.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/tailwindtemplates.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                        <div class="single-image">
                            <img src="{{ asset('templates/business/assets/images/client-logo/ecomhtml.svg') }}"
                                alt="Brand Logo Images" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Brand Area -->

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
                                        <h4>Contact</h4>
                                        <p>0984537278623</p>
                                        <p>support@webassetsmanagement.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="lni lni-map-marker"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h4>Address</h4>
                                        <p>175 5th Ave, New York, NY 10010</p>
                                        <p>United States</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="lni lni-alarm-clock"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h4>Schedule</h4>
                                        <p>24 Hours / 7 Days Open</p>
                                        <p>Office time: 10 AM - 5:30 PM</p>
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
                                    <span> Get in Touch </span>
                                    <h2>
                                        Ready to Get Started
                                    </h2>
                                    <p>
                                        Have questions about our web assets management system? We're here to help.
                                        Contact us today to learn more.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form action="#" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" placeholder="Name" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="phone" id="phone" placeholder="Phone" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="subject" id="subject" placeholder="Subject" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="message" id="message" placeholder="Type Message" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="button text-center rounded-buttons">
                                        <button type="submit" class="btn primary-btn rounded-full">
                                            Send Message
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
            <object style="border:0; height: 500px; width: 100%;"
                data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3102.7887109309127!2d-77.44196278417968!3d38.95165507956235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzjCsDU3JzA2LjAiTiA3N8KwMjYnMjMuMiJX!5e0!3m2!1sen!2sbd!4v1545420879707"></object>
        </div>
    </section>
    <!-- ========================= map-section end ========================= -->
@endsection
