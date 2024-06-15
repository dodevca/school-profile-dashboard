<?php
$actualUrl  = str_replace('?page=' . $data['page'], '', str_replace('&page=' . $data['page'], '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
$params     = strpos($actualUrl, "filter=") || strpos($actualUrl, "query=") ? true : false;
?>
<?php if($data['totalResults'] > 1 && $data['page'] > 0): ?>
    <nav aria-label="pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $data['page'] == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $actualUrl . '&page=' . ($data['page'] - 1) ?>" <?= $data['page'] == 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>><i class="bi bi-chevron-left"></i></a>
            </li>
            <?php for($i = 1; $i <= ceil($data['totalResults']/20); $i++): ?>
                <li class="page-item <?= $data['page'] == $i ? 'active' : '' ?>" <?= $data['page'] == $i ? 'aria-current="page"' : '' ?>>
                    <a class="page-link" href="<?= $params ? $actualUrl . '&page=' . $i : $actualUrl . '?page=' . $i ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>
            <li class="page-item <?= $data['page'] == ceil($data['totalResults']/20) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $actualUrl . '&page=' . ($data['page'] + 1) ?>" <?= $data['page'] == ceil($data['totalResults']/20) ? 'tabindex="-1" aria-disabled="true"' : '' ?>><i class="bi bi-chevron-right"></i></a>
            </li>
        </ul>
    </nav>
<?php endif; ?>