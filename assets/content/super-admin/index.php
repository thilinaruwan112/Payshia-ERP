<?php
require_once('../../../include/config.php');
include '../../../include/function-update.php';
include '../../../include/lms-functions.php';

include './methods/functions.php'; //Ticket Methods

$LoggedUser = $_POST['LoggedUser'];
?>
<div class="row">
    <div class="col-md-4">

        <div class="card mt-5">
            <div class="card-body">

                <h1 class="mb-0 border-bottom pb-2 mb-2">Module Create</h1>
                <form action="#" method="post" id="module_form">
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="module_name" class="text-secondary">Module Name</label>
                            <input type="text" class="form-control" name="module_name" id="module_name" placeholder="Module Name" required>
                        </div>

                        <div class="col-12 text-end">
                            <button type="button" onclick="SaveModule()" class="btn btn-dark"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>