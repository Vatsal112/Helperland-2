<div class="div-content table-responsive">
    <div class="shistory-title">
        <p>Current Service Requests</p>
        <button onclick="window.location='<?=$base_url.'?controller=Default&function=booknow'?>'">Add New Service Requests</button>
    </div>
    <div>
        <table class="table" id="table">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Service Id <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(1)">Service Date <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(2)">Service Provider <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(3)">Payment <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th>Is Accepted?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <div class="shistory-pagination">
        <div class="show-apge">
            show
            <select class="form-select" aria-label="Default select example">
                <option selected>5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            entries Total Record : <span class="totalrecords"><span>
        </div>
        <div class="paginations">
            <div class="jump-left"><img src="./static/images/jump-left.png" alt=""></div>
            <div class="next-left"><img src="./static/images/next-left.png" alt=""></div>
            <div class="current-page">1</div>
            <div class="next-right"><img src="./static/images/next-left.png" alt=""></div>
            <div class="jump-right"><img src="./static/images/jump-left.png" alt=""></div>
        </div>
    </div>
</div>