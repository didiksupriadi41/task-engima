# Tugas 1 IF3110 Pengembangan Aplikasi Berbasis Web

## Deskripsi Aplikasi Web

Saat ini Engi ingin melakukan ekspansi usaha dengan membangun sebuah bioskop. Setelah berdiri selama 2 bulan, Engi merasa bioskopnya sepi dibanding bioskop kompetitor lainnya. Usut punya usut, ternyata faktor utama penyebab sepinya bioskop Engi adalah tidak adanya kemudahan pemesanan tiket secara daring. Oleh karena itu, Engi meminta Anda untuk membuat aplikasi web pemesanan tiket bioskop daring. Engi menginginkan website miliknya untuk memiliki fitur pembelian tiket, memberi ulasan pada film yang telah ditonton, login dan register, riwayat pembelian tiket.

Engi telah mempekerjakan seorang UI/UX profesional untuk mendesain tampilan *website*-nya. Anda diminta untuk mengimplementasikan tampilan sedemikian mirip dengan tampilan pada contoh. Engi tidak meminta Anda untuk membangun *website* yang *responsive*. Icon dan jenis font tidak harus sama dengan contoh. Tata letak elemen, warna font, garis pemisah, dan perbedaan ukuran font harus terlihat sesuai contoh. Format rating dan waktu harus terlihat sesuai contoh tampilan.

## Daftar *Requirements*

### Login page

Halaman pertama yang ditampilkan jika pengguna belum *login* atau sudah *logout* adalah halaman **Login**. Pengguna dapat melakukan *login* sebagai *user*. *Login* hanya membandingkan email dan password saja. Tidak perlu tambahan proteksi apapun.

Identitas pengguna yang sudah *login* akan disimpan sebagai ***cookie*** dalam browser. *Cookie* menyimpan data pengguna dalam bentuk *string* dengan panjang tertentu. Untuk mengetahui pengguna mana yang sedang *login*, *string* tersebut dapat dilihat di basis data. **Identitas tersebut tidak boleh disimpan sebagai parameter HTTP GET**. Jika *cookie* ini tidak ada, pengguna dianggap belum login dan aplikasi akan selalu mengarahkan (*redirect*) pengguna ke halaman ini, meskipun pengguna membuka halaman yang lain. Masa berlaku *cookie* ditentukan sendiri oleh peserta.

### Register page

Pengguna dapat mendaftarkan akun baru jika belum *login* atau sudah *logout*. Pada halaman ini, pengguna mendaftarkan diri dengan email, username, dan nomor hp yang **unik**. Pengecekan keunikan nilai *field* dilakukan menggunakan AJAX. Jika unik, border *field* akan berwarna hijau. Jika tidak unik, *field* akan diberikan pesan error seperti berikut.

Validasi lain yang dilakukan pada **sisi klien** pada halaman ini adalah:

* Email sesuai memiliki format email standar seperti “user@mail.com”.
* Username hanya menerima kombinasi alphabet, angka, dan *underscore*.
* Nomor HP hanya menerima angka dengan panjang antara 9-12 angka.

Setelah semua nilai *field* sudah diisi dan valid, pengguna dapat mendaftarkan akun barunya. Jika akun berhasil didaftarkan, pengguna langsung diarahkan ke halaman **Home**. Mekanisme *cookie* sama dengan halaman **Login**.

### Home page

Pada halaman **Home**, pengguna disambut dengan *username* pengguna dan daftar film yang sedang tayang. Film yang sedang tayang adalah film yang mempunyai jadwal saat waktu sekarang. Pengguna dapat melihat detail film dengan mengklik poster atau judul film.

Header aplikasi web terdiri dari *search bar* dan pilihan untuk *logout*. Search bar digunakan untuk mencari film berdasarkan judul. Hasil pencarian ditampilkan pada halaman **Search Result**. Jika pengguna memilih untuk *logout*, halaman akan diarahkan ke halaman **Login**.

### Search Result page

Hasil pencarian dari *search bar* di halaman Home akan ditampilkan pada halaman ini. Untuk setiap film, ditampilkan informasi judul, sinopsis, rating, poster. Pengguna dapat melihat detail film dengan mengklik tombol “View details”.

Jika daftar film melebihi jumlah tertentu (tiga), maka akan muncul *pagination* untuk melihat daftar film selebihnya. Ketika memilih *page*, pengguna tidak diarahkan ke halaman baru namun daftar film langsung berubah di halaman ini.

### Film Detail page

Pada halaman **Film Detail**, terdapat beberapa informasi mengenai film yang dipilih, yaitu judul, poster, rating, genre (bisa lebih dari satu), tanggal rilis, durasi tayang (dalam menit), dan sinopsis dari film tersebut.

Pengguna dapat melihat ulasan film tersebut dari pengguna yang telah membeli tiket film tersebut. Informasi setiap review meliputi *username*, foto pengguna yang memberikan ulasan, penilaian bintang (dalam skala 1-10), dan ulasan yang diberikan mengenai film tersebut.

Pembelian tiket bioskop dapat dibeli di halaman ini juga. Pengguna memilih tanggal dan jam tayang yang belum lewat dari waktu sekarang. Jika tiket untuk suatu jadwal sudah habis, maka akan muncul “Not Available”. Jika masih ada kursi yang tersedia, pengguna dapat memilih tombol “Book Now” yang kemudian mengarahkan ke halaman **Buy Ticket**.

### Buy Ticket page

