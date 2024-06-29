# Tugas-Akhir-Prak-WEB
Tugas Akhir Praktikum Website Semester 4
TOPIK :
Pemanfaatan teknologi web untuk membuat kasir sebuah apotik Bernama “Obatin”.

Deskripsi
"Obatin" adalah sebuah aplikasi kasir berbasis web yang dirancang untuk mengelola penjualan obat di sebuah apotek atau toko obat. Aplikasi ini mencakup fitur-fitur untuk admin dan pengguna, memungkinkan pengelolaan stok obat, transaksi penjualan, serta laporan terkait aktivitas penjualan dan stok obat.

# Relasi Antar Tabel
a.Tabel obat ke tabel gudang:
Setiap obat (obat.id_gudang) dihubungkan dengan gudang (gudang.id_gudang).
Relasi: Many-to-One (Banyak obat bisa berada di satu gudang).

b.Tabel transaksi ke tabel obat:
Setiap transaksi (transaksi.id_obat) dihubungkan dengan obat (obat.id_obat).
Relasi: Many-to-One (Banyak transaksi bisa mencatat pembelian satu obat yang sama).

c.Tabel transaksi ke tabel login:
Setiap transaksi (transaksi.id_pengguna) dihubungkan dengan pengguna (login.id).
Relasi: Many-to-One (Banyak transaksi bisa dilakukan oleh satu pengguna).
