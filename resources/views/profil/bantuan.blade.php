@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="fw-bold text-center mb-4"><i class="bi bi-question-circle-fill text-primary me-2"></i>Pusat Bantuan</h2>
    <p class="text-center text-muted mb-5">Temukan jawaban atas pertanyaan umum seputar Basiru, investasi, dan UMKM. Jika masih ada yang ingin ditanyakan, tim kami siap membantu Anda!</p>

    {{-- FAQ Section --}}
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faqOneHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                    <i class="bi bi-person-plus-fill me-2 text-success"></i>Bagaimana cara mendaftar sebagai investor?
                </button>
            </h2>
            <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqOneHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Klik tombol <b>"Daftar"</b> di halaman utama, pilih peran sebagai investor, isi formulir, dan ikuti instruksi aktivasi akun yang dikirim ke email Anda.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqTwoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                    <i class="bi bi-cash-coin me-2 text-warning"></i>Bagaimana cara mendanai UMKM?
                </button>
            </h2>
            <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqTwoHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Masuk ke akun Anda, pilih proyek UMKM yang ingin didanai, klik <b>"Danai Sekarang"</b>, lalu ikuti proses pembayaran yang tersedia.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqThreeHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                    <i class="bi bi-shield-lock-fill me-2 text-info"></i>Apakah dana saya aman?
                </button>
            </h2>
            <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqThreeHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Kami bekerja sama dengan mitra keuangan terpercaya serta menerapkan sistem verifikasi berlapis untuk keamanan transaksi dan perlindungan dana Anda.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqFourHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                    <i class="bi bi-graph-up-arrow me-2 text-primary"></i>Bagaimana cara memantau perkembangan investasi saya?
                </button>
            </h2>
            <div id="faqFour" class="accordion-collapse collapse" aria-labelledby="faqFourHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat memantau portofolio dan perkembangan investasi melalui menu <b>"Portofolio"</b> di dashboard. Semua laporan dan update akan ditampilkan secara transparan.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqFiveHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
                    <i class="bi bi-people-fill me-2 text-secondary"></i>Siapa saja yang bisa menjadi investor di Basiru?
                </button>
            </h2>
            <div id="faqFive" class="accordion-collapse collapse" aria-labelledby="faqFiveHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Siapa pun Warga Negara Indonesia berusia minimal 17 tahun dan memiliki KTP dapat menjadi investor di Basiru.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="faqSixHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqSix" aria-expanded="false" aria-controls="faqSix">
                    <i class="bi bi-arrow-repeat me-2 text-success"></i>Bagaimana jika saya ingin menarik dana?
                </button>
            </h2>
            <div id="faqSix" class="accordion-collapse collapse" aria-labelledby="faqSixHeading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat melakukan penarikan dana melalui menu <b>"Saldo"</b> di dashboard. Proses penarikan akan diproses dalam waktu 1-2 hari kerja.
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Buttons --}}
    <div class="text-center mt-5">
        <div class="card shadow-sm d-inline-block p-4 border-0" style="max-width: 420px; background: #f8f9fa;">
            <h5 class="fw-semibold mb-3"><i class="bi bi-headset text-primary me-2"></i>Masih butuh bantuan? Hubungi kami langsung:</h5>
            <a href="https://wa.me/6281234567890?text=Halo%20saya%20butuh%20bantuan%20dengan%20Basiru" target="_blank" class="btn btn-success me-2 mb-2">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp
            </a>
            <a href="mailto:cs@basiru.id?subject=Bantuan%20dari%20Pengguna&body=Halo%20Basiru%2C%20saya%20ingin%20bertanya%20tentang..." class="btn btn-danger mb-2">
                <i class="bi bi-envelope-fill me-1"></i> Kirim Email
            </a>
            <div class="mt-3 text-muted small">
                <i class="bi bi-clock me-1"></i> Layanan aktif setiap hari 08.00 - 20.00 WIB
            </div>
        </div>
    </div>
</div>
@endsection
