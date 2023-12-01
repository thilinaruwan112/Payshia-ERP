<?php
require_once('../../../../include/config.php');
include '../../../../include/function-update.php';

include '../../../../include/settings_functions.php';

$Sections = GetSections($link);
$Departments = GetDepartments($link);
$Categories = GetCategories($link);
$LocationID = $_POST['LocationID'];

$LoggedUser = $_POST['LoggedUser'];
$deleteResult = deleteRecordsWithHoldStatusNotHold($link, $LoggedUser);
$brandFilter = GetSetting($link, $LocationID, 'brandFilter');
?>

<style>
    .filter-content {
        height: calc(100vh - 135px);
        max-height: calc(100vh - 135px);
        overflow-y: auto;
    }

    .filter-text {
        font-weight: 600;
    }

    #search-key {
        font-size: 15px;
    }

    .brand-button {
        height: 18px;
    }

    .filter-content button {
        font-size: 14px;
    }

    .brand-card {
        margin: 0px 0px 10px 0px;
    }

    .brand-filter {
        padding-top: 8px;
        padding-left: 8px;
        padding-right: 8px;
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 10px;
    }
</style>

<div id="page-content-wrapper"><!-- Your Page Content Goes Here -->
    <div class="row">
        <div class="col-md-8 px-1">
            <div class="row">
                <div class="col-md-9" style="padding-right: 0px;">
                    <div class="mt-1">
                        <input type="text" class="form-control mb-2 p-2 border-2" placeholder="Search Product" id="search-key" onclick="this.select()">
                    </div>

                    <?php
                    if ($brandFilter == 1) { ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="bg-white brand-filter d-flex flex-wrap justify-content-between">
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/tvs.png" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/bajaj-auto-2.svg" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/susuki.png" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/yamaha-2-1.svg" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/honda.png" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/susuki.png" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/tvs.png" class="brand-button"></button>
                                    <button class="btn btn-light shadow-sm brand-card"><img src="../assets/images/brands/honda.png" class="brand-button"></button>
                                </div>
                            </div>

                        </div>
                    <?php } ?>

                    <div class="item-container" id="item-container"></div>
                </div>
                <div class="col-md-3">
                    <div class="card w-100 category-card filter-content shadow-sm">
                        <div class="card-body">
                            <h5 class="text-center">Filter</h5>
                            <button onclick="OpenItemContainer(0, 'not-set')" class="btn px-3 btn-lg btn-dark mb-2 w-100 filter-text " data-id="">All Items</button>
                            <!-- Categories -->
                            <?php
                            if (!empty($Categories)) {
                                foreach ($Categories as $SelectedArray) {

                                    if ($SelectedArray['pos_display'] != 1 || $SelectedArray['is_active'] != 1) {
                                        continue;
                                    }
                            ?>
                                    <button onclick="OpenItemContainer ('<?= $SelectedArray['id'] ?>', 'category_id')" class="filter-text btn px-3 btn-lg btn-primary mb-2 w-100" data-id="<?= $SelectedArray['id'] ?>"><?= $SelectedArray['category_name'] ?></button>
                            <?php
                                }
                            }
                            ?>
                            <!-- Departments -->
                            <?php
                            if (!empty($Departments)) {
                                foreach ($Departments as $SelectedArray) {
                                    if ($SelectedArray['pos_display'] != 1 || $SelectedArray['is_active'] != 1) {
                                        continue;
                                    }
                            ?>
                                    <button onclick="OpenItemContainer ('<?= $SelectedArray['id'] ?>', 'department_id')" class="filter-text btn px-3  btn-lg btn-primary  mb-2 w-100" data-id="<?= $SelectedArray['id'] ?>"><?= $SelectedArray['department_name'] ?></button>
                            <?php
                                }
                            }
                            ?>

                            <!-- Sections -->
                            <?php
                            if (!empty($Sections)) {
                                foreach ($Sections as $SelectedArray) {
                                    if ($SelectedArray['pos_display'] != 1 || $SelectedArray['is_active'] != 1) {
                                        continue;
                                    }
                            ?>
                                    <button onclick=" OpenItemContainer ('<?= $SelectedArray['id'] ?>', 'section_id' )" class="filter-text btn-lg px-3 btn btn-primary  mb-2 w-100" data-id="<?= $SelectedArray['id'] ?>"><?= $SelectedArray['section_name'] ?></button>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-4  px-1" id="bill-container"></div>
    </div>


</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the input element by its ID
        var inputBox = document.getElementById("search-key");
        var programmaticFocus = true; // Flag to track programmatic focus

        // Set up a focus event listener
        inputBox.addEventListener("focus", function() {
            if (programmaticFocus) {
                this.select(); // Select the text when the input box is focused programmatically
            }
        });

        // Set focus on the input box
        inputBox.focus();

        // Set the flag to false when the input box is clicked
        inputBox.addEventListener("click", function() {
            programmaticFocus = false;
        });
    });
</script>
<script>
    document.getElementById("search-key").addEventListener("input", function() {
        const searchText = this.value.toLowerCase();
        const productColumns = document.querySelectorAll(".product-column");

        productColumns.forEach(function(productColumn) {
            const productName = productColumn.querySelector(".card-title").textContent.toLowerCase();

            if (productName.includes(searchText)) {
                productColumn.classList.remove("d-none");
                productColumn.classList.add("d-block");
            } else {
                productColumn.classList.remove("d-block");
                productColumn.classList.add("d-none");
            }
        });
    });
</script>