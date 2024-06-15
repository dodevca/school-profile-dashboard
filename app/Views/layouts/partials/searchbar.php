<div class="iq-search-bar ml-md-3 order-md-2 w-100 w-md-auto">
    <?= form_open('', ['class' => 'searchbox', 'method' => 'get']) ?>
        <button type="submit" class="btn btn-link search-link"><i class="bi bi-search"></i></button>
        <input type="text" class="text search-input border shadow-none" id="search" name="query" <?= !empty($data['query']) ? 'value="' . $data['query'] . '"&filter=terbaru"' :  '' ?> placeholder="Cari <?= $currentSearch ?> ...">
    <?= form_close() ?>
</div>