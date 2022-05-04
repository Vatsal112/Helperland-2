<div class="div-content" id="servicerequest">
    <div class="shistory-title">
        <p>Service Requests</p>
    </div>
    <div class="search-bar">
        <form action="#" id="form_searchreq">
            <div class="search-row">
                <div class="search-col">
                    <input type="number" name="serviceid" id="serviceid" class="form-control" placeholder="Service ID">
                </div>
                <div class="search-col">
                    <input type="number" name="postalcode" id="postalcode" class="form-control" placeholder="Postal Code">
                </div>
                <div class="search-col">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                </div>
                <div class="search-col form-group">
                    <select class="form-select" name="customername" id="customername" aria-label="Default select example">
                    </select>
                </div>
                <div class="search-col form-group">
                    <select class="form-select" name="servicername" id="servicername" aria-label="Default select example">
                    </select>
                </div>
                <div class="search-col form-group">
                    <select class="form-select" name="servicestatus" id="servicestatus" aria-label="Default select example">
                        <option value='' selected>Select Status</option>
                        <option value="-1">New</option>
                        <option value="1">Assign</option>
                        <option value="2">Accepted</option>
                        <option value="3">Cancelled</option>
                        <option value="4">Completed</option>
                        <option value="5">Refunded</option>
                    </select>
                </div>
                <!-- <div class="search-col form-group">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>SP Payment Status</option>
                    </select>
                </div> -->
                <div class="search-col">
                    <div class="form-check">
                        <input class="form-check-input" name="hasissue" id="hasissue" type="checkbox">
                        <label class="form-check-label" for="hasissue">
                            Has issue
                        </label>
                    </div>
                </div>
                <div class="search-col div-date">
                    <img src="static/images/admin-calendar.png" alt="">
                    <input type="text" class="form-control" name="fromdate" id="fromdate" placeholder="From Date" title="yyyy-mm-dd">
                </div>
                <div class="search-col div-date">
                    <img src="static/images/admin-calendar.png" alt="">
                    <input type="text" class="form-control" name="todate" id="todate" placeholder="To Date" title="yyyy-mm-dd">
                </div>
                <div class="search-col col-buttons">
                    <button type="Search" class="btn-search btn-service-search">Search</button>
                    <button type="reset" class="btn-clear">Clear</button>
                </div>
            </div>
        </form>
    </div>
    <div id="servicehistory" class="servicerequests table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Service ID </th>
                    <th scope="col">Service Date</th>
                    <th scope="col">Customer detailes </th>
                    <th scope="col">Service Provider </th>
                    <!-- <th scope="col">Gross Amount </th> -->
                    <th scope="col">Net Amount </th>
                    <!-- <th scope="col">Discount </th> -->
                    <th scope="col">Status </th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Action</th>

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
                <option value=2>2</option>
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="50">50</option>
            </select>
            Entries, Total Record : <span class="totalrecords"><span>
        </div>
        <div class="paginations">
            <div class="next-left changepage"><img src="./static/images/next-left.png" alt=""></div>
            <div class="next-right changepage"><img src="./static/images/next-left.png" alt=""></div>
        </div>
    </div>
    <div class="shistory-footer">
        ©2018 Helperland. All rights reserved.
    </div>
</div>