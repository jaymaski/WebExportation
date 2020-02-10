<section>
    <div class="container-main">
        <div class="row">
            <div class="col-xl-12">
                <nav>
                    <div class="nav nav-tabs nav-fill dashboard" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-myrequest-tab" data-toggle="tab" href="#nav-myrequest" role="tab" aria-controls="nav-myrequest" aria-selected="true">My Request</a>
                        <a class="nav-item nav-link" id="nav-myexported-tab" data-toggle="tab" href="#nav-myexported" role="tab" aria-controls="nav-myexported" aria-selected="false">My Exported</a>
                        <a class="nav-item nav-link" id="nav-owned-tab" data-toggle="tab" href="#nav-owned" role="tab" aria-controls="nav-owned" aria-selected="false">Owned Request</a>
                        <a class="nav-item nav-link" id="nav-sharedwithme-tab" data-toggle="tab" href="#nav-sharedwithme" role="tab" aria-controls="nav-sharedwithme" aria-selected="false">Shared with me</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <?php $this->view('users/dashboards/my_requests'); ?>
                    <?php $this->view('users/dashboards/my_exported'); ?>
                    <?php $this->view('users/dashboards/owned_requests'); ?>
                    <?php $this->view('users/dashboards/shared'); ?>
                </div>
            </div>
        </div>
    </div>
</section>