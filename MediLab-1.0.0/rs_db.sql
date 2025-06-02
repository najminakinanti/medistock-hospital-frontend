-- Membuat tabel kategori untuk inventaris rumah sakit
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- Menambahkan beberapa data kategori
INSERT INTO kategori (nama_kategori) VALUES 
('Alat Kesehatan'),
('Bahan Medis'),
('Perlengkapan Rumah Sakit');

-- Membuat tabel inventaris tanpa kolom satuan
CREATE TABLE IF NOT EXISTS inventaris (
    id_inventaris INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(150) NOT NULL,
    jumlah INT NOT NULL,
    id_kategori INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
);

-- Menambahkan beberapa data inventaris
INSERT INTO inventaris (nama_barang, jumlah, id_kategori) VALUES 
('Stetoskop', 20, 1),
('Paracetamol 500mg', 1000, 2),
('Masker Bedah', 5000, 3),
('Termometer Digital', 30, 1),
('Obat Penghilang Nyeri', 200, 2);
