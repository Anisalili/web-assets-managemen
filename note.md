Kasus Yang Diusulkan:

1. Inventaris Aset
• Pendaftaran aset baru
• Update data aset (misal: perubahan lokasi, status, atau pemilik)
• Stock Off (menghapus atau menonaktifkan aset yang sudah tidak digunakan), laporan akhir tahuanan jadi tidak perlu menghitung manual stok yang ada
2. Pencarian & Laporan Aset
• Pencarian aset berdasarkan kategori, status, lokasi, atau nomor inventaris
• Laporan aset lengkap dalam format PDF atau Excel
• Visualisasi peta lokasi aset di perusahaan
3. Modul Pemeliharaan & Kerusakan
• Pencatatan kerusakan aset
• Pencatatan jadwal pemeliharaan rutin
• Jadwal : a. Tidak harus pakai notifikasi otomatis.
b. tampilkan status atau pengingat di dashboard admin/petugas, misalnya:

= Menampilkan daftar aset yang butuh pemeliharaan (berdasarkan tanggal atau kondisi).

= Menandai aset yang dalam proses perbaikan.

c. Ini sudah cukup kuat untuk tahap implementasi awal, dan kamu bisa menulis di laporan bahwa: “Fitur notifikasi otomatis direncanakan sebagai pengembangan lanjutan sistem.”

• Laporan pemeliharaan dan kerusakan untuk manajemen yang habis digunakan dan tdk habis digunakan) aktifasiva di bagi nilai belinya di atas 500, fasif di bawah
4. Visualisasi Peta Aset
Peta mentah titik lokasi aset
Yang Dimaksud:

a. Sumber Data: Semua koordinat lokasi aset disimpan di database lokal Laravel (tabel lokasi), misalnya:
• id lokasi, dan nama lokasi
• Koordinat X, Y atau grid dalam peta perusahaan
• Setiap aset memiliki relasi dengan tabel lokasi.
b. Cara Visualisasi
• Peta bisa berupa gambar statis denah perusahaan (misal file PNG/JPG) yang ditampilkan di halaman web.
• Titik-titik aset ditampilkan menggunakan koordinat X,Y pada gambar peta.
Database : Menyimpan semua informasi aset, kondisi, riwayat pemeliharaan, dan lokasi aset, Relasi antar tabel seperti: aset, kategori, lokasi, riwayat kerusakan, dan jadwal    pemeliharaan



 

PEMBAGIAN

Orang

Modul Utama

Kasus yang Dikerjakan

Saudah

Modul Pemeliharaan & Pelaporan Kerusakan Aset

- Pencatatan kerusakan aset

 

 

- Pencatatan jadwal pemeliharaan rutin

 

 

- Laporan pemeliharaan dan kerusakan

 

 

- Database riwayat kerusakan dan jadwal pemeliharaan

 

 

- Visualisasi peta lokasi aset terkait pemeliharaan & kerusakan



Anisa Lili Safitri:

Modul Inventaris & Laporan Aset

- Pendaftaran aset baru

 

 

- Update data aset (lokasi, status, pemilik)

 

 

- Stock Off (menghapus/menonaktifkan aset)

 

 

- Pencarian aset berdasarkan kategori, status, lokasi, nomor inventaris

 

 

- Laporan aset lengkap (PDF/Excel)

 

 

- Database aset, kategori, lokasi

 

 

- Visualisasi peta lokasi aset terkait inventaris

