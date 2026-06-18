-- Jalankan hanya jika kolom final approval kepala sekolah belum ada di tabel `tagihan`.
-- Aman untuk XAMPP/MariaDB terbaru karena memakai IF NOT EXISTS.

ALTER TABLE `tagihan`
  ADD COLUMN IF NOT EXISTS `subtotal_tagihan` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `nomor_tagihan`,
  ADD COLUMN IF NOT EXISTS `diskon_tagihan` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `subtotal_tagihan`,
  ADD COLUMN IF NOT EXISTS `catatan_kepsek` VARCHAR(255) NULL AFTER `tanggal_tagihan`,
  ADD COLUMN IF NOT EXISTS `dibuat_oleh` VARCHAR(255) NULL AFTER `catatan_kepsek`,
  ADD COLUMN IF NOT EXISTS `disetujui_oleh` VARCHAR(255) NULL AFTER `dibuat_oleh`,
  ADD COLUMN IF NOT EXISTS `created_at` DATETIME NULL AFTER `disetujui_oleh`,
  ADD COLUMN IF NOT EXISTS `updated_at` DATETIME NULL AFTER `created_at`;

-- Pastikan invoice lama yang belum final tetap masuk ke antrian kepala sekolah.
UPDATE `tagihan`
SET `status_tagihan` = 'pending'
WHERE `status_tagihan` IS NULL OR `status_tagihan` = '';
