@extends('layouts.app')

@section('title', 'Progres Project')

@section('content')
<div class="feed" style="width: 100%;">
    <div class="progress-box" style="background: white; padding: 25px; border-radius: 15px; transition: 0.3s;">
        <p style="text-align: center;"><b>Progres Project</b></p>
        
        <div class="project-list" style="display: flex; flex-direction: column; gap: 20px; margin-top: 20px;">
            <!-- Example: Status Pengajuan -->
            <div class="project-card" style="border: 1px solid #e4e6eb; border-radius: 12px; padding: 20px; position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0; color: #1c1e21; font-size: 1rem; font-weight: 500;">Website Portofolio</h3>
                        <p style="margin: 5px 0 0; color: #65676b; font-size: 0.9rem;">ID Project: BK-2026-0001</p>
                    </div>
                    <span style="background: #e7f3ff; color: #1877f2; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">Pengajuan</span>
                </div>

                <div style="background: #f0f2f5; padding: 15px; border-radius: 10px;">
                    <p style="margin: 0 0 5px; font-weight: 500; font-size: 0.9rem; color: #1c1e21;">Keterangan:</p>
                    <p style="margin: 0; font-size: 0.85rem; color: #65676b;">Project sedang diajukan.</p>
                </div>
            </div>

            <!-- Example: Status Selesai -->
            <div class="project-card" style="border: 1px solid #e4e6eb; border-radius: 12px; padding: 20px; position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0; color: #1c1e21; font-size: 1rem; font-weight: 500;">Logo Design - Brand X</h3>
                        <p style="margin: 5px 0 0; color: #65676b; font-size: 0.9rem;">ID Project: BK-2026-0002</p>
                    </div>
                    <span style="background: #d1fae5; color: #059669; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">Selesai</span>
                </div>

                <div style="background: #f0f2f5; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                    <p style="margin: 0 0 5px; font-weight: 500; font-size: 0.9rem; color: #1c1e21;">Keterangan:</p>
                    <p style="margin: 0; font-size: 0.85rem; color: #65676b;">Project telah selesai dikerjakan.</p>
                </div>

                <div style="border-top: 1px solid #e4e6eb; padding-top: 15px;">
                    <p style="margin: 0 0 10px; font-weight: 500; font-size: 0.9rem; color: #1c1e21;">Data Diterima:</p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">
                        <a href="#" style="background: #1877f2; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; cursor: pointer;">File Project</a>
                        <a href="#" style="background: #1877f2; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; cursor: pointer;">Link Project</a>
                    </div>

                    <hr style="border: none; border-top: 1px solid #e4e6eb; margin: 15px 0;">

                    <!-- TESTIMONI SECTION -->
                    <div id="testi-section-{{ 'BK-2026-0002' }}">
                        <button onclick="showTestiForm('{{ 'BK-2026-0002' }}')" style="background: none; border: 1px solid #1877f2; color: #1877f2; padding: 8px 15px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; cursor: pointer; width: 100%;">Berikan Testimoni</button>
                    </div>

                    <div id="testi-form-{{ 'BK-2026-0002' }}" style="display: none; margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #e4e6eb;">
                        <p style="margin: 0 0 10px; font-weight: bold; font-size: 0.9rem;">Rating:</p>
                        <div style="display: flex; gap: 5px; color: #ffd700; font-size: 1.5rem; margin-bottom: 15px;">
                            <span class="star-t-BK-2026-0002" onclick="setTestiRating('BK-2026-0002', 1)" style="cursor: pointer;">☆</span>
                            <span class="star-t-BK-2026-0002" onclick="setTestiRating('BK-2026-0002', 2)" style="cursor: pointer;">☆</span>
                            <span class="star-t-BK-2026-0002" onclick="setTestiRating('BK-2026-0002', 3)" style="cursor: pointer;">☆</span>
                            <span class="star-t-BK-2026-0002" onclick="setTestiRating('BK-2026-0002', 4)" style="cursor: pointer;">☆</span>
                            <span class="star-t-BK-2026-0002" onclick="setTestiRating('BK-2026-0002', 5)" style="cursor: pointer;">☆</span>
                        </div>
                        <textarea placeholder="Tuliskan kesan Anda terhadap project ini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 0.9rem; margin-bottom: 15px; height: 80px; resize: none;"></textarea>
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button onclick="hideTestiForm('BK-2026-0002')" style="padding: 8px 20px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Batal</button>
                            <button onclick="alert('Testimoni berhasil diposting!')" style="padding: 8px 20px; border: none; background: #1877f2; color: white; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 0.85rem;">Posting</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTestiForm(id) {
        document.getElementById('testi-form-' + id).style.display = 'block';
    }
    function hideTestiForm(id) {
        document.getElementById('testi-form-' + id).style.display = 'none';
    }
    function setTestiRating(id, val) {
        let stars = document.querySelectorAll('.star-t-' + id);
        stars.forEach((star, index) => {
            if (index < val) {
                star.innerText = '★';
            } else {
                star.innerText = '☆';
            }
        });
    }
</script>
<style>
    .progress-box:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    .friend-box:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    <div class="friend-box" style="background: white; border-radius: 15px; padding: 15px; display: flex; flex-direction: column; height: 400px; transition: 0.3s;">
        <p style="margin-top: 0; border-bottom: 1px solid #f0f2f5; padding-bottom: 10px; text-align: center;"><b>Admin</b></p>
        <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 10px; display: flex; flex-direction: column; gap: 10px;">
            <div style="align-self: flex-start; background: #f0f2f5; padding: 8px 12px; border-radius: 15px; max-width: 80%; font-size: 0.9rem;">
                Halo! Anda bisa melihat progres project Anda di sini.
            </div>
        </div>
        <div style="margin-top: 10px; display: flex; gap: 5px;">
            <input type="text" placeholder="Tulis pesan..." style="flex: 1; border: 1px solid #e4e6eb; border-radius: 20px; padding: 8px 15px; font-size: 0.85rem;">
            <button style="background: #1877f2; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
            </button>
        </div>
    </div>
</div>
@endsection
