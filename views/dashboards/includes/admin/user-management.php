<div class="div-content" id="usermanagement">
    <div class="shistory-title">
        <p>User Management</p>
        <button id="export">Export</button>
    </div>
    <div class="search-bar">
        <form action="#" id="form_searchreq">
            <div class="search-row">
                <div class="search-col">
                    <select class="form-select" name="username" id="username" aria-label="Default select example">
                    </select>
                </div>
                <div class="search-col">
                    <select class="form-select" name="usertype" id="usertype" aria-label="Default select example">
                        <option value="" selected>User Type</option>
                        <option value="1">Customer</option>
                        <option value="2">Servicer</option>
                        <option value="3">Admin</option>
                    </select>
                </div>
                <div class="search-col">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+49</span>
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone Number" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="search-col">
                    <input type="text" class="form-control" name="postal" id="postal" placeholder="Postal code">
                </div>
                <div class="search-col">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                </div>
                <div class="search-col div-date">
                     <img src="static/images/admin-calendar.png" alt="">
                     <input type="text" class="form-control" id="fromdate" placeholder="From Date" title="Format:-yyyy-mm-dd">
                 </div>
                 <div class="search-col div-date">
                    <img src="static/images/admin-calendar.png" alt="">
                    <input type="text" class="form-control" id="todate" placeholder="To Date" title="Format:-yyyy-mm-dd">
                 </div>
                <div class="search-col col-buttons">
                    <button type="Search" class="btn-search btn-user-search">Search</button>
                    <button type="reset" class="btn-clear">Clear</button>
                </div>
            </div>
        </form>
    </div>
    <div id="servicehistory" class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th scope="col">User Name <img src="./static/images/icon-sort.png" alt=""></th>
                    <th scope="col">User Type <img src="./static/images/icon-sort.png" alt=""></th>
                    <th scope="col">Date of Registration</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Postal Code <img src="./static/images/icon-sort.png" alt=""></th>
                    <th scope="col">Status <img src="./static/images/icon-sort.png" alt=""></th>
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