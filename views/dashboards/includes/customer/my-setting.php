<div class="div-content">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">My Detailes</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">My Addresses</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Change Password</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="my-detailes">
                <form action="<?=Config::BASE_URL."?controller=Users&function=UpdateUserDetailes"?>" id="form-usersave" method="POST">
                    <input type="hidden" name="userid" value="<?=$userdata["UserId"]?>">
                    <input type="hidden" name="Email" value="<?=$userdata["Email"]?>">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input class="form-control" type="text" name="FirstName" id="firstname" value="<?= $userdata['FirstName'] ?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input class="form-control" type="text" name="LastName" id="lastname" value="<?= $userdata['LastName'] ?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input class="form-control disabled" type="email" id="email" value="<?= $userdata['Email'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+49</div>
                                    </div>
                                    <input type="number" name="PhoneNumber" class="form-control" id="phonenumber" placeholder="Phone number" value="<?= $userdata['Mobile'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Date of Birth">Date of Birth</label>
                                <div class="row">
                                    <div class="col">
                                        <?php $birthdate = is_null($userdata["DateOfBirth"]) ? "":date('Y-m-d',strtotime($userdata["DateOfBirth"])) ?>
                                        <input type="date" name="BirthDate" id="birthdate" style="padding: 10px; width: 100%;" value="<?=$birthdate?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="langauge">My Preferred Language</label>
                                <select name="langauge" class="form-select">
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn-detailes" type="submit" name="saveuser" id="btn-saveuser">Save</button>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="my-addresses">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Addresses</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("controllers/CDashboardController.php");
                        $obj = new ServiceModal($_POST);
                        $results = $obj->getUserAllAddressByUserId($userdata["UserId"]);
                        $i = 1;
                        foreach ($results as $result) {
                            $addressline = $result["AddressLine1"]." ".$result["AddressLine2"].", ".$result["PostalCode"]." ".$result["City"];
                            $mobile = $result["Mobile"];
                            $addressid = $result["AddressId"];
                        ?>
                            <tr>
                                <td class='add_index'><?=$i?></td>
                                <td>
                                    <div>Address: <span><?=$addressline?></span></div>
                                    <div>Phone number: <span><?=$mobile?></span></div>
                                </td>
                                <td id=add_<?=$addressid?> >
                                    <a href="#" class="edit-address"><img src="./static/images/edit-icon.png" alt=""></a>
                                    <a href="#" class="delete-address"><img src="./static/images/delete-icon.png" alt=""></a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <button class="btn-newaddress">Add New Address</button>
            </div>
        </div>
        <div class="tab-pane" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="change-password pt-3" >
                <form action="<?= Config::BASE_URL."?controller=Users&function=ChangedPassword" ?>" id="form-changepassword">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="Old Password">Old Password</label>
                            <input type="hidden" name="userid" value="<?=$userdata["UserId"]?>">
                            <input type="password" class="form-control" name="oldpassword" id="oldpsw" placeholder="Current Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="New Password">New Password</label>
                            <input type="password" class="form-control" name="newpassword" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="Confirm Password">Confirm Password</label>
                            <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="btn-changepsw">
                        <button type="submit" name="change" value="changepassword" id="btn-updatepassword">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>