<?php $__env->startSection('title', 'Verifikasi Anggota'); ?>
<?php $__env->startSection('page-title', 'Verifikasi Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-4 space-y-5">

  
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <div class="card p-5 border-l-4 border-amber">
      <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Menunggu Verifikasi</p>
      <div class="flex items-end justify-between mt-1">
        <h3 class="text-3xl font-bold text-navy"><?php echo e($statsSummary['pending']); ?></h3>
        <span class="text-amber-600 text-xs bg-amber-50 px-2 py-1 rounded font-medium">PENDING</span>
      </div>
    </div>
    <div class="card p-5 border-l-4 border-success">
      <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Anggota Aktif</p>
      <div class="flex items-end justify-between mt-1">
        <h3 class="text-3xl font-bold text-navy"><?php echo e($statsSummary['aktif']); ?></h3>
        <span class="text-success text-xs bg-green-50 px-2 py-1 rounded font-medium">AKTIF</span>
      </div>
    </div>
    <div class="card p-5 border-l-4 border-primary">
      <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Terdaftar</p>
      <div class="flex items-end justify-between mt-1">
        <h3 class="text-3xl font-bold text-navy"><?php echo e($statsSummary['total']); ?></h3>
        <span class="text-primary text-xs bg-blue-50 px-2 py-1 rounded font-medium">SEMUA</span>
      </div>
    </div>
  </div>

  
  <div class="card">
    <div class="card-header flex-col sm:flex-row items-start sm:items-center gap-4">
      <h3 class="font-semibold text-navy">Antrean Verifikasi Keanggotaan</h3>

      
      <div id="bulk-actions" class="hidden flex items-center gap-2">
        <span class="text-sm text-gray-500 mr-2"><span id="selected-count">0</span> terpilih</span>
        <button onclick="openBulkModal('Aktif')" class="btn-success text-xs py-1.5">
          Setujui Masal
        </button>
        <button onclick="openBulkModal('Tidak Aktif')" class="btn-danger text-xs py-1.5">
          Tolak Masal
        </button>
      </div>
    </div>

    <div class="table-wrapper rounded-none">
      <form id="bulk-form" action="<?php echo e(route('admin.verification.bulk')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="status" id="bulk-status-input">

        <table class="table">
          <thead>
            <tr>
              <th class="w-10 text-center">
                <input type="checkbox" id="check-all" class="rounded text-primary focus:ring-primary/30">
              </th>
              <th>Anggota</th>
              <th>NIM</th>
              <th>Departemen</th>
              <th>Status Saat Ini</th>
              <th class="text-center">Aksi Cepat</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td class="text-center">
                <input type="checkbox" name="member_ids[]" value="<?php echo e($member->id); ?>"
                  class="member-checkbox rounded text-primary focus:ring-primary/30">
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-primary">
                    <?php echo e(strtoupper(substr($member->full_name, 0, 1))); ?>

                  </div>
                  <div>
                    <p class="font-medium text-gray-800"><?php echo e($member->full_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($member->member_code); ?></p>
                  </div>
                </div>
              </td>
              <td class="font-mono text-xs text-gray-500"><?php echo e($member->nim); ?></td>
              <td class="text-gray-600"><?php echo e($member->department->name ?? '-'); ?></td>
              <td>
                <span class="badge-<?php echo e(strtolower(str_replace(' ','-',$member->status))); ?>">
                  <?php echo e($member->status); ?>

                </span>
              </td>
              <td>
                <div class="flex items-center justify-center gap-2">
                  <button type="button" onclick="openSingleModal('<?php echo e($member->id); ?>', '<?php echo e($member->full_name); ?>', 'Aktif')"
                    class="p-1.5 bg-green-50 text-success hover:bg-success hover:text-white rounded-lg transition-all"
                    title="Setujui">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                  </button>
                  <button type="button" onclick="openSingleModal('<?php echo e($member->id); ?>', '<?php echo e($member->full_name); ?>', 'Tidak Aktif')"
                    class="p-1.5 bg-red-50 text-danger hover:bg-danger hover:text-white rounded-lg transition-all"
                    title="Tolak">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="text-center py-12 text-gray-400 italic">
                Tidak ada data anggota yang memerlukan verifikasi.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </form>
    </div>

    
    <?php if($members->hasPages()): ?>
    <div class="p-4 border-t border-gray-100">
      <?php echo e($members->links()); ?>

    </div>
    <?php endif; ?>
  </div>
</div>


<div id="modal-verify" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
    <div class="p-6 border-b border-gray-100">
      <h3 class="font-semibold text-navy text-lg">Verifikasi Anggota</h3>
      <p class="text-sm text-gray-500 mt-1">
        Ubah status untuk <span id="verify-name" class="font-bold text-navy"></span>
      </p>
    </div>
    <form id="single-verify-form" method="POST">
      <?php echo csrf_field(); ?>
      <div class="p-6 space-y-4">
        <div>
          <label class="form-label">Status Baru</label>
          <select name="status" id="verify-status-select" class="form-select">
            <option value="Aktif">Setujui (Aktif)</option>
            <option value="Tidak Aktif">Tolak (Tidak Aktif)</option>
            <option value="Alumni">Alumni</option>
            <option value="Pending">Pending</option>
          </select>
        </div>
        <div>
          <label class="form-label">Catatan (Opsional)</label>
          <textarea name="note" class="form-input resize-none" rows="3" placeholder="Alasan perubahan status..."></textarea>
        </div>
      </div>
      <div class="p-6 pt-0 flex gap-3">
        <button type="button" onclick="closeModal('modal-verify')" class="btn-ghost border border-gray-300 flex-1">Batal</button>
        <button type="submit" class="btn-primary flex-1">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>


<div id="modal-bulk" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm text-center p-8">
    <div id="bulk-icon-container" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>
    <h3 class="text-xl font-bold text-navy mb-2">Konfirmasi Masal</h3>
    <p class="text-gray-500 text-sm mb-6">
      Apakah Anda yakin ingin mengubah status <span id="bulk-text-count" class="font-bold"></span> anggota terpilih menjadi <span id="bulk-text-status" class="font-bold"></span>?
    </p>
    <div class="flex gap-3">
      <button onclick="closeModal('modal-bulk')" class="btn-ghost border border-gray-300 flex-1">Batal</button>
      <button onclick="submitBulk()" class="btn-primary flex-1">Ya, Lanjutkan</button>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // Selection Logic
  const checkAll = document.getElementById('check-all');
  const checkboxes = document.querySelectorAll('.member-checkbox');
  const bulkActions = document.getElementById('bulk-actions');
  const selectedCountText = document.getElementById('selected-count');

  function updateBulkUI() {
    const checked = document.querySelectorAll('.member-checkbox:checked');
    if (checked.length > 0) {
      bulkActions.classList.remove('hidden');
      selectedCountText.textContent = checked.length;
    } else {
      bulkActions.classList.add('hidden');
    }
  }

  if (checkAll) {
    checkAll.addEventListener('change', function() {
      checkboxes.forEach(cb => cb.checked = this.checked);
      updateBulkUI();
    });
  }

  checkboxes.forEach(cb => {
    cb.addEventListener('change', updateBulkUI);
  });

  // Modal Single
  function openSingleModal(id, name, status) {
    document.getElementById('verify-name').textContent = name;
    document.getElementById('verify-status-select').value = status;
    document.getElementById('single-verify-form').action = `/admin/verification/${id}/update`;
    document.getElementById('modal-verify').classList.remove('hidden');
  }

  // Modal Bulk
  function openBulkModal(status) {
    const count = document.querySelectorAll('.member-checkbox:checked').length;
    document.getElementById('bulk-text-count').textContent = count;
    document.getElementById('bulk-text-status').textContent = status;
    document.getElementById('bulk-status-input').value = status;
    
    const icon = document.getElementById('bulk-icon-container');
    if (status === 'Aktif') {
      icon.className = 'w-16 h-16 rounded-full bg-green-100 text-success mx-auto mb-4';
    } else {
      icon.className = 'w-16 h-16 rounded-full bg-red-100 text-danger mx-auto mb-4';
    }
    
    document.getElementById('modal-bulk').classList.remove('hidden');
  }

  function submitBulk() {
    document.getElementById('bulk-form').submit();
  }

  function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\hris_isba_jaya-main\resources\views/admin/verification/index.blade.php ENDPATH**/ ?>