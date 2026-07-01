@extends('layouts.app')

@section('title', 'Dashboard Admin - Portal Wisata & Budaya Delta Brantas')

@push('styles')
<style>
/* ========================================
   ADMIN MODAL & INTERACTIVE STYLES
   ======================================== */

/* Toast Notification */
.admin-toast {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 22px;
    background: #111c31;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
    font-size: .9rem;
    font-weight: 500;
    color: #fff;
    transform: translateY(100px);
    opacity: 0;
    transition: all .4s cubic-bezier(.4,0,.2,1);
    max-width: 360px;
}
.admin-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.admin-toast .toast-icon { font-size: 1.2rem; }
.admin-toast.success { border-left: 4px solid #22c55e; }
.admin-toast.error   { border-left: 4px solid #ef4444; }
.admin-toast.warning { border-left: 4px solid #f59e0b; }

/* Overlay */
.admin-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.7);
    backdrop-filter: blur(6px);
    z-index: 1000;
    opacity: 0;
    pointer-events: none;
    transition: opacity .3s ease;
}
.admin-overlay.open {
    opacity: 1;
    pointer-events: all;
}

/* Modal */
.admin-modal {
    position: fixed;
    inset: 0;
    z-index: 1001;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    pointer-events: none;
    opacity: 0;
    transform: scale(.95) translateY(20px);
    transition: all .35s cubic-bezier(.4,0,.2,1);
}
.admin-modal.open {
    opacity: 1;
    transform: scale(1) translateY(0);
    pointer-events: all;
}
.modal-box {
    background: #0f172a;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 24px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 40px 100px rgba(0,0,0,.6);
}
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 28px 0;
    margin-bottom: 20px;
}
.modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #fff;
}
.modal-close {
    background: rgba(255,255,255,.07);
    border: none;
    border-radius: 10px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #94a3b8;
    font-size: 1.2rem;
    transition: all .2s;
}
.modal-close:hover { background: rgba(255,255,255,.14); color: #fff; }

.modal-body { padding: 0 28px 28px; }

/* Form inside modal */
.modal-form .form-group {
    margin-bottom: 18px;
}
.modal-form label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 8px;
}
.modal-form input,
.modal-form select,
.modal-form textarea {
    width: 100%;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px;
    padding: 12px 16px;
    color: #fff;
    font-family: inherit;
    font-size: .95rem;
    transition: border-color .2s;
    outline: none;
}
.modal-form input:focus,
.modal-form select:focus,
.modal-form textarea:focus {
    border-color: #22c55e;
    background: rgba(34,197,94,.05);
}
.modal-form textarea { resize: vertical; min-height: 90px; }
.modal-form select option { background: #0f172a; }

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.modal-footer {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
}

/* Confirm Delete Modal */
.confirm-modal-box {
    background: #0f172a;
    border: 1px solid rgba(239,68,68,.2);
    border-radius: 24px;
    width: 100%;
    max-width: 420px;
    padding: 32px;
    text-align: center;
    box-shadow: 0 40px 100px rgba(0,0,0,.6);
}
.confirm-icon {
    width: 64px;
    height: 64px;
    background: rgba(239,68,68,.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 20px;
}
.confirm-modal-box h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; }
.confirm-modal-box p { color: #94a3b8; font-size: .9rem; margin-bottom: 24px; line-height: 1.5; }
.confirm-modal-box .confirm-name {
    display: inline-block;
    background: rgba(255,255,255,.07);
    border-radius: 8px;
    padding: 3px 10px;
    color: #fff;
    font-weight: 600;
}
.confirm-buttons { display: flex; gap: 12px; justify-content: center; }

/* Buttons */
.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    transition: all .2s;
}
.btn-danger:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239,68,68,.3); }
.btn-ghost {
    background: rgba(255,255,255,.07);
    color: #94a3b8;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    transition: all .2s;
}
.btn-ghost:hover { background: rgba(255,255,255,.12); color: #fff; }
.btn-save {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 12px 28px;
    font-weight: 600;
    font-size: .9rem;
    cursor: pointer;
    transition: all .2s;
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(34,197,94,.3); }

/* Status badge in table */
.status-active {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(34, 197, 94, .12);
    color: #22c55e;
    border: 1px solid rgba(34,197,94,.25);
    border-radius: 8px;
    padding: 3px 10px;
    font-size: .78rem;
    font-weight: 600;
}
.status-active::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.status-draft {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(148,163,184,.1);
    color: #94a3b8;
    border: 1px solid rgba(148,163,184,.2);
    border-radius: 8px;
    padding: 3px 10px;
    font-size: .78rem;
    font-weight: 600;
}
.status-draft::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #94a3b8; }

/* Action buttons in table */
.table-action {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all .2s;
}
.table-action.edit {
    background: rgba(59,130,246,.12);
    color: #60a5fa;
    border: 1px solid rgba(59,130,246,.2);
}
.table-action.edit:hover { background: rgba(59,130,246,.25); transform: translateY(-1px); }
.table-action.danger {
    background: rgba(239,68,68,.1);
    color: #f87171;
    border: 1px solid rgba(239,68,68,.2);
}
.table-action.danger:hover { background: rgba(239,68,68,.22); transform: translateY(-1px); }
.table-action.toggle-status {
    background: rgba(245,158,11,.1);
    color: #fbbf24;
    border: 1px solid rgba(245,158,11,.2);
}
.table-action.toggle-status:hover { background: rgba(245,158,11,.22); transform: translateY(-1px); }

.action-group { display: flex; gap: 6px; flex-wrap: wrap; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #64748b;
}
.empty-state span { font-size: 2rem; display: block; margin-bottom: 8px; }

/* Image Upload Component */
.image-upload-wrapper { margin-bottom: 18px; }
.image-upload-area {
    border: 2px dashed rgba(255,255,255,.15);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    position: relative;
}
.image-upload-area:hover {
    border-color: #22c55e;
    background: rgba(34,197,94,.05);
}
.image-upload-area .upload-icon { font-size: 2rem; display: block; margin-bottom: 6px; }
.image-upload-area .upload-text { font-size: .85rem; color: #94a3b8; }
.image-upload-area .upload-hint { font-size: .75rem; color: #64748b; margin-top: 4px; }
.image-upload-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
}
.image-preview-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    margin-top: 10px;
    display: none;
    max-height: 220px;
}
.image-preview-box.show { display: block; }
.image-preview-box img {
    width: 100%; max-height: 200px; object-fit: cover; border-radius: 12px;
}
.image-preview-remove {
    position: absolute; top: 8px; right: 8px;
    background: rgba(239,68,68,.9); color: #fff;
    border: none; border-radius: 50%;
    width: 28px; height: 28px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; transition: all .2s;
}
.image-preview-remove:hover { background: #dc2626; transform: scale(1.1); }
</style>
@endpush

@section('content')

    {{-- Overlay --}}
    <div class="admin-overlay" id="adminOverlay"></div>

    {{-- ===== MODAL: TAMBAH / EDIT DESTINASI ===== --}}
    <div class="admin-modal" id="modalDestinasi">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalDestinasiTitle">🌿 Tambah Destinasi</h3>
                <button class="modal-close" onclick="closeModal('modalDestinasi')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formDestinasi" onsubmit="submitDestinasi(event)">
                    <input type="hidden" id="destiId">
                    <div class="form-group">
                        <label>Nama Destinasi</label>
                        <input type="text" id="destiNama" placeholder="cth: Hutan Mangrove Wonorejo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" id="destiLokasi" placeholder="cth: Wonorejo, Sidoarjo" required>
                        </div>
                        <div class="form-group">
                            <label>Rating (1–5)</label>
                            <input type="number" id="destiRating" min="1" max="5" step="0.1" placeholder="4.9" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="destiStatus">
                            <option value="Aktif">Aktif</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍 Latitude</label>
                            <input type="number" id="destiLat" step="any" placeholder="cth: -7.4458">
                        </div>
                        <div class="form-group">
                            <label>📍 Longitude</label>
                            <input type="number" id="destiLng" step="any" placeholder="cth: 112.7178">
                        </div>
                    </div>
                    <div class="image-upload-wrapper">
                        <label>Gambar</label>
                        <div class="image-upload-area" id="destiUploadArea">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Klik atau seret gambar ke sini</span>
                            <span class="upload-hint">JPG, PNG, WebP (Maks 5MB)</span>
                            <input type="file" id="destiImage" accept="image/*" onchange="previewImage(this, 'destiPreview')">
                        </div>
                        <div class="image-preview-box" id="destiPreview">
                            <img src="" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="removeImage('destiImage', 'destiPreview')">✕</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalDestinasi')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL: TAMBAH / EDIT ARTIKEL ===== --}}
    <div class="admin-modal" id="modalArtikel">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalArtikelTitle">📰 Tambah Artikel</h3>
                <button class="modal-close" onclick="closeModal('modalArtikel')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formArtikel" onsubmit="submitArtikel(event)">
                    <input type="hidden" id="artikelId">
                    <div class="form-group">
                        <label>Judul Artikel</label>
                        <input type="text" id="artikelJudul" placeholder="cth: Festival Budaya Delta Brantas" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tanggal Terbit</label>
                            <input type="date" id="artikelTanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="artikelStatus">
                                <option value="Publikasi">Publikasi</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ringkasan / Excerpt</label>
                        <textarea id="artikelExcerpt" placeholder="Tulis ringkasan singkat artikel..."></textarea>
                    </div>
                    <div class="image-upload-wrapper">
                        <label>Gambar</label>
                        <div class="image-upload-area" id="artikelUploadArea">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Klik atau seret gambar ke sini</span>
                            <span class="upload-hint">JPG, PNG, WebP (Maks 5MB)</span>
                            <input type="file" id="artikelImage" accept="image/*" onchange="previewImage(this, 'artikelPreview')">
                        </div>
                        <div class="image-preview-box" id="artikelPreview">
                            <img src="" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="removeImage('artikelImage', 'artikelPreview')">✕</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalArtikel')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL: TAMBAH / EDIT KULINER ===== --}}
    <div class="admin-modal" id="modalKuliner">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalKulinerTitle">🍜 Tambah Kuliner</h3>
                <button class="modal-close" onclick="closeModal('modalKuliner')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formKuliner" onsubmit="submitKuliner(event)">
                    <input type="hidden" id="kulinerId">
                    <div class="form-group">
                        <label>Nama Kuliner</label>
                        <input type="text" id="kulinerNama" placeholder="cth: Kupang Lontong" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select id="kulinerKategori">
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Camilan">Camilan</option>
                                <option value="Bumbu">Bumbu</option>
                                <option value="Oleh-oleh">Oleh-oleh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="kulinerStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Singkat</label>
                        <textarea id="kulinerDeskripsi" placeholder="Tulis deskripsi singkat kuliner..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Lokasi / Alamat</label>
                        <input type="text" id="kulinerLokasi" placeholder="cth: Jl. Gajah Mada, Sidoarjo">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍 Latitude</label>
                            <input type="number" id="kulinerLat" step="any" placeholder="cth: -7.4480">
                        </div>
                        <div class="form-group">
                            <label>📍 Longitude</label>
                            <input type="number" id="kulinerLng" step="any" placeholder="cth: 112.7150">
                        </div>
                    </div>
                    <div class="image-upload-wrapper">
                        <label>Gambar</label>
                        <div class="image-upload-area" id="kulinerUploadArea">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Klik atau seret gambar ke sini</span>
                            <span class="upload-hint">JPG, PNG, WebP (Maks 5MB)</span>
                            <input type="file" id="kulinerImage" accept="image/*" onchange="previewImage(this, 'kulinerPreview')">
                        </div>
                        <div class="image-preview-box" id="kulinerPreview">
                            <img src="" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="removeImage('kulinerImage', 'kulinerPreview')">✕</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalKuliner')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL: TAMBAH / EDIT BUDAYA ===== --}}
    <div class="admin-modal" id="modalBudaya">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalBudayaTitle">🎭 Tambah Budaya</h3>
                <button class="modal-close" onclick="closeModal('modalBudaya')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formBudaya" onsubmit="submitBudaya(event)">
                    <input type="hidden" id="budayaId">
                    <div class="form-group">
                        <label>Nama Budaya</label>
                        <input type="text" id="budayaNama" placeholder="cth: Batik Sidoarjo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" id="budayaLokasi" placeholder="cth: Sidoarjo, Jawa Timur" required>
                        </div>
                        <div class="form-group">
                            <label>Badge</label>
                            <input type="text" id="budayaBadge" placeholder="cth: Warisan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="budayaStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Featured</label>
                            <select id="budayaFeatured">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="budayaDeskripsi" placeholder="Tulis deskripsi budaya..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍 Latitude</label>
                            <input type="number" id="budayaLat" step="any" placeholder="cth: -7.4525">
                        </div>
                        <div class="form-group">
                            <label>📍 Longitude</label>
                            <input type="number" id="budayaLng" step="any" placeholder="cth: 112.7212">
                        </div>
                    </div>
                    <div class="image-upload-wrapper">
                        <label>Gambar</label>
                        <div class="image-upload-area" id="budayaUploadArea">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Klik atau seret gambar ke sini</span>
                            <span class="upload-hint">JPG, PNG, WebP (Maks 5MB)</span>
                            <input type="file" id="budayaImage" accept="image/*" onchange="previewImage(this, 'budayaPreview')">
                        </div>
                        <div class="image-preview-box" id="budayaPreview">
                            <img src="" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="removeImage('budayaImage', 'budayaPreview')">✕</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalBudaya')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL: TAMBAH / EDIT SEJARAH ===== --}}
    <div class="admin-modal" id="modalSejarah">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalSejarahTitle">🏛️ Tambah Sejarah</h3>
                <button class="modal-close" onclick="closeModal('modalSejarah')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formSejarah" onsubmit="submitSejarah(event)">
                    <input type="hidden" id="sejarahId">
                    <div class="form-group">
                        <label>Nama Situs Sejarah</label>
                        <input type="text" id="sejarahNama" placeholder="cth: Candi Pari" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" id="sejarahLokasi" placeholder="cth: Pari, Sidoarjo" required>
                        </div>
                        <div class="form-group">
                            <label>Badge</label>
                            <input type="text" id="sejarahBadge" placeholder="cth: Majapahit">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="sejarahStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Featured</label>
                            <select id="sejarahFeatured">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea id="sejarahDeskripsi" placeholder="Tulis deskripsi situs sejarah..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍 Latitude</label>
                            <input type="number" id="sejarahLat" step="any" placeholder="cth: -7.5505">
                        </div>
                        <div class="form-group">
                            <label>📍 Longitude</label>
                            <input type="number" id="sejarahLng" step="any" placeholder="cth: 112.7230">
                        </div>
                    </div>
                    <div class="image-upload-wrapper">
                        <label>Gambar</label>
                        <div class="image-upload-area" id="sejarahUploadArea">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Klik atau seret gambar ke sini</span>
                            <span class="upload-hint">JPG, PNG, WebP (Maks 5MB)</span>
                            <input type="file" id="sejarahImage" accept="image/*" onchange="previewImage(this, 'sejarahPreview')">
                        </div>
                        <div class="image-preview-box" id="sejarahPreview">
                            <img src="" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="removeImage('sejarahImage', 'sejarahPreview')">✕</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalSejarah')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ===== MODAL: TAMBAH / EDIT LOKASI PETA ===== --}}
    <div class="admin-modal" id="modalMapLocation">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalMapLocationTitle">🗺️ Tambah Lokasi Peta</h3>
                <button class="modal-close" onclick="closeModal('modalMapLocation')">✕</button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="formMapLocation" onsubmit="submitMapLocation(event)">
                    <input type="hidden" id="mapLocId">
                    <div class="form-group">
                        <label>Nama Lokasi / Tempat</label>
                        <input type="text" id="mapLocNama" placeholder="cth: Alun-Alun Sidoarjo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select id="mapLocKategori" required>
                                <option value="alam">🌿 Wisata Alam</option>
                                <option value="budaya">🏛️ Budaya</option>
                                <option value="kuliner">🍜 Kuliner</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="mapLocStatus">
                                <option value="Aktif">Aktif</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" id="mapLocAlamat" placeholder="cth: Jl. Sultan Agung, Sidoarjo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>📍 Latitude</label>
                            <input type="number" id="mapLocLat" step="any" placeholder="cth: -7.4458" required>
                        </div>
                        <div class="form-group">
                            <label>📍 Longitude</label>
                            <input type="number" id="mapLocLng" step="any" placeholder="cth: 112.7178" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Singkat</label>
                        <textarea id="mapLocDeskripsi" placeholder="Tulis info singkat lokasi ini..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-ghost" onclick="closeModal('modalMapLocation')">Batal</button>
                        <button type="submit" class="btn-save">💾 Simpan Lokasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MODAL: KONFIRMASI HAPUS ===== --}}
    <div class="admin-modal" id="modalHapus">
        <div class="confirm-modal-box">
            <div class="confirm-icon">🗑️</div>
            <h3>Hapus Data?</h3>
            <p>Kamu akan menghapus <span class="confirm-name" id="hapusNama">-</span>.<br>Tindakan ini tidak bisa dibatalkan.</p>
            <div class="confirm-buttons">
                <button class="btn-ghost" onclick="closeModal('modalHapus')">Batal</button>
                <button class="btn-danger" id="btnKonfirmasiHapus">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- ===== TOAST NOTIFIKASI ===== --}}
    <div class="admin-toast" id="adminToast">
        <span class="toast-icon" id="toastIcon">✅</span>
        <span id="toastMsg">Berhasil disimpan!</span>
    </div>

    <section class="section admin-section">
        <div class="container">

            {{-- Admin Header --}}
            <div class="admin-header reveal">
                <div>
                    <span class="section-label">Dashboard</span>
                    <h2 class="section-title">Dashboard Admin</h2>
                    <p class="section-subtitle">Kelola konten Portal Wisata & Budaya Delta Brantas Sidoarjo.</p>
                </div>
                <a href="/" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Lihat Website
                </a>
            </div>

            {{-- User Info Card --}}
            <div class="admin-user-info reveal" style="display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:18px 24px;margin-bottom:32px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:#22c55e;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;font-weight:700;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-weight:600;color:#fff;font-size:.95rem;">{{ auth()->user()->name }}</div>
                        <div style="font-size:.8rem;color:#94a3b8;">{{ auth()->user()->email }} &bull; <span style="color:#22c55e;font-weight:600;">{{ ucfirst(auth()->user()->role) }}</span></div>
                    </div>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:8px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#fca5a5;padding:8px 18px;border-radius:10px;cursor:pointer;font-family:inherit;font-size:.85rem;transition:all .2s;" onmouseover="this.style.background='rgba(239,68,68,.2)'" onmouseout="this.style.background='rgba(239,68,68,.1)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>

            {{-- Stats Overview --}}
            <div class="admin-stats-grid reveal">
                <div class="admin-stat-card">
                    <div class="admin-stat-icon">🌿</div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number" id="statDestinasi">3</span>
                        <span class="admin-stat-label">Destinasi</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon">🏛️</div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number" id="statBudayaSejarah">{{ $budayaItems->count() + $sejarahItems->count() }}</span>
                        <span class="admin-stat-label">Budaya & Sejarah</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon">🍜</div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number" id="statKuliner">3</span>
                        <span class="admin-stat-label">Kuliner</span>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-icon">📰</div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-number" id="statArtikel">3</span>
                        <span class="admin-stat-label">Artikel</span>
                    </div>
                </div>
            </div>

            {{-- Admin Content Modules --}}
            <div class="admin-modules reveal">

                {{-- Destinasi Wisata --}}
                <div class="admin-module-card">
                    <div class="admin-module-header">
                        <h3>🌿 Destinasi Wisata</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahDestinasi()">+ Tambah</button>
                    </div>
                    <table class="admin-table" id="tabelDestinasi">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDestinasi">
                            {{-- diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>

                {{-- Artikel Terbaru --}}
                <div class="admin-module-card">
                    <div class="admin-module-header">
                        <h3>📰 Artikel Terbaru</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahArtikel()">+ Tambah</button>
                    </div>
                    <table class="admin-table" id="tabelArtikel">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyArtikel">
                            {{-- diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>

                {{-- Kuliner Khas --}}
                <div class="admin-module-card">
                    <div class="admin-module-header">
                        <h3>🍜 Kuliner Khas</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahKuliner()">+ Tambah</button>
                    </div>
                    <table class="admin-table" id="tabelKuliner">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyKuliner">
                            {{-- diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>

                {{-- Budaya --}}
                <div class="admin-module-card">
                    <div class="admin-module-header">
                        <h3>🎭 Budaya</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahBudaya()">+ Tambah</button>
                    </div>
                    <table class="admin-table" id="tabelBudaya">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyBudaya">
                            {{-- diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>

                {{-- Sejarah --}}
                <div class="admin-module-card">
                    <div class="admin-module-header">
                        <h3>🏛️ Sejarah</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahSejarah()">+ Tambah</button>
                    </div>
                    <table class="admin-table" id="tabelSejarah">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodySejarah">
                            {{-- diisi oleh JS --}}
                        </tbody>
                    </table>
                </div>


                {{-- Peta Interaktif --}}
                <div class="admin-module-card" style="margin-top: 32px; border: 1px solid rgba(59,130,246,.2); background: rgba(59,130,246,.03);">
                    <div class="admin-module-header">
                        <h3>🗺️ Peta Interaktif Explore</h3>
                        <button class="btn btn-primary btn-sm" onclick="openTambahMapLocation()">+ Tambah Lokasi Peta</button>
                    </div>
                    <p style="font-size:.82rem;color:#94a3b8;padding:0 0 16px;line-height:1.6;">
                        Kelola pin lokasi khusus yang ditampilkan pada peta interaktif di halaman <b>Explore</b>. Pin dikelompokkan berdasarkan kategori wisata alam, budaya, dan kuliner.
                    </p>

                    {{-- Preview Peta Mini di Admin --}}
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <div id="admin-preview-map" style="width:100%;height:340px;border-radius:12px;border:1px solid rgba(255,255,255,.08);margin-bottom:16px;"></div>

                    {{-- Tabel Lokasi Terdaftar dengan Scroll --}}
                    <div style="max-height: 280px; overflow-y: auto; border: 1px solid rgba(255,255,255,.05); border-radius: 8px;">
                        <table class="admin-table" style="margin: 0;">
                            <thead style="position: sticky; top: 0; background: var(--bg-card); z-index: 10;">
                                <tr>
                                    <th>Nama Lokasi</th>
                                    <th>Kategori</th>
                                    <th>Koordinat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPeta">
                                {{-- diisi JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* =============================================
   ADMIN DASHBOARD — AJAX FETCH WITH LARAVEL
   =============================================*/

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Initial data passed from Blade (converted to JS objects)
let dataDestinasi = @json($destinations);
let dataArtikel = @json($articles);
let dataKuliner = @json($culinaries);
let dataBudaya = @json($budayaItems);
let dataSejarah = @json($sejarahItems);
let dataPeta = @json($mapLocations);

let pendingDelete = null;

// ── Image Helper Functions ──────────────
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.add('show');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function removeImage(inputId, previewId) {
    document.getElementById(inputId).value = '';
    const preview = document.getElementById(previewId);
    preview.classList.remove('show');
    preview.querySelector('img').src = '';
}
function showExistingImage(previewId, imageUrl) {
    if (imageUrl && !imageUrl.startsWith('http')) {
        imageUrl = '/storage/' + imageUrl;
    }
    if (imageUrl) {
        const preview = document.getElementById(previewId);
        preview.querySelector('img').src = imageUrl;
        preview.classList.add('show');
    }
}
function resetImage(inputId, previewId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewId).classList.remove('show');
    document.getElementById(previewId).querySelector('img').src = '';
}
function getImageUrl(url) {
    if (!url) return '';
    if (url.startsWith('http')) return url;
    return '/storage/' + url;
}

// Format Tanggal
function formatTanggal(tgl) {
    if (!tgl) return '-';
    const date = new Date(tgl);
    const m = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    return `${date.getDate()} ${m[date.getMonth()]} ${date.getFullYear()}`;
}

// Badge Status
function badgeStatus(status) {
    if (status === 'Aktif' || status === 'Publikasi') return `<span class="status-badge active">${status}</span>`;
    return `<span class="status-badge draft">${status}</span>`;
}

// Toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('adminToast');
    const icon = document.getElementById('toastIcon');
    document.getElementById('toastMsg').textContent = message;

    toast.className = 'admin-toast show ' + type;
    if (type === 'success') icon.textContent = '✅';
    else if (type === 'error') icon.textContent = '❌';
    else if (type === 'warning') icon.textContent = '⚠️';

    setTimeout(() => { toast.classList.remove('show'); }, 3000);
}

// Modal Helpers
function openModal(id) {
    document.getElementById('adminOverlay').classList.add('open');
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.getElementById('adminOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

// ══════════════════════════════════════════════
//  DESTINASI
// ══════════════════════════════════════════════
function renderDestinasi() {
    const tbody = document.getElementById('tbodyDestinasi');
    if (dataDestinasi.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><span>🌿</span>Belum ada destinasi.</div></td></tr>`;
        document.getElementById('statDestinasi').textContent = 0;
        return;
    }
    document.getElementById('statDestinasi').textContent = dataDestinasi.length;
    tbody.innerHTML = dataDestinasi.map(d => `
        <tr>
            <td><strong>${d.name}</strong></td>
            <td>${d.location}</td>
            <td>⭐ ${d.rating}</td>
            <td>${badgeStatus(d.status)}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditDestinasi(${d.id})">✏️ Edit</button>
                    <button class="table-action toggle-status" onclick="toggleStatusDestinasi(${d.id})">${d.status === 'Aktif' ? '📦 Draft' : '✅ Aktifkan'}</button>
                    <button class="table-action danger" onclick="openHapus('destinasi', ${d.id}, '${d.name.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openTambahDestinasi() {
    document.getElementById('modalDestinasiTitle').textContent = '🌿 Tambah Destinasi';
    document.getElementById('destiId').value       = '';
    document.getElementById('destiNama').value     = '';
    document.getElementById('destiLokasi').value   = '';
    document.getElementById('destiRating').value   = '';
    document.getElementById('destiStatus').value   = 'Aktif';
    document.getElementById('destiLat').value      = '';
    document.getElementById('destiLng').value      = '';
    resetImage('destiImage', 'destiPreview');
    openModal('modalDestinasi');
}

function openEditDestinasi(id) {
    const d = dataDestinasi.find(x => x.id === id);
    if (!d) return;
    document.getElementById('modalDestinasiTitle').textContent = '🌿 Edit Destinasi';
    document.getElementById('destiId').value     = d.id;
    document.getElementById('destiNama').value   = d.name;
    document.getElementById('destiLokasi').value = d.location;
    document.getElementById('destiRating').value = d.rating;
    document.getElementById('destiStatus').value = d.status;
    document.getElementById('destiLat').value    = d.latitude || '';
    document.getElementById('destiLng').value    = d.longitude || '';
    resetImage('destiImage', 'destiPreview');
    if (d.image) showExistingImage('destiPreview', d.image);
    openModal('modalDestinasi');
}

async function submitDestinasi(e) {
    e.preventDefault();
    const id     = document.getElementById('destiId').value;
    const name   = document.getElementById('destiNama').value.trim();
    const location = document.getElementById('destiLokasi').value.trim();
    const rating = document.getElementById('destiRating').value;
    const status = document.getElementById('destiStatus').value;

    const formData = new FormData();
    formData.append('name', name);
    formData.append('location', location);
    formData.append('rating', rating);
    formData.append('status', status);
    const lat = document.getElementById('destiLat').value;
    const lng = document.getElementById('destiLng').value;
    if (lat) formData.append('latitude', lat);
    if (lng) formData.append('longitude', lng);
    const destiImageFile = document.getElementById('destiImage').files[0];
    if (destiImageFile) formData.append('image', destiImageFile);
    if (id) formData.append('_method', 'PUT');

    const method = 'POST';
    const url = id ? `/admin/api/destinations/${id}` : '/admin/api/destinations';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });
        
        if (!res.ok) {
            const errData = await res.json();
            throw new Error(errData.message || 'Terjadi kesalahan pada server');
        }

        const result = await res.json();
        
        if (id) {
            const idx = dataDestinasi.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataDestinasi[idx] = result;
            showToast(`Destinasi berhasil diperbarui!`);
        } else {
            dataDestinasi.unshift(result);
            showToast(`Destinasi berhasil ditambahkan!`);
        }
        renderDestinasi();
        closeModal('modalDestinasi');
    } catch(err) {
        showToast(err.message || 'Gagal menyimpan!', 'error');
    }
}

async function toggleStatusDestinasi(id) {
    try {
        const res = await fetch(`/admin/api/destinations/${id}/toggle`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        const result = await res.json();
        const idx = dataDestinasi.findIndex(x => x.id === id);
        if (idx >= 0) dataDestinasi[idx] = result;
        renderDestinasi();
        showToast(`Status diubah ke ${result.status}.`, 'warning');
    } catch(err) {
        showToast('Gagal mengubah status!', 'error');
    }
}

// ══════════════════════════════════════════════
//  ARTIKEL
// ══════════════════════════════════════════════
function renderArtikel() {
    const tbody = document.getElementById('tbodyArtikel');
    if (dataArtikel.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state"><span>📰</span>Belum ada artikel.</div></td></tr>`;
        document.getElementById('statArtikel').textContent = 0;
        return;
    }
    document.getElementById('statArtikel').textContent = dataArtikel.length;
    tbody.innerHTML = dataArtikel.map(a => `
        <tr>
            <td><strong>${a.title}</strong></td>
            <td>${formatTanggal(a.published_at)}</td>
            <td>${badgeStatus(a.status)}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditArtikel(${a.id})">✏️ Edit</button>
                    <button class="table-action toggle-status" onclick="toggleStatusArtikel(${a.id})">${a.status === 'Publikasi' ? '📦 Draft' : '🚀 Publikasi'}</button>
                    <button class="table-action danger" onclick="openHapus('artikel', ${a.id}, '${a.title.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openTambahArtikel() {
    document.getElementById('modalArtikelTitle').textContent = '📰 Tambah Artikel';
    document.getElementById('artikelId').value     = '';
    document.getElementById('artikelJudul').value  = '';
    document.getElementById('artikelTanggal').value = '';
    document.getElementById('artikelStatus').value = 'Publikasi';
    document.getElementById('artikelExcerpt').value = '';
    resetImage('artikelImage', 'artikelPreview');
    openModal('modalArtikel');
}

function openEditArtikel(id) {
    const a = dataArtikel.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modalArtikelTitle').textContent = '📰 Edit Artikel';
    document.getElementById('artikelId').value     = a.id;
    document.getElementById('artikelJudul').value  = a.title;
    document.getElementById('artikelTanggal').value = a.published_at;
    document.getElementById('artikelStatus').value = a.status;
    document.getElementById('artikelExcerpt').value = a.excerpt || '';
    resetImage('artikelImage', 'artikelPreview');
    if (a.image) showExistingImage('artikelPreview', a.image);
    openModal('modalArtikel');
}

async function submitArtikel(e) {
    e.preventDefault();
    const id      = document.getElementById('artikelId').value;
    const title   = document.getElementById('artikelJudul').value.trim();
    const published_at = document.getElementById('artikelTanggal').value;
    const status  = document.getElementById('artikelStatus').value;
    const excerpt = document.getElementById('artikelExcerpt').value.trim();

    const formData = new FormData();
    formData.append('title', title);
    formData.append('published_at', published_at);
    formData.append('status', status);
    formData.append('excerpt', excerpt);
    const artikelImageFile = document.getElementById('artikelImage').files[0];
    if (artikelImageFile) formData.append('image', artikelImageFile);
    if (id) formData.append('_method', 'PUT');

    const method = 'POST';
    const url = id ? `/admin/api/articles/${id}` : '/admin/api/articles';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        if (!res.ok) {
            const errData = await res.json();
            throw new Error(errData.message || 'Terjadi kesalahan pada server');
        }

        const result = await res.json();
        
        if (id) {
            const idx = dataArtikel.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataArtikel[idx] = result;
            showToast(`Artikel berhasil diperbarui!`);
        } else {
            dataArtikel.unshift(result);
            showToast(`Artikel berhasil ditambahkan!`);
        }
        renderArtikel();
        closeModal('modalArtikel');
    } catch(err) {
        showToast(err.message || 'Gagal menyimpan!', 'error');
    }
}

async function toggleStatusArtikel(id) {
    try {
        const res = await fetch(`/admin/api/articles/${id}/toggle`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        const result = await res.json();
        const idx = dataArtikel.findIndex(x => x.id === id);
        if (idx >= 0) dataArtikel[idx] = result;
        renderArtikel();
        showToast(`Status diubah ke ${result.status}.`, 'warning');
    } catch(err) {
        showToast('Gagal mengubah status!', 'error');
    }
}

// ══════════════════════════════════════════════
//  KULINER
// ══════════════════════════════════════════════
function renderKuliner() {
    const tbody = document.getElementById('tbodyKuliner');
    if (dataKuliner.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state"><span>🍜</span>Belum ada kuliner.</div></td></tr>`;
        document.getElementById('statKuliner').textContent = 0;
        return;
    }
    document.getElementById('statKuliner').textContent = dataKuliner.length;
    tbody.innerHTML = dataKuliner.map(k => `
        <tr>
            <td><strong>${k.name}</strong></td>
            <td>${k.category_type}</td>
            <td>${badgeStatus(k.status)}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditKuliner(${k.id})">✏️ Edit</button>
                    <button class="table-action toggle-status" onclick="toggleStatusKuliner(${k.id})">${k.status === 'Aktif' ? '📦 Draft' : '✅ Aktifkan'}</button>
                    <button class="table-action danger" onclick="openHapus('kuliner', ${k.id}, '${k.name.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openTambahKuliner() {
    document.getElementById('modalKulinerTitle').textContent = '🍜 Tambah Kuliner';
    document.getElementById('kulinerId').value        = '';
    document.getElementById('kulinerNama').value      = '';
    document.getElementById('kulinerKategori').value  = 'Makanan';
    document.getElementById('kulinerStatus').value    = 'Aktif';
    document.getElementById('kulinerDeskripsi').value = '';
    document.getElementById('kulinerLokasi').value    = '';
    document.getElementById('kulinerLat').value       = '';
    document.getElementById('kulinerLng').value       = '';
    resetImage('kulinerImage', 'kulinerPreview');
    openModal('modalKuliner');
}

function openEditKuliner(id) {
    const k = dataKuliner.find(x => x.id === id);
    if (!k) return;
    document.getElementById('modalKulinerTitle').textContent = '🍜 Edit Kuliner';
    document.getElementById('kulinerId').value      = k.id;
    document.getElementById('kulinerNama').value    = k.name;
    document.getElementById('kulinerKategori').value = k.category_type;
    document.getElementById('kulinerStatus').value  = k.status;
    document.getElementById('kulinerDeskripsi').value = k.description || '';
    document.getElementById('kulinerLokasi').value  = k.location || '';
    document.getElementById('kulinerLat').value     = k.latitude || '';
    document.getElementById('kulinerLng').value     = k.longitude || '';
    resetImage('kulinerImage', 'kulinerPreview');
    if (k.image) showExistingImage('kulinerPreview', k.image);
    openModal('modalKuliner');
}

async function submitKuliner(e) {
    e.preventDefault();
    const id        = document.getElementById('kulinerId').value;
    const name      = document.getElementById('kulinerNama').value.trim();
    const category_type = document.getElementById('kulinerKategori').value;
    const status    = document.getElementById('kulinerStatus').value;
    const description = document.getElementById('kulinerDeskripsi').value.trim();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('category_type', category_type);
    formData.append('status', status);
    formData.append('description', description);
    const kulLokasi = document.getElementById('kulinerLokasi').value.trim();
    const kulLat = document.getElementById('kulinerLat').value;
    const kulLng = document.getElementById('kulinerLng').value;
    if (kulLokasi) formData.append('location', kulLokasi);
    if (kulLat) formData.append('latitude', kulLat);
    if (kulLng) formData.append('longitude', kulLng);
    const kulinerImageFile = document.getElementById('kulinerImage').files[0];
    if (kulinerImageFile) formData.append('image', kulinerImageFile);
    if (id) formData.append('_method', 'PUT');

    const method = 'POST';
    const url = id ? `/admin/api/culinaries/${id}` : '/admin/api/culinaries';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        if (!res.ok) {
            const errData = await res.json();
            throw new Error(errData.message || 'Terjadi kesalahan pada server');
        }

        const result = await res.json();
        
        if (id) {
            const idx = dataKuliner.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataKuliner[idx] = result;
            showToast(`Kuliner berhasil diperbarui!`);
        } else {
            dataKuliner.unshift(result);
            showToast(`Kuliner berhasil ditambahkan!`);
        }
        renderKuliner();
        closeModal('modalKuliner');
    } catch(err) {
        showToast(err.message || 'Gagal menyimpan!', 'error');
    }
}

async function toggleStatusKuliner(id) {
    try {
        const res = await fetch(`/admin/api/culinaries/${id}/toggle`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        const result = await res.json();
        const idx = dataKuliner.findIndex(x => x.id === id);
        if (idx >= 0) dataKuliner[idx] = result;
        renderKuliner();
        showToast(`Status diubah ke ${result.status}.`, 'warning');
    } catch(err) {
        showToast('Gagal mengubah status!', 'error');
    }
}

// ══════════════════════════════════════════════
//  BUDAYA
// ══════════════════════════════════════════════
function renderBudaya() {
    const tbody = document.getElementById('tbodyBudaya');
    if (dataBudaya.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><span>🎭</span>Belum ada data budaya.</div></td></tr>`;
        return;
    }
    tbody.innerHTML = dataBudaya.map(d => `
        <tr>
            <td><strong>${d.name}</strong></td>
            <td>${d.location || '-'}</td>
            <td>${badgeStatus(d.status)}</td>
            <td>${d.is_featured ? '⭐ Ya' : 'Tidak'}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditBudaya(${d.id})">✏️ Edit</button>
                    <button class="table-action toggle-status" onclick="toggleStatusBudaya(${d.id})">${d.status === 'Aktif' ? '📦 Draft' : '✅ Aktifkan'}</button>
                    <button class="table-action toggle-status" onclick="toggleFeaturedBudaya(${d.id})">${d.is_featured ? '📌 Unfeature' : '⭐ Feature'}</button>
                    <button class="table-action danger" onclick="openHapus('budaya', ${d.id}, '${d.name.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openTambahBudaya() {
    document.getElementById('modalBudayaTitle').textContent = '🎭 Tambah Budaya';
    document.getElementById('budayaId').value = '';
    document.getElementById('budayaNama').value = '';
    document.getElementById('budayaLokasi').value = '';
    document.getElementById('budayaBadge').value = '';
    document.getElementById('budayaStatus').value = 'Aktif';
    document.getElementById('budayaFeatured').value = '0';
    document.getElementById('budayaDeskripsi').value = '';
    document.getElementById('budayaLat').value = '';
    document.getElementById('budayaLng').value = '';
    resetImage('budayaImage', 'budayaPreview');
    openModal('modalBudaya');
}

function openEditBudaya(id) {
    const d = dataBudaya.find(x => x.id === id);
    if (!d) return;
    document.getElementById('modalBudayaTitle').textContent = '🎭 Edit Budaya';
    document.getElementById('budayaId').value = d.id;
    document.getElementById('budayaNama').value = d.name;
    document.getElementById('budayaLokasi').value = d.location || '';
    document.getElementById('budayaBadge').value = d.badge || '';
    document.getElementById('budayaStatus').value = d.status;
    document.getElementById('budayaFeatured').value = d.is_featured ? '1' : '0';
    document.getElementById('budayaDeskripsi').value = d.description || '';
    document.getElementById('budayaLat').value = d.latitude || '';
    document.getElementById('budayaLng').value = d.longitude || '';
    resetImage('budayaImage', 'budayaPreview');
    if (d.image) showExistingImage('budayaPreview', d.image);
    openModal('modalBudaya');
}

async function submitBudaya(e) {
    e.preventDefault();
    const id = document.getElementById('budayaId').value;
    const formData = new FormData();
    formData.append('name', document.getElementById('budayaNama').value.trim());
    formData.append('location', document.getElementById('budayaLokasi').value.trim());
    formData.append('badge', document.getElementById('budayaBadge').value.trim());
    formData.append('status', document.getElementById('budayaStatus').value);
    formData.append('is_featured', document.getElementById('budayaFeatured').value === '1' ? '1' : '0');
    formData.append('description', document.getElementById('budayaDeskripsi').value.trim());
    const budLat = document.getElementById('budayaLat').value;
    const budLng = document.getElementById('budayaLng').value;
    if (budLat) formData.append('latitude', budLat);
    if (budLng) formData.append('longitude', budLng);
    const imgFile = document.getElementById('budayaImage').files[0];
    if (imgFile) formData.append('image', imgFile);
    if (id) formData.append('_method', 'PUT');

    const url = id ? `/admin/api/budaya/${id}` : '/admin/api/budaya';
    try {
        const res = await fetch(url, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: formData });
        if (!res.ok) throw new Error((await res.json()).message || 'Terjadi kesalahan');
        const result = await res.json();
        if (id) {
            const idx = dataBudaya.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataBudaya[idx] = result;
            showToast('Budaya berhasil diperbarui!');
        } else {
            dataBudaya.unshift(result);
            showToast('Budaya berhasil ditambahkan!');
        }
        renderBudaya();
        closeModal('modalBudaya');
        updateStatBudayaSejarah();
    } catch(err) { showToast(err.message || 'Gagal menyimpan!', 'error'); }
}

async function toggleStatusBudaya(id) {
    try {
        const res = await fetch(`/admin/api/budaya/${id}/toggle`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken } });
        const result = await res.json();
        const idx = dataBudaya.findIndex(x => x.id === id);
        if (idx >= 0) dataBudaya[idx] = result;
        renderBudaya();
        showToast(`Status diubah ke ${result.status}.`, 'warning');
    } catch(err) { showToast('Gagal mengubah status!', 'error'); }
}

async function toggleFeaturedBudaya(id) {
    try {
        const res = await fetch(`/admin/api/budaya/${id}/featured`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken } });
        const result = await res.json();
        const idx = dataBudaya.findIndex(x => x.id === id);
        if (idx >= 0) dataBudaya[idx] = result;
        renderBudaya();
        showToast(result.is_featured ? 'Ditandai sebagai Featured.' : 'Featured dihapus.', 'warning');
    } catch(err) { showToast('Gagal mengubah featured!', 'error'); }
}

// ══════════════════════════════════════════════
//  SEJARAH
// ══════════════════════════════════════════════
function renderSejarah() {
    const tbody = document.getElementById('tbodySejarah');
    if (dataSejarah.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><span>🏛️</span>Belum ada data sejarah.</div></td></tr>`;
        return;
    }
    tbody.innerHTML = dataSejarah.map(d => `
        <tr>
            <td><strong>${d.name}</strong></td>
            <td>${d.location || '-'}</td>
            <td>${badgeStatus(d.status)}</td>
            <td>${d.is_featured ? '⭐ Ya' : 'Tidak'}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditSejarah(${d.id})">✏️ Edit</button>
                    <button class="table-action toggle-status" onclick="toggleStatusSejarah(${d.id})">${d.status === 'Aktif' ? '📦 Draft' : '✅ Aktifkan'}</button>
                    <button class="table-action toggle-status" onclick="toggleFeaturedSejarah(${d.id})">${d.is_featured ? '📌 Unfeature' : '⭐ Feature'}</button>
                    <button class="table-action danger" onclick="openHapus('sejarah', ${d.id}, '${d.name.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openTambahSejarah() {
    document.getElementById('modalSejarahTitle').textContent = '🏛️ Tambah Sejarah';
    document.getElementById('sejarahId').value = '';
    document.getElementById('sejarahNama').value = '';
    document.getElementById('sejarahLokasi').value = '';
    document.getElementById('sejarahBadge').value = '';
    document.getElementById('sejarahStatus').value = 'Aktif';
    document.getElementById('sejarahFeatured').value = '0';
    document.getElementById('sejarahDeskripsi').value = '';
    document.getElementById('sejarahLat').value = '';
    document.getElementById('sejarahLng').value = '';
    resetImage('sejarahImage', 'sejarahPreview');
    openModal('modalSejarah');
}

function openEditSejarah(id) {
    const d = dataSejarah.find(x => x.id === id);
    if (!d) return;
    document.getElementById('modalSejarahTitle').textContent = '🏛️ Edit Sejarah';
    document.getElementById('sejarahId').value = d.id;
    document.getElementById('sejarahNama').value = d.name;
    document.getElementById('sejarahLokasi').value = d.location || '';
    document.getElementById('sejarahBadge').value = d.badge || '';
    document.getElementById('sejarahStatus').value = d.status;
    document.getElementById('sejarahFeatured').value = d.is_featured ? '1' : '0';
    document.getElementById('sejarahDeskripsi').value = d.description || '';
    document.getElementById('sejarahLat').value = d.latitude || '';
    document.getElementById('sejarahLng').value = d.longitude || '';
    resetImage('sejarahImage', 'sejarahPreview');
    if (d.image) showExistingImage('sejarahPreview', d.image);
    openModal('modalSejarah');
}

async function submitSejarah(e) {
    e.preventDefault();
    const id = document.getElementById('sejarahId').value;
    const formData = new FormData();
    formData.append('name', document.getElementById('sejarahNama').value.trim());
    formData.append('location', document.getElementById('sejarahLokasi').value.trim());
    formData.append('badge', document.getElementById('sejarahBadge').value.trim());
    formData.append('status', document.getElementById('sejarahStatus').value);
    formData.append('is_featured', document.getElementById('sejarahFeatured').value === '1' ? '1' : '0');
    formData.append('description', document.getElementById('sejarahDeskripsi').value.trim());
    const sejLat = document.getElementById('sejarahLat').value;
    const sejLng = document.getElementById('sejarahLng').value;
    if (sejLat) formData.append('latitude', sejLat);
    if (sejLng) formData.append('longitude', sejLng);
    const imgFile = document.getElementById('sejarahImage').files[0];
    if (imgFile) formData.append('image', imgFile);
    if (id) formData.append('_method', 'PUT');

    const url = id ? `/admin/api/sejarah/${id}` : '/admin/api/sejarah';
    try {
        const res = await fetch(url, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: formData });
        if (!res.ok) throw new Error((await res.json()).message || 'Terjadi kesalahan');
        const result = await res.json();
        if (id) {
            const idx = dataSejarah.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataSejarah[idx] = result;
            showToast('Sejarah berhasil diperbarui!');
        } else {
            dataSejarah.unshift(result);
            showToast('Sejarah berhasil ditambahkan!');
        }
        renderSejarah();
        closeModal('modalSejarah');
        updateStatBudayaSejarah();
    } catch(err) { showToast(err.message || 'Gagal menyimpan!', 'error'); }
}

async function toggleStatusSejarah(id) {
    try {
        const res = await fetch(`/admin/api/sejarah/${id}/toggle`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken } });
        const result = await res.json();
        const idx = dataSejarah.findIndex(x => x.id === id);
        if (idx >= 0) dataSejarah[idx] = result;
        renderSejarah();
        showToast(`Status diubah ke ${result.status}.`, 'warning');
    } catch(err) { showToast('Gagal mengubah status!', 'error'); }
}

async function toggleFeaturedSejarah(id) {
    try {
        const res = await fetch(`/admin/api/sejarah/${id}/featured`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken } });
        const result = await res.json();
        const idx = dataSejarah.findIndex(x => x.id === id);
        if (idx >= 0) dataSejarah[idx] = result;
        renderSejarah();
        showToast(result.is_featured ? 'Ditandai sebagai Featured.' : 'Featured dihapus.', 'warning');
    } catch(err) { showToast('Gagal mengubah featured!', 'error'); }
}

function updateStatBudayaSejarah() {
    document.getElementById('statBudayaSejarah').textContent = dataBudaya.length + dataSejarah.length;
}

// ══════════════════════════════════════════════
//  HAPUS (SHARED)
// ══════════════════════════════════════════════
function openHapus(type, id, nama) {
    pendingDelete = { type, id };
    document.getElementById('hapusNama').textContent = nama;
    openModal('modalHapus');
}

document.getElementById('btnKonfirmasiHapus').addEventListener('click', async function () {
    if (!pendingDelete) return;
    const { type, id } = pendingDelete;

    let url = '';
    if (type === 'destinasi') url = `/admin/api/destinations/${id}`;
    else if (type === 'artikel') url = `/admin/api/articles/${id}`;
    else if (type === 'kuliner') url = `/admin/api/culinaries/${id}`;
    else if (type === 'budaya') url = `/admin/api/budaya/${id}`;
    else if (type === 'sejarah') url = `/admin/api/sejarah/${id}`;

    try {
        await fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        
        if (type === 'destinasi') {
            dataDestinasi = dataDestinasi.filter(x => x.id !== id);
            renderDestinasi();
        } else if (type === 'artikel') {
            dataArtikel = dataArtikel.filter(x => x.id !== id);
            renderArtikel();
        } else if (type === 'kuliner') {
            dataKuliner = dataKuliner.filter(x => x.id !== id);
            renderKuliner();
        } else if (type === 'budaya') {
            dataBudaya = dataBudaya.filter(x => x.id !== id);
            renderBudaya();
            updateStatBudayaSejarah();
        } else if (type === 'sejarah') {
            dataSejarah = dataSejarah.filter(x => x.id !== id);
            renderSejarah();
            updateStatBudayaSejarah();
        }
        showToast(`Data berhasil dihapus!`, 'error');
    } catch(err) {
        showToast('Gagal menghapus data!', 'error');
    }

    pendingDelete = null;
    closeModal('modalHapus');
});

// ── ESC TO CLOSE ──────────────────────────────
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.admin-modal.open').forEach(m => m.classList.remove('open'));
        document.getElementById('adminOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
});

// ══════════════════════════════════════════════
//  HAPUS (SHARED)
// ══════════════════════════════════════════════
function openHapus(type, id, nama) {
    pendingDelete = { type, id };
    document.getElementById('hapusNama').textContent = nama;
    openModal('modalHapus');
}

document.getElementById('btnKonfirmasiHapus').addEventListener('click', async function () {
    if (!pendingDelete) return;
    const { type, id } = pendingDelete;

    let url = '';
    if (type === 'destinasi') url = `/admin/api/destinations/${id}`;
    else if (type === 'artikel') url = `/admin/api/articles/${id}`;
    else if (type === 'kuliner') url = `/admin/api/culinaries/${id}`;
    else if (type === 'budaya') url = `/admin/api/budaya/${id}`;
    else if (type === 'sejarah') url = `/admin/api/sejarah/${id}`;
    else if (type === 'map-location') url = `/admin/api/map-locations/${id}`;

    try {
        await fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        
        if (type === 'destinasi') {
            dataDestinasi = dataDestinasi.filter(x => x.id !== id);
            renderDestinasi();
        } else if (type === 'artikel') {
            dataArtikel = dataArtikel.filter(x => x.id !== id);
            renderArtikel();
        } else if (type === 'kuliner') {
            dataKuliner = dataKuliner.filter(x => x.id !== id);
            renderKuliner();
        } else if (type === 'budaya') {
            dataBudaya = dataBudaya.filter(x => x.id !== id);
            renderBudaya();
            updateStatBudayaSejarah();
        } else if (type === 'sejarah') {
            dataSejarah = dataSejarah.filter(x => x.id !== id);
            renderSejarah();
            updateStatBudayaSejarah();
        } else if (type === 'map-location') {
            dataPeta = dataPeta.filter(x => x.id !== id);
            renderPeta();
            if (typeof initAdminPreviewMap === 'function') {
                initAdminPreviewMap();
            }
        }
        showToast(`Data berhasil dihapus!`, 'error');
    } catch(err) {
        showToast('Gagal menghapus data!', 'error');
    }

    pendingDelete = null;
    closeModal('modalHapus');
});

// ── ESC TO CLOSE ──────────────────────────────
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.admin-modal.open').forEach(m => m.classList.remove('open'));
        document.getElementById('adminOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }
});

// ── INIT ──────────────────────────────────────
renderDestinasi();
renderArtikel();
renderKuliner();
renderBudaya();
renderSejarah();
renderPeta();

// ══════════════════════════════════════════════
//  PETA INTERAKTIF ADMIN CRUD
// ══════════════════════════════════════════════
function renderPeta() {
    const tbody = document.getElementById('tbodyPeta');
    if (dataPeta.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><span>🗺️</span>Belum ada data pin di peta. Silakan tambah lokasi baru.</div></td></tr>`;
        if (adminMap) {
            adminMarkers.forEach(m => adminMap.removeLayer(m));
            adminMarkers = [];
        }
        return;
    }

    tbody.innerHTML = dataPeta.map(item => {
        const iconEmoji = item.category === 'alam' ? '🌿' : item.category === 'budaya' ? '🏛️' : '🍜';
        const catLabel = item.category === 'alam' ? 'Wisata Alam' : item.category === 'budaya' ? 'Budaya' : 'Kuliner';
        return `<tr>
            <td><strong>${iconEmoji} ${item.name}</strong></td>
            <td>${catLabel}</td>
            <td><span style="font-size:.75rem;color:#94a3b8;">${parseFloat(item.latitude).toFixed(5)}, ${parseFloat(item.longitude).toFixed(5)}</span></td>
            <td>${badgeStatus(item.status)}</td>
            <td>
                <div class="action-group">
                    <button class="table-action edit" onclick="openEditMapLocation(${item.id})">✏️ Edit</button>
                    <button class="table-action danger" onclick="openHapus('map-location', ${item.id}, '${item.name.replace(/'/g,"\\'")}')">🗑️ Hapus</button>
                </div>
            </td>
        </tr>`;
    }).join('');

    setTimeout(initAdminPreviewMap, 300);
}

function openTambahMapLocation() {
    document.getElementById('modalMapLocationTitle').textContent = '🗺️ Tambah Lokasi Peta';
    document.getElementById('mapLocId').value = '';
    document.getElementById('mapLocNama').value = '';
    document.getElementById('mapLocKategori').value = 'alam';
    document.getElementById('mapLocStatus').value = 'Aktif';
    document.getElementById('mapLocAlamat').value = '';
    document.getElementById('mapLocLat').value = '';
    document.getElementById('mapLocLng').value = '';
    document.getElementById('mapLocDeskripsi').value = '';
    openModal('modalMapLocation');
}

function openEditMapLocation(id) {
    const loc = dataPeta.find(x => x.id === id);
    if (!loc) return;
    document.getElementById('modalMapLocationTitle').textContent = '🗺️ Edit Lokasi Peta';
    document.getElementById('mapLocId').value = loc.id;
    document.getElementById('mapLocNama').value = loc.name;
    document.getElementById('mapLocKategori').value = loc.category;
    document.getElementById('mapLocStatus').value = loc.status;
    document.getElementById('mapLocAlamat').value = loc.address || '';
    document.getElementById('mapLocLat').value = loc.latitude;
    document.getElementById('mapLocLng').value = loc.longitude;
    document.getElementById('mapLocDeskripsi').value = loc.description || '';
    openModal('modalMapLocation');
}

async function submitMapLocation(e) {
    e.preventDefault();
    const id = document.getElementById('mapLocId').value;
    const bodyData = {
        name: document.getElementById('mapLocNama').value.trim(),
        category: document.getElementById('mapLocKategori').value,
        status: document.getElementById('mapLocStatus').value,
        address: document.getElementById('mapLocAlamat').value.trim(),
        latitude: document.getElementById('mapLocLat').value,
        longitude: document.getElementById('mapLocLng').value,
        description: document.getElementById('mapLocDeskripsi').value.trim(),
    };

    const method = id ? 'PUT' : 'POST';
    const url = id ? `/admin/api/map-locations/${id}` : '/admin/api/map-locations';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(bodyData)
        });

        if (!res.ok) throw new Error('Gagal menyimpan lokasi peta');
        const result = await res.json();

        if (id) {
            const idx = dataPeta.findIndex(x => x.id === parseInt(id));
            if (idx >= 0) dataPeta[idx] = result;
            showToast('Lokasi peta berhasil diperbarui!');
        } else {
            dataPeta.unshift(result);
            showToast('Lokasi peta berhasil ditambahkan!');
        }

        renderPeta();
        closeModal('modalMapLocation');
        if (typeof initAdminPreviewMap === 'function') {
            initAdminPreviewMap();
        }
    } catch (err) {
        showToast(err.message || 'Gagal menyimpan!', 'error');
    }
}

let adminMap = null;
let adminMarkers = [];

function initAdminPreviewMap() {
    const mapEl = document.getElementById('admin-preview-map');
    if (!mapEl || typeof L === 'undefined') return;

    if (!adminMap) {
        adminMap = L.map('admin-preview-map').setView([-7.4756, 112.7483], 11);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CartoDB', maxZoom: 19
        }).addTo(adminMap);
    } else {
        adminMarkers.forEach(m => adminMap.removeLayer(m));
        adminMarkers = [];
    }

    const colors = { alam: '#22c55e', budaya: '#3b82f6', kuliner: '#fb923c' };
    const emojis = { alam: '🌿', budaya: '🏛️', kuliner: '🍜' };

    dataPeta.forEach(item => {
        if (!item.latitude || !item.longitude) return;
        const icon = L.divIcon({
            className: '',
            html: `<div style="width:28px;height:28px;border-radius:50% 50% 50% 0;background:${colors[item.category]};border:2px solid #fff;transform:rotate(-45deg);box-shadow:0 2px 8px rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:10px;">${emojis[item.category]}</span></div>`,
            iconSize: [28,28], iconAnchor: [14,28], popupAnchor: [0,-30]
        });
        const m = L.marker([parseFloat(item.latitude), parseFloat(item.longitude)], { icon })
            .bindPopup(`<b>${item.name}</b><br><small style="color:#64748b">${item.address || ''}</small>`)
            .addTo(adminMap);
        adminMarkers.push(m);
    });

    adminMap.invalidateSize();
}
</script>
@endpush