Setelah memilih jadwal tayang film, pengguna memilih posisi kursi. Untuk setiap pembelian, pengguna hanya dapat **membeli 1 kursi**. Pengguna tidak dapat memilih kursi yang telah dibeli oleh pengguna lain. Kursi yang tersedia berwarna biru dan yang tidak tersedia berwarna abu-abu. (Asumsi saat pembelian tiket, ketersediaan kursi tidak berubah).

“Booking Summary” akan muncul ketika pengguna sudah memilih posisi kursi. Pengguna dapat membeli tiket dengan menekan tombol “Buy Ticket”.

Sebuah modal akan muncul untuk memberitahukan apakah tiketnya berhasil dibeli atau tidak. Modal hanya muncul jika **sudah ada konfirmasi keberhasilan/kegagalan dari *response* AJAX**. Menutup modal tersebut akan mengarahkan pengguna ke halaman **Transaction History**.

### Transaction History page

Pada halaman ini, ditampilkan daftar film yang telah dipesan dan telah ditonton (jadwal tayang telah lewat) maupun yang belum (jadwal tayang di masa depan). Daftar diurutkan **berdasarkan waktu jadwal tayang** dengan jadwal tayang paling terakhir merupakan entri paling atas.

Ulasan baru dapat dilakukan ketika tiket yang telah dibeli telah lewat jadwal tayangnya.

Pada setiap entri pada *history*:

* Jika jadwal tayang film belum terlewat, tidak pengguna tidak dapat menambah review
* Jika jadwal tayang film telah lewat:
  * Jika belum memberikan ulasan, muncul tombol “Add Review”
  * Jika sudah memberikan ulasan, muncul tombol “Edit Review” dan tombol “Delete Review”

### User Review page

Pengguna menulis ulasan film pada halaman ini. Pengguna dapat memberikan ulasan dalam bentuk pilihan rating dalam skala 1-10 dan deskripsi ulasan.

Jika pengguna belum pernah mengulas film tersebut atau telah menghapus ulasannya, pengguna dapat memberikan ulasannya dengan tombol "Submit" atau membatalkan ulasan dengan menekan tombol "Cancel". Jika pengguna telah memberikan ulasan dan belum dihapus, akan ada tombol "Submit" digantikan dengan tombol "Edit" untuk mengubah ulasan. Saat pengguna akan mengubah ulasan, informasi rating dan deskripsi ulasan akan muncul pada halaman ini.

## Bonus

1. Data yang disimpan pada cookie memiliki *expiry time*. Jika *access token* ini tidak ada atau tidak valid, maka pengguna dianggap belum *login*. *Expiry time* sebuah *access token* berbeda dengan waktu berlaku cookie.
2. Pada halaman **Buy Ticket**, ketersediaan kursi diperbaharui secara *real-time*.
3. Tampilan dibuat responsif (minimal untuk ukuran 1280x768 dan 800x600). Artinya, tampilan mungkin berubah menyesuaikan ukuran layar.

## System requirement

Minimum requirement:

1. XAMPP 7.3.0-0
2. PHP 7.1.0
3. Chrome Version 77.0.3865.90 (Official Build) (64-bit)


## Cara Instalasi

1. Download XAMPP di https://www.apachefriends.org/download.html

2. Ikuti petunjuk instalasi XAMPP

2. Buka terminal dan pindah ke direktori /Applications/XAMPP/xamppfiles/htdocs

3. Jalankan perintah:


```
git clone https://gitlab.informatika.org/if3110-2019-01-k03-01/tugas-besar-1-2019
```

## Cara menjalankan *server*

1. Buka terminal dan jalankan perintah:

### Windows

```
\xampp\xampp_start.exe
```

### Linux

```
sudo /opt/lampp/lampp start
```

### Mac

```
sudo /Applications/XAMPP/xamppfiles/xampp start
```

2. Pada browser, buka URL http://localhost/phpmyadmin

3. Klik New dan masukkan Database Name 'tubes1'

4. Klik Import dan Choose File

5. Pilih file 'tubes1.sql' dan klik Go

6. Buka URL http://localhost/tugas-besar-1-2019/public/

## *Screenshot* Tampilan Aplikasi

### Login page

![](mockup/Login.jpg)

### Register page

![](mockup/Register.jpg)

<p align="center">
  <img src="mockup/Register-Wrong.jpg">
</p>

### Home page

![](mockup/Home.jpg)

### Search Result page

![](mockup/Search.jpg)

![](mockup/Search-Pagination.jpg)

### Film Detail page

![](mockup/MovieDetail.jpg)

### Buy Ticket page

![](mockup/BookTicket-Noticketselected.jpg)

![](mockup/BookTicket-Selectedticket.jpg)

![](mockup/BookTicket-Success.jpg)

### Transaction History page

![](mockup/Transactions.jpg)

![](mockup/Transactions-2.jpg)

### User Review page

![](mockup/Reviews-Add.jpg)

## Anggota Tim

1. Muhamad Arif Adiputra - 13516114
2. Johanes - 13517012
3. Juniardi Akbar - 13517075
4. Tasya Lailinissa Diandraputri - 13517141

## Pembagian Tugas

### Frontend

1. Login : 13517075
2. Register : 13517012, 13517075
3. Home : 13516114, 13517075
4. Search : 13517012, 13517141
5. Film Detail : 13517141
6. Buy Ticket : 13517012
7. Transaction History : 13517075
8. User Review : 13517075

### Backend

1. Login : 13517075
2. Register : 13517075
3. Home : 13516114, 13517075
4. Search : 13517075, 13517141
5. Film Detail : 13517141
6. Buy Ticket : 13517012
7. Transaction History : 13517075
8. User Review : 13517075

### Bonus
1. Cookie expired : 13517075
2. Buy Ticket live time : 13517012
3. Tampilan reponsive : 13517012

