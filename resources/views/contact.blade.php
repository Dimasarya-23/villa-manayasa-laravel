@extends('layouts.villa')

@section('title', 'Contact Us - Villa Manayasa: Get in Touch')

@section('content')
<section class="contact-hero-section container section">
    <h1 style="text-align: center;">
        <span class="text-en">We're Here to Help</span>
        <span class="text-id hidden">Kami Siap Membantu</span>
    </h1>
    <p style="text-align: center; max-width: 600px; margin: 0 auto 50px;">
        <span class="text-en">Whether you have questions about your booking, local tours, or need special arrangements, feel free to reach out!</span>
        <span class="text-id hidden">Apakah Anda memiliki pertanyaan tentang pemesanan, tur lokal, atau membutuhkan pengaturan khusus, jangan ragu untuk menghubungi kami!</span>
    </p>

    <div class="contact-grid">
        <div class="contact-card">
            <img src="{{ asset('assets/icon-whatsapp.png') }}" alt="WhatsApp Icon" class="contact-icon">
            <h3 class="text-en">WhatsApp Us</h3>
            <h3 class="text-id hidden">Hubungi Kami via WhatsApp</h3>
            <p>+62 812 1375 1532</p>
            <a href="https://wa.me/6281213751532" target="_blank" class="btn-primary">
                <span class="text-en">Start Chat</span>
                <span class="text-id hidden">Mulai Chat</span>
            </a>
        </div>

        <div class="contact-card">
            <img src="{{ asset('assets/icon-email.png') }}" alt="Email Icon" class="contact-icon">
            <h3 class="text-en">Send Us an Email</h3>
            <h3 class="text-id hidden">Kirim Email kepada Kami</h3>
            <p>villamanayasa@gmail.com</p>
            <a href="mailto:villamanayasa@gmail.com" class="btn-primary">
                <span class="text-en">Compose Email</span>
                <span class="text-id hidden">Tulis Email</span>
            </a>
        </div>

        <div class="contact-card">
            <img src="{{ asset('assets/icon-map.png') }}" alt="Map Icon" class="contact-icon">
            <h3 class="text-en">Find Us</h3>
            <h3 class="text-id hidden">Temukan Kami</h3>
            <p>Jl. Arteriwico Gg. Tekukur, Kalibukbuk, Lovina</p>
            <a href="https://maps.google.com/?cid=15810987548643222649" target="_blank" class="btn-primary">
                <span class="text-en">Get Directions</span>
                <span class="text-id hidden">Dapatkan Petunjuk Arah</span>
            </a>
        </div>
    </div>
</section>

<section class="map-section container section">
    <h2>
        <span class="text-en">Our Location</span>
        <span class="text-id hidden">Lokasi Kami</span>
    </h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.4323219808625!2d115.04033697415442!3d-8.15843089182315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd98018260126ff%3A0x867ef5e2277d7f95!2sVilla%20Manayasa%20Lovina!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<section class="faq-section container section">
    <h2 style="text-align: center;">
        <span class="text-en">Frequently Asked Questions (FAQ)</span>
        <span class="text-id hidden">Pertanyaan yang Sering Diajukan (FAQ)</span>
    </h2>
    <div class="faq-list">

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">Is breakfast included in the room rate?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">Yes, a complimentary daily breakfast is included for all guests, served by the pool or in your room upon request.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Apakah sarapan termasuk dalam harga kamar?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Ya, sarapan harian gratis termasuk untuk semua tamu, disajikan di tepi kolam renang atau di kamar Anda berdasarkan permintaan.</p>
        </div>

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">Do you organize dolphin watching tours?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">Yes, we work closely with local boat owners and can arrange the famous early morning dolphin watching tour directly from the villa.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Apakah Anda mengatur tur melihat lumba-lumba?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Ya, kami bekerja sama erat dengan pemilik perahu lokal dan dapat mengatur tur melihat lumba-lumba pagi hari yang terkenal langsung dari vila.</p>
        </div>

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">How far is Villa Manayasa from Lovina Beach?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">We are approximately a 5-minute drive or a comfortable 15-minute walk from the main Lovina Beach area.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Seberapa jauh Villa Manayasa dari Pantai Lovina?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Kami berjarak sekitar 5 menit berkendara atau 15 menit berjalan kaki yang nyaman dari area utama Pantai Lovina.</p>
        </div>

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">Is there parking available for guests?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">Yes, we provide free and secure parking space for motorbikes.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Apakah tersedia tempat parkir untuk tamu?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Ya, kami menyediakan tempat parkir gratis dan aman untuk motor.</p>
        </div>

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">Do you provide airport transfer or shuttle service?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">Yes, we can arrange private airport transfers and local shuttle services to nearby attractions for an additional fee.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Apakah Anda menyediakan layanan antar-jemput bandara atau shuttle?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Ya, kami dapat mengatur antar-jemput bandara pribadi dan layanan shuttle lokal ke tempat-tempat wisata terdekat dengan biaya tambahan.</p>
        </div>

        <div class="faq-item">
            <h3 onclick="toggleFaq(this)" class="text-en">What is the smoking policy?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-en">Smoking is strictly prohibited inside the rooms. Guests may smoke in designated open-air areas, such as the garden or balcony.</p>
            <h3 onclick="toggleFaq(this)" class="text-id hidden">Apa kebijakan merokok di vila?<span class="faq-icon">+</span></h3>
            <p class="faq-answer hidden text-id hidden">Merokok dilarang keras di dalam kamar. Tamu diperbolehkan merokok di area terbuka yang telah ditentukan, seperti taman atau balkon.</p>
        </div>

    </div>
</section>

<script>
function toggleFaq(element) {
    const faqItem = element.closest('.faq-item');
    const isActiveEn = document.querySelector('.lang-en').classList.contains('active-lang');
    const targetAnswerClass = isActiveEn ? '.text-en.faq-answer' : '.text-id.faq-answer';
    const answer = faqItem.querySelector(targetAnswerClass);
    const icon = element.querySelector('.faq-icon');

    if (answer && answer.classList.contains('hidden')) {
        faqItem.querySelectorAll('.faq-answer').forEach(p => p.classList.add('hidden'));
        faqItem.querySelectorAll('.faq-icon').forEach(i => i.textContent = '+');
        answer.classList.remove('hidden');
        icon.textContent = '-';
    } else if (answer) {
        answer.classList.add('hidden');
        icon.textContent = '+';
    }
}
</script>
@endsection