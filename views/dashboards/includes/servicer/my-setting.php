<div class="div-content">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">My Detailes</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Change Password</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="my-detailes">
                <div class="account-status">
                    Account Status: <span>Active</span>
                </div>
                <form action="<?= Config::BASE_URL . "?controller=Users&function=UpdateUserDetailes" ?>" id="form-usersave" method="POST">
                    <input type="hidden" name="userid" value="<?= $userdata["UserId"] ?>">
                    <input type="hidden" name="Email" value="<?= $userdata["Email"] ?>">
                    <div class="account-header">
                        <div class="account-title">Basic details</div>
                        <?php $profile_ = is_null($userdata["UserProfilePicture"]) ? Config::PROFILE_PICTURES[0] : $userdata["UserProfilePicture"];?>
                        <div><img src="./static/images/avtar/<?=$profile_?>.png" alt="<?=$profile_?>"></div>
                    </div>
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
                                <label for="firstname">Email Address</label>
                                <input class="form-control" type="email" id="email" value="<?= $userdata['Email'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mobile">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+46</div>
                                    </div>
                                    <input type="number" name="PhoneNumber" id="phonenumber" class="form-control" id="inlineFormInputGroup" placeholder="Phone number" value="<?= $userdata['Mobile'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Date of Birth">Date of Birth</label>
                                <div class="row">
                                    <div class="col">
                                        <?php $birthdate = is_null($userdata["DateOfBirth"]) ? "" : date('Y-m-d', strtotime($userdata["DateOfBirth"])) ?>
                                        <input type="date" name="BirthDate" id="birthdate" style="padding: 10px; width: 100%;" value="<?= $birthdate ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Nationality">Nationality</label>
                                <select name="nationality" class="form-select" id="">
                                    <?php echo is_null($userdata["NationalityId"]) ? '<option value="german">German</option>' : '<option></option>' ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4 gender">
                            <div class="form-group">
                                <label for="gender" class="mb-2">Gender</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="1" <?php if(!is_null($userdata["Gender"]) && $userdata["Gender"]==1){ echo "checked"; }?>>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="2" <?php if(!is_null($userdata["Gender"]) && $userdata["Gender"]==2){ echo "checked"; }?> >
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="nottosay" value="3" <?php if(is_null($userdata["Gender"]) || $userdata["Gender"]==3){ echo "checked"; }?> >
                                <label class="form-check-label" for="nottosay">Rather not to say</label>
                            </div>
                        </div>
                    </div>
                    <div class="row avtar">
                        <div class="col">
                            <div class="row form-group">
                                <label for="langauge">Select Avtar</label>
                                <div class="col" id="avatars">
                                    <?php
                                        foreach(Config::PROFILE_PICTURES as $profile){
                                            $is_selected = "";
                                            if($profile==$profile_){
                                                $is_selected = "selected";
                                            }
                                            echo "<img src='static/images/avtar/$profile.png' class='$is_selected' alt='$profile'>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row address">
                        <?php
                            include("controllers/SDashboardController.php");
                            $obj = new ServiceModal($_POST);
                            $result = $obj->getUserAddressByUserId($userdata["UserId"]);
                            $streetname = "";
                            $houcenumber = "";
                            $postalcode = "";
                            $city = "";
                            $mobile = "";
                            $addressid = "";
                            if(count($result[0]) > 0){
                                $result = $result[0];
                                $streetname = $result["AddressLine2"];
                                $houcenumber = $result["AddressLine1"];
                                $postalcode = $result["PostalCode"];
                                $city = $result["City"];
                                $mobile = $result["Mobile"];
                                $addressid = $result["AddressId"];
                            }
                        ?>
                        <input type="hidden" name="addid" value="<?=$addressid?>" id="addid">
                        <input type="hidden" name="mobile" id="add-mobile" value="<?=$userdata["Mobile"]?>">
                        <div class="title">My Address</div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="streetname">Street name</label>
                                <input class="form-control" type="text" name="streetname" id="add-street" value="<?=$streetname?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="housenumber">House number</label>
                                <input class="form-control" type="text" name="housenumber" id="add-house" value="<?=$houcenumber?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="postalcode">Postal code</label>
                                <input class="form-control" type="text" name="postalcode" id="add-postal" value="<?=$postalcode?>">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="city" id="city" class="form-select" id="">
                                    <option value="<?=$city?>"><?=$city?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn-detailes" type="submit" name="saveuser" id="servicersave">Save</button>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="change-password">
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