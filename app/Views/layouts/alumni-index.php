<?= $this->extend('app') ?>

<?= $this->section('breadcrumb') ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house mr-1"></i>Beranda</a></li>
        <i class="bi bi-chevron-compact-right"></i>
        <li class="breadcrumb-item active" aria-current="page">Ikatan Alumni</li>
    </ol>
</nav>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between breadcrumb-content">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between order-md-2 w-100 w-md-auto">
                        <?php include_once('partials/searchbar.php') ?>
                        <div class="dropdown status-dropdown pr-md-3 mt-3 mt-md-0 border-right btn-new order-md-1">
                            <div class="dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown">
                                <div class="btn bg-body"><span class="h6">Urutkan :</span> A-Z<i class="bi bi-chevron-down ml-2 mr-0"></i></div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton03">
                                <a class="dropdown-item" href="<?= base_url('agenda?sort=asc') ?>">A-Z</a>
                                <a class="dropdown-item" href="<?= base_url('agenda?sort=asc') ?>">Z-A</a>
                                <a class="dropdown-item" href="<?= base_url('agenda?sort=asc') ?>">Terbaru</a>
                                <a class="dropdown-item" href="<?= base_url('agenda?sort=desc') ?>">Terlama</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center order-2 order-md-1">                       
                        <div class="list-grid-toggle d-flex align-items-center mr-3">
                            <div data-toggle-extra="tab" data-target-extra="#grid" class="active">
                                <div class="grid-icon mr-2">
                                    <i class="bi bi-grid-fill"></i>
                                </div>
                            </div>
                            <div data-toggle-extra="tab" data-target-extra="#list">
                                <div class="grid-icon">
                                    <i class="bi bi-list"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card-transparent card-block card-stretch card-height">
                <div class="card-body text-center p-0">                            
                    <div class="item">
                        <button type="button" class="btn btn-link odr-img" data-toggle="modal" data-target="#announcementModal1">
                            <img src="<?= base_url('template/images/user/01.jpg') ?>" class="img-fluid rounded-circle avatar-90 m-auto" alt="image">
                        </button>                        
                        <div class="odr-content rounded"> 
                            <button type="button" class="btn btn-link">
                                <h4 class="mb-2" data-toggle="modal" data-target="#announcementModal1">Ruben Franci</h4>
                            </button>                                         
                            <p class="mb-3">PT. Lorem Ipsum</p>
                            <ul class="list-unstyled mb-3">
                                <li class="bg-secondary-light rounded-circle iq-card-icon-small mr-4"><i class="bi bi-envelope"></i></li>
                                <li class="bg-primary-light rounded-circle iq-card-icon-small mr-4"><i class="bi bi-telephone"></i></li>
                                <li class="bg-success-light rounded-circle iq-card-icon-small"><i class="bi bi-instagram"></i></li>
                            </ul>                                    
                            <div class="pt-3 border-top">
                                <a href="<?= base_url('ikatan-alumni/1234567890') ?>" class="btn bg-secondary-light mr-2"><i class="bi bi-pen"></i>Edit</a>
                                <button type="button" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></button>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="list" class="item-content animate__animated animate__fadeIn" data-toggle-extra="tab-content">
    <div class="table-responsive rounded bg-white mb-4">
        <table class="table mb-0 table-borderless tbl-server-info">
            <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-link media d-flex align-items-center" data-toggle="modal" data-target="#announcementModal1">
                            <img src="<?= base_url('template/images/user/01.jpg') ?>" class="img-fluid rounded-circle avatar-40" alt="image">
                            <h5 class="ml-3">Paityn Siphron</h5>
                        </button>
                    </td>
                    <td>PT. Lorem Ipsum</td>
                    <td>
                        <div class="media align-items-center">
                            <div class="bg-secondary-light rounded-circle iq-card-icon-small mr-3"><i class="bi bi-envelope"></i></div>
                            <div class="bg-primary-light rounded-circle iq-card-icon-small mr-3"><i class="bi bi-telephone"></i></div>
                            <div class="bg-success-light rounded-circle iq-card-icon-small"><i class="bi bi-instagram"></i></div>
                        </div>
                    </td>
                    <td class="text-right">
                        <a href="<?= base_url('ikatan-alumni/1234567890') ?>" class="btn bg-secondary-light mr-2"><i class="bi bi-pen"></i>Edit</a>
                        <button type="button" class="btn bg-secondary-light"><i class="bi bi-trash m-0"></i></button>                            
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('layouts/partials/pagination') ?>
<div class="modal fade" id="announcementModal1" tabindex="-1" aria-labelledby="announcementModal1Title" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModal1Title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="<?= base_url('agenda/1234567890') ?>" type="button" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>