<?php
// PHP logic can be added here (e.g., session handling, database connection)
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로로 소송 전문 법률 사무소</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --gold-primary: #C5A059;
            --gold-dark: #A6823D;
            --dark-bg: #1A1A1A;
            --sidebar-width: 220px;
        }
        
        html {
            font-size: 0.9rem;
        }

        /* 모바일 폰트 및 하단 바 사이즈 최적화 */
        @media (max-width: 768px) {
            html { font-size: 0.8rem; }
            h1 { font-size: 1.75rem !important; }
            h2 { font-size: 1.5rem !important; }
            
            /* 하단 상담신청 팝업 사이즈 축소 (모바일 전용) */
            .sticky-bottom-bar {
                padding: 8px 12px !important;
                right: 0 !important;
            }
            .sticky-bottom-bar .flex-col {
                flex-direction: row !important;
                gap: 4px !important;
                space-y: 0 !important;
            }
            .sticky-input {
                padding: 6px 10px !important;
                font-size: 0.75rem !important;
                border-radius: 6px !important;
            }
            .sticky-bottom-bar button {
                padding: 6px 12px !important;
                font-size: 0.75rem !important;
                width: auto !important;
                flex-shrink: 0;
            }
        }
        
        body {
            font-family: 'Dotum', '돋움', 'Apple SD Gothic Neo', sans-serif;
            scroll-behavior: smooth;
            background-color: #fff;
            color: #333;
            padding-bottom: 80px;
            padding-right: var(--sidebar-width);
            -webkit-user-select: none;
            user-select: none;
            line-height: 1.5;
        }

        .serif { 
            font-family: 'Dotum', '돋움', sans-serif; 
            letter-spacing: -0.05em;
        }
        
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), 
                        url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }

        /* --- Header --- */
        #main-header {
            transition: all 0.3s ease;
            width: calc(100% - var(--sidebar-width));
        }
        .header-scrolled {
            background: white !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* --- Desktop Sidebar --- */
        .fixed-sidebar {
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--dark-bg);
            border-left: 1px solid rgba(197, 160, 89, 0.3);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 40px 20px;
        }

        /* --- Mobile Burger Menu --- */
        #mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100%;
            background: var(--dark-bg);
            z-index: 3000;
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 40px 20px;
            box-shadow: -10px 0 30px rgba(0,0,0,0.5);
        }
        #mobile-menu.active { right: 0; }
        #menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2900;
            display: none;
        }
        #menu-overlay.active { display: block; }

        .sidebar-link {
            display: block;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            color: white;
            transition: all 0.3s;
            cursor: pointer;
        }
        .sidebar-link:hover {
            color: var(--gold-primary);
            padding-left: 8px;
        }
        .sidebar-link .label {
            font-size: 0.95rem;
            font-weight: 600;
            word-break: keep-all;
        }

        /* --- General UI --- */
        .btn-gold {
            background: var(--gold-primary);
            color: white;
            transition: all 0.3s;
        }
        .btn-gold:hover {
            background: var(--gold-dark);
        }

        .diag-progress-bar {
            height: 4px;
            background: #eee;
            border-radius: 2px;
            overflow: hidden;
        }
        .diag-progress-inner {
            height: 100%;
            background: var(--gold-primary);
            width: 0%;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sticky-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: var(--sidebar-width);
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            z-index: 200;
            border-top: 1px solid rgba(197, 160, 89, 0.3);
            display: flex;
            align-items: center;
            padding: 12px 20px;
            box-shadow: 0 -10px 25px rgba(0,0,0,0.3);
        }
        
        .sticky-input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
        }

        #modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        #modal-overlay.active { display: flex; }

        .modal-container {
            animation: modalFadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1024px) {
            body { padding-right: 0; }
            .fixed-sidebar { display: none; }
            #main-header { width: 100%; }
            .sticky-bottom-bar { right: 0; }
            .burger-btn { display: block !important; }
        }

        .attorney-icon-wrap {
            width: 120px;
            height: 120px;
            background: #f8f9fa;
            border-radius: 1.5rem; 
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            color: var(--gold-primary);
            transition: all 0.5s ease;
        }
        .group:hover .attorney-icon-wrap {
            background: var(--gold-primary);
            color: white;
            transform: translateY(-5px);
        }

        .principle-card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 2rem;
            border: 1px solid #f1f1f1;
            transition: all 0.4s ease;
        }
        .principle-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-primary);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin 20s linear infinite;
        }
    </style>
