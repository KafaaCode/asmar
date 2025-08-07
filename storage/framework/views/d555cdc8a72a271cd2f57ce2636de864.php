<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#gamesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                "order": [[0, "asc"]],
                "responsive": true
            });
        });
    </script>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 card-title flex-grow-1"><?php echo app('translator')->get('translation.Games'); ?></h5>
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(url('ad/games/create?action=addGame')); ?>" class="btn btn-soft-primary">
                            <?php echo app('translator')->get('translation.Add'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="gamesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('translation.id'); ?></th>
                                <th><?php echo app('translator')->get('translation.icon'); ?></th>
                                <!-- <th><?php echo app('translator')->get('translation.slug'); ?></th> -->
                                <th><?php echo app('translator')->get('translation.title'); ?></th>
                                <!-- <th><?php echo app('translator')->get('translation.keywords'); ?></th> -->
                                <th><?php echo app('translator')->get('translation.name_currency'); ?></th>
                                <th><?php echo app('translator')->get('translation.need_name_player'); ?></th>
                                <th><?php echo app('translator')->get('translation.need_id_player'); ?></th>
                                <th><?php echo app('translator')->get('translation.price_qty'); ?></th>
                                <th><?php echo app('translator')->get('translation.is_active'); ?></th>
                                <th><?php echo app('translator')->get('translation.is_show'); ?></th>
                                <th><?php echo app('translator')->get('translation.have_packages'); ?></th>
                                <th>API</th>
                                <th><?php echo app('translator')->get('translation.action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(++$i); ?></td>
                                    <th scope="row">
                                        <?php if($game->image): ?>
                                            <img src="<?php echo e(asset('uploads/games/' . $game->image)); ?>" alt="game image" width="50">
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </th>
                                    <!-- <td><?php echo e($game->slug); ?></td> -->
                                    <td><?php echo e($game->title); ?></td>
                                    <!-- <td><?php echo e($game->keywords); ?></td> -->
                                    <td><?php echo e($game->name_currency); ?></td>
                                    <td><?php echo e($game->name_player_string); ?></td>
                                    <td><?php echo e($game->id_player_string); ?></td>
                                    <td><?php echo e(number_format($game->price_qty, 2)); ?></td>
                                    <td><?php echo e($game->active_string); ?></td>
                                    <td><?php echo e($game->is_show_string); ?></td>
                                    <td><?php echo e($game->have_packages_string); ?></td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 api-status-badge <?php echo e($game->provider_id ? 'bg-success' : 'bg-danger'); ?>" style="font-size:1em;cursor:pointer;" data-game-id="<?php echo e($game->id); ?>" data-provider-id="<?php echo e($game->provider_id); ?>" data-provider-game-id="<?php echo e($game->provider_game_id); ?>">
                                            <?php if($game->provider_id): ?>
                                                <?php echo e(optional($game->provider)->name ?? 'مفعل'); ?>

                                            <?php else: ?>
                                                غير مفعل
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <li>
                                                <a href="<?php echo e(route('front.game.show', $game->slug)); ?>"
                                                    class="btn btn-sm btn-soft-primary" title="<?php echo app('translator')->get('translation.view'); ?>">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('ad.games.edit', $game->id)); ?>"
                                                    class="btn btn-sm btn-soft-primary" title="<?php echo app('translator')->get('translation.edit'); ?>">
                                                    <i class="mdi mdi-pencil-outline"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="btn btn-sm btn-soft-danger"
                                                    data-bs-toggle="modal" data-bs-target="#gameDelete_<?php echo e($game->id); ?>"
                                                    title="<?php echo app('translator')->get('translation.delete'); ?>">
                                                    <i class="mdi mdi-delete-outline"></i>
                                                </button>
                                            </li>
                                            <?php if($game->have_packages == 1): ?>
                                                <li>
                                                    <a href="<?php echo e(route('ad.games.packages', $game->id)); ?>"
                                                        class="btn btn-sm btn-soft-success"
                                                        title="<?php echo app('translator')->get('translation.ViewPackage'); ?>">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </td>
                                </tr>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="gameDelete_<?php echo e($game->id); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo app('translator')->get('translation.delete'); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo e(route('ad.games.destroy', $game->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('delete'); ?>
                                                <div class="modal-body">
                                                    <p><?php echo app('translator')->get('translation.titleDel'); ?> <strong><?php echo e($game->slug); ?></strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-danger"><?php echo app('translator')->get('translation.delete'); ?></button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal"><?php echo app('translator')->get('translation.close'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        <?php echo $games->appends(request()->all())->links(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal API Settings -->
<div class="modal fade" id="apiStatusModal" tabindex="-1" aria-labelledby="apiStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="apiStatusModalLabel">تعديل حالة API للمنتج</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="apiStatusForm">
          <input type="hidden" id="modalGameId" name="game_id" value="">
          <div class="mb-3">
            <label class="form-label">نوع الربط</label>
            <select class="form-select" id="providerTypeSelect" name="provider_type">
              <option value="manual">يدوي</option>
              <option value="auto">آلي (API)</option>
            </select>
          </div>
          <div id="providerFields" style="display:none;">
            <div class="mb-3">
              <label class="form-label">المزود الحالي</label>
              <input type="text" class="form-control mb-2" id="currentProviderName" value="" readonly style="display:none;">
              <label class="form-label">المزود</label>
              <select class="form-select" id="providerSelect" name="provider_id">
                <option value="">اختر المزود</option>
                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($provider->id); ?>"><?php echo e($provider->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">منتج المزود الحالي</label>
              <input type="text" class="form-control mb-2" id="currentProviderGameName" value="" readonly style="display:none;">
              <label class="form-label">منتج المزود</label>
              <select class="form-select" id="providerGameSelect" name="provider_game_id">
                <option value="">اختر المنتج</option>
              </select>
            </div>
          </div>
          <div id="apiStatusError" class="alert alert-danger d-none"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        <button type="button" class="btn btn-primary" id="saveApiStatusBtn">حفظ</button>
      </div>
    </div>
  </div>
</div>

<?php
    $gamesMapped = $games->keyBy('id')->map(function($g){
        return [
            'provider_id' => $g->provider_id,
            'provider_game_id' => $g->provider_game_id,
            'provider_name' => optional($g->provider)->name,
            'provider_game_name' => $g->provider_game_id ? (optional($g->provider)->name . ' - ' . $g->provider_game_id) : null
        ];
    })->toArray();
?>



<script>
$(document).ready(function() {
    var currentGameId = null;
    var providerNames = <?php echo json_encode($providers->pluck('name', 'id'), 512) ?>;
    var gamesData = <?php echo json_encode($gamesMapped, 15, 512) ?>;
    // فتح المودال مع تعبئة البيانات
    $('.api-status-badge').on('click', function() {
        currentGameId = $(this).data('game-id');
        $('#modalGameId').val(currentGameId);
        var game = gamesData[currentGameId];
        var providerId = game ? game.provider_id : '';
        var providerGameId = game ? game.provider_game_id : '';
        var providerName = game ? game.provider_name : '';
        var providerGameName = game ? game.provider_game_name : '';
        if(providerId) {
            $('#providerTypeSelect').val('auto');
            $('#providerFields').show();
            $('#providerSelect').val(providerId);
            fetchProviderGames(providerId, providerGameId);
            $('#currentProviderName').val(providerName).show();
            $('#currentProviderGameName').val(providerGameName).show();
        } else {
            $('#providerTypeSelect').val('manual');
            $('#providerFields').hide();
            $('#providerSelect').val('');
            $('#providerGameSelect').html('<option value="">اختر المنتج</option>');
            $('#currentProviderName').hide();
            $('#currentProviderGameName').hide();
        }
        $('#apiStatusModal').modal('show');
    });
    // إظهار/إخفاء حقول المزود حسب نوع الربط
    $('#providerTypeSelect').on('change', function() {
        if($(this).val() === 'auto') {
            $('#providerFields').show();
            fetchProviderGames($('#providerSelect').val());
        } else {
            $('#providerFields').hide();
        }
    });
    // عند تغيير المزود، جلب المنتجات
    $('#providerSelect').on('change', function() {
        fetchProviderGames($(this).val());
    });
    function fetchProviderGames(providerId, selectedId = '') {
        if(!providerId) {
            $('#providerGameSelect').html('<option value="">اختر المنتج</option>');
            return;
        }
        $('#providerGameSelect').html('<option>جاري التحميل...</option>');
        $.ajax({
            url: '<?php echo e(route('ad.games.fetch-products')); ?>',
            type: 'GET',
            data: { provider: providerId },
            success: function(response) {
                var gameSelect = $('#providerGameSelect');
                gameSelect.empty();
                gameSelect.append('<option value="">اختر المنتج</option>');
                var data = response.data || response;
                if(Array.isArray(data)) {
                    data.forEach(function(item) {
                        if(item && item.id && item.name) {
                            var selected = (item.id == selectedId) ? 'selected' : '';
                            gameSelect.append('<option value="'+item.id+'" '+selected+'>'+item.name+'</option>');
                        }
                    });
                }
            },
            error: function() {
                $('#providerGameSelect').html('<option value="">تعذر جلب المنتجات</option>');
            }
        });
    }
    // حفظ الحالة
    $('#saveApiStatusBtn').on('click', function() {
        var type = $('#providerTypeSelect').val();
        var providerId = $('#providerSelect').val();
        var providerGameId = $('#providerGameSelect').val();
        var data = {};
        if(type === 'auto') {
            if(!providerId || !providerGameId) {
                $('#apiStatusError').removeClass('d-none').text('يجب اختيار المزود والمنتج.');
                return;
            }
            data.provider_id = providerId;
            data.provider_game_id = providerGameId;
        }
        $('#apiStatusError').addClass('d-none');
        $.ajax({
            url: '/ad/games/' + currentGameId + '/toggle-api',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                ...data
            },
            success: function(response) {
                if(response.success) {
                    $('#apiStatusModal').modal('hide');
                    var badge = $('.api-status-badge[data-game-id="'+currentGameId+'"]');
                    if(response.status === 'مفعل') {
                        badge.removeClass('bg-danger').addClass('bg-success').text('مفعل');
                    } else {
                        badge.removeClass('bg-success').addClass('bg-danger').text('غير مفعل');
                    }
                } else {
                    $('#apiStatusError').removeClass('d-none').text(response.message || 'حدث خطأ');
                }
            },
            error: function(xhr) {
                let msg = 'حدث خطأ غير متوقع';
                if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                $('#apiStatusError').removeClass('d-none').text(msg);
            }
        });
    });
});
</script>
<?php /**PATH D:\Personal\Freelancer\Asmar Market\asmar\resources\views/admin/games/view.blade.php ENDPATH**/ ?>