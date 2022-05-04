<div class="div-content table-responsive">
    <div class="shistory-title">
        <p>Serivce History</p>
        <button id="export">Export</button>
    </div>
    <div id="servicehistory">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Service Id  <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(1)">Service Detailes <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(2)">Service Provider <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(3)">Payment <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th onclick="sortTable(4)">Status <img class="sorting-icon" src="./static/images/icon-sort.png" alt=""></th>
                    <th>Rate SP</th>
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
                <option value="5" selected>5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="30">30</option>
            </select>
            entries Total Record : <span class="totalrecords">50<span>
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