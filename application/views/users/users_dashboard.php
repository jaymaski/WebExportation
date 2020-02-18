<div class="dashboard-container">
    <nav>
        <div class="nav nav-tabs nav-fill dashboard" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-my-uat-request-tab" data-toggle="tab" href="#nav-my-uat-request" role="tab" aria-controls="nav-my-uat-request" aria-selected="true">My UAT Requests</a>
            <a class="nav-item nav-link" id="nav-my-uat-exported-tab" data-toggle="tab" href="#nav-my-uat-exported" role="tab" aria-controls="nav-my-uat-exported" aria-selected="false">My UAT Exported</a>
            <a class="nav-item nav-link" id="nav-my-prod-request-tab" data-toggle="tab" href="#nav-my-prod-request" role="tab" aria-controls="nav-my-prod-request" aria-selected="false">My PROD Requests</a>
            <a class="nav-item nav-link" id="nav-my-prod-exported-tab" data-toggle="tab" href="#nav-my-prod-exported" role="tab" aria-controls="nav-my-prod-exported" aria-selected="false">My PROD Exported</a>
            <a class="nav-item nav-link" id="nav-owned-tab" data-toggle="tab" href="#nav-owned" role="tab" aria-controls="nav-owned" aria-selected="false">Owned Request</a>
            <a class="nav-item nav-link" id="nav-sharedwithme-tab" data-toggle="tab" href="#nav-sharedwithme" role="tab" aria-controls="nav-sharedwithme" aria-selected="false">Shared with me</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <?php $this->view('users/dashboards/my_uatrequests'); ?>
        <?php $this->view('users/dashboards/my_uatexported'); ?>
        <?php $this->view('users/dashboards/my_prodrequests'); ?>
        <?php $this->view('users/dashboards/my_prodexported'); ?>
        <?php $this->view('users/dashboards/owned_requests'); ?>
        <?php $this->view('users/dashboards/shared'); ?>
    </div>
</div>
