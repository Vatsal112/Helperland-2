<div class="div-content dashboard">
    <div class="row text-center">
        <div class="col-4">
            <div class="request-count blue">0</div>
            <div class="request-title">New Service Requests</div>
            <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=newservice"?>" class="btn-viewall">View all</a>
        </div>
        <div class="col-4 center-count">
            <div class="request-count green">0</div>
            <div class="request-title">Upcoming Service</div>
            <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=upcoming"?>" class="btn-viewall">View all</a>
        </div>
        <div class="col-4">
            <div class="request-count red">0</div>
            <div class="request-title">Payment Due</div>
            <a href="<?=Config::BASE_URL."?controller=Default&function=servicer_dashboard&parameter=upcoming"?>" class="btn-viewall">View all</a>
        </div>
    </div>
</div>