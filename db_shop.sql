-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 06:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `label` varchar(50) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `id_buku`, `id_user`, `nama_penerima`, `no_telp`, `label`, `lokasi`, `kode_pos`, `alamat_lengkap`, `created_at`) VALUES
(7, 0, 17, 'Andika', '08212425816', 'Rumah', 'Malang', '15847', 'Mekar Jaya', '2025-04-20 23:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT 'default-book.jpg',
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `harga`, `stok`, `gambar`, `deskripsi`) VALUES
(12, 'Si Anak Cahaya Tere Liye', 'Tere Liye', 'REPUBLIKA PENERBIT', '2018', 'Novel', 74700.00, 90, 'uploads/buku1', 'Si Anak Cahaya Karya Tere Liye adalah fiksi sastra jenis novel yang sempat populer pada masanya. Kisah ini tentang gadis kecil yang bernama Nurmas yang hidup di kampung pedalaman. Hidup di masa awal kemerdekaan dimana semua serba terbatas, bahkan sekolah pun tidak menggunakan seragam dan tidak beralas kaki. Meskipun kehidupan di kampung sana tidaklah mudah, Nur tetap menjalani hidupnya dengan ceria. Nur kelas 5 SD saat cerita ini dimulai, dia pergi ke kota kabupaten seorang diri untung menemui dokter dan meminta obat bapaknya yang sakit sakitan, dengan hanya menaiki gerobak kerbau dan sampai di kota setelah melewati jarak 15 pal.\r\n\r\nKetika musim paceklik tiba, persediaan bahan makanan di rumahpun sudah habis, Nur di minta mamaknya untuk menjual ikan di pasar, hasil berjualan itu harus dibelikannya bahan dapur namun Nur malah menghilangkan uang tersebut. Untuk memenuhi kebutuhan sehari hari bapaknya harus rela menjadi kuli di pasar yang hanya buat satu hari dalam seminggu itu. Untung bapaknya hanya menjadi kuli selama sehari. Nur memikirkan cara membantu orang tuanya, dia memulai usaha menjual gorengan dan kopi di stasiun kereta dekat kampung mereka. Dulu, bapak Nur pernah ikut kelompok komunis, namun setelah terjadi peristiwa tragis bapak Nur akhirnya taubat dan menikah dengan mamak. Peristiwa itu membuat seseorang menyimpan dendam dan pembalasan dendam itu akhirnya terjadi saat Nur kelas 6 sd. Dari peristiwa peristiwa itulah Nur disebut sebut sebagai si anak cahaya.'),
(13, 'Journey to Allah: Menyusuri Jalan Cahaya Menuju Rida-Nya', 'Muyassaroh', 'Elex Media Komputindo', '2025', 'Agama', 108000.00, 65, 'uploads/buku2', 'Meski terlahir sebagai seorang muslim, tidak dipungkiri, banyak di antara kita masih asing dengan agama Islam. Kita salat, tetapi hati dan pikiran tidak benar-benar terhubung kepada Allah. Kita puasa, tetapi hanya sekadar menahan haus dan lapar. Kita beragama hanya sekadarnya. Tidak pernah menghadirkan hati untuk menghambakan diri kepada Allah. Padahal, kita sangat butuh kepada Allah. Manusia punya batas, ia punya kehidupan dan prioritasnya sendiri, sedangkan Allah itu unlimited. Di fase terburuk sekalipun, Allah tidak pernah meninggalkan kita.\r\n\r\nPertanyaannya, bagaimana cara kita supaya bisa kembali terhubung dengan Allah? Journey to Allah hadir sebagai panduan yang akan membantu kita supaya terkoneksi kembali dengan Allah. Setiap muslim punya kesempatan untuk memperbaiki diri dan bertumbuh menjadi versi terbaiknya. Buku ini akan membahas hal-hal yang dapat mewujudkannya. Selamat membaca!\r\n\r\nProfil Penulis:\r\nMuyassaroh merupakan penulis sekaligus ilustrator buku anak. Buku-buku yang pernah ia tulis antara lain, Mindset Islami Muslimah Milenial (Alifia Books), 101 Renungan untuk Muslimah Akhir Zaman (Quanta), Sesekali Kita Butuh Ruang, Butuh Waktu, Butuh Menepi (Quanta), 99 Great Ways to be Wonderful Muslimah (Quanta), Belajar Jadi Lebih Baik (Genta Hidayah), Simple Diet for Muslimah (Quanta), Melelahkan, Tapi Ada Allah yang Selalu Menguatkan (Qultummedia), Ternyata Aku Bisa Sekuat Ini (Syalmahat Publishing), Tenangkan Hatimu, Sertakan Allah di Setiap Langkahmu (Shiramedia), 20 Fabel Motivasi Pembentuk Karakter (Elex Kidz), La Taias, Jangan Berputus Asa! (Quanta), Kumpulan Kisah Pangeran dan Putri Kerajaan Islam (Elex Kidz), dll. Bukunya juga telah diterjemahkan dalam Bahasa Melayu dan diterbitkan di Malaysia. Jika ingin melihat karya-karya Muyassaroh dan menyapanya, silakan ikuti: Instagram : @muyassarohzuhri TikTok : @muyassarohzuhri Blog : www.muyass.com'),
(14, 'Aku Mencium Aroma Bapak & Ibu', 'Josse Tama SCJ ', 'Rumah Dehonian ', '2024', 'Agama', 62100.00, 48, 'uploads/buku3', 'Catatan ini bukan saja tentang diriku, tapi tentang Tuhan yang mengasihiku dalam rumah kecilku yang kusebut: keluarga. Mencium aroma Bapak dan bu sama halnya merasakan kehadiran Tuhan yang tak selalu mudah dicerna. Aroma yang tercium itu ber gumul dalam peristiwa kedukaan, kekecewaan, penyesalan, tangisan. Derasaan marah, dan tak berdaya.\r\n\r\nNamun, aroma itu juga yang menumbuhkan rasa cinta, syukur, dan damai yang seakan menarikku untuk segera datang mencicipi setiap rasanya. Aroma yang muncul pada saat-saat diriku tak berdaya dan menarik diriku untuk berserah tentang apa saja yang terjadi dalam hidup ini.\r\n\r\nTahun Terbit : Cetakan Pertama: September 2024\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(15, 'Sejarah dan Evolusi Agama', 'Adityas Arifianto ', 'Anak Hebat Indonesia', '2024', 'Agama', 58950.00, 66, 'uploads/buku4', 'Sinopsis :\r\n\r\nAgama adalah objek yang kompleks. Agama mencakup emosi, perasaan, dan sikap yang kompleks terhadap misteri alam semesta dan tujun hidup. Agama memainkan peran penting dalam membentuk budaya, nilai, dan struktur sosial di berbagai masyarakat.\r\n\r\nAgama-agama animisme yang masih ada si Afrika hingga sekarang terdiri dari sejumlah kelompok masyarakat, dan pertunjukan ritual yang dimiliki berbeda di setiap kawasan. Terdapat pula shamanisme yang telah dianggap sebagai salah satu agama tertua di dunia dan juga salah satu agama modern terbaru dalam bentuk neo paganisme.\r\n\r\nSetiap tahap dalam evolusi keagamaan berhubungan dengan perubahan pemahaman manusia tentang dunia, struktur masyarakatnya, dan tempat manusia di alam semesta. Perjalanan ini bukan sekadar keingintahuan historis, tetapi bukti pencarian tanpa henti manusia untuk mencari makna dan pemahaman tentang alam semseta yang lebih luas.\r\n\r\nTahun Terbit : Cetakan Pertama, November 2024\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(16, 'Kamus Populer Bahasa Indonesia', 'Kuswanto', 'Bee Media Pustaka', '2016', 'Bahasa', 234000.00, 95, 'uploads/buku5', 'Bahasa Indonesia adalah bahasa nasional dan resmi di seluruh Indonesia. Ini merupakan bahasa komunikasi resmi, diajarkan di sekolah-sekolah, dan digunakan untuk disiarkan di media elektronik dan digital. Sebagai negara dengan tingkat multilingual (terutama trilingual) teratas di dunia, mayoritas orang Indonesia juga mampu bertutur dalam bahasa daerah atau bahasa suku mereka sendiri. Bahasa yang paling banyak dituturkan adalah bahasa Jawa dan Sunda.\r\n\r\nDengan penutur bahasa yang besar di seantero negeri beserta dengan diaspora yang tinggal di luar negeri, bahasa Indonesia masuk sebagai salah satu bahasa yang paling banyak digunakan atau dituturkan di seluruh dunia. Selain dalam skala nasional, bahasa Indonesia juga diakui sebagai salah satu bahasa resmi di negara lain seperti Timor Leste.\r\n\r\nSebab bahasa Indonesia dituturkan oleh banyak orang, kami membuat paduan berupa kamus sebagai sarana mempelajari bahasa Indonesia yang baik dan benar. Kamus ini kami beri judul \"Kamus Populer Bahasa Indonesia\", kamus ini menyediakan penjelasan yang singkat dan padat dari setiap kata atau istilah yang dimuatnya, serta disertai gambar sebagai penunjang pemahaman akan kata tertentu.\r\n\r\nKamus ini dapat menjadi referensi untuk masyarakat luas agar mengetahui kata bahasa Indonesia dahulu, dan hari ini. Kamus ini bisa diperuntukkan bagi pelajar, penggiat bahasa, serta masyarakat umum lainnya.\r\n\r\nInformasi Buku\r\n\r\nPenulis : Rohmat Kurnia, Dedy Subandi, Kuswoto\r\nISBN : 9786026227744\r\nPenerbit : Bee Media\r\nTanggal terbit : Januari - 2017\r\nBerat : 950 gr\r\nJenis Cover : Soft Cover'),
(17, 'Buku Praktis Belajar Bahasa Jepang', 'Riskaninda Maharani ', 'Checklist', '2024', 'Bahasa', 48600.00, 74, 'uploads/buku6', 'Sinopsis :\r\n\r\nBanyak orang kini berbondong-bondong mempelajari bahasa asing guna menopang kebutuhan mereka dalam bekerja maupun belajar, termasuk bahasa Jepang. Tentu sebagai awalan, hiragana dan katakana harus dikuasai terlebih dahulu. Sayangnya, untuk selanjutnya yaitu huruf kanji, tidak sedikit yang kesulitan dalam memahami dan mengaplikasikannya.\r\n\r\nDi sinilah hadir penjelasan lugas dan ringkas mengenai huruf kanji. Terdapat rangkaian kanji sederhana dan tabel kanji untuk kata kerja N4. Tidak berhenti di situ, ada lanjutan praktik penggunaan kanji dalam berbicara menggunakan bahasa hormat dan dalam percakapan di berbagai tempat, seperti di stasiun, toserba, dan kantor. Selain itu, tentu saja kita tidak bisa mengabaikan budaya orang Jepang, bukan?\r\n\r\nDemikian ringkasnya buku ini, sangat cocok untuk para pembelajar yang ingin meningkatkan keterampilan bahasa Jepangnya serta melengkapi pengetahuan mengenai kultur di Jepang. Jadi mari maksimalkan level bahasa Jepang yang dipunya sampai tuntas!\r\n\r\nTahun Terbit : Cetakan Pertama, 2024\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(18, 'Life Reset: Bertumbuh Dimulai dari Sini', 'Senja Rindiani', 'Gramedia Widiasarana Indonesia ', '2024', 'Pengembangan Diri', 73500.00, 94, 'uploads/buku7', 'Pembahasan dalam buku ini dikemas dalam lima bagian, termasuk juga tambahan bagian worksheet dan rekomendasi buku.\r\n\r\nUntuk memulai perjalanan yang terjal, kamu perlu belajar memaafkan diri dulu supaya siap menghadapi rintangan ke depannya.\r\n\r\nBagian 1: Memaafkan Diri Sendiri akan menjelaskan hal-hal apa saja yang perlu kamu bereskan dulu. Setelah berhasil memaafkan diri, mungkin kamu akan menghadapi keraguan dalam dirimu ketika akan memulai melangkah.\r\n\r\nBagian 2: Selesaikan Hal-Hal yang Mengganggu akan membantu kamu menguraikan satu per satu keraguan dalam diri yang belum didapatkan jawabannya. Kalau kamu sudah siap memulai perjalananmu, mulailah dengan mencintai diri sendiri dan mempraktikkan self-love dan self-care.\r\n\r\nBagian 3: Self-Love akan menjelaskan bagaimana kamu juga perlu mencintai dirimu sendiri. Tidak selalu mengutamakan orang lain. Siapkan diri lebih dulu, cintai diri lebih dulu agar bisa mencintai orang lain dengan baik.\r\n\r\nBagian 4: Self-Care akan membantu kamu menguraikan caranya satu per satu. Setelah mencintai diri sendiri, juga perlu merawat diri sendiri. Sebab kalau tidak kamu yang peduli dengan dirimu sendiri, siapa lagi? Setelah berhasil menjaga dan merawat diri, saatnya kamu memulai petualangan yang lebih jauh.\r\n\r\nBagian 5: A Guide to be A Better Version of Yourself akan menemani diri kamu menuju tujuan hidup yang selama ini kamu impikan. Versi dirimu yang lebih baik setelah mengalami perjalanan dan perubahan.\r\n\r\nSelanjutnya, isilah worksheet sebagai bukti bahwa kamu sudah memahami isi buku ini dan siap untuk mempraktikkannya. Terakhir, jangan berhenti di buku ini saja. Lanjutkan dengan membaca buku-buku lainnya yang membantu kamu untuk terus bertumbuh.\r\n\r\nBacalah bagian Rekomendasi Buku untuk menemukan buku-buku terbaik yang akan memperluas sudut pandangmu tentang kehidupan.\r\n\r\nSelling Point:\r\nKalau kamu sedang berada di fase mulai mempertanyakan tujuan hidup, sedang bersemangat bertumbuh tapi sulit melupakan kesalahan masa lalu, sedang bingung harus mulai semuanya dari mana, inilah buku yang tepat untuk dibaca.\r\n\r\nBuku ini ditulis oleh Senja Rindiani, seorang personal growth content creator. Selama menekuni aktivitas ini, Senja mendapatkan banyak pertanyaan seputar bagaimana cara mengatasi rasa takut gagal?, Kalau mau berubah harus mulai dari mana? dan komentar-komentar terkait topik personal growth lain di akun media sosialnya.\r\n\r\nPercakapan-percakapan itu menunjukkan keingintahuan generasi muda untuk memperbaiki diri dan menjadi orang yang bertumbuh setiap hari. Oleh karena itu, penulis merangkum pertanyaan-pertanyaan yang sering ditanyakan serta topik-topik yang sering menjadi masalah bagi kaum remaja menuju dewasa muda.\r\n\r\nBuku Life Reset: Bertumbuh Dimulai dari Sini dilengkapi dengan halaman worksheet sehingga menjadi interaktif bagi pembaca. Juga ada bagian Rekomendasi Buku, yaitu buku-buku yang direkomendasikan penulis kepada pembaca untuk referensi menuju versi diri yang lebih baik.\r\n\r\nDalam segi tulisan, buku ini ditulis dengan gaya bertutur yang lugas sehingga maksudnya langsung bisa dipahami. Selain itu, juga disertai ilustrasi yang menarik yang membuah pemahaman akan suatu kalimat atau maksud lebih bisa tersampaikan. Kutipan-kutipan di beberapa halaman juga membuat buku ini bisa lebih mudah dibagikan kepada orang lain dengan memuatnya di media sosial.'),
(19, 'Konsep, Penerapan, dan Pembaruan Hukum Pidana di Indonesia', 'Taufiqullah, S.H. ', 'Anak Hebat Indonesia', '2025', 'Hukum', 53550.00, 90, 'uploads/buku8', 'Posisi hukum pidana dalam sistem hukum Indonesia tercermin dalam berbagai undang-undang dan peraturan perundang-undangan. KUHP (Kitab Undang-Undang Hukum Pidana) merupakan salah satu instrumen utama yang mengatur hukum pidana di Indonesia.\r\n\r\nPembaruan hukum pidana di Indonesia adalah langkah penting dalam menyesuaikan sistem hukum dengan dinamika masyarakat yang terus berkembang. Kitab Undang-Undang Hukum Pidana (KUHP) yang digunakan saat ini masih merupakan warisan dari zaman kolonial Belanda sehingga banyak ketentuan di dalamnya yang dianggap tidak relevan dengan perkembangan sosial, politik, dan ekonomi bangsa Indonesia yang modern.\r\n\r\nFilosofi hukum pidana lama didasarkan pada asas retributif yang lebih menekankan pada pembalasan terhadap pelaku tindak pidana. KUHP baru berpindah ke filosofi restorative justice yang lebih menekankan pada pemulihan korban, rehabilitasi pelaku, dan keseimbangan keadilan.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, Maret 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(20, 'Hukum Tata Negara dan Transformasi', 'Dr. Ridwan Syaidi Tarigan, S.H., M.H ', ' selfietera indonesia', '2025', 'Hukum', 71100.00, 60, 'uploads/buku9', 'Hukum tata negara merupakan bagian penting dari sistem hukum yang dimiliki oleh setiap negara di dunia, baik negara-negara dengan tradisi hukum yang panjang maupun negara-negara modern yang lebih baru terbentuk. Meskipun demikian, formulasi hukum tata negara dan penekanan yang diberikan akan berbeda sesuai dengan perkembangan zaman dan konteks masing-masing negara.\r\n\r\nSetiap negara, berdasarkan karakteristik sosial, politik, ekonomi, dan sejarahnya, akan mengembangkan sistem hukum tata negara yang sesuai dengan kebutuhan serta aspirasi rakyatnya. Perbedaan ini juga mencerminkan bagaimana negara-negara tersebut mengatur hubungan antara rakyat, pemerintah, dan institusi lainnya dalam mencapai tujuan-tujuan nasionalnya.\r\n\r\nKeberadaan hukum tata negara dalam kehidupan berbangsa dan bernegara memegang peranan yang sangat penting. Hukum tata negara berfungsi untuk menggambarkan suasana ketatanegaraan, menyusun pemerintahan, menentukan wewenang, serta menetapkan hubungan antara alat-alat perlengkapan negara. Selain itu, hukum tata negara juga mengatur interaksi antara berbagai lembaga negara, baik dalam konteks hubungan internal maupun eksternal.\r\n\r\nDengan adanya hukum tata negara, negara dapat bekerja secara efektif untuk mencapai tujuan-tujuannya, termasuk menjaga keseimbangan kekuasaan dan memastikan perlindungan hak asasi manusia bagi setiap warganya.\r\n\r\nIstilah Hukum Tata Negara dalam bahasa Indonesia sebenarnya memiliki akar dari beberapa istilah asing, yang masing-masing berasal dari bahasa Belanda, Prancis, Jerman, dan Inggris. Dalam bahasa Belanda, hukum tata negara dikenal sebagaistaatrecht, sementara dalam bahasa Prancis disebut droit constitutionnel, dalam bahasa Jerman dikenal sebagai verfassungsrecht, dan dalam bahasa Inggris disebut constitutional law. Masing-masing istilah ini, jika diterjemahkan secara harfiah ke dalam bahasa Indonesia, sering kali dipahami sebagai hukum konstitusi, karena cakupannya berhubungan dengan aturan dasar negara, yang tertuang dalam konstitusi.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(21, 'Rahasia Sukses Personal Branding untuk Pemula di Era Society', 'Finaang', 'Yash Media', '2024', 'Bisnis', 62100.00, 49, 'uploads/buku10', 'Gimana sih cara menggunakan personal branding untuk mencapai kesuksesan karir? Personal branding yang akan kita bahas dalam buku ini bukan hanya sekedar tentang menciptakan citra pribadi, melainkan tentang menyadari nilai unik yang membedakan kita dari orang lain. buku ini tidak hanya bertujuan untuk memberikan panduan praktis dalam membangun personal branding yang kuat, tetapi juga untuk mengajak kita merenung, menggali, dan mengembangkan potensi diri yang mungkin belum kita sadari. yuk branding yourself dengan bangun citra diri yang mengesankan dan mendatangkan cuan.\r\n\r\n*************\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(23, 'Teradata Basic Training for Application Developers', 'Wingate, Robert ', 'Paperback', '2019', 'Teknologi', 544000.00, 83, 'uploads/buku11.jpg', 'This book will help you learn the basic information and skills you need to develop applications with Teradata. The instruction, examples and questions/answers in this book are a fast track to becoming productive as quickly as possible. The content is easy to read and digest, well organized and focused on honing real job skills. Programming examples are coded in both Java and C# .NET. Teradata Basic Training for Application Developers is a key step in the direction of mastering Teradata application development so you\'ll be ready to join a technical team.'),
(24, 'Elon Musk : From Bullied to Tech Billionaire', 'Reyvan Maulid', 'Anak Hebat Indonesia', '2025', 'Biografi', 71550.00, 94, 'uploads/buku12.jpg', 'Elon Musk : From Bullied to Tech Billionaire\r\n\r\n1. Apa rahasia di balik ambisi seorang Elon Musk yang berani mengubah dunia dari revolusi mobil listrik penjelajahan ke planet Mars?\r\n2. Bagaimana kisah pemuda yang pernah menjadi korban bully di sekolah tumbuh menjadi seorang miliarder visioner yang tak kenal rasa takut hingga berhasil mengakuisisi platform Twitter/X?\r\n3. Apa yang membuat Elon musk terus maju, bahkan saat dunia meragukan mimpinya?\r\nBuku ini mengisahkan perjalanan hidup Elon Musk, dari masa kecil yang penuh tantangan di Afrika Selatan hingga menjadi miliarder visioner di dunia teknologi. Berbekal kecintaan pada sains fiksi dan teknologi, Musk membangun resiliensi dari pengalaman bullying yang membentuk karakternya. Pindah ke Amerika Serikat, ia memulai karier dengan mendirikan Zip2 dan PayPal sebelum meluncurkan SpaceX dan Tesla, dua proyek yang berhasil merevolusi dunia.\r\n\r\nDi luar pencapaian bisnis, buku ini juga mengeksplorasi sisi pribadi dan filosofi hidup Elon Musk, serta kontroversi yang turut mengiringinya. Sosoknya yang kompleks diuraikan dalam bab khusus yang membahas bagaimana ia kerap dilihat sebagai superhero di satu sisi, tetapi dianggap supervillain oleh pihak lain. Dengan pengaruh besar yang ia bawa pada dunia teknologi, bisnis, dan bahkan masyarakat, Musk meninggalkan jejak yang tak mungkin diabaikan. Dengan visi besar untuk masa depan, Musk terus menginspirasi dunia, baik melalui inovasi maupun kisah hidupnya yang penuh pelajaran. Selamat mengenal lebih dekat sosok Elon Musk.\r\n\r\n\r\nTahun Terbit : Cetakan Pertama, Januari 2025\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan.\r\n\r\nMembaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas.\r\n\r\nTetapkan waktu khusus untuk membaca setiap hari. Dari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi.\r\n\r\nPilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca.\r\n\r\nTemukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik.\r\n\r\nBuat catatan atau jurnal tentang buku yang telah Anda baca. Tuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan.'),
(25, 'Membangun Peradaban Dunia', 'UNTUNG WIDYANTO, DKK. ', 'Penerbit Buku Kompas', '2023', 'Arsitektur', 89100.00, 80, 'uploads/buku13', 'Taman Ismail Marzuki yang dibangun tahun 1968 diniatkan sebagai pusat kesenian yang bebas dari intervensi kekuasaan. Para seniman tidak ingin diatur-atur oleh partai dan penguasa politik seperti yang terjadi di era Demokrasi Terpimpin. Periode Gubernur Ali Sadikin, TIM benar-benar menjadi ekosistem kesenian yang menggairahkan seniman dengan karya-karyanya yang fenomenal.\r\n\r\nBang Ali kemudian dicopot Presiden Soeharto pada 1977, yang diikuti dengan campur tangan birokrat. Setelah itu TIM mengalami kemunduran, seiring dengan munculnya gedung-gedung kesenian di Jakarta. Berbagai upaya dilakukan para Gubernur Jakarta untuk membangkitkan TIM. Gubernur Fauzi Bowo menggelar Sayembara Revitalisasi TIM pada 2007 yang dimenangkan arsitek Andra Matin dengan tema \"Rayuan Pulau Kelapa\".\r\n\r\nSayembara itu akhirnya mulai direalisasikan pada perayaan TIM yang ke-50 di masa Gubernur Anies Baswedan. \"The new TIM\" dibuka untuk umum pada 2022 dan kawasan hijau di Cikini ini langsung menjadi destinasi favorit kaum muda. Buku ini menceritakan dinamika pembangunan TIM yang terjadi di panggung depan dan belakang, sejarah pengelolaan TIM selama setengah abad, serta model pengelolaan TIM ke depan. Buku ini kaya dengan infografis yang memudahkan pembaca menikmati narasi dengan gaya bercerita (storytelling).\r\n\r\nProfil Penulis:\r\nUntung Widyanto\r\nKarier jurnalistiknya dimulai sebagai wartawan majalah Editor, dilanjutkan ke Tiras dan majalah Tajuk. Pada tahun 2001 bergabung ke grup Tempo (Koran Tempo, majalah Tempo, dan Tempo.co) hingga purnabakti tahun 2019. Lulusan S-1 dan S-2 Sosiologi FISIP UI ini menjadi Ketua Dewan Pengawas The Society of Indonesian Environmental Journalists (2013-2016) dan pengurus/andalan Kwarnas Gerakan Pramuka. Saat ini sebagai wartawan lepas, penulis, peneliti, dan pengajar.'),
(27, 'Titipo: Buku Stiker & Game Edukasi', 'Iconix', 'Book Stairs Pustaka Utama', '2021', 'Edukasi', 74250.00, 74, 'uploads/buku15', 'Titipo adalah kereta kecil yang rajin, ia selalu mengangkut dan mengantar penumpang ke tujuan mereka. Titipo memiliki banyak sekali teman, ada Genie yang merupakan kereta penumpang, Diesel si kereta kargo, Xingxing si kereta cepat, Fix dan Lift si kereta mekanik yang senang membantu memperbaiki kereta-kereta lain yang rusak.\r\nAyo, bersenang-senang bersama Titipo si Kereta Kecil dengan buku berisi bermacam-macam permainan stiker. Mari sama-sama kita tingkatkan konsentrasi dan kecerdasan anak-anak melalui berbagai aktivitas menyenangkan. Ada 24 aktivitas seru yang bisa mengasah otak kita, yaitu cari dan temukan, puzzle, teka-teki, labirin, serta banyak lagi. Yuk, jadikan buku ini sebagai hadiah untuk si kecil!\r\nTitipo: Buku Stiker dan Game Edukasi merupakan kategori buku anak-anak usia 3-6 tahun. Pada umur tersebut anak-anak sedang memasuki fase golden age atau perkembangan yang sangat cepat. Oleh karena itu, peran Ayah dan Bunda sangat dibutuhkan untuk mengawasi tumbuh kembang si kecil. Melalui permainan-permainan yang seru anak akan lebih mudah belajar dan memahami setiap hal yang menjadi kebutuhan pengetahuannya. Buku ini akan mengajak si kecil bersama dengan kereta kecil bernama Titipo untuk berpetualang menyelesaikan semua permainan. Setiap permainan dalam buku bermanfaat untuk mengasah daya fokus anak sejak dini. Buku ini juga bermanfaat untuk mengembangkan daya imajinasi anak melalui ilustrasi yang ditampilkan. Para orang tua dapat menjadikan buku ini sebagai media pembelajaran awal untuk anak.'),
(28, 'Hunger Games #1', 'Suzanne Collins ', 'Gramedia Pustaka Utama', '2025', 'Fiksi', 74250.00, 83, 'uploads/buku16', 'Dua puluh empat peserta. Hanya satu pemenang yang selamat. Amerika Utara musnah sudah. Kini di bekasnya berdiri negara Panem, dengan Capitol sebagai pusat kota yang dikelilingi dua belas distrik. Katniss, gadis 16 tahun, tinggal bersama adik perempuan dan ibunya di distrik termiskin di Distrik12. Karena pemberontakan di masa lalu terhadap Capitol, setiap tahun masing-masing Distrik harus mengirim seorang anak perempuan dan anak lelaki untuk bertarung sampai mati dan ditayangkan secara langsung di acara televisi The Hunger Games. Hanya ada satu pemenang setiap tahun. Tujuannya adalah membunuh atau dibunuh. Ketika adik perempuannya terpilih mengikuti The Hunger Games, Katniss mengajukan diri untuk menggantikannya. Dan dimulailah pertarungan yang takkan pernah dilupakan Capitol.\r\n\r\nTentang Penulis:\r\nPengarang bestseller, SUZANNE COLLINS memulai karier kepenulisan dengan buku seri fantasi anak-anak Underland Chronicles yang masuk daftar buku laris New York Times. Ia terus mengeksplorasi tema perang dan kekerasan untuk pembaca remaja dengan seri YA, The Hunger Games (September 2008), yang lang­sung menjadi bestseller, memikat pembaca remaja dan dewasa. Stephen King menyebut buku itu “bikin kecanduan” dalam Entertainment Weekly, dan kata Stephanie Meyer “(buku) luar biasa” di situsnya.\r\n\r\nThe Hunger Games berada dalam daftar buku laris New York Times selama lebih dari 260 minggu nonstop yang berarti lebih dari lima tahun berturut-turut. Lebih dari 100 juta ekspemplar Trilogi The Hunger Games (September 2008), Catching Fire (September 2009), and Mockingjay (Agustus 2010) beredar di seluruh dunia dalam bentuk cetak dan format digital. Trilogi The Hunger Games telah diterjemahkan ke dalam 53 bahasa dan diterbitkan di 56 negara hingga saat ini. Pada tahun 2012 Lionsgate merilis film pertama dari empat film berdasarkan seri The Hunger Games, dengan pemeran utama Jennifer Lawrence. Franchise film ini meraup penghasilan hampir tiga miliar dolar.\r\nYear of the Jungle, buku bergambar karya Suzanne Collins berdasarkan masa perang ayahnya di Viet Nam, dengan ilustrasi karya James Proimos, diterbitkan tahun 2013 dan mendapat tanggapan positif.'),
(29, 'My Handsome Brothers (Terbit Ulang)', 'Shiraishi Yuki ', 'm&c!', '2020', 'Komik', 25000.00, 85, 'uploads/buku17', 'Tiga bersaudara Shiratori ketampanannya sangat memesona.\r\nSou si jago seni, Daichi si jago olahraga dan Yuuto si cerdas yang misterius.\r\nTapi ketiga cowok super keren ini malah jatuh hati pada Ayumu, gadis yang dijuluki si bebek jelek.\r\nYang lebih mengejutkan lagi, Ayumu itu… adik mereka!?'),
(30, 'Novel Mrs. Mcginty\'s Dead (Mrs. Mcginty Sudah Mati)', 'Agatha Christie ', 'Book Stairs Pustaka Utama', '2017', 'Novel', 51570.00, 95, 'uploads/buku18.jpg', 'Novel Mrs McGinty\'s Dead adalah sebuah karya fiksi detektif buatan Agatha Christie yang pertama kali diterbitkan di AS oleh Dodd, Mead and Company pada Februari 1952 dan di Inggris oleh Collins Crime Club pada 3 Maret tahun yang sama. Mrs McGinty\'s Dead adalah sebuah karya fiksi detektif buatan Agatha Christie yang pertama kali diterbitkan di AS oleh Dodd, Mead and Company pada Februari 1952 dan di Inggris oleh Collins Crime Club pada 3 Maret tahun yang sama. The Detective Book Club mengeluarkan sebuah edisi, juga pada 1952, dengan judul Blood Will Tell. Mrs. McGinty tewas dibunuh. Semua orang mencurigai James Bentley, pria lugu yang tinggal di rumah Mrs. McGinty. Tetapi Inspektur Spence yang menangani kasus tersebut merasa ada kejanggalan dan langsung meminta bantuan Hercule Poirot. Namun sebelum kasus ini terpecahkan, korban kedua jatuh. Poirot harus segera menemukan pelakunya sebelum kasus ini diperumit dengan kebohongan dan penyamaran.\r\n\r\nNovel ini direkomendasikan untuk pembaca yang menyukai genre thriller.\r\n\r\nSinopsis Buku\r\n\r\nMrs. McGinty tewas dibunuh. Semua orang mencurigai James Bentley, pria lugu yang tinggal di rumah Mrs. McGinty. Tetapi Inspektur Spence yang menangani kasus tersebut merasa ada kejanggalan dan langsung meminta bantuan Hercule Poirot. Namun sebelum kasus ini terpecahkan, korban kedua jatuh. Poirot harus segera menemukan pelakunya sebelum kasus ini diperumit dengan kebohongan dan penyamaran.\r\n\r\nInformasi lain :\r\nJudul: Mrs. Mcginty\'s Dead (Mrs. Mcginty Sudah Mati)\r\nRating: yang diperuntukan untuk pembaca berusia tahun ke atas.\r\nPenulis: Agatha Christie\r\nPenerbit: Gramedia Pustaka Utama\r\nTebal: 336 halaman\r\nFormat: Soft Cover\r\nTanggal Terbit: 17 Juli 2017\r\nISBN : 9789792230482\r\nBerat : 0.2 kg\r\nDimensi : 11 cm'),
(31, 'Novel Masa Muda dan Kisah-Kisah Lainnya', 'Joseph Conrad ', 'Diva Press', '2022', 'Novel', 54000.00, 90, 'uploads/buku19', 'Laut mempunyai arti penting bagi kehidupan manusia seperti sumber makanan, sebagai jalan raya perdagangan, sebagai sarana penaklukan, sebagai tempat pertempuran, sebagai tempat rekreasi dan sebagai alat pemisah atau pemersatu bangsa. Tanpa peranan laut, maka hampir keseluruhan planet Bumi akan menjadi terlalu dingin bagi manusia untuk hidup. Laut juga merupakan sumber makanan, energi (baik yang terbarukan maupun yang tak terbarukan), dan obat-obatan. Daerah pantai juga merupakan daerah yang sangat besar peranannya bagi kehidupan manusia.\r\n\r\nLaut menyediakan setengah dari oksigen dunia hingga membantu mengatur iklim dan cuaca kita, laut sangat penting untuk berfungsinya planet kita. Ini adalah bagian sentral dari sistem Bumi dan bertindak sebagai penyangga terhadap perubahan iklim.\r\n\r\nCerita-cerita dalam buku kumpulan kisah ini hanya bisa terjadi di Inggris, tempat hidup orang-orangnya berkelindan dengan laut, bisa dikatakan begitu—laut merembesi hidup sebagian besar rakyatnya, dan mereka tahu sedikit-sedikit atau tahu banyak segala sesuatu soal laut, baik dalam segi keterpesonaan, pelayaran, atau mata pencaharian dari situ.\r\n\r\nJoseph Conrad, pengarang Polandia yang dianggap sebagai salah satu novelis berbahasa Inggris terhebat, melalui karya-karya sastranya sering kali menampilkan latar belakang kelautan, merefleksikan pengaruh karier awalnya dalam armada kapal niaga, dan penggambarannya atas gelora semangat manusia dalam dunia yang kejam dan acuh tak acuh akibat imperialisme dan kolonialisme Eropa.\r\n\r\nInformasi Lain\r\nISBN : 9786023919420\r\nUkuran : 14 x 20 cm\r\nBerat : 0,155 kg\r\nTahun terbit : 2022\r\nPenerbit : Diva Press\r\nJumlah Halaman : 172'),
(32, 'Novel Cantik Itu Luka', 'Eka Kurniawan ', 'Gramedia Pustaka Utama', '2018', 'Novel', 93750.00, 58, 'uploads/buku20', 'Hidup di era kolonialisme bagi para wanita dianggap sudah setara seperti hidup di neraka. Terutama bagi para wanita berparas cantik yang menjadi incaran tentara penjajah untuk melampiaskan hasrat mereka. Itu lah takdir miris yang dilalui Dewi Ayu, demi menyelamatkan hidupnya sendiri Dewi harus menerima paksaan menjadi pelacur bagi tentara Belanda dan Jepang selama masa kedudukan mereka di Indonesia.\r\n\r\nKecantikan Dewi tidak hanya terkenal dikalangan para penjajah saja, seluruh desa pun mengakui pesona parasnya itu. Namun bagi Dewi, kecantikannya ini seperti kutukan, kutukan yang membuat hidupnya sengsara, dan kutukan yang mengancam takdir keempat anak perempuannya yang ikut mewarisi genetik cantiknya.\r\n\r\nTapi tidak dengan satu anak terakhir Dewi, si Cantik, yang lahir dengan kondisi buruk rupa. Tak lama setelah mendatangkan Cantik ke dunia, Dewi harus berpulang. Tapi di satu sore, dua puluh satu tahun kemudian, Dewi kembali, bangkit dari kuburannya. Kebangkitannya menguak kutukan dan tragedi keluarga.\r\n\r\nBagaimana takdir yang akan menghampiri si Cantik? Apa yang membuat Dewi harus kembali ke dunia bak neraka ini? Ungkap rahasia dibalik misteri kisah masa kolonial dalam novel Cantik Itu Luka karya Eka Kurniawan.\r\n\r\nInformasi Lain:\r\nCover: Soft Cover\r\nGenre: Novel, Romansa, Supernatural, Misteri, Kolonial, Sejarah.\r\nUsia: Dewasa (17+)\r\n\r\nDetail\r\nPenulis: Eka Kurniawan\r\nJumlah Halaman: 489\r\nBahasa: Indonesia\r\nPenerbit: Gramedia Pustaka Utama\r\nDimensi: 14 x 21 cm\r\nTanggal Terbit: 30 Januari 2015\r\nBerat: 0.30 kg\r\nISBN: 9786020312583'),
(34, 'Arsitektur Rumah Jawa : Mengungkap Filosofi Makna dan Simbologinya', 'Asti Musman ', 'Anak Hebat Indonesia', '2024', 'Arsitektur', 49950.00, 154, 'uploads/buku22', 'Persepsi umum terhadap karakter orang Jawa seringkali dipandang sebagai individu yang hidup secara sederhana, tidak terlalu mengutamakan kenyamanan dalam kehidupannya. Ada pepatah Jawa yang mengatakan \"Urip mung mampir ngombe\" yang berarti kehidupan di dunia ini hanyalah sementara, seakan-akan menunjukkan ketidakpedulian orang Jawa terhadap materi dan kesenangan duniawi.\r\n\r\nNamun, pemikiran tersebut tidak sepenuhnya benar. Dalam kebudayaan Jawa, seorang pria dianggap telah menjalani hidup yang lengkap apabila ia memiliki lima hal esensial, yaitu rumah, kuda, burung, pasangan wanita, dan keris.\r\n\r\nOrang Jawa dikenal mengikuti pandangan hidup yang dikenal sebagai kejawen, yang tidak hanya mempengaruhi cara pandang mereka terhadap kehidupan tetapi juga menentukan apa yang mereka anggap sebagai kehidupan yang sempurna. Segala tindakan dalam kehidupan sehari-hari mereka dipandu oleh nilai-nilai filosofis.\r\n\r\nSebagai contoh, proses membangun rumah, mulai dari pemilihan lokasi hingga penanaman pohon di halaman, dilakukan dengan penuh pertimbangan filosofis. Pemilihan tanah yang miring ke arah timur, misalnya, diyakini akan membawa kemakmuran, kesehatan fisik dan spiritual bagi penghuninya. Ini menunjukkan bahwa dalam setiap aspek pembangunan rumah ala Jawa terdapat nilai filosofis yang mendalam.\r\n\r\nPenting bagi generasi sekarang, baik bagi mereka yang secara langsung mewarisi nilai-nilai ini maupun bagi siapapun yang menghargai kebudayaan dan nilai-nilai mulianya, untuk memahami dan menghargai filosofi ini. Bagaimanapun, pemahaman ini menjadi kunci untuk menjaga keberlangsungan budaya di tengah arus modernisasi yang semakin menguat.\r\n\r\n*************\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(35, 'Wanderlust : Wonderful Places All Over The World', 'REYNA MASARU ', 'C-Klik Media', '2022', 'Arsitektur', 47700.00, 76, 'uploads/buku23', 'BUKU INI BERBICARA TENTANG TRAVELLING. BEGITU BANYAK TEMPAT MENAKJUBKAN YANG TERSEBAR DI DUNIA, MULAI DARI BANGUNAN DENGAN SEJARAH PANJANG, KUIL - KUIL SUCI YANG PENUH KEBUDAYAAN LOKAL, HINGGA TEMPAT'),
(36, 'Merancang Bangunan Sekolah', 'Ir. Taufik Priambodo ', 'Yrama Widya', '2024', 'Arsitektur', 54000.00, 97, 'uploads/buku24', 'Sudah merupakan satu hal yang pasti, bahwa merancang arsitektur bangunan sekolah tidak lebih sulit dari merancang rumah besar. Memang luas bangunannya berada jauh di atas bangunan rumah besar yang hanya kisaran 300 m2. Namun, sebetulnya dari segi luas bangunan yang jauh lebih besar dari rumah mewah, sebagian besar luas bangunan sekolah hanyalah akumulasi dari luas jenis ruang kelas teori. Satu ruang kelas teori sekurang-kurangnya berukuran 42,25 m2 atau seukuran dengan 3,5 kali ruang tidur anak (4 m × 3 m) di bangunan rumah mewah.\r\n\r\nDari segi interiornya, jelas tak terbantahkan. Perancangan interior bangunan sekolah memiliki tingkat kompleksitas di bawah perancangan interior bangunan rumah mewah. Yang pasti, merancang interior bangunan sekolah, sama sekali tidak bermain dengan karakter personalitas.\r\n\r\nBuku ini hadir untuk mahasiswa arsitektur dan arsitek pemula. Buku ini patut dibaca juga untuk keahlian sampingan bagi para mahasiswa maupun praktisi spesialis ilmu bangunan yang bukan dari jurusan arsitektur, seperti teknik sipil, teknik elektro, teknik mesin, desainer interior, dan desainer lanskap. Bahkan, siswa SMK teknik gambar bangunan pun dapat mengambil manfaat dari buku ini. Ayo segera miliki buku ini untuk mengetahui ilmu merancang bangunan sekolah!\r\n\r\n************\r\n\r\nPernahkah Anda terpikir betapa menariknya dunia yang terbuka lebar lewat lembaran buku? Membaca bukan hanya kegiatan rutin, tetapi juga petualangan tak terbatas ke dalam imajinasi dan pengetahuan. Membaca mengasah pikiran, membuka wawasan, dan memperkaya kosakata. Ini adalah pintu menuju dunia di luar kita yang tak terbatas. Tetapkan waktu khusus untuk membaca setiap hari.\r\n\r\nDari membaca sebelum tidur hingga menyempatkan waktu di pagi hari, kebiasaan membaca dapat dibentuk dengan konsistensi. Pilih buku sesuai minat dan level literasi. Mulailah dengan buku yang sesuai dengan keinginan dan kemampuan membaca. Temukan tempat yang tenang dan nyaman untuk membaca. Lampu yang cukup, kursi yang nyaman, dan sedikit musik pelataran bisa menciptakan pengalaman membaca yang lebih baik. Bergabunglah dalam kelompok membaca atau forum literasi. Diskusikan buku yang Anda baca dan dapatkan rekomendasi dari sesama pembaca. Buat catatan atau jurnal tentang buku yang telah Anda baca.\r\n\r\nTuliskan pemikiran, kesan, dan pelajaran yang Anda dapatkan. Libatkan keluarga dalam kegiatan membaca. Bacakan cerita untuk anak-anak atau ajak mereka membaca bersama. Ini menciptakan ikatan keluarga yang erat melalui kegiatan positif. Jangan ragu untuk menjelajahi genre baru. Terkadang, kejutan terbaik datang dari buku yang tidak pernah Anda bayangkan akan Anda nikmati. Manfaatkan teknologi dengan membaca buku digital atau bergabung dalam komunitas literasi online. Ini membuka peluang untuk terhubung dengan pembaca dari seluruh dunia.'),
(38, 'Novel Ayah: Sebuah Novel', 'Andrea Hirata ', 'Mizan', '2016', 'Novel', 95000.00, 700, 'uploads/buku25', 'Betapa Sabari menyayangi Zorro. Ingin dia memeluknya sepanjang waktu. Dia terpesona melihat makhluk kecil yang sangat indah dan seluruh kebaikan yang terpancar darinya. Diciuminya anak itu dari kepala sampai ke jari-jemari kakinya yang mungil. Kalau malam Sabari susah susah tidur lantaran membayangkan bermacam rencana yang akan dia lalui dengan anaknya jika besar nanti. Dia ingin mengajaknya melihat pawai 17 Agustus, mengunjungi pasar malam, membelikannya mainan, menggandengnya ke masjid, mengajarinya berpuasa dan mengaji, dan memboncengnya naik sepeda saban sore ke taman kota.'),
(40, 'Scholarship Goals : Kulik Serba-Serbi Beasiswa Dalam dan Luar Negeri', 'Adora Kirana', 'Pixelindo', '0000', 'Pendidikan', 36000.00, 98, 'uploads/buku14.jpg', 'Setiap orang berhak mendapatkan pendidikan yang layak, bahkan hingga ke jenjang yang paling tinggi. Namun, sering kali masalah ekonomi menjadi salah satu kendala. Apalagi biaya pendidikan yang naik kian tinggi setiap tahunnya. Hal ini yang kemudian menimbulkan ketakutan dan kesulitan tersendiri di masyarakat untuk mendapatkan pendidikan setinggi-tingginya. Bahkan, sampai ada ungkapan \"orang miskin dilarang sekolah!.\r\nBeasiswa menjadi sebuah solusi untuk mengatasinya. Di dalam buku ini akan dikulik serba-serbi terkait beasiswa, baik di dalam maupun luar negeri. Ada tips dan trik berburu beasiswa, cara mempersiapkan diri untuk menghadapi wawancara beasiswa, serta kisah-kisah dari para penerima beasiswa yang bisa menjadi inspirasi dan motivasi. Selamat membaca dan selamat mencoba!\r\n\r\nTentang Penulis:\r\nAdora Kinara, menempuh pendidikan S-1 di sebuah universitas swasta di Yogyakarta,. Sejak semester pertama hingga delapan ia mendapatkan beasiswa, baik yang berasal dari kampus maupun luar kampus. Setelah lulus, perempuan ini menghabiskan waktunya untuk berkecimpung di dunia perbukuan. la juga sempat menjadi editor buku di salah satu penerbit mayor di Indonesia. Kini, ia menjadi penulis lepas sekaligus content creator di salah satu media daring besar di Indonesia. Setelah menepi dari hingar-bingar kota, kesehariannya saat ini dilalui dengan hidup lebih sederhana. Ketika rehat dari aktivitas, ia senang melakukan jalan-jalan ke pantai yang paling dekat dengan rumahnya. Menurutnya, bersahabat dengan alam adalah hidup yang paling bermakna. la suka membaca dan menonton drama Korea.\r\n\r\nTahun Terbit: Cetakan Pertama, 2023');
INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `harga`, `stok`, `gambar`, `deskripsi`) VALUES
(41, 'Akasha : Ito Junji\'s Selected Collection - Shiver', 'Ito Junji', 'm&c!', '2025', 'Komik', 78750.00, 150, 'uploads/buku26', 'Shiver adalah sebuah kumpulan cerita pendek yang dipilih oleh Junji Ito sendiri. Kumpulan ini mencakup sembilan cerita pendek yang menampilkan berbagai tema horor;\r\nUsed Record, The Chill, Fashion Model, Hanging Balloons, House of Puppets, The Painter, Long Dream, My Dear Ancestors, dan Glyceride.\r\n\r\nDisclaimer\r\nCerita dalam komik ini mengandung materi yang diperuntukan untuk pembaca dewasa. Berisi cerita seram dengan ilustrasi detail yang seram. Tidak dianjurkan untuk dibaca anak-anak di bawah umur.\r\n\r\nIto Junji dikenal sebagai mangaka horor paling ternama di Jepang. Ia juga peraih penghargaan Eisner 2019 yang seperti “Hall of Fame”-nya industri komik. Ada banyak sekali karyanya yang terkenal dan beberapa diantaranya dimasukan dalam komik berikut. Ada 10 cerita pendek yang telah dipilih khusus untuk para pembaca setia Ito dengan kisah-kisahnya yang menegangkan dan dijamin bikin kalian merinding!\r\n\r\n*****\r\nDi antara jenis buku lainnya, komik memang disukai oleh semua kalangan mulai dari anak kecil hingga orang dewasa. Alasan komik lebih disukai oleh banyak orang karena disajikan dengan penuh dengan gambar dan cerita yang mengasyikan sehingga mampu menghilangkan rasa bosan di kala waktu senggang.\r\n\r\nKomik seringkali dijadikan sebagai koleksi dan diburu oleh penggemarnya karena serinya yang cukup terkenal dan kepopulerannya terus berlanjut sampai saat ini. Dalam memilih jenis komik, ada baiknya perhatikan terlebih dahulu ringkasan cerita komik di sampul bagian belakang sehingga sesuai dengan preferensi pribadi pembaca.\r\n\r\nM&C! Publishing adalah penerbit di bawah Divisi Ritel dan Penerbitan Grup Kompas Gramedia, perusahaan penerbitan terbesar di Indonesia. Grup Kompas Gramedia memulai usaha dengan fokus di media cetak. Dalam perkembangannya, perusahaan telah berkembang menjadi kelompok usaha dengan berbagai divisi. Di bidang informasi, grup ini juga merambah ke media elektronik dan multimedia. M&C! Penerbitan telah menerbitkan berbagai judul dan jenis buku: komik, komik pendidikan, buku anak-anak, novel, buku nonfiksi. Salah Satunya seperti komik ”Akasha : Ito Junji\'s Selected Collection - Shiver”'),
(42, 'Kubo Won\'t Let Me Be Invisible 11', 'Nene Yukimori', 'Elex Media Komputindo', '2025', 'Komik', 50000.00, 99, 'uploads/buku27', 'Ketika perasaan itu punya nama, keduanya menjadi sedikit lebih dewasa. Cewek heroine dan cowok figuran akhirnya berjalan seiring sedikit ke depan Episode festival budaya ketika Shiraishi-kun meraih sukses besar pun menuju babak terakhir yang mengesankan. Bersama-sama melalui acara penting, Kubo-san dan Shiraishi-kun akhirnya mengalami pertumbuhan perasaan yang pasti dalam diri masing-masing. Perlahan dengan langkahmu sendiri kamu menjadi karakter utama. Ini kisah yang sampai pada ‘cinta’. Inilah komedi manis remaja vol. 11!\r\n\r\nCerita Sebelumnya:\r\nAda dirimu yang berbeda dengan kemarin, cewek heroine dan cowok figuran kebingungan dengan jarak yang mulai berubah Usai liburan musim panas yang panjang dan penuh acara, musim berganti ke semester baru. Acara penting musim gugur, tentu saja festival budaya! Dan ternyata, Shiraishi-kun terpilih menjadi ‘peran utama’ dalam acara puncak sekolah tersebut! Warna embun pagi dan aroma senja terus berubah setiap kali mereka berdua pandang. Gulungan gambar bunga tentang perasaan yang berubah, ini lah komedi manis remaja vol. 10!\r\n\r\n******\r\nDi antara jenis buku lainnya, komik memang disukai oleh semua kalangan mulai dari anak kecil hingga orang dewasa. Alasan komik lebih disukai oleh banyak orang karena disajikan dengan penuh dengan gambar dan cerita yang mengasyikan sehingga mampu menghilangkan rasa bosan di kala waktu senggang.\r\n\r\nKomik seringkali dijadikan sebagai koleksi dan diburu oleh penggemarnya karena serinya yang cukup terkenal dan kepopulerannya terus berlanjut sampai saat ini. Dalam memilih jenis komik, ada baiknya perhatikan terlebih dahulu ringkasan cerita komik di sampul bagian belakang sehingga sesuai dengan preferensi pribadi pembaca.'),
(43, 'The Fragrant Flower Blooms with Dignity-Kaoru & Rin 04', 'SAKA MIKAMI', 'Elex Media Komputindo', '2024', 'Komik', 33750.00, 100, 'uploads/buku28', 'Rintaro Tsumugi, murid SMA Chidori, tempat berkumpulnya cowok berandalan, berkenalan dengan Kaoruko Waguri, siswi Akademi Kikyo, sekolah para gadis kaya-raya. Meski dilanda keraguan akibat jurang kedua sekolah yang begitu besar, Rintaro akhirnya memutuskan untuk memperkenalkan Kaoruko dan Subaru ke kawan-kawan Chidori. Berkat itu, hubungan baik mulai terbentuk dan Rintaro menjadi lebih terbuka dengan orang-orang di sekelilingnya. Kawan-kawan Rintaro bertandang ke rumahnya, membuatnya menceritakan masa lalu, menguatkan persahabatan, dan merencanakan libur musim panas bersama. Semua itu membuat sang ibu terharu.\r\n\r\nProfil Penulis :\r\nSaka Mikami adalah seorang penulis asal Jepang yang lahir pada tanggal 20 Maret 1979. Ia dikenal sebagai penulis novel ringan dan manga.\r\n\r\nMikami memulai karier menulisnya pada tahun 2008 dengan merilis novel ringan berjudul \"Tensei Shitara Slime Datta Ken\" (Reincarnated as a Slime). Novel ringan ini kemudian diadaptasi menjadi manga dan anime, dan menjadi salah satu seri paling populer di Jepang.\r\n\r\nSelain \"Tensei Shitara Slime Datta Ken\", Mikami juga menulis berbagai novel ringan lainnya, seperti \"KonoSuba: God\'s Blessing on This Wonderful World!\", \"Arifureta Shokugyou de Sekai Saikyou\", dan \"Mushoku Tensei: Jobless Reincarnation\".\r\n\r\nMikami juga menulis manga, antara lain \"Tensei Shitara Slime Datta Ken\", \"KonoSuba: God\'s Blessing on This Wonderful World!\", dan \"Arifureta Shokugyou de Sekai Saikyou\".\r\n\r\nDi antara jenis buku lainnya, komik memang disukai oleh semua kalangan mulai dari anak kecil hingga orang dewasa. Alasan komik lebih disukai oleh banyak orang karena disajikan dengan penuh dengan gambar dan cerita yang mengasyikan sehingga mampu menghilangkan rasa bosan di kala waktu senggang.\r\n\r\nKomik seringkali dijadikan sebagai koleksi dan diburu oleh penggemarnya karena serinya yang cukup terkenal dan kepopulerannya terus berlanjut sampai saat ini. Dalam memilih jenis komik, ada baiknya perhatikan terlebih dahulu ringkasan cerita komik di sampul bagian belakang sehingga sesuai dengan preferensi pribadi pembaca.'),
(44, 'Solo Leveling 05 (Komik)', 'DUBU/CHUGONG', 'm&c!', '2024', 'Komik', 63750.00, 103, 'uploads/buku29', 'Berhati-hatilah saat melawan monster agar dalam prosesnya,\r\ndirimu sendiri tidak menjadi monster.\r\nSebab saat kau menatap jauh ke dalam jurang, jurang itu pun akan menatapmu.\r\n\r\nKeunggulan:\r\n- Ada versi anime dan novelnya\r\n- Cerita bertema dungeon (penjara bawah tanah) yang paling popular saat ini\r\n- Cerita seru cocok untuk pembaca pria dan wanita\r\n- Komik berwarna\r\n\r\nDi antara jenis buku lainnya, komik memang disukai oleh semua kalangan mulai dari anak kecil hingga orang dewasa. Alasan komik lebih disukai oleh banyak orang karena disajikan dengan penuh dengan gambar dan cerita yang mengasyikan sehingga mampu menghilangkan rasa bosan di kala waktu senggang.\r\n\r\nKomik seringkali dijadikan sebagai koleksi dan diburu oleh penggemarnya karena serinya yang cukup terkenal dan kepopulerannya terus berlanjut sampai saat ini. Dalam memilih jenis komik, ada baiknya perhatikan terlebih dahulu ringkasan cerita komik di sampul bagian belakang sehingga sesuai dengan preferensi pribadi pembaca.\r\n\r\nM&C! Publishing adalah penerbit di bawah Divisi Ritel dan Penerbitan Grup Kompas Gramedia, perusahaan penerbitan terbesar di Indonesia. Grup Kompas Gramedia memulai usaha dengan fokus di media cetak. Dalam perkembangannya, perusahaan telah berkembang menjadi kelompok usaha dengan berbagai divisi. Di bidang informasi, grup ini juga merambah ke media elektronik dan multimedia. M&C! Penerbitan telah menerbitkan berbagai judul dan jenis buku: komik, komik pendidikan, buku anak-anak, novel, buku nonfiksi. Salah Satunya seperti komik ”Solo Leveling 05 (Komik)”.'),
(45, 'Strategi = Eksekusi', 'Jacques Pijl', ' Gemilang (kelompok Pustaka Alvabet)', '2023', 'Bisnis', 117000.00, 110, 'uploads/buku30', 'Wajib dibaca oleh setiap pemimpin, profesional, dan pengusaha yang merasa tugas utama mereka adalah mengeksekusi strategi, bukan menetapkan strategi.\r\n\r\nDigitalisasi telah menyebabkan disrupsi di segala bidang. Disrupsi adalah nama baru dalam perekonomian. Disrupsi telah mengubah semuanya dalam bisnis. Kontinuitas tidak lagi menjadi sesuatu yang pasti, dan kenyataan pahitnya, strategi apa pun akan sama cemerlangnya dengan eksekusinya.\r\n\r\nBuku ini menjawab tantangan baru tersebut. Strategi sama dengan Eksekusi. Di situlah letak satu-satunya keunggulan kompetitif dalam beradaptasi pada era disrupsi ini. Tidak mengherankan, kekuatan, kecepatan, dan ketangkasan dalam pelaksanaan sangatlah penting, jauh lebih penting daripada strategi yang dipetakan secara sempurna berdasarkan kelayakan dan prediktabilitas.\r\n\r\nBerisi 80 persen cara yang aplikatif—diperkaya dengan kisah bagaimana pemimpin-pemimpin hebat berinovasi—buku ini akan memandu kita untuk meningkatkan, memperbarui, dan berinovasi agar dapat beradaptasi dan tumbuh lebih cepat pada era digital.\r\n\r\n“Wajib dibaca oleh semua pemimpin.”\r\n—George Kohlrieser, Profesor Kepemimpinan dan Perilaku Organisasi di IMD Business School Switzerland\r\n“Kaya gagasan dan nasihat yang kuat.”\r\n—Ben Tiggelaar, ilmuwan, penulis, publik speaker dan konsultan\r\n“Jembatan antara gagasan dan tindakan yang sangat dibutuhkan … formula sukses yang siap digunakan.”\r\n—Peter Meyers, pendiri dan CEO Stand & Deliver Group dan dosen tamu di Stanford University dan IMD (Lausanne)\r\n\r\nProfil Penulis :\r\nJacques Pijl memiliki pengalaman lebih dari 20 tahun dalam memberikan nasihat kepada para direktur dan tim di perusahaan dan organisasi terkemuka mengenai pelaksanaan strategi dan inovasi. Selain itu, ia berpartisipasi dalam transformasi skala besar di sektor swasta, publik, dan semi-publik.\r\n\r\nDia adalah Managing Director agen konsultan Turner, pemimpin, pemikir dan pembicara yang banyak berbicara mengenai pelaksanaan strategi dan inovasi. Buku-bukunya telah mendapat status bestseller di Belanda.\r\n\r\nTahun Terbit : Cetakan Pertama, Desember 2023'),
(46, 'Novel Ayah: Sebuah Novel', 'Andrea Hirata', 'Mizan', '2016', 'Novel', 95000.00, 100, 'uploads/buku25', 'Betapa Sabari menyayangi Zorro. Ingin dia memeluknya sepanjang waktu. Dia terpesona melihat makhluk kecil yang sangat indah dan seluruh kebaikan yang terpancar darinya. Diciuminya anak itu dari kepala sampai ke jari-jemari kakinya yang mungil. Kalau malam Sabari susah susah tidur lantaran membayangkan bermacam rencana yang akan dia lalui dengan anaknya jika besar nanti. Dia ingin mengajaknya melihat pawai 17 Agustus, mengunjungi pasar malam, membelikannya mainan, menggandengnya ke masjid, mengajarinya berpuasa dan mengaji, dan memboncengnya naik sepeda saban sore ke taman kota.');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Arsitektur'),
(4, 'Bahasa'),
(5, 'Bisnis'),
(6, 'Edukasi'),
(7, 'Fiksi'),
(8, 'Hukum'),
(10, 'Pengembangan Diri'),
(11, 'Biografi'),
(12, 'Teknologi'),
(13, 'Novel'),
(15, 'Pendidikan'),
(17, 'Komik'),
(20, 'Agama');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`, `created_at`) VALUES
(30, 17, 'Azis', 'anonymblck@gmail.com', '082328662987', 'haloooooooo', '2025-04-20 21:42:33'),
(31, 17, 'Andika', 'muhammadabdulazis104@gmail.com', '082328662987', 'I Like You', '2025-04-20 23:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `biaya_ongkir` decimal(10,2) NOT NULL,
  `ekspedisi` varchar(50) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `status` enum('pending','paid','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_number` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_harga`, `biaya_ongkir`, `ekspedisi`, `nama_penerima`, `alamat_pengiriman`, `no_telp`, `status`, `payment_method`, `payment_number`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
(31, 17, 66600.00, 18000.00, 'sicepat', 'Andika', 'Panongan, Banten, 15820', '+6282328662987', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 15:26:16', '2025-04-20 20:21:56', '2025-04-20 13:26:16'),
(32, 17, 68600.00, 20000.00, 'jne', 'Andika', 'Panongan, Banten, 15820', '+6282328662987', 'delivered', 'shopeepay', '082328662987', 'success', '2025-04-20 15:26:08', '2025-04-20 20:26:06', '2025-04-20 13:26:33'),
(33, 17, 94250.00, 20000.00, 'jne', 'Andika', 'Panongan, Jakarta, 15820', '+6282328662987', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 15:30:03', '2025-04-20 20:30:00', '2025-04-20 13:30:03'),
(34, 17, 145000.00, 20000.00, 'jne', 'Andika', 'Panongan, Jakarta, 15820', '+6282328662987', 'paid', 'ovo', '082328662987', 'success', '2025-04-20 15:44:29', '2025-04-20 20:44:22', '2025-04-20 13:44:29'),
(35, 17, 86550.00, 15000.00, 'anteraja', 'Andika', 'Panongan, Jakarta, 15820', '+6282328662987', 'cancelled', 'shopeepay', '082328662987', 'success', '2025-04-20 15:47:50', '2025-04-20 20:47:47', '2025-04-20 13:54:48'),
(36, 17, 240500.00, 20000.00, 'jne', 'Andika', 'Panongan, Jakarta, 15820', '+6282328662987', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 16:04:55', '2025-04-20 20:55:15', '2025-04-20 14:04:55'),
(37, 17, 86100.00, 15000.00, 'anteraja', 'Andika', 'Panongan, Jakarta Selatan, 15820', '+6282328662987', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 18:10:36', '2025-04-20 23:10:33', '2025-04-20 16:10:36'),
(38, 17, 1505000.00, 20000.00, 'jne', 'Andika', 'Panongan, Yogyakarta, 15820', '+6282328662987', 'paid', 'ovo', '082328662987', 'success', '2025-04-20 18:12:30', '2025-04-20 23:12:26', '2025-04-20 16:12:30'),
(39, 17, 466250.00, 20000.00, 'jne', 'Andika', 'Panongan, Yogyakarta, 15820', '+6282328662987', 'pending', NULL, NULL, NULL, NULL, '2025-04-20 23:13:43', '2025-04-20 16:13:43'),
(40, 17, 652500.00, 15000.00, 'anteraja', 'Azis', 'Panongan, Kyoto, 15820', '082124258162', 'cancelled', 'shopeepay', '082328662987', 'success', '2025-04-20 18:14:46', '2025-04-20 23:14:43', '2025-04-20 16:16:46'),
(41, 17, 93500.00, 20000.00, 'jne', 'Andika', 'Panongan, Surabaya, 15820', '082124258162', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 18:19:46', '2025-04-20 23:19:44', '2025-04-20 16:19:46'),
(42, 17, 236000.00, 20000.00, 'jne', 'Andika', 'Panongan, Surabaya, 15820', '082124258162', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 18:20:22', '2025-04-20 23:20:20', '2025-04-20 16:20:22'),
(43, 17, 172500.00, 15000.00, 'anteraja', 'Azis', 'Palasari, Kyoto, 15820', '082124258162', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 18:26:03', '2025-04-20 23:26:00', '2025-04-20 16:26:03'),
(44, 17, 87000.00, 15000.00, 'anteraja', 'Azis', 'Palasari, Kyoto, 15820', '082124258162', 'paid', 'shopeepay', '082328662987', 'success', '2025-04-20 18:27:25', '2025-04-20 23:27:22', '2025-04-20 16:27:25'),
(45, 17, 91100.00, 20000.00, 'jne', 'Azis', 'Palasari, Kyoto, 15820', '082124258162', 'shipped', 'shopeepay', '082328662987', 'success', '2025-04-20 18:29:26', '2025-04-20 23:29:23', '2025-04-20 16:35:18'),
(46, 17, 722000.00, 20000.00, 'jne', 'Andika', 'Panongan, Medan, 15820', '0821242581620', 'pending', 'ovo', '082328662987', 'success', '2025-04-20 18:32:28', '2025-04-20 23:32:22', '2025-04-20 16:34:21'),
(47, 17, 81750.00, 18000.00, 'sicepat', 'Andika', 'Panongan, Medan, 15820', '0821242581620', 'paid', 'ovo', '082328662987', 'success', '2025-04-20 18:43:09', '2025-04-20 23:43:05', '2025-04-20 16:43:09'),
(48, 17, 115000.00, 15000.00, 'anteraja', 'Azis', 'Panongan, Kyoto, 15820', '08212425816', 'paid', 'ovo', '082328662987', 'success', '2025-04-20 18:43:56', '2025-04-20 23:43:53', '2025-04-20 16:43:56'),
(49, 17, 135900.00, 18000.00, 'sicepat', 'Andika', 'Mekar Jaya, Malang, 15847', '08212425816', 'paid', 'gopay', '082328662987', 'success', '2025-04-21 01:10:11', '2025-04-21 06:10:05', '2025-04-20 23:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `judul`, `quantity`, `harga`, `subtotal`) VALUES
(32, 31, 17, 'Buku Praktis Belajar Bahasa Jepang', 1, 48600.00, 48600.00),
(33, 32, 17, 'Buku Praktis Belajar Bahasa Jepang', 1, 48600.00, 48600.00),
(34, 33, 27, 'Titipo: Buku Stiker & Game Edukasi', 1, 74250.00, 74250.00),
(35, 34, 29, 'My Handsome Brothers (Terbit Ulang)', 5, 25000.00, 125000.00),
(36, 35, 24, 'Elon Musk : From Bullied to Tech Billionaire', 1, 71550.00, 71550.00),
(37, 36, 18, 'Life Reset: Bertumbuh Dimulai dari Sini', 3, 73500.00, 220500.00),
(38, 37, 20, 'Hukum Tata Negara dan Transformasi', 1, 71100.00, 71100.00),
(39, 38, 27, 'Titipo: Buku Stiker & Game Edukasi', 20, 74250.00, 1485000.00),
(40, 39, 44, 'Solo Leveling 05 (Komik)', 7, 63750.00, 446250.00),
(41, 40, 44, 'Solo Leveling 05 (Komik)', 10, 63750.00, 637500.00),
(42, 41, 18, 'Life Reset: Bertumbuh Dimulai dari Sini', 1, 73500.00, 73500.00),
(43, 42, 13, 'Journey to Allah: Menyusuri Jalan Cahaya Menuju Rida-Nya', 2, 108000.00, 216000.00),
(44, 43, 41, 'Akasha : Ito Junji\'s Selected Collection - Shiver', 2, 78750.00, 157500.00),
(45, 44, 40, 'Scholarship Goals : Kulik Serba-Serbi Beasiswa Dalam dan Luar Negeri', 2, 36000.00, 72000.00),
(46, 45, 20, 'Hukum Tata Negara dan Transformasi', 1, 71100.00, 71100.00),
(47, 46, 16, 'Kamus Populer Bahasa Indonesia', 3, 234000.00, 702000.00),
(48, 47, 44, 'Solo Leveling 05 (Komik)', 1, 63750.00, 63750.00),
(49, 48, 42, 'Kubo Won\'t Let Me Be Invisible 11', 2, 50000.00, 100000.00),
(50, 49, 15, 'Sejarah dan Evolusi Agama', 2, 58950.00, 117900.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `created_at`) VALUES
(15, 'muhamad abdul azis', 'anonymblck@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'admin', '2025-04-18 08:22:21'),
(17, 'MLBB', 'mlbb@gmail.com', '1bbd886460827015e5d605ed44252251', 'user', '2025-04-18 09:04:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_buku_user` (`id_buku`,`id_user`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `buku` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