</head>
<body class="bg-white text-gray-900" oncontextmenu="return false" onselectstart="return false">

    <!-- Desktop Fixed Sidebar Navigation -->
    <aside class="fixed-sidebar">
        <div class="mb-10 text-center">
            <div class="text-[10px] text-[#C5A059] font-bold tracking-[0.2em] mb-1 uppercase">Menu</div>
            <div class="h-px bg-white/10 w-full"></div>
        </div>
        <nav class="flex-1">
            <div onclick="showMainSection()" class="sidebar-link group"><span class="label">홈으로</span></div>
            <div onclick="showMainSection(); scrollToSection('lawyers');" class="sidebar-link group"><span class="label">변호사 소개</span></div>
            <div onclick="showMainSection(); scrollToSection('location');" class="sidebar-link group"><span class="label">오시는 길</span></div>
            <div onclick="startDiagnosis()" class="sidebar-link group"><span class="label">소송 진단</span></div>
            <div onclick="showBoardSection()" class="sidebar-link group"><span class="label">공지/보도</span></div>
        </nav>
        <div class="mt-auto">
            <div class="p-4 bg-white/5 rounded-xl border border-white/5 text-center">
                <p class="text-[9px] text-white/40 mb-3 leading-tight uppercase">Emergency Call</p>
                <button onclick="openModal()" class="btn-gold w-full py-2.5 rounded text-[10px] font-bold">1:1 상담</button>
            </div>
        </div>
    </aside>

    <!-- Mobile Side Menu -->
    <div id="menu-overlay" onclick="toggleMenu()"></div>
    <aside id="mobile-menu">
        <div class="flex justify-between items-center mb-10">
            <div class="text-[10px] text-[#C5A059] font-bold tracking-[0.2em] uppercase">Navigation</div>
            <button onclick="toggleMenu()" class="text-white/50 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="space-y-2">
            <div onclick="showMainSection(); toggleMenu();" class="sidebar-link group"><span class="label">홈으로</span></div>
            <div onclick="showMainSection(); scrollToSection('lawyers'); toggleMenu();" class="sidebar-link group"><span class="label">변호사 소개</span></div>
            <div onclick="showMainSection(); scrollToSection('location'); toggleMenu();" class="sidebar-link group"><span class="label">오시는 길</span></div>
            <div onclick="startDiagnosis(); toggleMenu();" class="sidebar-link group"><span class="label">소송 진단</span></div>
            <div onclick="showBoardSection(); toggleMenu();" class="sidebar-link group"><span class="label">공지/보도</span></div>
        </nav>
        <div class="mt-12">
            <button onclick="openModal(); toggleMenu();" class="btn-gold w-full py-4 rounded-2xl font-bold text-xs uppercase tracking-widest">Consultation</button>
        </div>
    </aside>

    <!-- Header -->
    <header class="h-20 flex items-center px-6 md:px-12 fixed z-50" id="main-header">
        <div class="grid grid-cols-3 items-center w-full">
            <div class="flex justify-start">
                <button onclick="toggleMenu()" class="burger-btn hidden text-white transition-colors" id="burger-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <div class="flex justify-center">
                <div class="flex items-center space-x-2 cursor-pointer" onclick="showMainSection()">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-[#C5A059]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 3v17M3 7h18M7 7c0 4 1 6 5 6s5-2 5-6"></path>
                    </svg>
                    <div class="text-lg md:text-xl font-bold serif tracking-tighter text-white" id="logo-text">로로 <span class="text-[#C5A059]">소송 로펌</span></div>
                </div>
            </div>

            <div class="flex justify-end">
                <button onclick="openModal()" class="btn-gold px-4 md:px-5 py-2 rounded-full font-bold text-[9px] md:text-[10px] shadow-lg flex items-center space-x-2">
                    <span class="hidden md:inline">상담 신청</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div id="main-section">
        <section class="hero-bg min-h-[85vh] md:min-h-[90vh] flex items-center pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-6 w-full grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white text-center lg:text-left order-1">
                    <div class="inline-block px-4 py-1.5 border border-white/20 rounded-full mb-6 text-[10px] md:text-xs backdrop-blur-sm">
                        <span class="text-[#C5A059] font-bold">Top 1%</span> Expertise in Litigation
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold serif leading-tight mb-6">압도적 전문성으로<br>판결을 <span class="text-[#C5A059]">뒤집습니다.</span></h1>
                    <p class="text-white/60 text-[12px] md:text-sm mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">로로 소송 법률사무소는 각 분야별 검찰 및 법원 출신 베테랑 변호사들이 원팀(One-Team) 체제로 사건의 본질을 꿰뚫는 전략을 제시합니다.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-4">
                        <button onclick="startDiagnosis()" class="btn-gold px-8 py-4 rounded-2xl font-bold text-xs w-full sm:w-auto">무료 법률 진단</button>
                        <button onclick="scrollToSection('lawyers')" class="px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-xs hover:bg-white/10 w-full sm:w-auto">변호사 이력 보기</button>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-2xl order-2 w-full max-w-sm mx-auto lg:mx-0 lg:ml-auto">
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 bg-[#C5A059]/10 text-[#C5A059] text-[10px] font-bold rounded-full mb-3 uppercase tracking-widest">Criminal Law Center</span>
                        <h2 class="text-xl md:text-2xl font-bold mb-2 serif">형사 소송 전문 센터</h2>
                        <p class="text-gray-400 text-[11px] leading-relaxed">구속 영장 실질 심사부터 항소심까지,<br>검찰 출신 변호사들이 직접 전담합니다.</p>
                    </div>
                    <div class="space-y-3">
                        <button onclick="startDiagnosis()" class="w-full p-4 rounded-xl border border-gray-100 hover:border-[#C5A059] text-left text-[11px] md:text-xs font-medium flex justify-between items-center group transition-all">
                            <div>
                                <span class="block font-bold">마약·경제범죄 전담팀</span>
                                <span class="text-[9px] text-gray-400">초기 대응 및 증거 수집 전략</span>
                            </div>
                            <svg class="w-3 h-3 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                        <button onclick="startDiagnosis()" class="w-full p-4 rounded-xl border border-gray-100 hover:border-[#C5A059] text-left text-[11px] md:text-xs font-medium flex justify-between items-center group transition-all">
                            <div>
                                <span class="block font-bold">민사·손해배상 센터</span>
                                <span class="text-[9px] text-gray-400">최대 승소 및 합의 대행 서비스</span>
                            </div>
                            <svg class="w-3 h-3 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lawyers Section -->
        <section id="lawyers" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <span class="text-[#C5A059] font-bold text-[10px] uppercase tracking-widest mb-2 block">Our Attorneys</span>
                    <h2 class="text-2xl md:text-3xl font-bold serif">전담 변호사 그룹</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-8 rounded-[2.5rem] text-center border border-gray-100 group hover:shadow-xl transition-all duration-500">
                        <div class="attorney-icon-wrap">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 4v1m0 11v1m5-10.111l-.894.447M19 12l-1 0m-1.111 5l.447.894M12 19v1m-5-10.111l.894.447M5 12l-1 0m1.111 5l-.447.894M12 7a5 5 0 100 10 5 5 0 000-10z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <h4 class="font-bold serif text-lg mb-1">김로로 변호사</h4>
                        <p class="text-[#C5A059] text-[10px] font-bold mb-4 uppercase tracking-tighter">Chief Attorney / Criminal Specialist</p>
                        <p class="text-[11px] text-gray-500 leading-relaxed">전 서울중앙지검 검사<br>사법연수원 35기<br>마약·강력범죄 1,500건 이상 수행</p>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-[2.5rem] text-center border border-gray-100 group hover:shadow-xl transition-all duration-500">
                        <div class="attorney-icon-wrap">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h4 class="font-bold serif text-lg mb-1">이안양 변호사</h4>
                        <p class="text-[#C5A059] text-[10px] font-bold mb-4 uppercase tracking-tighter">Partner / Civil Litigation</p>
                        <p class="text-[11px] text-gray-500 leading-relaxed">전 서울고등법원 판사<br>대형 로펌 출신<br>손해배상·건설 분쟁 전문</p>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-[2.5rem] text-center border border-gray-100 group hover:shadow-xl transition-all duration-500">
                        <div class="attorney-icon-wrap">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h4 class="font-bold serif text-lg mb-1">최만안 변호사</h4>
                        <p class="text-[#C5A059] text-[10px] font-bold mb-4 uppercase tracking-tighter">Senior Associate / Family Law</p>
                        <p class="text-[11px] text-gray-500 leading-relaxed">가사전문 변호사 등록<br>이혼·상속 분쟁 전담<br>누적 합의 성공률 92%</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section id="location" class="py-24 bg-gray-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <span class="text-[#C5A059] font-bold text-[10px] uppercase tracking-widest mb-2 block">Visit Us</span>
                    <h2 class="text-2xl md:text-3xl font-bold serif">오시는 길</h2>
                </div>
                <div class="grid lg:grid-cols-12 gap-8 items-stretch">
                    <div class="lg:col-span-4 flex flex-col justify-center">
                        <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 h-full flex flex-col justify-center">
                            <div class="mb-8">
                                <h3 class="text-xl font-bold serif mb-4 text-gray-800">로로 소송 법률 사무소</h3>
                                <p class="text-xs text-gray-500 leading-relaxed mb-6">서울특별시 서초구 서초대로 123<br>로로빌딩 5층</p>
                            </div>
                            <div class="space-y-4 border-t border-gray-50 pt-8">
                                <p class="text-[11px] text-gray-500 leading-relaxed"><span class="font-bold text-gray-700">지하철:</span> 서초역 7번 출구 도보 3분 거리</p>
                                <p class="text-[11px] text-gray-500 leading-relaxed"><span class="font-bold text-gray-700">주차:</span> 건물 내 무료 발렛 파킹 지원</p>
                            </div>
                            <button onclick="openModal()" class="btn-gold w-full py-4 rounded-2xl font-bold text-[10px] mt-10 uppercase tracking-widest shadow-lg">상담 예약하기</button>
                        </div>
                    </div>
                    <div class="lg:col-span-8">
                        <div class="h-[450px] lg:h-full min-h-[400px] bg-gray-200 rounded-[2.5rem] overflow-hidden shadow-2xl border border-white">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3165.267362098656!2d127.00938457635398!3d37.49103562846872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca1394f6f1c7d%3A0x6b7726359560f48!2z7ISc7LSI7Jet!5e0!3m2!1sko!2skr!4v1710745500000!5m2!1sko!2skr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Board Section -->
    <div id="board-section" class="pt-32 pb-24 px-6 hidden">
        <div class="max-w-3xl mx-auto" id="board-container"></div>
    </div>

    <!-- Diagnostic View -->
    <div id="diagnostic-view" class="pt-32 pb-24 px-6 hidden">
        <div class="max-w-xl mx-auto bg-white p-8 md:p-10 rounded-[2rem] shadow-2xl border border-gray-100">
            <div id="diag-header" class="mb-8">
                <div class="flex justify-between items-end mb-3">
                    <h2 class="text-lg md:text-xl font-bold serif">소송 가능성 진단</h2>
                    <span id="step-counter" class="text-[#C5A059] font-bold text-xs">1 / 5</span>
                </div>
                <div class="diag-progress-bar"><div id="diag-progress-inner" class="diag-progress-inner"></div></div>
            </div>
            <div id="diag-content"></div>
        </div>
    </div>

    <!-- Sticky Bottom Bar (Slim Design for Mobile) -->
    <div class="sticky-bottom-bar flex justify-center">
        <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 w-full max-w-2xl">
            <input type="text" placeholder="성함" class="sticky-input flex-1 w-full" id="sticky-name">
            <input type="tel" placeholder="연락처" class="sticky-input flex-1 w-full" id="sticky-phone">
            <button onclick="openModal()" class="btn-gold px-8 py-2.5 rounded-lg font-bold text-[10px] md:text-[11px] w-full md:w-auto">상담 신청</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-16 bg-[#1A1A1A] text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="text-lg font-bold serif mb-4">로로 <span class="text-[#C5A059]">소송 로펌</span></div>
            <p class="text-white/40 text-[9px] md:text-[10px] mb-2">서울특별시 서초구 서초대로 123 로로빌딩 5층</p>
            <p class="text-white/20 text-[8px] md:text-[9px]">사업자 등록번호: 123-45-67890 | 광고책임변호사: 김로로<br>© <?php echo date("Y"); ?> 로로 소송 법률사무소. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Consultation Modal -->
    <div id="modal-overlay" onclick="closeModal()">
        <div class="modal-container bg-white rounded-[2.5rem] w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-[#1A1A1A] p-8 text-center relative">
                <button onclick="closeModal()" class="absolute top-6 right-6 text-white/40 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="text-[9px] text-[#C5A059] font-bold tracking-[0.3em] uppercase mb-2">Secured Inquiry</div>
                <h3 class="text-xl md:text-2xl font-bold serif text-white">비밀 소송 상담</h3>
            </div>
            <div class="p-6 md:p-8 space-y-4">
                <input type="text" id="form-name" placeholder="의뢰인 성함" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none text-xs">
                <input type="tel" id="form-phone" placeholder="연락처" class="w-full px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none text-xs">
                <textarea id="form-content" placeholder="사건의 경위 및 희망하는 결과를 간략히 남겨주시면 담당 변호사가 즉시 검토하겠습니다." class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:outline-none text-xs h-32 resize-none"></textarea>
                <button class="btn-gold w-full py-4 rounded-2xl font-bold text-xs md:text-sm uppercase tracking-widest">변호사 직접 상담 신청</button>
            </div>
        </div>
    </div>

    <script>
        // --- UI Interactions ---
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('menu-overlay');
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            const logoText = document.getElementById('logo-text');
            const burger = document.getElementById('burger-icon');
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
                logoText.classList.replace('text-white', 'text-gray-900');
                if (burger) burger.classList.replace('text-white', 'text-gray-900');
            } else {
                header.classList.remove('header-scrolled');
                logoText.classList.replace('text-gray-900', 'text-white');
                if (burger) burger.classList.replace('text-gray-900', 'text-white');
            }
        });

        function showMainSection() {
            document.getElementById('main-section').classList.remove('hidden');
            document.getElementById('board-section').classList.add('hidden');
            document.getElementById('diagnostic-view').classList.add('hidden');
            window.scrollTo(0,0);
        }

        function showBoardSection() {
            document.getElementById('main-section').classList.add('hidden');
            document.getElementById('board-section').classList.remove('hidden');
            document.getElementById('diagnostic-view').classList.add('hidden');
            renderBoardList();
            window.scrollTo(0,0);
        }

        function startDiagnosis() {
            document.getElementById('main-section').classList.add('hidden');
            document.getElementById('board-section').classList.add('hidden');
            document.getElementById('diagnostic-view').classList.remove('hidden');
            currentStep = 0;
            window.scrollTo(0,0);
            renderStep();
        }

        function scrollToSection(id) {
            const el = document.getElementById(id);
            if(el) window.scrollTo({top: el.offsetTop - 100, behavior: 'smooth'});
        }

        function openModal() { 
            const stickyName = document.getElementById('sticky-name').value;
            const stickyPhone = document.getElementById('sticky-phone').value;
            if(stickyName) document.getElementById('form-name').value = stickyName;
            if(stickyPhone) document.getElementById('form-phone').value = stickyPhone;
            document.getElementById('modal-overlay').classList.add('active'); 
        }
        function closeModal() { document.getElementById('modal-overlay').classList.remove('active'); }

        const boardData = [
            { id: 1, title: "[보도] 로로 법률 사무소, 마약 범죄 특별 전담팀 구성", date: "2026.01.01", content: "최근 급증하는 마약 범죄 대응을 위해 검찰 출신 변호사진과 디지털 포렌식 전문가로 구성된 특별 전담팀을 공식 출범했습니다." },
            { id: 2, title: "[공지] 설 연휴 기간 긴급 법률 지원 서비스 안내", date: "2026.01.15", content: "연휴 기간 중 발생할 수 있는 긴급 구속 및 압수수색에 대비하여 24시간 당직 변호사 시스템을 가동합니다." }
        ];

        function renderBoardList() {
            const container = document.getElementById('board-container');
            let html = `<h2 class="text-2xl font-bold serif text-center mb-12">공지/보도</h2><div class="space-y-4">`;
            boardData.forEach(item => {
                html += `<div onclick="renderBoardDetail(${item.id})" class="p-6 bg-white border border-gray-100 rounded-2xl flex justify-between items-center hover:bg-gray-50 transition-all cursor-pointer shadow-sm">
                    <div><h3 class="font-bold text-sm mb-1">${item.title}</h3><span class="text-[10px] text-gray-400">${item.date}</span></div>
                    <svg class="w-4 h-4 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>`;
            });
            html += `</div>`;
            container.innerHTML = html;
        }

        function renderBoardDetail(id) {
            const post = boardData.find(p => p.id === id);
            const container = document.getElementById('board-container');
            container.innerHTML = `
                <button onclick="renderBoardList()" class="text-[#C5A059] text-[10px] font-bold mb-8 flex items-center space-x-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span>목록으로 돌아가기</span>
                </button>
                <h2 class="text-xl font-bold serif mb-2">${post.title}</h2>
                <div class="text-[10px] text-gray-400 border-b border-gray-100 pb-4 mb-6">${post.date}</div>
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap">${post.content}</div>
            `;
        }

        let currentStep = 0;
        const questions = [
            { q: "현재 사건의 법적 단계는 어느 단계입니까?", a: ["사건 발생 전 (예방/자문)", "경찰/검찰 수사 개시", "공판 진행 중 (1심/2심)", "판결 선고 후 항소 준비"] },
            { q: "예상되는 사건의 중대성은 어떠합니까?", a: ["경미한 벌금형 예상", "집행유예 목표", "구속 위기/실형 가능성 높음", "무죄/무혐의 주장"] },
            { q: "변호인 선임 시 가장 중요하게 생각하는 요소는?", a: ["검찰/법원 출신 이력", "유사 사건 승소 경험", "신속한 1:1 소통", "합리적인 수임료"] }
        ];

        function renderStep() {
            const step = questions[currentStep];
            const content = document.getElementById('diag-content');
            const progress = document.getElementById('diag-progress-inner');
            const counter = document.getElementById('step-counter');

            if(currentStep >= questions.length) {
                progress.style.width = '100%';
                counter.innerText = '완료';
                content.innerHTML = `<div class="text-center py-5"><p class="text-[13px] text-gray-500 mb-6 leading-relaxed">진단 결과, 의뢰인님의 사건은 <strong>전문 변호사의 즉각적인 개입</strong>이 필요한 상황으로 분석됩니다.</p><button onclick="openModal()" class="btn-gold px-10 py-4 rounded-2xl font-bold text-xs">전문화 리포트 신청</button></div>`;
                return;
            }

            progress.style.width = `${((currentStep) / questions.length) * 100}%`;
            counter.innerText = `${currentStep + 1} / ${questions.length}`;
            content.innerHTML = `<h3 class="text-base font-bold mb-5 serif">${step.q}</h3><div class="space-y-2">${step.a.map(ans => `<button onclick="nextDiagStep()" class="w-full p-4 border border-gray-100 rounded-2xl text-left hover:border-[#C5A059] transition-all text-xs font-medium">${ans}</button>`).join('')}</div>`;
        }

        function nextDiagStep() { currentStep++; renderStep(); }
    </script>
</body>
</html>
